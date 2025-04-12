<?php
require_once('C:/xampp/htdocs/tarea5/includes/conexion.php');
require_once('C:/xampp/htdocs/tarea5/includes/header.php');

$pdo = Database::getConexion();

// En este punto se obtiene las categorias que existen
$categorias = $pdo->query("SELECT id, categoria FROM categorias")->fetchAll();

// Se procesa el formulario con post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $duracionhoras = $_POST['duracionhoras'];
    $nivel = $_POST['nivel'];
    $precio = $_POST['precio'];
    $fechainicio = $_POST['fechainicio'];

    $categoria_id = $_POST['categoria_id'] ?? null;
    $nueva_categoria = trim($_POST['nueva_categoria']);

    // Si se escribió una nueva categoría se inserta primero
    if (!empty($nueva_categoria)) {
        $stmtCat = $pdo->prepare("INSERT INTO categorias (categoria) VALUES (?)");
        $stmtCat->execute([$nueva_categoria]);
        $categoria_id = $pdo->lastInsertId(); // ID recién insertado
    }

    // Se valida que haya una categoria insertada
    if (empty($categoria_id)) {
        echo "<div class='alert alert-danger'>Debes seleccionar o crear una categoría.</div>";
    } else {
        $stmt = $pdo->prepare("INSERT INTO cursos (titulo, duracionhoras, nivel, precio, fechainicio, categoria_id)
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$titulo, $duracionhoras, $nivel, $precio, $fechainicio, $categoria_id]);

        header("Location: index.php");
        exit;
    }
}
?>

<h2 class="mb-4">Agregar Curso</h2>

<form method="POST" class="needs-validation" novalidate>
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" name="titulo" id="titulo" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="duracionhoras" class="form-label">Duración (horas)</label>
        <input type="time" name="duracionhoras" id="duracionhoras" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="nivel" class="form-label">Nivel</label>
        <select name="nivel" id="nivel" class="form-select" required>
            <option value="">Selecciona un nivel</option>
            <option value="basico">Básico</option>
            <option value="intermedio">Intermedio</option>
            <option value="avanzado">Avanzado</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="precio" class="form-label">Precio ($)</label>
        <input type="number" step="0.01" name="precio" id="precio" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="fechainicio" class="form-label">Fecha de Inicio</label>
        <input type="datetime-local" name="fechainicio" id="fechainicio" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="categoria_id" class="form-label">Categoría existente</label>
        <select name="categoria_id" id="categoria_id" class="form-select">
            <option value="">Selecciona una categoría</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['categoria']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="nueva_categoria" class="form-label">O escribe una nueva categoría</label>
        <input type="text" name="nueva_categoria" id="nueva_categoria" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Guardar Curso</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php include ('C:/xampp/htdocs/tarea5/includes/footer.php')?>
