<?php
$allowedTeikejai = ['Bitė', 'Tele2', 'Telia', 'Pildyk', 'Labas', 'Ežys'];
?>

<div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h4 mb-3 text-dark">Sukurti naują</h1>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Mokėtojo kodas</label>
                        <input name="Moketojo_kodas" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Teritorinis padalinis</label>
                        <select name="Teritorija_Id" class="form-select">
                            <option value="">— pasirinkti —</option>
                            <?php foreach ($data['teritorija'] as $t): ?>
                                <option value="<?php echo (int) $t['Id']; ?>"><?php echo ($t['Teritorinis_padalinis']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-1">
                        <label class="form-label">Struktūrinis padalinys</label>
                        <input name="Strukturinis_padalinis" class="form-control">
                    </div>

                    <div class="mb-1">
                        <label class="form-label">Pareigos</label>
                        <input name="Pareigos" class="form-control">
                    </div>

                    <div class="mb-1">
                        <label class="form-label">Vardas pavardė</label>
                        <input name="Vardas_pavarde" class="form-control">
                    </div>

                    <div class="mb-1">
                        <label class="form-label">Telefono numeris</label>
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
                        <label class="form-check-label" for="m_parasas">M. parašas</label>
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
                        <label class="form-label">Teikėjas</label>
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