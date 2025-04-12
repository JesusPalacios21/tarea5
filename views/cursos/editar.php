<?php
require_once('C:/xampp/htdocs/tarea5/includes/conexion.php');
require_once('C:/xampp/htdocs/tarea5/includes/header.php');

$pdo = Database::getConexion();

// Obtener ID del curso a editar
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<div class='alert alert-danger'>ID de curso no válido.</div>";
    exit;
}

// Aqui obtenmeos los datos
$stmt = $pdo->prepare("SELECT * FROM cursos WHERE id = ?");
$stmt->execute([$id]);
$curso = $stmt->fetch();

if (!$curso) {
    echo "<div class='alert alert-danger'>Curso no encontrado.</div>";
    exit;
}

// Se obtiene las categorias
$categorias = $pdo->query("SELECT id, categoria FROM categorias")->fetchAll();

// Procesamos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $duracionhoras = $_POST['duracionhoras'];
    $nivel = $_POST['nivel'];
    $precio = $_POST['precio'];
    $fechainicio = $_POST['fechainicio'];
    $categoria_id = $_POST['categoria_id'];

    $stmt = $pdo->prepare("UPDATE cursos 
                           SET titulo = ?, duracionhoras = ?, nivel = ?, precio = ?, fechainicio = ?, categoria_id = ? 
                           WHERE id = ?");
    $stmt->execute([$titulo, $duracionhoras, $nivel, $precio, $fechainicio, $categoria_id, $id]);

    header("Location: index.php");
    exit;
}
?>

<h2 class="mb-4">Editar Curso</h2>

<form method="POST">
    <div class="mb-3">
        <label for="titulo" class="form-label">Título</label>
        <input type="text" name="titulo" id="titulo" class="form-control" value="<?= htmlspecialchars($curso['titulo']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="duracionhoras" class="form-label">Duración (horas)</label>
        <input type="time" name="duracionhoras" id="duracionhoras" class="form-control" value="<?= $curso['duracionhoras'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="nivel" class="form-label">Nivel</label>
        <select name="nivel" id="nivel" class="form-select" required>
            <option value="">Selecciona un nivel</option>
            <option value="basico" <?= $curso['nivel'] == 'basico' ? 'selected' : '' ?>>Básico</option>
            <option value="intermedio" <?= $curso['nivel'] == 'intermedio' ? 'selected' : '' ?>>Intermedio</option>
            <option value="avanzado" <?= $curso['nivel'] == 'avanzado' ? 'selected' : '' ?>>Avanzado</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="precio" class="form-label">Precio ($)</label>
        <input type="number" step="0.01" name="precio" id="precio" class="form-control" value="<?= $curso['precio'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="fechainicio" class="form-label">Fecha de Inicio</label>
        <input type="datetime-local" name="fechainicio" id="fechainicio" class="form-control" 
               value="<?= date('Y-m-d\TH:i', strtotime($curso['fechainicio'])) ?>" required>
    </div>
    <div class="mb-3">
        <label for="categoria_id" class="form-label">Categoría</label>
        <select name="categoria_id" id="categoria_id" class="form-select" required>
            <option value="">Selecciona una categoría</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $curso['categoria_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['categoria']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Actualizar</button>
    <a href="index.php" class="btn btn-secondary">Cancelar</a>
</form>

<?php include ('C:/xampp/htdocs/tarea5/includes/footer.php')?>
