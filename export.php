<?php
require_once __DIR__ . '/config.php';

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME, DB_CHARSET);
$pdo = new PDO($dsn, DB_USER, DB_PASS);

$search = $_GET['search'] ?? '';

$baseSql = "SELECT i.Id, i.Moketojo_kodas, i.Strukturinis_padalinis, i.Pareigos, i.Vardas_pavarde, i.Telefono_nr, i.IP, i.ICCID, i.M_parasas, i.Pastaba, i.Modemas, i.Teikejas, t.Teritorinis_padalinis, t.Adresas, i.Teritorija_Id
        FROM Informacija i
        LEFT JOIN Teritorija t ON i.Teritorija_Id = t.Id";

$stmt = $pdo->prepare("$baseSql WHERE i.Moketojo_kodas LIKE :search OR i.Strukturinis_padalinis LIKE :search OR i.Vardas_pavarde LIKE :search OR i.Telefono_nr LIKE :search OR i.ICCID LIKE :search OR t.Teritorinis_padalinis LIKE :search OR t.Adresas LIKE :search ORDER BY i.Id ASC");
$stmt->execute([':search' => '%' . $search . '%']);

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="informacija_export_' . date('Ymd_His') . '.csv"');

echo "\xEF\xBB\xBF";

$out = fopen('php://output', 'w');

fputcsv($out, ['Id', 'Moketojo_kodas', 'Strukturinis_padalinis', 'Pareigos', 'Vardas_pavarde', 'Telefono_nr', 'IP', 'ICCID', 'M_parasas', 'Pastaba', 'Modemas', 'Teikejas', 'Teritorinis_padalinis', 'Adresas', 'Teritorija_Id']);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $row['M_parasas'] = $row['M_parasas'] ? 'Taip' : 'Ne';
    fputcsv($out, [
        $row['Id'],
        $row['Moketojo_kodas'],
        $row['Strukturinis_padalinis'],
        $row['Pareigos'],
        $row['Vardas_pavarde'],
        $row['Telefono_nr'],
        $row['IP'],
        $row['ICCID'],
        $row['M_parasas'],
        $row['Pastaba'],
        $row['Modemas'],
        $row['Teikejas'],
        $row['Teritorinis_padalinis'],
        $row['Adresas'],
        $row['Teritorija_Id']
    ]);
}

fclose($out);
exit;
