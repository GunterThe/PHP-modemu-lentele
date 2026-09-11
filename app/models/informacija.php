<?php

class Informacija
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllInformacija()
    {
        $basesql = "SELECT i.Id, i.Moketojo_kodas, i.Strukturinis_padalinis, i.Pareigos, i.Vardas_pavarde, i.Telefono_nr, i.IP, i.ICCID, i.M_parasas, i.Pastaba, i.Modemas, i.Teikejas, t.Teritorinis_padalinis, t.Adresas, i.Teritorija_Id
		FROM Informacija i
		LEFT JOIN Teritorija t ON i.Teritorija_Id = t.Id";
        $this->db->query($basesql);
        $this->db->execute();
        return $this->db->results();
    }

    public function getInformacijaById($id)
    {
        $basesql = "SELECT i.Id, i.Moketojo_kodas, i.Strukturinis_padalinis, i.Pareigos, i.Vardas_pavarde, i.Telefono_nr, i.IP, i.ICCID, i.M_parasas, i.Pastaba, i.Modemas, i.Teikejas, t.Teritorinis_padalinis, t.Adresas, i.Teritorija_Id
		FROM Informacija i
		LEFT JOIN Teritorija t ON i.Teritorija_Id = t.Id
		WHERE i.Id = :id";
        $this->db->query($basesql);
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->result();
    }

    public function createInformacija($data)
    {
        $this->db->query("INSERT INTO Informacija (Moketojo_kodas, Strukturinis_padalinis, Pareigos, Vardas_pavarde, Telefono_nr, IP, ICCID, M_parasas, Pastaba, Modemas, Teritorija_Id, Teikejas)
            VALUES (:Moketojo_kodas, :Strukturinis_padalinis, :Pareigos, :Vardas_pavarde, :Telefono_nr, :IP, :ICCID, :M_parasas, :Pastaba, :Modemas, :Teritorija_Id, :Teikejas)");
        
        $this->db->bind(':Moketojo_kodas', $data['Moketojo_kodas']);
        $this->db->bind(':Strukturinis_padalinis', $data['Strukturinis_padalinis']);
        $this->db->bind(':Pareigos', $data['Pareigos']);
        $this->db->bind(':Vardas_pavarde', $data['Vardas_pavarde']);
        $this->db->bind(':Telefono_nr', $data['Telefono_nr']);
        $this->db->bind(':IP', $data['IP']);
        $this->db->bind(':ICCID', $data['ICCID']);
        $this->db->bind(':M_parasas', $data['M_parasas']);
        $this->db->bind(':Pastaba', $data['Pastaba']);
        $this->db->bind(':Modemas', $data['Modemas']);
        $this->db->bind(':Teritorija_Id', $data['Teritorija_Id']);
        $this->db->bind(':Teikejas', $data['Teikejas']);

        return $this->db->execute();
    }

    public function updateInformacija($id, $data)
    {
        $this->db->query("UPDATE Informacija SET Moketojo_kodas = :Moketojo_kodas, Strukturinis_padalinis = :Strukturinis_padalinis, Pareigos = :Pareigos, Vardas_pavarde = :Vardas_pavarde, Telefono_nr = :Telefono_nr, IP = :IP, ICCID = :ICCID, M_parasas = :M_parasas, Pastaba = :Pastaba, Modemas = :Modemas, Teritorija_Id = :Teritorija_Id, Teikejas = :Teikejas WHERE id = :id");
        
        $this->db->bind(':Moketojo_kodas', $data['Moketojo_kodas']);
        $this->db->bind(':Strukturinis_padalinis', $data['Strukturinis_padalinis']);
        $this->db->bind(':Pareigos', $data['Pareigos']);
        $this->db->bind(':Vardas_pavarde', $data['Vardas_pavarde']);
        $this->db->bind(':Telefono_nr', $data['Telefono_nr']);
        $this->db->bind(':IP', $data['IP']);
        $this->db->bind(':ICCID', $data['ICCID']);
        $this->db->bind(':M_parasas', $data['M_parasas']);
        $this->db->bind(':Pastaba', $data['Pastaba']);
        $this->db->bind(':Modemas', $data['Modemas']);
        $this->db->bind(':Teritorija_Id', $data['Teritorija_Id']);
        $this->db->bind(':Teikejas', $data['Teikejas']);
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    public function deleteInformacija($id)
    {
        $this->db->query("DELETE FROM Informacija WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

}

?>