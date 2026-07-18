<?php
require_once __DIR__ . '/config.php';

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME, DB_CHARSET);
$pdo = new PDO($dsn, DB_USER, DB_PASS);

$allowedTeikejai = ['Bitė','Tele2','Telia','Pildyk','Labas','Ežys'];

$terStmt = $pdo->query('SELECT Id, Teritorinis_padalinis, Adresas FROM Teritorija ORDER BY Teritorinis_padalinis ASC');
$teritorijos = $terStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['Id']) ? (int)$_POST['Id'] : 0;
    if ($id > 0) {
        $sql = "UPDATE Informacija SET Moketojo_kodas = :Moketojo_kodas, Strukturinis_padalinis = :Strukturinis_padalinis, Pareigos = :Pareigos, Vardas_pavarde = :Vardas_pavarde, Telefono_nr = :Telefono_nr, IP = :IP, ICCID = :ICCID, M_parasas = :M_parasas, Pastaba = :Pastaba, Modemas = :Modemas, Teritorija_Id = :Teritorija_Id, Teikejas = :Teikejas WHERE Id = :Id";
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
            ':Id' => $id,
        ]);
    }

    header('Location: index.php');
    exit;
}

$editRow = null;
if (isset($_GET['id'])) {
    $editId = (int)$_GET['id'];
    $editStmt = $pdo->prepare('SELECT * FROM Informacija WHERE Id = :Id');
    $editStmt->execute([':Id' => $editId]);
    $editRow = $editStmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Redaguoti įrašą</title>
    <style>body{font-family:Arial,Helvetica,sans-serif;padding:20px;}label{display:block;margin-bottom:8px;}textarea{width:100%;height:80px;}</style>
</head>
<body>

<?php if ($editRow): ?>
    <h1>Redaguoti įrašą #<?php echo (int)$editRow['Id']; ?></h1>
    <form method="post">
        <input type="hidden" name="Id" value="<?php echo (int)$editRow['Id']; ?>">
        <div><label>Moketojo_kodas: <input name="Moketojo_kodas" value="<?php echo $editRow['Moketojo_kodas']; ?>"></label></div>
        <div><label>Teritorinis padalinis: <select name="Teritorija_Id">
            <option value="">— pasirinkti —</option>
            <?php foreach ($teritorijos as $t): ?>
                <option value="<?php echo (int)$t['Id']; ?>" <?php echo ($t['Id'] == $editRow['Teritorija_Id']) ? 'selected' : ''; ?>><?php echo ($t['Teritorinis_padalinis']); ?></option>
            <?php endforeach; ?>
        </select></label></div>
        <div><label>Strukturinis_padalinis: <input name="Strukturinis_padalinis" value="<?php echo ($editRow['Strukturinis_padalinis']); ?>"></label></div>
        <div><label>Pareigos: <input name="Pareigos" value="<?php echo ($editRow['Pareigos']); ?>"></label></div>
        <div><label>Vardas_pavarde: <input name="Vardas_pavarde" value="<?php echo ($editRow['Vardas_pavarde']); ?>"></label></div>
        <div><label>Telefono_nr: <input name="Telefono_nr" value="<?php echo ($editRow['Telefono_nr']); ?>"></label></div>
        <div><label>IP: <input name="IP" value="<?php echo ($editRow['IP']); ?>"></label></div>
        <div><label>ICCID: <input name="ICCID" value="<?php echo ($editRow['ICCID']); ?>"></label></div>
        <div><label>M_parasas: <input type="checkbox" name="M_parasas" value="1" <?php echo $editRow['M_parasas'] ? 'checked' : ''; ?>></label></div>
        <div><label>Pastaba: <textarea name="Pastaba"><?php echo ($editRow['Pastaba']); ?></textarea></label></div>
        <div><label>Modemas: <input name="Modemas" value="<?php echo $editRow['Modemas']; ?>"></label></div>
        <div><label>Teikejas: <select name="Teikejas" required>
            <option value="" disabled>— pasirinkti —</option>
            <?php foreach ($allowedTeikejai as $t): ?>
                <option value="<?php echo ($t); ?>" <?php echo ($t === $editRow['Teikejas']) ? 'selected' : ''; ?>><?php echo ($t); ?></option>
            <?php endforeach; ?>
        </select></label></div>
        <div><button type="submit">Išsaugoti</button> <a href="index.php">Atšaukti</a></div>
    </form>
<?php else: ?>
    <p>Įrašas nerastas.</p>
    <p><a href="index.php">Grįžti</a></p>
<?php endif; ?>

</body>
</html>
