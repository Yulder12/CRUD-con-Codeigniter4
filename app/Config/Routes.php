<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Estudiantes::index');
$routes->get('estudiantes', 'Estudiantes::index');
$routes->get('estudiantes/adicionar', 'Estudiantes::adicionar');
$routes->post('estudiantes/adicionar', 'Estudiantes::adicionar');
$routes->post('estudiantes/save', 'Estudiantes::save');
$routes->get('estudiantes/detalle/(:num)', 'Estudiantes::detalle/$1');
$routes->get('estudiantes/eliminar/(:num)', 'Estudiantes::eliminar/$1');
$routes->get('estudiantes/editar/(:num)', 'Estudiantes::editar/$1');
$routes->post('estudiantes/actualizar/(:num)', 'Estudiantes::actualizar/$1');
$routes->post('estudiantes/actualizar', 'Estudiantes::actualizar');
$routes->get('estudiantes/cboColores', 'Estudiantes::cboColores');
$routes->get('estudiantes/cboProfesiones', 'Estudiantes::cboProfesiones');
$routes->get('estudiantes/cboTipoSangre', 'Estudiantes::cboTipoSangre');
$routes->get('estudiantes/cboNacionalidad', 'Estudiantes::cboNacionalidad');
$routes->get('estudiantes/cboEstadoCivil', 'Estudiantes::cboEstadoCivil');
$routes->get('estudiantes/cboCiudades', 'Estudiantes::cboCiudades');
