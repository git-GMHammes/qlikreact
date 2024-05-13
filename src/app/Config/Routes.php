<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
// $routes->get('/', 'LicitacaoApiController::dbRead');
$routes->addRedirect('/', 'qlikreact/licitacao/endpoint/listar');
$routes->addRedirect('/api', 'qlikreact/licitacao/api/listar');
$routes->addRedirect('/endpoint', 'qlikreact/licitacao/endpoint/listar');

$routes->group('qlikreact', function ($routes) {
    # www/qlikreact/feriado/(:any)
    $routes->group('feriado', function ($routes) {
        $routes->group('api', function ($routes) {
            # www/qlikreact/feriado/api/listar/(:any)
            $routes->get('listar', 'FeriadoController::dbRead');
            $routes->get('listar/(:segment)', 'FeriadoController::dbRead/$1');
            $routes->get('listar/(:any)', 'FeriadoController::dbRead/$1');
            $routes->post('listar', 'FeriadoController::dbRead');
            $routes->post('listar/(:any)', 'FeriadoController::dbRead/$1');
        });
    });
    # www/qlikreact/api/(:any)
    $routes->group('licitacao', function ($routes) {
        $routes->group('api', function ($routes) {
            # www/qlikreact/licitacao/api/criar/(:any)
            $routes->get('criar', 'LicitacaoApiController::create_update');
            $routes->get('criar/(:segment)', 'LicitacaoApiController::create_update/$1');
            $routes->get('criar/(:any)', 'LicitacaoApiController::create_update/$1');
            $routes->post('criar', 'LicitacaoApiController::create_update');
            $routes->post('criar/(:any)', 'LicitacaoApiController::create_update/$1');
            # www/qlikreact/licitacao/api/listar/(:any)
            $routes->get('listar', 'LicitacaoApiController::dbRead');
            $routes->get('listar/(:segment)', 'LicitacaoApiController::dbRead/$1');
            $routes->get('listar/(:any)', 'LicitacaoApiController::dbRead/$1');
            $routes->post('listar', 'LicitacaoApiController::dbRead');
            $routes->post('listar/(:any)', 'LicitacaoApiController::dbRead/$1');
            # www/qlikreact/licitacao/api/atualizar/(:any)
            $routes->get('atualizar', 'LicitacaoApiController::create_update');
            $routes->get('atualizar/(:segment)', 'LicitacaoApiController::create_update/$1');
            $routes->get('atualizar/(:any)', 'LicitacaoApiController::create_update/$1');
            $routes->post('atualizar', 'LicitacaoApiController::create_update');
            $routes->post('atualizar/(:any)', 'LicitacaoApiController::create_update/$1');
            # www/qlikreact/licitacao/api/ordem/(:any)
            $routes->get('ordem', 'LicitacaoApiController::dbOrder');
            $routes->get('ordem/(:segment)', 'LicitacaoApiController::dbOrder/$1');
            $routes->get('ordem/(:any)', 'LicitacaoApiController::dbOrder/$1');
            $routes->post('ordem', 'LicitacaoApiController::dbOrder');
            $routes->post('ordem/(:any)', 'LicitacaoApiController::dbOrder/$1');
            # www/qlikreact/licitacao/api/deletar/(:any)
            $routes->get('deletar', 'LicitacaoApiController::dbDelete');
            $routes->get('deletar/(:segment)', 'LicitacaoApiController::dbDelete/$1');
            $routes->get('deletar/(:any)', 'LicitacaoApiController::dbDelete/$1');
            $routes->post('deletar', 'LicitacaoApiController::dbDelete');
            $routes->post('deletar/(:any)', 'LicitacaoApiController::dbDelete/$1');
            # www/qlikreact/licitacao/api/limpar/(:any)
            $routes->get('limpar', 'LicitacaoApiController::clear');
            $routes->get('limpar/(:segment)', 'LicitacaoApiController::clear/$1');
            $routes->get('limpar/(:any)', 'LicitacaoApiController::clear/$1');
            $routes->post('limpar', 'LicitacaoApiController::clear');
            $routes->post('limpar/(:any)', 'LicitacaoApiController::clear/$1');
        });
        # www/qlikreact/licitacao/endpoint/(:any)
        $routes->group('endpoint', function ($routes) {
            # www/qlikreact/licitacao/endpoint/criar/(:any)
            $routes->get('criar', 'LicitacaoEndpointController::dbCreate');
            $routes->get('criar/(:segment)', 'LicitacaoEndpointController::dbCreate/$1');
            $routes->get('criar/(:any)', 'LicitacaoEndpointController::dbCreate/$1');
            $routes->post('criar', 'LicitacaoEndpointController::dbCreate');
            $routes->post('criar/(:any)', 'LicitacaoEndpointController::dbCreate/$1');
            # www/qlikreact/licitacao/endpoint/listar/(:any)
            $routes->get('listar', 'LicitacaoEndpointController::dbRead');
            $routes->get('listar/(:segment)', 'LicitacaoEndpointController::dbRead/$1');
            $routes->get('listar/(:any)', 'LicitacaoEndpointController::dbRead/$1');
            $routes->post('listar', 'LicitacaoEndpointController::dbRead');
            $routes->post('listar/(:any)', 'LicitacaoEndpointController::dbRead/$1');
            # www/qlikreact/licitacao/endpoint/atualizar/(:any)
            $routes->get('atualizar', 'LicitacaoEndpointController::dbUpdate');
            $routes->get('atualizar/(:segment)', 'LicitacaoEndpointController::dbUpdate/$1');
            $routes->get('atualizar/(:any)', 'LicitacaoEndpointController::dbUpdate/$1');
            $routes->post('atualizar', 'LicitacaoEndpointController::dbUpdate');
            $routes->post('atualizar/(:any)', 'LicitacaoEndpointController::dbUpdate/$1');
            # www/qlikreact/licitacao/endpoint/deletar/(:any)
            $routes->get('deletar', 'LicitacaoEndpointController::dbDelete');
            $routes->get('deletar/(:segment)', 'LicitacaoEndpointController::dbDelete/$1');
            $routes->get('deletar/(:any)', 'LicitacaoEndpointController::dbDelete/$1');
            $routes->post('deletar', 'LicitacaoEndpointController::dbDelete');
            $routes->post('deletar/(:any)', 'LicitacaoEndpointController::dbDelete/$1');
        });
    });
});
