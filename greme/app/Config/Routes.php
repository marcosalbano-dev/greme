<?php

use App\Controllers\Api\ApiParentsController;
use App\Controllers\HomeController;
use App\Controllers\ParentsController;
use App\Controllers\StudentsController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [HomeController::class, 'index'], ['as' => 'home']);

// Responsáveis
$routes->group('parents', static function ($routes) {
    $routes->get('/', [ParentsController::class, 'index'], ['as' => 'parents']);
    $routes->get('new', [ParentsController::class, 'new'], ['as' => 'parents.new']);
    $routes->post('create', [ParentsController::class, 'create'], ['as' => 'parents.create']);
    $routes->get('show/(:segment)', [ParentsController::class, 'show/$1'], ['as' => 'parents.show']);
    $routes->get('edit/(:segment)', [ParentsController::class, 'edit/$1'], ['as' => 'parents.edit']);
    $routes->put('update/(:segment)', [ParentsController::class, 'update/$1'], ['as' => 'parents.update']);
    $routes->delete('destroy/(:segment)', [ParentsController::class, 'destroy/$1'], ['as' => 'parents.destroy']);
});

// Estudantes - alunos
$routes->group('students', static function ($routes) {
    $routes->get('/', [StudentsController::class, 'index'], ['as' => 'students']);
    $routes->get('new', [StudentsController::class, 'new'], ['as' => 'students.new']);
    $routes->post('create', [StudentsController::class, 'create'], ['as' => 'students.create']);
    $routes->get('show/(:segment)', [StudentsController::class, 'show/$1'], ['as' => 'students.show']);
    $routes->get('edit/(:segment)', [StudentsController::class, 'edit/$1'], ['as' => 'students.edit']);
    $routes->put('update/(:segment)', [StudentsController::class, 'update/$1'], ['as' => 'students.update']);
    $routes->delete('destroy/(:segment)', [StudentsController::class, 'destroy/$1'], ['as' => 'students.destroy']);
});

// API
$routes->group('api', static function ($routes) {
    $routes->get('get-by-cpf', [ApiParentsController::class, 'getByCpf'], ['as' => 'api.fetch.parent.by.cpf']);
});
