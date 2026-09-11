<?php
require_once __DIR__ . '/../../config/config.php';
$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME, DB_CHARSET);
$pdo = new PDO($dsn, DB_USER, DB_PASS);

$allowedTeikejai = ['Bitė', 'Tele2', 'Telia', 'Pildyk', 'Labas', 'Ežys'];

$terStmt = $pdo->query('SELECT Id, Teritorinis_padalinis, Adresas FROM Teritorija ORDER BY Teritorinis_padalinis ASC');
$teritorijos = $terStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="h4 mb-3 text-dark">Redaguoti įrašą #<?php echo (int) $row['Id']; ?></h1>

            <form method="post">
                <input type="hidden" name="Id" value="<?php echo (int) $row['Id']; ?>">

                <div class="mb-3">
                    <label class="form-label">Mokėtojo kodas</label>
                    <input name="Moketojo_kodas" value="<?php echo $row['Moketojo_kodas']; ?>"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Teritorinis padalinys</label>
                    <select name="Teritorija_Id" class="form-select">
                        <option value="">— pasirinkti —</option>
                        <?php foreach ($teritorijos as $t): ?>
                            <option value="<?php echo (int) $t['Id']; ?>" <?php echo ($t['Id'] == $row['Teritorija_Id']) ? 'selected' : ''; ?>>
                                <?php echo ($t['Teritorinis_padalinis']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Struktūrinis padalinys</label>
                    <input name="Strukturinis_padalinis" value="<?php echo ($row['Strukturinis_padalinis']); ?>"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Pareigos</label>
                    <input name="Pareigos" value="<?php echo ($row['Pareigos']); ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Vardas pavardė</label>
                    <input name="Vardas_pavarde" value="<?php echo ($row['Vardas_pavarde']); ?>"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Telefono numeris</label>
                    <input name="Telefono_nr" value="<?php echo ($row['Telefono_nr']); ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">IP</label>
                    <input name="IP" value="<?php echo ($row['IP']); ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">ICCID</label>
                    <input name="ICCID" value="<?php echo ($row['ICCID']); ?>" class="form-control">
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="M_parasas" value="1" <?php echo $row['M_parasas'] ? 'checked' : ''; ?> class="form-check-input" id="m_parasas_edit">
                    <label class="form-check-label" for="m_parasas_edit">M. parašas</label>
                </div>

                <div class="mb-3">
                    <label class="form-label">Pastaba</label>
                    <textarea name="Pastaba" class="form-control"
                        rows="3"><?php echo ($row['Pastaba']); ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Modemas</label>
                    <input name="Modemas" value="<?php echo $row['Modemas']; ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Teikėjas</label>
                    <select name="Teikejas" required class="form-select">
                        <option value="" disabled>— pasirinkti —</option>
                        <?php foreach ($allowedTeikejai as $t): ?>
                            <option value="<?php echo ($t); ?>" <?php echo ($t === $row['Teikejas']) ? 'selected' : ''; ?>><?php echo ($t); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-0">
                    <button type="submit" class="btn btn-primary">Išsaugoti</button>
                    <a href="../../../public/index.php" class="btn btn-secondary ms-2">Atšaukti</a>
                </div>
            </form>
        </div>
    </div>
</div>