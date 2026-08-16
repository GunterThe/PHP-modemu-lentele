<?php
require_once __DIR__ . '/config.php';

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME, DB_CHARSET);
$pdo = new PDO($dsn, DB_USER, DB_PASS);
$search = $_GET['search'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$id = isset($_POST['Id']) ? (int) $_POST['Id'] : 0;
	if ($id > 0) {
		$stmt = $pdo->prepare('DELETE FROM Informacija WHERE Id = :Id');
		$stmt->execute([':Id' => $id]);
	}
	header('Location: ' . basename(__FILE__));
	exit;

}

$baseSql = "SELECT i.Id, i.Moketojo_kodas, i.Strukturinis_padalinis, i.Pareigos, i.Vardas_pavarde, i.Telefono_nr, i.IP, i.ICCID, i.M_parasas, i.Pastaba, i.Modemas, i.Teikejas, t.Teritorinis_padalinis, t.Adresas, i.Teritorija_Id
		FROM Informacija i
		LEFT JOIN Teritorija t ON i.Teritorija_Id = t.Id";

$terStmt = $pdo->query('SELECT Id, Teritorinis_padalinis, Adresas FROM Teritorija ORDER BY Teritorinis_padalinis ASC');
$teritorijos = $terStmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = $pdo->prepare("$baseSql WHERE i.Moketojo_kodas LIKE :search OR i.Strukturinis_padalinis LIKE :search OR i.Vardas_pavarde LIKE :search OR i.Telefono_nr LIKE :search OR i.ICCID LIKE :search OR t.Teritorinis_padalinis LIKE :search OR t.Adresas LIKE :search ORDER BY i.Id ASC");
$stmt->execute([':search' => '%' . $search . '%']);

if (isset($_GET['export'])) {

	header('Content-Type: text/csv; charset=UTF-8');
	header('Content-Disposition: attachment; filename="informacija_export_' . date('Ymd_His') . '.csv"');

	$out = fopen('php://output', 'w');
	fputcsv($out, ['Id', 'Moketojo_kodas', 'Strukturinis_padalinis', 'Pareigos', 'Vardas_pavarde', 'Telefono_nr', 'IP', 'ICCID', 'M_parasas', 'Pastaba', 'Modemas', 'Teikejas', 'Teritorinis_padalinis', 'Adresas', 'Teritorija_Id']);

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$row['M_parasas'] = $row['M_parasas'] ? 'Taip' : 'Ne';
		fputcsv($out, [
			$row['Id'],
			$row['Moketojo_kodas'],
			$row['Strukturinis_padalinis'],
			$row['Pareigos'],
			$row['Vardas_pavarde'],
			$row['Telefono_nr'],
			$row['IP'],
			$row['ICCID'],
			$row['M_parasas'],
			$row['Pastaba'],
			$row['Modemas'],
			$row['Teikejas'],
			$row['Teritorinis_padalinis'],
			$row['Adresas'],
			$row['Teritorija_Id']
		]);
	}

	fclose($out);
	exit;
}
?>

<!DOCTYPE html>
<html lang="lt">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Informacija</title>
	<link rel="stylesheet" href="style.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
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
							<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
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
							<?php endwhile; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</body>

</html>