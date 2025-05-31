<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Estudiantes [Adicionar]</title>
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
    <script src="<?= base_url('js/listavalores.js'); ?>"></script>
</head>
<body class="ui container" style="background-color: #f4f4f4; padding-top: 20px;">
    <div class="ui segment">
        <h1 class="ui header">Adicionar registro a Estudiantes</h1>

        <!-- Mostrar errores si existen -->
        <?php if (session('errors')): ?>
            <div class="ui negative message">
                <ul class="list">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('estudiantes/save') ?>" method="post" enctype="multipart/form-data" class="ui form">
            <?= csrf_field() ?>

            <div class="ui grid">
                <div class="row">
                    <div class="sixteen wide column">
                        <!-- Campos de texto -->
                        <div class="field">
                            <label for="nombre1">Primer Nombre</label>
                            <input type="text" name="nombre1" id="nombre1" required>
                        </div>

                        <div class="field">
                            <label for="nombre2">Segundo Nombre</label>
                            <input type="text" name="nombre2" id="nombre2" required>
                        </div>

                        <div class="field">
                            <label for="apellido1">Primer Apellido</label>
                            <input type="text" name="apellido1" id="apellido1" required>
                        </div>

                        <div class="field">
                            <label for="apellido2">Segundo Apellido</label>
                            <input type="text" name="apellido2" id="apellido2" required>
                        </div>

                        <!-- Combos dinámicos -->
                        <div class="field">
                            <label for="tiposangre">Tipo de Sangre</label>
                            <select id="tiposangre" name="tiposangre" class="tom-select" data-url="<?= site_url('estudiantes/cboTipoSangre') ?>" required></select>
                        </div>

                        <div class="field">
                            <label for="altura">Altura en metros</label>
                            <input type="number" name="altura" id="altura" step=".01" required>
                        </div>

                        <div class="field">
                            <label for="peso">Peso en kilogramos</label>
                            <input type="number" name="peso" id="peso" required>
                        </div>

                        <div class="field">
                            <label for="colorojos">Color de Ojos</label>
                            <select id="colorojos" name="colorojos" class="tom-select" data-url="<?= site_url('estudiantes/cboColores') ?>" required></select>
                        </div>

                        <div class="field">
                            <label for="fechanace">Fecha de Nacimiento</label>
                            <input type="date" name="fechanace" id="fechanace" required>
                        </div>

                        <div class="field">
                            <label for="colorprefiere">Color Preferido</label>
                            <select id="colorprefiere" name="colorprefiere" class="tom-select" data-url="<?= site_url('estudiantes/cboColores') ?>" required></select>
                        </div>

                        <div class="field">
                            <label for="profesion">Profesión</label>
                            <select id="profesion" name="profesion" class="tom-select" data-url="<?= site_url('estudiantes/cboProfesiones') ?>" required></select>
                        </div>

                        <div class="field">
                            <label for="nacionalidad">Nacionalidad</label>
                            <select id="nacionalidad" name="nacionalidad" class="tom-select" data-url="<?= site_url('estudiantes/cboNacionalidad') ?>" required></select>
                        </div>

                        <!-- Otros campos -->
                        <div class="field">
                            <label for="correo">Correo Electrónico</label>
                            <input type="email" name="correo" id="correo" required>
                        </div>

                        <div class="field">
                            <label for="url">Página Web</label>
                            <input type="url" name="url" id="url" required>
                        </div>

                        <div class="field">
                            <label for="celular">Celular</label>
                            <input type="text" name="celular" id="celular" required>
                        </div>

                        <div class="field">
                            <label for="estadocivil">Estado Civil</label>
                            <select id="estadocivil" name="estadocivil" class="tom-select" data-url="<?= site_url('estudiantes/cboEstadoCivil') ?>" required></select>
                        </div>

                        <div class="field">
                            <label for="ciudadtrabaja">Ciudad Donde Trabaja</label>
                            <select id="ciudadtrabaja" name="ciudadtrabaja" class="tom-select" data-url="<?= site_url('estudiantes/cboCiudades') ?>" required></select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Observaciones y foto -->
            <div class="field">
                <label for="observacion">Observación</label>
                <div id="observacion" class="quill-editor"></div>
                <input type="hidden" name="observacion">
            </div>

            <div class="field">
                <label for="foto">Foto</label>
                <input type="file" id="foto" name="foto" accept=".png, .jpg, .gif, .jpeg">
            </div>

            <button type="submit" class="ui button primary">Adicionar Registro</button>
        </form>

        <nav class="ui segment">
            <a href="<?= site_url('estudiantes') ?>" class="ui blue button">&larr; Retornar</a>
        </nav>
    </div>

    <script>
        // Inicializar combos dinámicos
        document.addEventListener('DOMContentLoaded', () => {
            inicializarCombosDinamicos();

            // Inicializar Quill.js
            const quill = new Quill('#observacion', {
                theme: 'snow'
            });

            // Sincronizar contenido de Quill con el formulario
            const observacionInput = document.querySelector('input[name="observacion"]');
            quill.on('text-change', () => {
                observacionInput.value = quill.root.innerHTML;
            });
        });
    </script>
</body>
</html>
