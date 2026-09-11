<div>
    <h1 class="h4 mb-3 text-dark">Įrašo informacija #<?php echo (int) $row['Id']; ?></h1>
    <p>Mokėtojo kodas: <?php echo $row['Moketojo_kodas']; ?></p>
    <p>Teritorinis padalinys: <?php echo $row['Teritorinis_padalinis']; ?></p>
    <p>Struktūrinis padalinys: <?php echo $row['Strukturinis_padalinis']; ?></p>
    <p>Pareigos: <?php echo $row['Pareigos']; ?></p>
    <p>Vardas pavardė: <?php echo $row['Vardas_pavarde']; ?></p>
    <p>Telefono numeris: <?php echo $row['Telefono_nr']; ?></p>
    <p>IP: <?php echo $row['IP']; ?></p>
    <p>ICCID: <?php echo $row['ICCID']; ?></p>
    <p>M. parašas: <?php echo $row['M_parasas'] ? 'Taip' : 'Ne'; ?></p>
    <p>Pastaba: <?php echo $row['Pastaba']; ?></p>
    <p>Modemas: <?php echo $row['Modemas']; ?></p>
    <p>Teikėjas: <?php echo $row['Teikejas']; ?></p>
</div>