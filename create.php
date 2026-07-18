<?php
require_once __DIR__ . '/config.php';

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME, DB_CHARSET);
$pdo = new PDO($dsn, DB_USER, DB_PASS);

$allowedTeikejai = ['Bitė','Tele2','Telia','Pildyk','Labas','Ežys'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO Informacija (Moketojo_kodas, Strukturinis_padalinis, Pareigos, Vardas_pavarde, Telefono_nr, IP, ICCID, M_parasas, Pastaba, Modemas, Teritorija_Id, Teikejas)
            VALUES (:Moketojo_kodas, :Strukturinis_padalinis, :Pareigos, :Vardas_pavarde, :Telefono_nr, :IP, :ICCID, :M_parasas, :Pastaba, :Modemas, :Teritorija_Id, :Teikejas)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':Moketojo_kodas' => $_POST['Moketojo_kodas'] ?? '',
        ':Strukturinis_padalinis' => $_POST['Strukturinis_padalinis'] ?? '',
        ':Pareigos' => $_POST['Pareigos'] ?? '',
        ':Vardas_pavarde' => $_POST['Vardas_pavarde'] ?? '',
        ':Telefono_nr' => $_POST['Telefono_nr'] ?? '',
        ':IP' => $_POST['IP'] ?? '',
        ':ICCID' => $_POST['ICCID'] ?? '',
        ':M_parasas' => isset($_POST['M_parasas']) ? 1 : 0,
        ':Pastaba' => $_POST['Pastaba'] ?? '',
        ':Modemas' => $_POST['Modemas'] ?? '',
        ':Teritorija_Id' => $_POST['Teritorija_Id'] ? (int)$_POST['Teritorija_Id'] : null,
        ':Teikejas' => in_array($_POST['Teikejas'] ?? '', $allowedTeikejai, true) ? $_POST['Teikejas'] : $allowedTeikejai[0],
    ]);

    header('Location: index.php');
    exit;
}

$terStmt = $pdo->query('SELECT Id, Teritorinis_padalinis, Adresas FROM Teritorija ORDER BY Teritorinis_padalinis ASC');
$teritorijos = $terStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Sukurti naują</title>
    <style>body{font-family:Arial,Helvetica,sans-serif;padding:20px;}label{display:block;margin-bottom:8px;}textarea{width:100%;height:80px;}</style>
</head>
<body>

<h1>Sukurti naują</h1>

<form method="post">
    <div><label>Moketojo_kodas: <input name="Moketojo_kodas"></label></div>
    <div><label>Teritorinis padalinis: <select name="Teritorija_Id">
        <option value="">— pasirinkti —</option>
        <?php foreach ($teritorijos as $t): ?>
            <option value="<?php echo (int)$t['Id']; ?>"><?php echo ($t['Teritorinis_padalinis']); ?></option>
        <?php endforeach; ?>
    </select></label></div>
    <div><label>Strukturinis_padalinis: <input name="Strukturinis_padalinis"></label></div>
    <div><label>Pareigos: <input name="Pareigos"></label></div>
    <div><label>Vardas_pavarde: <input name="Vardas_pavarde"></label></div>
    <div><label>Telefono_nr: <input name="Telefono_nr"></label></div>
    <div><label>IP: <input name="IP"></label></div>
    <div><label>ICCID: <input name="ICCID"></label></div>
    <div><label>M_parasas: <input type="checkbox" name="M_parasas" value="1"></label></div>
    <div><label>Pastaba: <textarea name="Pastaba"></textarea></label></div>
    <div><label>Modemas: <input name="Modemas"></label></div>
    <div><label>Teikejas: <select name="Teikejas" required>
        <option value="" disabled selected>— pasirinkti —</option>
        <?php foreach ($allowedTeikejai as $t): ?>
            <option value="<?php echo ($t); ?>"><?php echo ($t); ?></option>
        <?php endforeach; ?>
    </select></label></div>
    <div><button type="submit">Sukurti</button> <a href="index.php">Atšaukti</a></div>
</form>

</body>
</html>
