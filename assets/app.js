const apiUrl = '/api/informacija.php';

const form = document.getElementById('informacija-modal-form');
const tableBody = document.querySelector('#informacija-table tbody');
const resetBtn = document.getElementById('reset-btn');
const formTitle = document.getElementById('modal-title');
const createBtn = document.getElementById('create-btn');
const modalOverlay = document.getElementById('modal-overlay');
const modalCancel = document.getElementById('modal-cancel-btn');
let teritorijaMap = {};

async function fetchList(){
  let url = apiUrl;
  if (window.globalSearch && window.globalSearch.q) {
    url += '?q=' + encodeURIComponent(window.globalSearch.q) + '&col=' + encodeURIComponent(window.globalSearch.col || 'Vardas_pavarde');
  }
  const res = await fetch(url);
  const data = await res.json();
  renderTable(data);
}

function renderTable(rows){
  tableBody.innerHTML = '';
  rows.forEach(r => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${r.Id}</td>
      <td>${escapeHtml(r.Moketojo_kodas||'')}</td>
      <td>${escapeHtml(r.Vardas_pavarde||'')}</td>
      <td>${escapeHtml(r.Telefono_nr||'')}</td>
      <td>${escapeHtml(r.ICCID||'')}</td>
      <td>${escapeHtml(r.Teritorinis_padalinis||'')}</td>
      <td>${escapeHtml(r.Adresas||'')}</td>
      <td>${r.M_parasas? 'Yes' : 'No'}</td>
      <td>${escapeHtml(r.Modemas||'')}</td>
      <td>${escapeHtml(r.Teikejas||'')}</td>
      <td>
        <a href="#" class="btn edit" data-id="${r.Id}">Edit</a>
        <a href="#" class="btn delete" data-id="${r.Id}">Delete</a>
      </td>
    `;
    tableBody.appendChild(tr);
  });
  tableBody.querySelectorAll('.edit').forEach(a=>a.addEventListener('click', e=>{
    e.preventDefault(); const id = e.target.dataset.id; loadItem(id);
  }));
  tableBody.querySelectorAll('.delete').forEach(a=>a.addEventListener('click', e=>{
    e.preventDefault(); const id = e.target.dataset.id; if(confirm('Delete id '+id+'?')) deleteItem(id);
  }));
}

function escapeHtml(s){ return String(s).replace(/[&<>"']/g, c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;','\'':'&#39;'}[c])); }

async function loadItem(id){
  const res = await fetch(apiUrl+'?id='+encodeURIComponent(id));
  if(!res.ok){ alert('Not found'); return; }
  const data = await res.json();
  populateForm(data);
}

function populateForm(d){
  form.Id.value = d.Id || '';
  form.Moketojo_kodas.value = d.Moketojo_kodas || '';
  form.Teritorija_Id.value = d.Teritorija_Id || '';
  const addrInput = document.getElementById('Adresas');
  if (addrInput) addrInput.value = d.Adresas || (d.Teritorija_Id && teritorijaMap[d.Teritorija_Id] ? teritorijaMap[d.Teritorija_Id].Adresas : '');
  form.Strukturinis_padalinis.value = d.Strukturinis_padalinis || '';
  form.Pareigos.value = d.Pareigos || '';
  form.Vardas_pavarde.value = d.Vardas_pavarde || '';
  form.Telefono_nr.value = d.Telefono_nr || '';
  form.IP.value = d.IP || '';
  form.ICCID.value = d.ICCID || '';
  form.M_parasas.checked = !!d.M_parasas;
  form.Pastaba.value = d.Pastaba || '';
  form.Modemas.value = d.Modemas || '';
  form.Teikejas.value = d.Teikejas || '';
  formTitle.textContent = 'Edit #' + d.Id;
  openModal();
}

function clearForm(){
  form.reset(); form.Id.value = ''; formTitle.textContent = 'Create new';
  const addrInput = document.getElementById('Adresas'); if (addrInput) addrInput.value = '';
}

form.addEventListener('submit', async (e)=>{
  e.preventDefault();
  const id = form.Id.value;
  const payload = Object.fromEntries(new FormData(form).entries());
  payload.M_parasas = form.M_parasas.checked ? 1 : 0;
  if(id){
    const res = await fetch(apiUrl+'?id='+encodeURIComponent(id), {method:'PUT',headers:{'Content-Type':'application/json'},body:JSON.stringify(payload)});
    const j = await res.json();
    if(res.ok) { alert('Updated'); clearForm(); fetchList(); }
    else alert(j.error||'Error');
  } else {
    const res = await fetch(apiUrl, {method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify(payload)});
    const j = await res.json();
    if(res.ok) { alert('Created id '+(j.id||'')); clearForm(); fetchList(); }
    else alert(j.error||'Error');
  }
  closeModal();
});

resetBtn && resetBtn.addEventListener('click', (e)=>{ e.preventDefault(); clearForm(); });

createBtn.addEventListener('click', (e)=>{ e.preventDefault(); clearForm(); openModal(); });
modalCancel.addEventListener('click', (e)=>{ e.preventDefault(); closeModal(); });

function openModal(){ modalOverlay.setAttribute('aria-hidden','false'); }
function closeModal(){ modalOverlay.setAttribute('aria-hidden','true'); }

async function deleteItem(id){
  const res = await fetch(apiUrl+'?id='+encodeURIComponent(id), {method:'DELETE'});
  const j = await res.json();
  if(res.ok) { fetchList(); }
  else alert(j.error||'Error');
}

async function init(){
  try {
    const teritorijaSelect = document.getElementById('Teritorija_Id');
    const teikejasSelect = document.getElementById('Teikejas');
    const tRes = await fetch(apiUrl+'?teritorijos=1');
    const tData = await tRes.json();
    teritorijaMap = {};
    tData.forEach(t => { teritorijaMap[t.Id] = t; });
    if (teritorijaSelect) teritorijaSelect.innerHTML = '<option value="">— pasirinkti —</option>' + tData.map(t=>`<option value="${t.Id}">${escapeHtml(t.Teritorinis_padalinis)}</option>`).join('');
    if (teritorijaSelect) {
      teritorijaSelect.addEventListener('change', ()=>{
        const id = teritorijaSelect.value;
        const addr = id && teritorijaMap[id] ? teritorijaMap[id].Adresas : '';
        const addrInput = document.getElementById('Adresas'); if (addrInput) addrInput.value = addr;
      });
    }
    const teRes = await fetch(apiUrl+'?teikejai=1');
    const teData = await teRes.json();
    if (teikejasSelect) teikejasSelect.innerHTML = teData.map(v=>`<option value="${v}">${escapeHtml(v)}</option>`).join('');
  } catch (err) {
    console.error('Dropdown load failed', err);
  }
  fetchList();

  const searchCol = document.getElementById('search-col');
  const searchQ = document.getElementById('search-q');
  const searchBtn = document.getElementById('search-btn');
  const clearBtn = document.getElementById('clear-search-btn');
  if (searchBtn) searchBtn.addEventListener('click', (e)=>{ e.preventDefault(); window.globalSearch = {col: searchCol.value, q: searchQ.value}; fetchList(); });
  if (clearBtn) clearBtn.addEventListener('click', (e)=>{ e.preventDefault(); window.globalSearch = null; searchQ.value = ''; fetchList(); });
}

init();
