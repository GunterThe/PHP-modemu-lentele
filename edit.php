<?php
require_once __DIR__ . '/config.php';

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME, DB_CHARSET);
$pdo = new PDO($dsn, DB_USER, DB_PASS);

$allowedTeikejai = ['Bitė', 'Tele2', 'Telia', 'Pildyk', 'Labas', 'Ežys'];

$terStmt = $pdo->query('SELECT Id, Teritorinis_padalinis, Adresas FROM Teritorija ORDER BY Teritorinis_padalinis ASC');
$teritorijos = $terStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['Id']) ? (int) $_POST['Id'] : 0;
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
            ':Teritorija_Id' => $_POST['Teritorija_Id'] ? (int) $_POST['Teritorija_Id'] : null,
            ':Teikejas' => in_array($_POST['Teikejas'] ?? '', $allowedTeikejai, true) ? $_POST['Teikejas'] : $allowedTeikejai[0],
            ':Id' => $id,
        ]);
    }

    header('Location: index.php');
    exit;
}

$editRow = null;
if (isset($_GET['id'])) {
    $editId = (int) $_GET['id'];
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
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

    <?php if ($editRow): ?>
        <div class="container py-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-3 text-dark">Redaguoti įrašą #<?php echo (int) $editRow['Id']; ?></h1>

                    <form method="post">
                        <input type="hidden" name="Id" value="<?php echo (int) $editRow['Id']; ?>">

                        <div class="mb-3">
                            <label class="form-label">Mokėtojo kodas</label>
                            <input name="Moketojo_kodas" value="<?php echo $editRow['Moketojo_kodas']; ?>"
                                class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Teritorinis padalinys</label>
                            <select name="Teritorija_Id" class="form-select">
                                <option value="">— pasirinkti —</option>
                                <?php foreach ($teritorijos as $t): ?>
                                    <option value="<?php echo (int) $t['Id']; ?>" <?php echo ($t['Id'] == $editRow['Teritorija_Id']) ? 'selected' : ''; ?>>
                                        <?php echo ($t['Teritorinis_padalinis']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Struktūrinis padalinys</label>
                            <input name="Strukturinis_padalinis" value="<?php echo ($editRow['Strukturinis_padalinis']); ?>"
                                class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pareigos</label>
                            <input name="Pareigos" value="<?php echo ($editRow['Pareigos']); ?>" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Vardas pavardė</label>
                            <input name="Vardas_pavarde" value="<?php echo ($editRow['Vardas_pavarde']); ?>"
                                class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Telefono numeris</label>
                            <input name="Telefono_nr" value="<?php echo ($editRow['Telefono_nr']); ?>" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">IP</label>
                            <input name="IP" value="<?php echo ($editRow['IP']); ?>" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">ICCID</label>
                            <input name="ICCID" value="<?php echo ($editRow['ICCID']); ?>" class="form-control">
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="M_parasas" value="1" <?php echo $editRow['M_parasas'] ? 'checked' : ''; ?> class="form-check-input" id="m_parasas_edit">
                            <label class="form-check-label" for="m_parasas_edit">M. parašas</label>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pastaba</label>
                            <textarea name="Pastaba" class="form-control"
                                rows="3"><?php echo ($editRow['Pastaba']); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Modemas</label>
                            <input name="Modemas" value="<?php echo $editRow['Modemas']; ?>" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Teikėjas</label>
                            <select name="Teikejas" required class="form-select">
                                <option value="" disabled>— pasirinkti —</option>
                                <?php foreach ($allowedTeikejai as $t): ?>
                                    <option value="<?php echo ($t); ?>" <?php echo ($t === $editRow['Teikejas']) ? 'selected' : ''; ?>><?php echo ($t); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-0">
                            <button type="submit" class="btn btn-primary">Išsaugoti</button>
                            <a href="index.php" class="btn btn-secondary ms-2">Atšaukti</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="container py-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="mb-2">Įrašas nerastas.</p>
                    <p><a href="index.php" class="btn btn-secondary">Grįžti</a></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

</body>

</html>