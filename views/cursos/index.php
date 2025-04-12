<?php
// Incluimos la conexion aquí
require_once('C:/xampp/htdocs/tarea5/includes/conexion.php');

// Incluimos el header (cabecera que tendrá mi llamado a bootstrap)
require_once('C:/xampp/htdocs/tarea5/includes/header.php');

// Obtenemos la conexión de la bd
$pdo = Database::getConexion();

// Se realiza la consulta
$stmt = $pdo->query("SELECT cursos.*, categorias.categoria 
                     FROM cursos 
                     LEFT JOIN categorias ON cursos.categoria_id = categorias.id 
                     ORDER BY cursos.id DESC");

// Se obtiene los resultados
$cursos = $stmt->fetchAll();
?>

<h1 class="mb-4">Lista de Cursos</h1>

<a href="crear.php" class="btn btn-primary mb-3">Agregar Curso</a>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Duración</th>
            <th>Nivel</th>
            <th>Precio</th>
            <th>Fecha de Inicio</th>
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cursos as $curso): ?>
            <tr>
                <td><?= $curso['id'] ?></td>
                <td><?= htmlspecialchars($curso['titulo']) ?></td>
                <td><?= $curso['duracionhoras'] ?></td>
                <td><?= ucfirst($curso['nivel']) ?></td>
                <td>$<?= $curso['precio'] ?></td>
                <td><?= $curso['fechainicio'] ?></td>
                <td><?= htmlspecialchars($curso['categoria'] ?? 'Sin categoría') ?></td>
                <td>
                    <a href="editar.php?id=<?= $curso['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="eliminar.php?id=<?= $curso['id'] ?>" class="btn btn-sm btn-danger">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include ('C:/xampp/htdocs/tarea5/includes/footer.php'); ?> <!--Este simplemente llama al script que pusimos en el footer-->


