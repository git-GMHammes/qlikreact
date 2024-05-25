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
    # www/qlikreact/api/licitacao_etapa/(:any)
    $routes->group('licitacao_etapa', function ($routes) {
        $routes->group('api', function ($routes) {
            # www/qlikreact/licitacao_etapa/api/criar/(:any)
            $routes->get('criar', 'LicitacaoEtapaApiController::create_update');
            $routes->get('criar/(:segment)', 'LicitacaoEtapaApiController::create_update/$1');
            $routes->get('criar/(:any)', 'LicitacaoEtapaApiController::create_update/$1');
            $routes->post('criar', 'LicitacaoEtapaApiController::create_update');
            $routes->post('criar/(:any)', 'LicitacaoEtapaApiController::create_update/$1');
            # www/qlikreact/licitacao_etapa/api/listar/(:any)
            $routes->get('listar', 'LicitacaoEtapaApiController::dbRead');
            $routes->get('listar/(:segment)', 'LicitacaoEtapaApiController::dbRead/$1');
            $routes->get('listar/(:any)', 'LicitacaoEtapaApiController::dbRead/$1');
            $routes->post('listar', 'LicitacaoEtapaApiController::dbRead');
            $routes->post('listar/(:any)', 'LicitacaoEtapaApiController::dbRead/$1');
            # www/qlikreact/licitacao_etapa/api/atualizar/(:any)
            $routes->get('atualizar', 'LicitacaoEtapaApiController::create_update');
            $routes->get('atualizar/(:segment)', 'LicitacaoEtapaApiController::create_update/$1');
            $routes->get('atualizar/(:any)', 'LicitacaoEtapaApiController::create_update/$1');
            $routes->post('atualizar', 'LicitacaoEtapaApiController::create_update');
            $routes->post('atualizar/(:any)', 'LicitacaoEtapaApiController::create_update/$1');
            # www/qlikreact/licitacao_etapa/api/ordem/(:any)
            $routes->get('ordem', 'LicitacaoEtapaApiController::dbOrder');
            $routes->get('ordem/(:segment)', 'LicitacaoEtapaApiController::dbOrder/$1');
            $routes->get('ordem/(:any)', 'LicitacaoEtapaApiController::dbOrder/$1');
            $routes->post('ordem', 'LicitacaoEtapaApiController::dbOrder');
            $routes->post('ordem/(:any)', 'LicitacaoEtapaApiController::dbOrder/$1');
            # www/qlikreact/licitacao_etapa/api/deletar/(:any)
            $routes->get('deletar', 'LicitacaoEtapaApiController::dbDelete');
            $routes->get('deletar/(:segment)', 'LicitacaoEtapaApiController::dbDelete/$1');
            $routes->get('deletar/(:any)', 'LicitacaoEtapaApiController::dbDelete/$1');
            $routes->post('deletar', 'LicitacaoEtapaApiController::dbDelete');
            $routes->post('deletar/(:any)', 'LicitacaoEtapaApiController::dbDelete/$1');
            # www/qlikreact/licitacao_etapa/api/limpar/(:any)
            $routes->get('limpar', 'LicitacaoEtapaApiController::clear');
            $routes->get('limpar/(:segment)', 'LicitacaoEtapaApiController::clear/$1');
            $routes->get('limpar/(:any)', 'LicitacaoEtapaApiController::clear/$1');
            $routes->post('limpar', 'LicitacaoEtapaApiController::clear');
            $routes->post('limpar/(:any)', 'LicitacaoEtapaApiController::clear/$1');
        });
        # www/qlikreact/licitacao_etapa/endpoint/(:any)
        $routes->group('endpoint', function ($routes) {
            # www/qlikreact/licitacao_etapa/endpoint/criar/(:any)
            $routes->get('criar', 'LicitacaoEtapaEndpointController::dbCreate');
            $routes->get('criar/(:segment)', 'LicitacaoEtapaEndpointController::dbCreate/$1');
            $routes->get('criar/(:any)', 'LicitacaoEtapaEndpointController::dbCreate/$1');
            $routes->post('criar', 'LicitacaoEtapaEndpointController::dbCreate');
            $routes->post('criar/(:any)', 'LicitacaoEtapaEndpointController::dbCreate/$1');
            # www/qlikreact/licitacao_etapa/endpoint/listar/(:any)
            $routes->get('listar', 'LicitacaoEtapaEndpointController::dbRead');
            $routes->get('listar/(:segment)', 'LicitacaoEtapaEndpointController::dbRead/$1');
            $routes->get('listar/(:any)', 'LicitacaoEtapaEndpointController::dbRead/$1');
            $routes->post('listar', 'LicitacaoEtapaEndpointController::dbRead');
            $routes->post('listar/(:any)', 'LicitacaoEtapaEndpointController::dbRead/$1');
            # www/qlikreact/licitacao_etapa/endpoint/atualizar/(:any)
            $routes->get('atualizar', 'LicitacaoEtapaEndpointController::dbUpdate');
            $routes->get('atualizar/(:segment)', 'LicitacaoEtapaEndpointController::dbUpdate/$1');
            $routes->get('atualizar/(:any)', 'LicitacaoEtapaEndpointController::dbUpdate/$1');
            $routes->post('atualizar', 'LicitacaoEtapaEndpointController::dbUpdate');
            $routes->post('atualizar/(:any)', 'LicitacaoEtapaEndpointController::dbUpdate/$1');
            # www/qlikreact/licitacao_etapa/endpoint/deletar/(:any)
            $routes->get('deletar', 'LicitacaoEtapaEndpointController::dbDelete');
            $routes->get('deletar/(:segment)', 'LicitacaoEtapaEndpointController::dbDelete/$1');
            $routes->get('deletar/(:any)', 'LicitacaoEtapaEndpointController::dbDelete/$1');
            $routes->post('deletar', 'LicitacaoEtapaEndpointController::dbDelete');
            $routes->post('deletar/(:any)', 'LicitacaoEtapaEndpointController::dbDelete/$1');
        });
    });
    # www/qlikreact/api/(:any)
    $routes->group('etapa', function ($routes) {
        $routes->group('api', function ($routes) {
            # www/qlikreact/etapa/api/criar/(:any)
            $routes->get('criar', 'EtapaApiController::create_update');
            $routes->get('criar/(:segment)', 'EtapaApiController::create_update/$1');
            $routes->get('criar/(:any)', 'EtapaApiController::create_update/$1');
            $routes->post('criar', 'EtapaApiController::create_update');
            $routes->post('criar/(:any)', 'EtapaApiController::create_update/$1');
            # www/qlikreact/etapa/api/listar/(:any)
            $routes->get('listar', 'EtapaApiController::dbRead');
            $routes->get('listar/(:segment)', 'EtapaApiController::dbRead/$1');
            $routes->get('listar/(:any)', 'EtapaApiController::dbRead/$1');
            $routes->post('listar', 'EtapaApiController::dbRead');
            $routes->post('listar/(:any)', 'EtapaApiController::dbRead/$1');
            # www/qlikreact/etapa/api/atualizar/(:any)
            $routes->get('atualizar', 'EtapaApiController::create_update');
            $routes->get('atualizar/(:segment)', 'EtapaApiController::create_update/$1');
            $routes->get('atualizar/(:any)', 'EtapaApiController::create_update/$1');
            $routes->post('atualizar', 'EtapaApiController::create_update');
            $routes->post('atualizar/(:any)', 'EtapaApiController::create_update/$1');
            # www/qlikreact/etapa/api/ordem/(:any)
            $routes->get('ordem', 'EtapaApiController::dbOrder');
            $routes->get('ordem/(:segment)', 'EtapaApiController::dbOrder/$1');
            $routes->get('ordem/(:any)', 'EtapaApiController::dbOrder/$1');
            $routes->post('ordem', 'EtapaApiController::dbOrder');
            $routes->post('ordem/(:any)', 'EtapaApiController::dbOrder/$1');
            # www/qlikreact/etapa/api/deletar/(:any)
            $routes->get('deletar', 'EtapaApiController::dbDelete');
            $routes->get('deletar/(:segment)', 'EtapaApiController::dbDelete/$1');
            $routes->get('deletar/(:any)', 'EtapaApiController::dbDelete/$1');
            $routes->post('deletar', 'EtapaApiController::dbDelete');
            $routes->post('deletar/(:any)', 'EtapaApiController::dbDelete/$1');
            # www/qlikreact/etapa/api/limpar/(:any)
            $routes->get('limpar', 'EtapaApiController::clear');
            $routes->get('limpar/(:segment)', 'EtapaApiController::clear/$1');
            $routes->get('limpar/(:any)', 'EtapaApiController::clear/$1');
            $routes->post('limpar', 'EtapaApiController::clear');
            $routes->post('limpar/(:any)', 'EtapaApiController::clear/$1');
        });
        # www/qlikreact/etapa/endpoint/(:any)
        $routes->group('endpoint', function ($routes) {
            # www/qlikreact/etapa/endpoint/criar/(:any)
            $routes->get('criar', 'EtapaEndpointController::dbCreate');
            $routes->get('criar/(:segment)', 'EtapaEndpointController::dbCreate/$1');
            $routes->get('criar/(:any)', 'EtapaEndpointController::dbCreate/$1');
            $routes->post('criar', 'EtapaEndpointController::dbCreate');
            $routes->post('criar/(:any)', 'EtapaEndpointController::dbCreate/$1');
            # www/qlikreact/etapa/endpoint/listar/(:any)
            $routes->get('listar', 'EtapaEndpointController::dbRead');
            $routes->get('listar/(:segment)', 'EtapaEndpointController::dbRead/$1');
            $routes->get('listar/(:any)', 'EtapaEndpointController::dbRead/$1');
            $routes->post('listar', 'EtapaEndpointController::dbRead');
            $routes->post('listar/(:any)', 'EtapaEndpointController::dbRead/$1');
            # www/qlikreact/etapa/endpoint/atualizar/(:any)
            $routes->get('atualizar', 'EtapaEndpointController::dbUpdate');
            $routes->get('atualizar/(:segment)', 'EtapaEndpointController::dbUpdate/$1');
            $routes->get('atualizar/(:any)', 'EtapaEndpointController::dbUpdate/$1');
            $routes->post('atualizar', 'EtapaEndpointController::dbUpdate');
            $routes->post('atualizar/(:any)', 'EtapaEndpointController::dbUpdate/$1');
            # www/qlikreact/etapa/endpoint/deletar/(:any)
            $routes->get('deletar', 'EtapaEndpointController::dbDelete');
            $routes->get('deletar/(:segment)', 'EtapaEndpointController::dbDelete/$1');
            $routes->get('deletar/(:any)', 'EtapaEndpointController::dbDelete/$1');
            $routes->post('deletar', 'EtapaEndpointController::dbDelete');
            $routes->post('deletar/(:any)', 'EtapaEndpointController::dbDelete/$1');
        });
    });
});
