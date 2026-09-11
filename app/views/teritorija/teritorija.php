<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="h3">Teritorija</h1>

            <p>
                <a href="add_teritorija.php" class="btn btn-success">Sukurti naują įrašą</a>
                <a href="<?php echo basename(__FILE__); ?>?export=1&search=<?php echo urlencode($search); ?>" class="btn btn-outline-secondary ms-2">Eksportuoti CSV</a>
            </p>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Teritorinis padalinys</th>
                            <th>Adresas</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php foreach ($data['teritorija'] as $row) : ?>
                            <tr>
                                <td><?php echo $row['Id']; ?></td>
                                <td><?php echo $row['Teritorinis_padalinis']; ?></td>
                                <td><?php echo $row['Adresas']; ?></td>
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