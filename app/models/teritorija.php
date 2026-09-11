<?php

class Teritorija
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllTeritorija()
    {
        $basesql = "SELECT i.Id, i.Teritorinis_padalinis, i.Adresas
        FROM Teritorija i";
        $this->db->query($basesql);
        $this->db->execute();
        return $this->db->results();
    }

    public function getTeritorijaById($id)
    {
        $basesql = "SELECT i.Id, i.Teritorinis_padalinis, i.Adresas
		FROM Teritorija i
		WHERE i.Id = :id";
        $this->db->query($basesql);
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->result();
    }

    public function createTeritorija($data)
    {
        $this->db->query("INSERT INTO Teritorija (Teritorinis_padalinis, Adresas)
            VALUES (:Teritorinis_padalinis, :Adresas)");
        
        $this->db->bind(':Teritorinis_padalinis', $data['Teritorinis_padalinis']);
        $this->db->bind(':Adresas', $data['Adresas']);

        return $this->db->execute();
    }

    public function updateTeritorija($id, $data)
    {
        $this->db->query("UPDATE Teritorija SET Teritorinis_padalinis = :Teritorinis_padalinis, Adresas = :Adresas WHERE id = :id");
        
        $this->db->bind(':Teritorinis_padalinis', $data['Teritorinis_padalinis']);
        $this->db->bind(':Adresas', $data['Adresas']);
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    public function deleteTeritorija($id)
    {
        $this->db->query("DELETE FROM Teritorija WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

}

?>