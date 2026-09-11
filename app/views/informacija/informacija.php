<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="h3">Informacija</h1>

            <p>
                <a href="create.php" class="btn btn-success">Sukurti naują įrašą</a>
                <a href="<?php echo basename(__FILE__); ?>?export=1&search=<?php echo urlencode($search); ?>" class="btn btn-outline-secondary ms-2">Eksportuoti CSV</a>
            </p>

            <form method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                        placeholder="Paieška pagal mokėtojo kodą, vardą, telefoną..."
                        value="<?= htmlspecialchars($search) ?>">
                    <button class="btn btn-primary" type="submit">
                        Ieškoti
                    </button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Mokėtojo kodas</th>
                            <th>Vardas pavardė</th>
                            <th>Telefono numeris</th>
                            <th>ICCID</th>
                            <th>Teritorinis padalinys</th>
                            <th>Adresas</th>
                            <th>M. parašas</th>
                            <th>Modemas</th>
                            <th>Teikėjas</th>
                            <th>Veiksmai</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php foreach ($data['informacija'] as $row) : ?>
                            <tr>
                                <td><?php echo $row['Id']; ?></td>
                                <td><?php echo $row['Moketojo_kodas']; ?></td>
                                <td><?php echo $row['Vardas_pavarde']; ?></td>
                                <td><?php echo $row['Telefono_nr']; ?></td>
                                <td><?php echo $row['ICCID']; ?></td>
                                <td><?php echo $row['Teritorinis_padalinis']; ?></td>
                                <td><?php echo $row['Adresas']; ?></td>
                                <td><?php echo $row['M_parasas'] ? 'Taip' : 'Ne'; ?></td>
                                <td><?php echo $row['Modemas']; ?></td>
                                <td><?php echo $row['Teikejas']; ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo (int) $row['Id']; ?>"
                                        class="btn btn-primary">Redaguoti</a>
                                    <form method="post" class="d-inline"
                                        onsubmit="return confirm('Ar tikrai ištrinti?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="Id" value="<?php echo (int) $row['Id']; ?>">
                                        <button type="submit" class="btn btn-danger">Ištrinti</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>