<?php
require_once('C:/xampp/htdocs/tarea5/includes/conexion.php');
require_once('C:/xampp/htdocs/tarea5/includes/header.php');

$pdo = Database::getConexion();

//Como en otros archivos....siempre se llama al id para que se sepa en que registro se está modificando lo que se quiere
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<div class='alert alert-danger'>ID de curso no válido.</div>";
    exit;
}

// Se obtiene el curso
$stmt = $pdo->prepare("SELECT cursos.*, categorias.categoria 
                       FROM cursos 
                       LEFT JOIN categorias ON cursos.categoria_id = categorias.id 
                       WHERE cursos.id = ?");
$stmt->execute([$id]);
$curso = $stmt->fetch();

if (!$curso) {
    echo "<div class='alert alert-danger'>Curso no encontrado.</div>";
    exit;
}

// Con el metodo post hacemos la confirmación de eliminacion sencillita, esto hará que no tengamos eliminaciones por error
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("DELETE FROM cursos WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: index.php?");
    exit;
}
?>

<h2 class="mb-4 text-danger">¿Estás seguro de eliminar este curso?</h2>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($curso['titulo']) ?></h5>
        <p class="card-text"><strong>Categoría:</strong> <?= htmlspecialchars($curso['categoria'] ?? 'Sin categoría') ?></p>
        <p class="card-text"><strong>Duración:</strong> <?= $curso['duracionhoras'] ?> | <strong>Nivel:</strong> <?= ucfirst($curso['nivel']) ?></p>
        <p class="card-text"><strong>Precio:</strong> $<?= $curso['precio'] ?> | <strong>Inicio:</strong> <?= $curso['fechainicio'] ?></p>
    </div>
</div>

<form method="POST">
    <button type="submit" class="btn btn-danger">Sí, eliminar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php include ('C:/xampp/htdocs/tarea5/includes/footer.php')?>
