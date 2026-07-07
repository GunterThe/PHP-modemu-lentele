<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Informacija — CRUD</title>
	<link rel="stylesheet" href="assets/style.css?v=<?php echo filemtime(__DIR__ . '/assets/style.css'); ?>">
</head>
<body>
	<main>
		<h1>Informacija</h1>

		<div class="controls" style="margin-bottom:12px;">
			<button id="create-btn">Sukurti naują</button>
			<div style="display:inline-block;margin-left:12px;">
				<select id="search-col">
					<option value="Vardas_pavarde">Vardas_pavarde</option>
					<option value="Moketojo_kodas">Moketojo_kodas</option>
					<option value="Telefono_nr">Telefono_nr</option>
					<option value="ICCID">ICCID</option>
					<option value="Modemas">Modemas</option>
					<option value="Teikejas">Teikejas</option>
					<option value="Strukturinis_padalinis">Strukturinis_padalinis</option>
					<option value="Teritorinis_padalinis">Teritorinis_padalinis</option>
					<option value="Adresas">Adresas</option>
				</select>
				<input id="search-q" placeholder="Paieškos terminas">
				<button id="search-btn">Ieškoti</button>
				<button id="clear-search-btn">Išvalyti</button>
			</div>
		</div>

		<div id="modal-overlay" class="modal-overlay" aria-hidden="true">
			<div class="modal" role="dialog" aria-modal="true" aria-labelledby="modal-title">
				<h2 id="modal-title">Sukurti naują</h2>
				<form id="informacija-modal-form">
					<input type="hidden" name="Id" id="Id">
					<div class="row"><label>Moketojo_kodas<input name="Moketojo_kodas" id="Moketojo_kodas"></label></div>
					<div class="row"><label>Teritorinis padalinis<select name="Teritorija_Id" id="Teritorija_Id"><option value="">— pasirinkti —</option></select></label></div>
					<div class="row"><label>Strukturinis_padalinis<input name="Strukturinis_padalinis" id="Strukturinis_padalinis"></label></div>
					<div class="row"><label>Pareigos<input name="Pareigos" id="Pareigos"></label></div>
					<div class="row"><label>Vardas_pavarde<input name="Vardas_pavarde" id="Vardas_pavarde"></label></div>
					<div class="row"><label>Telefono_nr<input name="Telefono_nr" id="Telefono_nr"></label></div>
					<div class="row"><label>IP<input name="IP" id="IP"></label></div>
					<div class="row"><label>ICCID<input name="ICCID" id="ICCID"></label></div>
					<div class="row"><label>M_parasas<input type="checkbox" name="M_parasas" id="M_parasas"></label></div>
					<div class="row"><label>Adresas<input id="Adresas" disabled></label></div>
					<div class="row"><label>Pastaba<textarea name="Pastaba" id="Pastaba"></textarea></label></div>
					<div class="row"><label>Modemas<input name="Modemas" id="Modemas"></label></div>
					<div class="row"><label>Teikejas<select name="Teikejas" id="Teikejas"><option value="">— pasirinkti —</option></select></label></div>
					<div class="actions">
						<button type="submit" id="modal-save-btn">Išsaugoti</button>
						<button type="button" id="modal-cancel-btn">Atšaukti</button>
					</div>
				</form>
			</div>
		</div>

		<section id="table-section">
			<h2>Sąrašas</h2>
			<table id="informacija-table">
				<thead>
					<tr>
						<th>Id</th>
						<th>Moketojo_kodas</th>
						<th>Vardas_pavarde</th>
						<th>Telefono_nr</th>
						<th>ICCID</th>
						<th>Teritorinis padalinis</th>
						<th>Adresas</th>
						<th>M_parasas</th>
						<th>Modemas</th>
						<th>Teikejas</th>
						<th>Veiksmai</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</section>
	</main>

	<script src="assets/app.js?v=<?php echo filemtime(__DIR__ . '/assets/app.js'); ?>"></script>
</body>
</html>