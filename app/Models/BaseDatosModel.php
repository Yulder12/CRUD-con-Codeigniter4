<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseDatosModel extends Model
{

    protected $table = 'estudiantes';
    protected $primaryKey = 'codigo';
    protected $allowedFields = [
        'nombre1', 'nombre2', 'apellido1', 'apellido2', 'tiposangre', 'altura', 'peso',
        'colorojos', 'fechanace', 'colorprefiere', 'profesion', 'nacionalidad', 'correo',
        'url', 'celular', 'estadocivil', 'ciudadtrabaja', 'observacion', 'foto'
    ];

    // Método para obtener los estudiantes con prioridad (cuando se pasa un código)
    public function getEstudianteByCodigo($codigo)
    {
        $builder = $this->db->table('estudiantes e');
        $builder->select('e.codigo, e.nombre1, e.nombre2, e.apellido1, e.apellido2,
                         c6.nombre AS tiposangre, e.altura, e.peso,
                         c1.nombre AS nombre_colorojos,
                         DATE_FORMAT(e.fechanace, "%Y-%m-%d") as fechanace,
                         c2.nombre AS nombre_colorprefiere,
                         c3.nombre AS profesion,
                         c4.nombre AS nacionalidad,
                         e.correo, e.URL, e.celular,
                         c7.nombre AS estadocivil,
                         c5.nombre AS ciudadtrabaja, e.observacion, e.foto');
        $builder->join('colores c1', 'e.colorojos = c1.codigo');
        $builder->join('colores c2', 'e.colorprefiere = c2.codigo');
        $builder->join('profesiones c3', 'e.profesion = c3.codigo');
        $builder->join('paises c4', 'e.nacionalidad = c4.codigo');
        $builder->join('ciudades c5', 'e.ciudadtrabaja = c5.codigo');
        $builder->join('tiposangre c6', 'e.tiposangre = c6.codigo');
        $builder->join('estadocivil c7', 'e.estadocivil = c7.codigo');
        $builder->where('e.codigo', $codigo);

        return $builder->get()->getRowArray();
    }

    // Método para obtener los estudiantes (paginación)
    public function getEstudiantes($codigo = null, $posicion = 0)
    {
        if ($codigo) {
            $sql = "SELECT subquery.codigo, 
                           subquery.nombre1, 
                           subquery.apellido1, 
                           subquery.altura,
                           subquery.peso, 
                           subquery.color_ojos, 
                           subquery.profesion
                    FROM (
                        SELECT estudiantes.codigo, 
                               estudiantes.nombre1, 
                               estudiantes.apellido1, 
                               estudiantes.altura,
                               estudiantes.peso, 
                               colores.nombre AS color_ojos, 
                               profesiones.nombre AS profesion,
                               CASE WHEN estudiantes.codigo = ? THEN 0 ELSE 1 END AS prioridad
                        FROM estudiantes
                        JOIN colores ON estudiantes.colorojos = colores.codigo
                        JOIN profesiones ON estudiantes.profesion = profesiones.codigo
                    ) AS subquery
                    ORDER BY subquery.prioridad, subquery.nombre1
                    LIMIT 0, 10";
            return $this->db->query($sql, [$codigo])->getResultArray();
        } else {
            $sql = "SELECT estudiantes.codigo, 
                           estudiantes.nombre1, 
                           estudiantes.apellido1, 
                           estudiantes.altura,
                           estudiantes.peso, 
                           colores.nombre AS color_ojos, 
                           profesiones.nombre AS profesion
                    FROM estudiantes
                    JOIN colores ON estudiantes.colorojos = colores.codigo
                    JOIN profesiones ON estudiantes.profesion = profesiones.codigo 
                    ORDER BY estudiantes.nombre1 
                    LIMIT ?, 10";
            return $this->db->query($sql, [$posicion])->getResultArray();
        }
    }

        // Función para el ComboBox Dinámico
    public function comboBoxDinamico($tabla, $valorCampo, $textoCampo, $busca) {
        $builder = $this->db->table($tabla);
        
        // Si no hay término de búsqueda
        if (empty($busca)) {
            $builder->select("{$valorCampo}, {$textoCampo}")
                    ->orderBy($textoCampo)
                    ->limit(10);
        } else {
            $builder->select("{$valorCampo}, {$textoCampo}")
                    ->like($textoCampo, $busca)
                    ->orderBy($textoCampo)
                    ->limit(10);
        }

        $query = $builder->get();
        $resultados = $query->getResultArray();

        // Formato de la respuesta
        $respuesta = [];
        foreach ($resultados as $registro) {
            $respuesta[] = [
                'id' => $registro[$valorCampo],
                'text' => $registro[$textoCampo]
            ];
        }

        return $respuesta;
    }
}