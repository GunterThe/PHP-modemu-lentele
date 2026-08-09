<?php
require_once __DIR__ . '/config.php';

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME, DB_CHARSET);
$pdo = new PDO($dsn, DB_USER, DB_PASS);

$allowedTeikejai = ['Bitė', 'Tele2', 'Telia', 'Pildyk', 'Labas', 'Ežys'];

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
        ':Teritorija_Id' => $_POST['Teritorija_Id'] ? (int) $_POST['Teritorija_Id'] : null,
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
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h4 mb-3 text-dark">Sukurti naują</h1>

                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Moketojo_kodas</label>
                        <input name="Moketojo_kodas" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Teritorinis padalinis</label>
                        <select name="Teritorija_Id" class="form-select">
                            <option value="">— pasirinkti —</option>
                            <?php foreach ($teritorijos as $t): ?>
                                <option value="<?php echo (int) $t['Id']; ?>"><?php echo ($t['Teritorinis_padalinis']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-1">
                        <label class="form-label">Strukturinis_padalinis</label>
                        <input name="Strukturinis_padalinis" class="form-control">
                    </div>

                    <div class="mb-1">
                        <label class="form-label">Pareigos</label>
                        <input name="Pareigos" class="form-control">
                    </div>

                    <div class="mb-1">
                        <label class="form-label">Vardas_pavarde</label>
                        <input name="Vardas_pavarde" class="form-control">
                    </div>

                    <div class="mb-1">
                        <label class="form-label">Telefono_nr</label>
                        <input name="Telefono_nr" class="form-control">
                    </div>

                    <div class="mb-1">
                        <label class="form-label">IP</label>
                        <input name="IP" class="form-control">
                    </div>

                    <div class="mb-1">
                        <label class="form-label">ICCID</label>
                        <input name="ICCID" class="form-control">
                    </div>

                    <div class="mb-1 form-check">
                        <input type="checkbox" name="M_parasas" value="1" class="form-check-input" id="m_parasas">
                        <label class="form-check-label" for="m_parasas">M_parasas</label>
                    </div>

                    <div class="mb-1">
                        <label class="form-label">Pastaba</label>
                        <textarea name="Pastaba" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-1">
                        <label class="form-label">Modemas</label>
                        <input name="Modemas" class="form-control">
                    </div>

                    <div class="mb-1">
                        <label class="form-label">Teikejas</label>
                        <select name="Teikejas" required class="form-select">
                            <option value="" disabled selected>— pasirinkti —</option>
                            <?php foreach ($allowedTeikejai as $t): ?>
                                <option value="<?php echo ($t); ?>"><?php echo ($t); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-1">
                        <button type="submit" class="btn btn-primary">Sukurti</button>
                        <a href="index.php" class="btn btn-secondary ms-2">Atšaukti</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>