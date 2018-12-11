<!DOCTYPE html>
<html lang="es">
<head>
<title>cookies</title>
</head>
<body>
<?php
if (isset($_GET['consultar'])) {
    if (isset($_COOKIE[$_GET['nombre']])) {
        $cookie = $_COOKIE[$_GET['nombre']];
        echo $_GET['nombre'] . "= $cookie";
      } else {
        echo 'No existe esa cookie';
    }
} else if (isset($_GET['registrar'])) {
    setCookie($_GET['nombre'], $_GET['valor'], time() + 60 * 60 * 24 * 30);
}
?>
<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label>NombreCookie:</label>
    <input type="text" name="nombre" value="">
    <label>ValorCookie:</label>
    <input type="text" name="valor" value="">

    <input type="submit" name="consultar" value="CONSULTA">
    <input type="submit" name="registrar" value="REGISTRAR">
</form>