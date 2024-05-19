<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

$routes->group('v1/api', function ($routes) {
    $routes->group('user', function ($routes) {
        $routes->post('create-details', 'FormSubmissionsController::submitForm');
        $routes->get('get-details', 'FormSubmissionsController::getDetails');
    });
    $routes->group('admin', function ($routes) {
        $routes->get('get-documents-request', 'AdminController::getDetails');
        $routes->post('get-user-documents', 'AdminController::getUserDocuments');
        $routes->post('action', 'AdminController::verifyDoc');

    });

});

$routes->get('logout', 'AuthController::logout');
