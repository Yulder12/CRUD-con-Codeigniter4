<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Semantic UI CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Detalle del Estudiante</title>
</head>
<body>
<div class="ui container">
    <div class="ui segment">
        <h1 class="ui header">Detalles del Estudiante</h1>
        <a href="<?= site_url('estudiantes/editar/' . $estudiante['codigo']) ?>" class="ui blue button">
            <i class="fas fa-edit"></i> Actualizar
        </a>
        <button class="ui red button right floated" onclick="mostrarModal()">
            <i class="fas fa-trash-alt"></i> Borrar (no se podrá deshacer)
        </button>
        <div id="myModal" class="ui modal" style="display: none;">
            <div class="header">¿Está usted seguro?</div>
            <div class="content">
                <a href="<?= site_url('estudiantes/eliminar/' . $estudiante['codigo']) ?>" class="ui red button">Sí</a>
                <button class="ui gray button" onclick="cerrarModal()">No</button>
            </div>
        </div>
        <br><br>
        <table class="ui celled table">
            <thead>
                <tr><th>Atributo</th><th>Valor</th></tr>
            </thead>
            <tbody>
                <tr><td>Primer Nombre</td><td><?= esc($estudiante['nombre1']) ?></td></tr>
                <tr><td>Segundo Nombre</td><td><?= esc($estudiante['nombre2']) ?></td></tr>
                <tr><td>Primer Apellido</td><td><?= esc($estudiante['apellido1']) ?></td></tr>
                <tr><td>Segundo Apellido</td><td><?= esc($estudiante['apellido2']) ?></td></tr>
                <tr><td>Tipo de Sangre</td><td><?= esc($estudiante['tiposangre']) ?></td></tr>
                <tr><td>Altura</td><td><?= esc($estudiante['altura']) ?></td></tr>
                <tr><td>Peso</td><td><?= esc($estudiante['peso']) ?></td></tr>
                <tr><td>Color Ojos</td><td><?= esc($estudiante['nombre_colorojos']) ?></td></tr>
                <tr><td>Fecha de Nacimiento</td><td><?= esc($estudiante['fecha']) ?></td></tr>
                <tr><td>Color Preferido</td><td><?= esc($estudiante['nombre_colorprefiere']) ?></td></tr>
                <tr><td>Profesión</td><td><?= esc($estudiante['profesion']) ?></td></tr>
                <tr><td>Nacionalidad</td><td><?= esc($estudiante['nacionalidad']) ?></td></tr>
                <tr><td>Correo</td><td><?= esc($estudiante['correo']) ?></td></tr>
                <tr><td>Página Web</td><td><a href="<?= esc($estudiante['URL']) ?>" target="_blank" class="ui blue link"><?= esc($estudiante['URL']) ?></a></td></tr>
                <tr><td>Celular</td><td><?= esc($estudiante['celular']) ?></td></tr>
                <tr><td>Estado Civil</td><td><?= esc($estudiante['estadocivil']) ?></td></tr>
                <tr><td>Ciudad donde trabaja</td><td><?= esc($estudiante['CiudadTrabajo']) ?></td></tr>
                <tr><td>Observación</td><td><?= esc(strip_tags($estudiante['observacion'])) ?></td></tr>
                <tr><td>Foto</td><td><img src="<?= base_url('' . esc($estudiante['foto'])) ?>" alt="Foto del estudiante" class="ui image"></td></tr>
            </tbody>
        </table>
    </div>
    <div class="ui segment">
        <nav class="ui pagination menu">
            <a href="<?= site_url('estudiantes') ?>" class="ui blue button" class="item">← Retornar al listado</a>
        </nav>
    </div>
</div>

<script>
    function mostrarModal() {
        document.getElementById('myModal').style.display = "block";
        $('.ui.modal').modal('show');
    }

    function cerrarModal() {
        document.getElementById('myModal').style.display = "none";
        $('.ui.modal').modal('hide');
    }
</script>

<!-- Semantic UI JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
</body>
</html>
