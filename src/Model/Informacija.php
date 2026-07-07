<?php
namespace App\Model;

class Informacija
{
    public ?int $Id = null;
    public string $Moketojo_kodas = '';
    public ?int $Teritorija_Id = null;
    public string $Teritorinis_padalinis = '';
    public string $Strukturinis_padalinis = '';
    public string $Pareigos = '';
    public string $Vardas_pavarde = '';
    public string $Telefono_nr = '';
    public string $IP = '';
    public string $ICCID = '';
    public int $M_parasas = 0;
    public string $Adresas = '';
    public string $Pastaba = '';
    public string $Modemas = '';
    public string $Teikejas = '';

    public static function fromArray(array $data): self
    {
        $m = new self();
        foreach ($data as $k => $v) {
            if (!property_exists($m, $k)) continue;

            switch ($k) {
                case 'Id':
                    $m->Id = ($v === '' || $v === null) ? null : (int)$v;
                    break;
                case 'Teritorija_Id':
                    $m->Teritorija_Id = ($v === '' || $v === null) ? null : (int)$v;
                    break;
                case 'M_parasas':
                    if ($v === '' || $v === null) {
                        $m->M_parasas = 0;
                    } else {
                        $m->M_parasas = (int)$v;
                    }
                    break;
                default:
                    $m->{$k} = $v === null ? '' : (string)$v;
            }
        }
        return $m;
    }

    public function toArray(): array
    {
        return [
            'Id' => $this->Id,
            'Moketojo_kodas' => $this->Moketojo_kodas,
            'Teritorinis_padalinis' => $this->Teritorinis_padalinis,
            'Strukturinis_padalinis' => $this->Strukturinis_padalinis,
            'Pareigos' => $this->Pareigos,
            'Vardas_pavarde' => $this->Vardas_pavarde,
            'Telefono_nr' => $this->Telefono_nr,
            'IP' => $this->IP,
            'ICCID' => $this->ICCID,
            'M_parasas' => $this->M_parasas,
            'Adresas' => $this->Adresas,
            'Teritorija_Id' => $this->Teritorija_Id,
            'Pastaba' => $this->Pastaba,
            'Modemas' => $this->Modemas,
            'Teikejas' => $this->Teikejas,
        ];
    }
}
