<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Semantic UI -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" rel="stylesheet">
    <!-- Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <!-- Quill.js -->
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <title>Estudiantes [CRUD]</title>
</head>
<body class="ui segment">
    <div class="ui container">
        <div class="ui segment shadow-2">
            <h1 class="ui header">Editar registro de Estudiantes</h1>
            <?= form_open_multipart("estudiantes/actualizar/{$estudiante['codigo']}", ['class' => 'ui form']) ?>
                <input type="hidden" name="codigo" value="<?= esc($estudiante['codigo']) ?>">
                <input type="hidden" name="fotoantigua" value="<?= esc($estudiante['foto']) ?>">

                <div class="field">
                    <label for="nombre1">Primer Nombre</label>
                    <input type="text" name="nombre1" id="nombre1" value="<?= esc($estudiante['nombre1']) ?>">
                </div>

                <div class="field">
                    <label for="nombre2">Segundo Nombre</label>
                    <input type="text" name="nombre2" id="nombre2" value="<?= esc($estudiante['nombre2']) ?>">
                </div>

                <div class="field">
                    <label for="apellido1">Primer Apellido</label>
                    <input type="text" name="apellido1" id="apellido1" value="<?= esc($estudiante['apellido1']) ?>">
                </div>

                <div class="field">
                    <label for="apellido2">Segundo Apellido</label>
                    <input type="text" name="apellido2" id="apellido2" value="<?= esc($estudiante['apellido2']) ?>">
                </div>

                <div class="field">
                    <label for="tiposangre">Tipo de Sangre</label>
                    <select id="tiposangre" name="tiposangre">
                        <?= $tiposangre ?>
                    </select>
                </div>

                <div class="field">
                    <label for="altura">Altura en centímetros</label>
                    <input type="number" name="altura" id="altura" value="<?= esc($estudiante['altura']) ?>">
                </div>

                <div class="field">
                    <label for="peso">Peso en kilogramos</label>
                    <input type="number" name="peso" id="peso" value="<?= esc($estudiante['peso']) ?>">
                </div>

                <div class="field">
                    <label for="colorojos">Color de Ojos</label>
                    <select id="colorojos" name="colorojos">
                        <?= $colorojos ?>
                    </select>
                </div>

                <div class="field">
                    <label for="fecha">Fecha de Nacimiento</label>
                    <input type="date" name="fecha" id="fecha" value="<?= esc($estudiante['fecha']) ?>">
                </div>

                <div class="field">
                    <label for="colorprefiere">Color Preferido</label>
                    <select id="colorprefiere" name="colorprefiere">
                        <?= $colorprefiere ?>
                    </select>
                </div>

                <div class="field">
                    <label for="profesion">Profesión</label>
                    <select id="profesion" name="profesion">
                        <?= $profesion ?>
                    </select>
                </div>

                <div class="field">
                    <label for="nacionalidad">Nacionalidad</label>
                    <select id="nacionalidad" name="nacionalidad">
                        <?= $nacionalidad ?>
                    </select>
                </div>

                <div class="field">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" value="<?= esc($estudiante['correo']) ?>">
                </div>

                <div class="field">
                    <label for="URL">Página Web</label>
                    <input type="URL" name="URL" id="URL" value="<?= esc($estudiante['URL']) ?>">
                </div>

                <div class="field">
                    <label for="celular">Celular</label>
                    <input type="text" name="celular" id="celular" value="<?= esc($estudiante['celular']) ?>">
                </div>

                <div class="field">
                    <label for="estadocivil">Estado Civil</label>
                    <select id="estadocivil" name="estadocivil">
                        <?= $estadocivil ?>
                    </select>
                </div>

                <div class="field">
                    <label for="ciudadtrabaja">Ciudad Donde Trabaja</label>
                    <select id="ciudadtrabaja" name="ciudadtrabaja">
                        <?= $ciudadtrabaja ?>
                    </select>
                </div>

                <div class="field">
                    <label for="observacion">Observación</label>
                    <div id="observacion-editor" class="ui segment"></div>
                    <textarea name="observacion" id="observacion" class="hidden"><?= esc($estudiante['observacion']) ?></textarea>
                </div>


                <div class="field">
                    <label for="foto">Foto</label>
                    <input type="file" id="foto" name="foto" accept=".png, .jpg, .gif, .jpeg">
                </div>

                <button class="ui blue button" type="submit">Editar Registro</button>
            <?= form_close() ?>
        </div>

        <nav class="ui segment">
            <ul class="ui pagination menu">
                <li class="item">
                    <a href="<?= base_url('/estudiantes') ?>" class="item">&larr; Retornar</a>
                </li>
            </ul>
        </nav>
    </div>

    <script>
        // Inicializar Tom Select
        ['#tiposangre', '#colorojos', '#colorprefiere', '#profesion', '#nacionalidad', '#estadocivil', '#ciudadtrabaja'].forEach(id => {
            new TomSelect(id, { create: false });
        });

        // Inicializar Quill.js para el campo "observación"
        const quill = new Quill('#observacion-editor', {
            theme: 'snow'
        });

        // Sincronizar el contenido de Quill con el textarea
        quill.on('text-change', function() {
            document.querySelector('#observacion').value = quill.root.innerHTML;
        });
    </script>
</body>
</html>
