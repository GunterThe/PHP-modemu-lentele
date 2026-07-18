<?php
require_once __DIR__ . '/config.php';

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME, DB_CHARSET);
$pdo = new PDO($dsn, DB_USER, DB_PASS);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$action = $_POST['action'] ?? '';
	if ($action === 'delete') {
		$id = isset($_POST['Id']) ? (int)$_POST['Id'] : 0;
		if ($id > 0) {
			$stmt = $pdo->prepare('DELETE FROM Informacija WHERE Id = :Id');
			$stmt->execute([':Id' => $id]);
		}
		header('Location: ' . basename(__FILE__));
		exit;
	}

}

$sql = "SELECT i.Id, i.Moketojo_kodas, i.Strukturinis_padalinis, i.Pareigos, i.Vardas_pavarde, i.Telefono_nr, i.IP, i.ICCID, i.M_parasas, i.Pastaba, i.Modemas, i.Teikejas, t.Teritorinis_padalinis, t.Adresas, i.Teritorija_Id
		FROM Informacija i
		LEFT JOIN Teritorija t ON i.Teritorija_Id = t.Id
		ORDER BY i.Id ASC";
$stmt = $pdo->query($sql);

$terStmt = $pdo->query('SELECT Id, Teritorinis_padalinis, Adresas FROM Teritorija ORDER BY Teritorinis_padalinis ASC');
$teritorijos = $terStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="lt">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Informacija</title>
	<style>
		body { font-family: Arial, Helvetica, sans-serif; padding: 20px; }
		table { border-collapse: collapse; width: 100%; max-width: 1200px; }
		th, td { border: 1px solid #bbb; padding: 8px; text-align: left; }
		th { background: #efefef; }
		tr:nth-child(even) { background: #fafafa; }
		h1 { margin-bottom: 16px; }
		.small { font-size: 0.9em; color: #555; }
	</style>
</head>
<body>

<h1>Informacija</h1>

<p>
	<a href="create.php">Sukurti naują įrašą</a>
</p>

<table>
	<thead>
		<tr>
			<th>Id</th>
			<th>Moketojo_kodas</th>
			<th>Vardas_pavarde</th>
			<th>Telefono_nr</th>
			<th>ICCID</th>
			<th>Teritorinis padalinis</th>
			<th>Adresas</th>
			<th>M_parasas</th>
			<th>Modemas</th>
			<th>Teikejas</th>
		</tr>
	</thead>
	<tbody>
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
					<a href="edit.php?id=<?php echo (int)$row['Id']; ?>">Redaguoti</a>
					|
					<form method="post" style="display:inline" onsubmit="return confirm('Ar tikrai ištrinti?');">
						<input type="hidden" name="action" value="delete">
						<input type="hidden" name="Id" value="<?php echo (int)$row['Id']; ?>">
						<button type="submit">Ištrinti</button>
					</form>
				</td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>

</body>
</html>