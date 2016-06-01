<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Home</title>
	</head>

	<body>
		<h1>Bienvenido!</h1>
		<p>Hello <?php echo htmlspecialchars($nombre) ?> </p>
		<?php echo htmlspecialchars($edad) ?>
	</body>
</html>