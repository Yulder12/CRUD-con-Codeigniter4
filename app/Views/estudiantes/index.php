<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Estudiantes [CRUD]</title>
</head>
<body class="ui segment">
<div class="ui container">
    <div class="ui text center aligned segment">
        <h1 class="ui header">Tabla Estudiantes: Operaciones CRUD</h1>
        <p class="ui sub header">Nombre: Yulder Felipe Orozco Londoño</p>
    </div>

    <!-- Botones de navegación -->
    <div class="ui buttons mb-4">
        <a href="<?= site_url('/estudiantes/adicionar') ?>" class="ui green button">
            <i class="fas fa-plus-circle"></i> Adicionar Estudiante
        </a>
        <a href="<?= site_url('estudiantes') ?>" class="ui grey button">Inicio</a>
        <a href="<?= site_url('estudiantes?pos=' . $paginaAnterior) ?>" class="ui blue button">&larr; Anterior</a>
        <a href="<?= site_url('estudiantes?pos=' . $paginaSigue) ?>" class="ui blue button">Siguiente &rarr;</a>
    </div>

    <!-- Tabla de Estudiantes -->
    <table class="ui celled table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Altura</th>
                <th>Peso</th>
                <th>Color Ojos</th>
                <th>Profesión</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estudiantes as $estudiante): ?>
                <tr>
                    <td><?= esc($estudiante['nombre1']) ?></td>
                    <td><?= esc($estudiante['apellido1']) ?></td>
                    <td><?= esc($estudiante['altura']) ?></td>
                    <td><?= esc($estudiante['peso']) ?></td>
                    <td><?= esc($estudiante['color_ojos']) ?></td>
                    <td><?= esc($estudiante['profesion']) ?></td>
                    <td>
                        <a href="<?= base_url('estudiantes/detalle/' . $estudiante['codigo']) ?>" class="ui blue button">
                            <i class="fas fa-info-circle"></i> Ver Más
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
</body>
</html>
