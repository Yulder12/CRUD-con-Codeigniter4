<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\BaseDatosModel;
use CodeIgniter\Files\File;

class Estudiantes extends BaseController
{
    public function __construct() {
        // Aquí es donde cargas el modelo correctamente
        $this->BaseDatosModel = new BaseDatosModel();
    }

    public function index()
    {
        $model = new BaseDatosModel();

        $posicion = $this->request->getGet('pos') ? intval($this->request->getGet('pos')) : 0;
        $codigo = $this->request->getGet('codigo');

        // Obtener los datos
        $estudiantes = $model->getEstudiantes($codigo, $posicion);

        // Paginación
        $paginaAnterior = $posicion > 10 ? $posicion - 10 : 0;
        $paginaSigue = $posicion + 10;

        // Pasar datos a la vista
        return view('estudiantes/index', [
            'estudiantes' => $estudiantes,
            'paginaAnterior' => $paginaAnterior,
            'paginaSigue' => $paginaSigue,
        ]);
    }

    public function detalle($codigo)
    {
        $db = \Config\Database::connect();

        // Consulta del estudiante con uniones necesarias
        $sql = "SELECT 
                    e.codigo, e.nombre1, e.nombre2, e.apellido1, e.apellido2,
                    c6.nombre AS tiposangre, e.altura, e.peso,
                    c1.nombre AS nombre_colorojos,
                    DATE_FORMAT(e.fechanace, '%Y-%m-%d') as fecha,
                    c2.nombre AS nombre_colorprefiere,
                    c3.nombre AS profesion,
                    c4.nombre AS nacionalidad,
                    e.correo, e.URL, e.celular,
                    c7.nombre AS estadocivil,
                    c5.nombre AS CiudadTrabajo, e.observacion, e.foto
                FROM estudiantes e
                JOIN colores c1 ON e.colorojos = c1.codigo
                JOIN colores c2 ON e.colorprefiere = c2.codigo
                JOIN profesiones c3 ON e.profesion = c3.codigo
                JOIN paises c4 ON e.nacionalidad = c4.codigo
                JOIN ciudades c5 ON e.ciudadtrabaja = c5.codigo
                JOIN tiposangre c6 ON e.tiposangre = c6.codigo
                JOIN estadocivil c7 ON e.estadocivil = c7.codigo
                WHERE e.codigo = :codigo:";

        $query = $db->query($sql, ['codigo' => $codigo]);
        $estudiante = $query->getRowArray();

        if (!$estudiante) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Estudiante con código $codigo no encontrado.");
        }

        // Carga la vista con los datos
        return view('estudiantes/detalle', ['estudiante' => $estudiante]);
    }

    public function eliminar($codigo)
    {
        $db = \Config\Database::connect();
        $codigo = abs(intval($codigo)); // Asegurarse de que el código sea un entero positivo

        // Obtener la foto del estudiante para eliminarla del sistema de archivos
        $sqlFoto = "SELECT foto FROM estudiantes WHERE codigo = :codigo:";
        $queryFoto = $db->query($sqlFoto, ['codigo' => $codigo]);
        $registro = $queryFoto->getRow();

        if ($registro && !empty($registro->foto)) {
            $rutaFoto = FCPATH . $registro->foto; // Ruta completa de la foto
            if (file_exists($rutaFoto)) {
                unlink($rutaFoto); // Elimina la foto del servidor
            }
        }

        // Borrar el registro del estudiante
        $sqlEliminar = "DELETE FROM estudiantes WHERE codigo = :codigo:";
        $queryEliminar = $db->query($sqlEliminar, ['codigo' => $codigo]);

        if ($db->affectedRows() > 0) {
            return redirect()->to(site_url('estudiantes'))->with('mensaje', 'Estudiante eliminado exitosamente.');
        } else {
            return redirect()->to(site_url('estudiantes'))->with('error', 'No se pudo eliminar el estudiante.');
        }
    }

    public function adicionar()
    {
        $db = \Config\Database::connect();
    
        // Obtener las opciones para cada campo
        $tiposangre = $db->table('tiposangre')->select('codigo, nombre')->get()->getResultArray();
        $colores = $db->table('colores')->select('codigo, nombre')->get()->getResultArray();
        $profesiones = $db->table('profesiones')->select('codigo, nombre')->get()->getResultArray();
        $paises = $db->table('paises')->select('codigo, nombre')->get()->getResultArray();
        $estadocivil = $db->table('estadocivil')->select('codigo, nombre')->get()->getResultArray();
        $ciudades = $db->table('ciudades')->select('codigo, nombre')->get()->getResultArray();
    
        return view('estudiantes/adicionar', [
            'tiposangre' => $tiposangre,
            'colores' => $colores,
            'profesiones' => $profesiones,
            'paises' => $paises,
            'estadocivil' => $estadocivil,
            'ciudades' => $ciudades,
        ]);
    }

    public function save()
    {
        $model = new BaseDatosModel();

        // Validar campos
        if (!$this->validate([
            'nombre1' => 'required',
            'apellido1' => 'required',
            'tiposangre' => 'required',
            'altura' => 'required|decimal',
            'peso' => 'required|decimal',
            'colorojos' => 'required',
            'fechanace' => 'required|valid_date',
            'foto' => 'uploaded[foto]|max_size[foto,4096]|is_image[foto]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Manejo de la foto
        $foto = $this->request->getFile('foto');
        $foto->move('fotos');  // Mueve la foto a la carpeta 'fotos'
        $rutaFoto = 'fotos/' . $foto->getName();

        // Preparar datos para la base de datos
        $data = [
            'nombre1' => $this->request->getPost('nombre1'),
            'nombre2' => $this->request->getPost('nombre2'),
            'apellido1' => $this->request->getPost('apellido1'),
            'apellido2' => $this->request->getPost('apellido2'),
            'tiposangre' => $this->request->getPost('tiposangre'),
            'altura' => $this->request->getPost('altura'),
            'peso' => $this->request->getPost('peso'),
            'colorojos' => $this->request->getPost('colorojos'),
            'fechanace' => $this->request->getPost('fechanace'),
            'colorprefiere' => $this->request->getPost('colorprefiere'),
            'profesion' => $this->request->getPost('profesion'),
            'nacionalidad' => $this->request->getPost('nacionalidad'),
            'correo' => $this->request->getPost('correo'),
            'url' => $this->request->getPost('url'),
            'celular' => $this->request->getPost('celular'),
            'estadocivil' => $this->request->getPost('estadocivil'),
            'ciudadtrabaja' => $this->request->getPost('ciudadtrabaja'),
            'observacion' => $this->request->getPost('observacion'),
            'foto' => $rutaFoto,
        ];

        if ($model->insert($data)) {
            $ultimoId = $model->getInsertID();
            return redirect()->to('/estudiantes')->with('success', "Registro agregado con éxito. Código: $ultimoId");
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al guardar el registro.');
        }
    }

    public function editar($codigo)
    {
        helper(['form']); // Cargar el helper de formularios

        $codigo = abs((int)$codigo); // Asegurar que el código sea positivo

        // Cargar el modelo
        $model = new BaseDatosModel();

        // Obtener datos del estudiante
        $estudiante = $model->find($codigo);

        if (!$estudiante) {
            return redirect()->to('/estudiantes')->with('error', 'Estudiante no encontrado.');
        }

        // Obtener valores para los combobox
        $db = \Config\Database::connect();

        // Consultar los datos del estudiante
        $sql = "SELECT 
                    e.codigo, e.nombre1, e.nombre2, e.apellido1, e.apellido2,
                    c6.nombre AS tiposangre, e.altura, e.peso,
                    c1.nombre AS nombre_colorojos,
                    DATE_FORMAT(e.fechanace, '%Y-%m-%d') as fecha,
                    c2.nombre AS nombre_colorprefiere,
                    c3.nombre AS profesion,
                    c4.nombre AS nacionalidad,
                    e.correo, e.URL, e.celular,
                    c7.nombre AS estadocivil,
                    c5.nombre AS CiudadTrabajo, e.observacion, e.foto
                FROM estudiantes e
                JOIN colores c1 ON e.colorojos = c1.codigo
                JOIN colores c2 ON e.colorprefiere = c2.codigo
                JOIN profesiones c3 ON e.profesion = c3.codigo
                JOIN paises c4 ON e.nacionalidad = c4.codigo
                JOIN ciudades c5 ON e.ciudadtrabaja = c5.codigo
                JOIN tiposangre c6 ON e.tiposangre = c6.codigo
                JOIN estadocivil c7 ON e.estadocivil = c7.codigo
                WHERE e.codigo = :codigo:";
    
        $query = $db->query($sql, ['codigo' => $codigo]);
        $estudiante = $query->getRowArray();
    
        // Si no se encuentra el estudiante
        if (!$estudiante) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Estudiante con código $codigo no encontrado.");
        }

        $tiposangre = $this->getOptions($db, 'tiposangre', 'codigo', 'nombre', $estudiante['tiposangre']);
        $colorojos = $this->getOptions($db, 'colores', 'codigo', 'nombre', $estudiante['nombre_colorojos']);
        $colorprefiere = $this->getOptions($db, 'colores', 'codigo', 'nombre', $estudiante['nombre_colorprefiere']);
        $profesion = $this->getOptions($db, 'profesiones', 'codigo', 'nombre', $estudiante['profesion']);
        $nacionalidad = $this->getOptions($db, 'paises', 'codigo', 'nombre', $estudiante['nacionalidad']);
        $estadocivil = $this->getOptions($db, 'estadocivil', 'codigo', 'nombre', $estudiante['estadocivil']);
        $ciudadtrabaja = $this->getOptions($db, 'ciudades', 'codigo', 'nombre', $estudiante['CiudadTrabajo']);

        // Preparar datos para la vista
        $data = [
            'estudiante' => $estudiante,
            'tiposangre' => $tiposangre,
            'colorojos' => $colorojos,
            'colorprefiere' => $colorprefiere,
            'profesion' => $profesion,
            'nacionalidad' => $nacionalidad,
            'estadocivil' => $estadocivil,
            'ciudadtrabaja' => $ciudadtrabaja,
        ];

        // Renderizar la vista
        return view('estudiantes/editar', $data);
    }

    private function getOptions($db, $table, $keyColumn, $valueColumn, $selectedValue)
    {
        $query = $db->table($table)->select("$keyColumn, $valueColumn")->get();
        $options = '';

        foreach ($query->getResultArray() as $row) {
            $selected = ($row[$keyColumn] == $selectedValue) ? 'selected="selected"' : '';
            $options .= '<option value="' . $row[$keyColumn] . '" ' . $selected . '>' . $row[$valueColumn] . '</option>';
        }

        return $options;
    }

    public function actualizar($codigo)
    {
        helper(['form', 'url']); // Cargar helpers necesarios
    
        $codigo = abs((int)$codigo); // Validar que el código sea positivo
    
        // Cargar el modelo
        $model = new \App\Models\BaseDatosModel();
    
        // Verificar si el estudiante existe
        $estudiante = $model->find($codigo);
        if (!$estudiante) {
            return redirect()->to('/estudiantes')->with('error', 'Estudiante no encontrado.');
        }
    
        // Tratamiento de la foto
        $fotoAntigua = $this->request->getPost('fotoantigua'); // Obtener el nombre de la foto anterior
        $directorioDestino = $fotoAntigua; // Inicializar la variable de destino con la foto antigua

        // Obtener la nueva foto
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Generar un nombre aleatorio para la nueva foto
            $nuevoNombre = $foto->getRandomName();
            $directorioDestino = 'fotos/' . $nuevoNombre; // Establecer el directorio de destino con el nuevo nombre

            // Mover la nueva foto al directorio de destino
            $foto->move('fotos', $nuevoNombre);

            // Eliminar la foto antigua si existe
            if ($fotoAntigua && file_exists(FCPATH . $fotoAntigua)) {
                // Eliminar el archivo de la foto antigua desde el directorio
                unlink(FCPATH . $fotoAntigua);
            }
        }

    
        // Datos del formulario
        $data = [
            'nombre1'       => $this->request->getPost('nombre1'),
            'nombre2'       => $this->request->getPost('nombre2'),
            'apellido1'     => $this->request->getPost('apellido1'),
            'apellido2'     => $this->request->getPost('apellido2'),
            'tiposangre'    => $this->request->getPost('tiposangre'),
            'altura'        => $this->request->getPost('altura'),
            'peso'          => $this->request->getPost('peso'),
            'colorojos'     => $this->request->getPost('colorojos'),
            'fechanace'     => $this->request->getPost('fechanace'),
            'colorprefiere' => $this->request->getPost('colorprefiere'),
            'profesion'     => $this->request->getPost('profesion'),
            'nacionalidad'  => $this->request->getPost('nacionalidad'),
            'correo'        => $this->request->getPost('correo'),
            'url'           => $this->request->getPost('url'),
            'celular'       => $this->request->getPost('celular'),
            'estadocivil'   => $this->request->getPost('estadocivil'),
            'ciudadtrabaja' => $this->request->getPost('ciudadtrabaja'),
            'observacion'   => $this->request->getPost('observacion'),
            'foto'          => $directorioDestino,
        ];
    
        // Actualizar el registro en la base de datos
        try {
            $model->update($codigo, $data);
            return redirect()->to('/estudiantes')->with('success', 'Estudiante actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el registro: ' . $e->getMessage());
        }
    }

    // Métodos para los combos dinámicos
    public function cboColores() { return $this->cbo('colores'); }
    public function cboCiudades() { return $this->cbo('ciudades'); }
    public function cboEstadoCivil() { return $this->cbo('estadocivil'); }
    public function cboNacionalidad() { return $this->cbo('paises'); }
    public function cboProfesiones() { return $this->cbo('profesiones'); }
    public function cboTipoSangre() { return $this->cbo('tiposangre'); }

    private function cbo($table)
    {
        $busca = $this->request->getVar('Busca');
        $resultados = $this->BaseDatosModel->comboBoxDinamico($table, 'codigo', 'nombre', $busca);
        return $this->response->setJSON($resultados);
    }
}