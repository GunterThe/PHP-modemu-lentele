<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="h4 mb-3 text-dark">Redaguoti teritoriją #<?php echo (int) $row['Id']; ?></h1>

            <form method="post">
                <input type="hidden" name="Id" value="<?php echo (int) $row['Id']; ?>">

                <div class="mb-3">
                    <label class="form-label">Teritorinis padalinys</label>
                    <input name="Teritorinis_padalinis" value="<?php echo $row['Teritorinis_padalinis']; ?>"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Adresas</label>
                    <input name="Adresas" value="<?php echo ($row['Adresas']); ?>"
                        class="form-control">
                </div>

                <div class="mb-0">
                    <button type="submit" class="btn btn-primary">Išsaugoti</button>
                    <a href="../../../public/teritorija" class="btn btn-secondary ms-2">Atšaukti</a>
                </div>
            </form>
        </div>
    </div>
</div>