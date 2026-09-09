<?php
require_once __DIR__ . '/config.php';
session_start();
$error = '';
if (isset($_SESSION['username'])) {
  header("Location: index.php");
  exit;
}

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_NAME, DB_CHARSET);
$pdo = new PDO($dsn, DB_USER, DB_PASS);

if (isset($_POST['login'])) {

  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM naudotojas WHERE username = ?");
  $stmt->execute([$username]);
  $user = $stmt->fetch();
  
  if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['username'] = $user['username'];
    header("Location: index.php");
    exit;
  } else {
    $error = "Invalid username or password.";
  }
}

?>

<!DOCTYPE html>
<html lang="lt">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Prisijungimas</title>
	<link rel="stylesheet" href="style.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
	<div class="container py-5">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card shadow-sm">
					<div class="card-body">
						<h1 class="h3 mb-3">Prisijungimas</h1>

						<?php if ($error): ?>
							<div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
						<?php endif; ?>

						<form method="post" action="">
							<div class="mb-3">
								<label for="username" class="form-label">Vartotojo vardas</label>
								<input id="username" name="username" type="text" class="form-control" required>
							</div>

							<div class="mb-3">
								<label for="password" class="form-label">Slaptažodis</label>
								<input id="password" name="password" type="password" class="form-control" required>
							</div>

							<button type="submit" name="login" class="btn btn-primary">Prisijungti</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>