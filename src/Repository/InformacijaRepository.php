<?php
namespace App\Repository;
use PDO;
use App\Model\Informacija;
use App\Database\Connection;
use InvalidArgumentException;

class InformacijaRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getPDO();
    }

    public function create(Informacija $m): int
    {
        $sql = "INSERT INTO Informacija
            (Moketojo_kodas, Strukturinis_padalinis, Pareigos, Vardas_pavarde,
             Telefono_nr, IP, ICCID, M_parasas, Pastaba, Modemas, Teritorija_Id, Teikejas)
            VALUES
            (:Moketojo_kodas, :Strukturinis_padalinis, :Pareigos, :Vardas_pavarde,
             :Telefono_nr, :IP, :ICCID, :M_parasas, :Pastaba, :Modemas, :Teritorija_Id, :Teikejas)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':Moketojo_kodas' => $m->Moketojo_kodas,
            ':Strukturinis_padalinis' => $m->Strukturinis_padalinis,
            ':Pareigos' => $m->Pareigos,
            ':Vardas_pavarde' => $m->Vardas_pavarde,
            ':Telefono_nr' => $m->Telefono_nr,
            ':IP' => $m->IP,
            ':ICCID' => $m->ICCID,
            ':M_parasas' => $m->M_parasas,
            ':Pastaba' => $m->Pastaba,
            ':Modemas' => $m->Modemas,
            ':Teritorija_Id' => $m->Teritorija_Id,
            ':Teikejas' => $m->Teikejas,
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function find(int $id): ?Informacija
    {
        $stmt = $this->pdo->prepare('SELECT i.*, t.Teritorinis_padalinis as Teritorinis_padalinis, t.Adresas as Adresas FROM Informacija i LEFT JOIN Teritorija t ON i.Teritorija_Id = t.Id WHERE i.Id = :id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        if (!$row) return null;
        return Informacija::fromArray($row);
    }

    public function update(Informacija $m): bool
    {
        if ($m->Id === null) return false;
        $sql = "UPDATE Informacija SET
            Moketojo_kodas = :Moketojo_kodas,
            Strukturinis_padalinis = :Strukturinis_padalinis,
            Pareigos = :Pareigos,
            Vardas_pavarde = :Vardas_pavarde,
            Telefono_nr = :Telefono_nr,
            IP = :IP,
            ICCID = :ICCID,
            M_parasas = :M_parasas,
            Pastaba = :Pastaba,
            Modemas = :Modemas,
            Teritorija_Id = :Teritorija_Id,
            Teikejas = :Teikejas
            WHERE Id = :Id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':Moketojo_kodas' => $m->Moketojo_kodas,
            ':Strukturinis_padalinis' => $m->Strukturinis_padalinis,
            ':Pareigos' => $m->Pareigos,
            ':Vardas_pavarde' => $m->Vardas_pavarde,
            ':Telefono_nr' => $m->Telefono_nr,
            ':IP' => $m->IP,
            ':ICCID' => $m->ICCID,
            ':M_parasas' => $m->M_parasas,
            ':Pastaba' => $m->Pastaba,
            ':Modemas' => $m->Modemas,
            ':Teritorija_Id' => $m->Teritorija_Id,
            ':Teikejas' => $m->Teikejas,
            ':Id' => $m->Id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM Informacija WHERE Id = :id');
        return $stmt->execute([':id' => $id]);
    }

    public function all(int $limit = 100, int $offset = 0): array
    {
        $stmt = $this->pdo->prepare('SELECT i.*, t.Teritorinis_padalinis as Teritorinis_padalinis, t.Adresas as Adresas FROM Informacija i LEFT JOIN Teritorija t ON i.Teritorija_Id = t.Id LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $out = [];
        foreach ($rows as $r) $out[] = Informacija::fromArray($r)->toArray();
        return $out;
    }
    public function search(string $column, string $term, int $limit = 100, int $offset = 0): array
    {
        $mapping = [
            'Id' => 'i.Id',
            'Moketojo_kodas' => 'i.Moketojo_kodas',
            'Vardas_pavarde' => 'i.Vardas_pavarde',
            'Telefono_nr' => 'i.Telefono_nr',
            'ICCID' => 'i.ICCID',
            'Modemas' => 'i.Modemas',
            'Teikejas' => 'i.Teikejas',
            'Strukturinis_padalinis' => 'i.Strukturinis_padalinis',
            'Teritorinis_padalinis' => 't.Teritorinis_padalinis',
            'Adresas' => 't.Adresas',
        ];

        if (!isset($mapping[$column])) {
            throw new InvalidArgumentException('Invalid search column');
        }

        $sqlCol = $mapping[$column];
        $sql = "SELECT i.*, t.Teritorinis_padalinis as Teritorinis_padalinis, t.Adresas as Adresas FROM Informacija i LEFT JOIN Teritorija t ON i.Teritorija_Id = t.Id WHERE $sqlCol LIKE :term LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':term', '%' . $term . '%', PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $out = [];
        foreach ($rows as $r) $out[] = Informacija::fromArray($r)->toArray();
        return $out;
    }

    public function getTeritorijos(): array
    {
        $stmt = $this->pdo->query('SELECT Id, Teritorinis_padalinis, Adresas FROM Teritorija ORDER BY Teritorinis_padalinis');
        return $stmt->fetchAll();
    }
}
