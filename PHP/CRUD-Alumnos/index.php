<?php
session_start();
//session_unset();
if (isset($_SESSION['pagina'])) {
    require_once $_SESSION['pagina'];
} else {
    $titulo = 'Menú principal';
    require_once('head.php');
    if (isset($_POST['paginaAlumnos'])) {
        $_SESSION['pagina'] = 'Alumnos/alumnos.php';
        header("Refresh:0");
    } else if (isset($_POST['paginaAsignaturas'])) {
        $_SESSION['pagina'] = 'Asignaturas/asignaturas.php';
        header("Refresh:0");
    } else if (isset($_POST['paginaNotas'])) {
        $_SESSION['pagina'] = 'Notas/notas.php';
        header("Refresh:0");
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
        <button type="submit" name="paginaAlumnos">Alumnos</button>
        <button type="submit" name="paginaAsignaturas">Asignaturas</button>
        <button type="submit" name="paginaNotas">Notas</button>
    </form>
    <?php
}
