<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
// use App\Models\NomeModel;
use Exception;

class IntegraEndpointController extends ResourceController
{ //src\app\Controllers\IntegraEndpointController.php
    use ResponseTrait;
    private $template = 'projeto_view/template/main';
    private $message = 'projeto_view/message';
    private $footer = 'projeto_view/footer';
    private $head = 'projeto_view/head';
    private $menu = 'projeto_view/menu';
    private $ModelResponse;
    private $uri;
    private $token;
    #
    public function __construct()
    {
        // $this->ModelResponse = new NomeModel();
        $this->uri = new \CodeIgniter\HTTP\URI(current_url());
        // $this->token = isset($_COOKIE['token']) ? $_COOKIE['token'] : '123';
    }
    #
    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [view]
    public function index($parameter = NULL)
    {
        exit('403 Forbidden - Directory access is forbidden.');
        $request = service('request');
        $getMethod = $request->getMethod();
        $getVar_page = $request->getVar('page');
        $processRequest = (array)$request->getVar();
        // $processRequest = eagarScagaire($processRequest);
        $json = isset($processRequest['json']) && $processRequest['json'] == true ? $processRequest['json'] : false;
        #
        $loadView = array(
            $this->head,
            $this->menu,
            $this->message,
            $this->footer,
        );
        try {
            # URI da API                                                                                                          
            $endPoint['objeto'] = myEndPoint('index.php/projeto/endereco/api/verbo', '123');
            $requestJSONform['objeto'] = isset($endPoint['objeto']['result']) ? $endPoint['objeto']['result'] : array();
            # Configuração Paginate
            if (isset($requestJSONform['objeto'])) {
                $totalItems = count($requestJSONform['objeto']);
                $itemsPerPage = 10; // Itens por página
                // $totalPages = ceil($totalItems / $itemsPerPage);
                $currentPage = isset($getVar_page) ? $getVar_page : 1;
                # Constrção Paginate
                $pager = service('pager');
                $pager->setPath('intranet/painel/endpoint/master');
                $pager->makeLinks($currentPage, $itemsPerPage, $totalItems);
                # Finalização Paginate
                $requestJSONform['objeto']['list'] = $this->paginateArray($requestJSONform['objeto'], $currentPage, $itemsPerPage);
                $requestJSONform['objeto']['pager'] = $pager;
            }
            #
            $requestJSONform = array();
            $apiRespond = [
                'status' => 'success',
                'message' => 'API loading data (dados para carregamento da API)',
                'date' => date('Y-m-d'),
                'api' => [
                    'version' => '1.0',
                    'method' => $getMethod,
                    'description' => 'API Description',
                    'content_type' => 'application/x-www-form-urlencoded'
                ],
                // 'method' => '__METHOD__',
                // 'function' => '__FUNCTION__',
                'result' => $processRequest,
                'loadView' => $loadView,
                'metadata' => [
                    'page_title' => 'Application title',
                    'getURI' => $this->uri->getSegments(),
                    // Você pode adicionar campos comentados anteriormente se forem relevantes
                    // 'method' => '__METHOD__',
                    // 'function' => '__FUNCTION__',
                ]
            ];
        } catch (\Exception $e) {
            $apiRespond = [
                'status' => 'error',
                'message' => $e->getMessage(),
                'date' => date('Y-m-d'),
                'api' => [
                    'version' => '1.0',
                    'method' => $getMethod,
                    'description' => 'API Criar Method',
                    'content_type' => 'application/x-www-form-urlencoded'
                ],
                'metadata' => [
                    'page_title' => 'ERRO - API Method',
                    'getURI' => $this->uri->getSegments(),
                ]
            ];
        }
        if ($json != 1) {
            return $apiRespond;
        } else {
            return view($this->template, $apiRespond);
            // return $apiRespond;
        }
    }

    private function token_csrf()
    {
        $token_csrf = myUCI();
        session()->set('token_csrf',  $token_csrf);
        session()->markAsTempdata('token_csrf', 1800);
        // myPrint($token_csrf, 'www\oficina\app\Controllers\CustomersEndPointController.php', true);
        return $token_csrf;
    }

    private function returnMyFunction($message = array(), $typeMessage, $dataValue = array())
    {
        // ['success', 'warning', 'danger'];
        if (session()->get('message')) {
            $recebe = session()->get('message');
            foreach ($recebe as $key_recebe => $value_recebe) {
                $message[] = $value_recebe;
            }
            // myPrint($message, 'src\app\Controllers\APMEtapaApiController.php', true);
        }
        #
        if ($message !== array()) {
            $message['message'][$typeMessage] = $message;
            session()->set('message', $message);
            session()->markAsTempdata('message', 5);
        }
        #
        if ($dataValue !== array()) {
            session()->set('value_form', $dataValue);
        }
        session()->markAsTempdata(
            'message',
            5
        );
        return (NULL);
    }
    
    private function paginateArray($data, $page, $perPage)
    {
        // Calcula o offset
        $offset = ($page - 1) * $perPage;

        // Retorna os itens da página atual
        return array_slice($data, $offset, $perPage);
    }

    # Consumo de API
    # route GET /www/sigla/rota
    # route POST /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function dbCreate($parameter = NULL)
    {
        $this->token_csrf();
        $request = service('request');
        $getMethod = $request->getMethod();
        $getVar_page = $request->getVar('page');
        $processRequest = (array)$request->getVar();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        $id = (isset($processRequest['id'])) ? ('/' . $processRequest['id']) : ('/' . $parameter);
        // $processRequest = eagarScagaire($processRequest);
        #
        $loadView = array(
            $this->head,
            $this->menu,
            $this->message,
            $this->footer,
        );
        try {
            # URI da API                                                                                                          
            $endPoint['objeto'] = myEndPoint('index.php/projeto/endereco/api/verbo', '123');
            $requestJSONform['objeto'] = isset($endPoint['objeto']['result']) ? $endPoint['objeto']['result'] : array();
            # Configuração Paginate
            $totalItems = count($requestJSONform['objeto']);
            $itemsPerPage = 10; // Itens por página
            // $totalPages = ceil($totalItems / $itemsPerPage);
            $currentPage = isset($getVar_page) ? $getVar_page : 1;
            # Constrção Paginate
            $pager = service('pager');
            $pager->setPath('intranet/painel/endpoint/master');
            $pager->makeLinks($currentPage, $itemsPerPage, $totalItems);
            # Finalização Paginate
            $requestJSONform['objeto']['list'] = $this->paginateArray($requestJSONform['objeto'], $currentPage, $itemsPerPage);
            $requestJSONform['objeto']['pager'] = $pager;
            #
            $requestJSONform = array();
            $apiRespond = [
                'status' => 'success',
                'message' => 'API loading data (dados para carregamento da API)',
                'date' => date('Y-m-d'),
                'api' => [
                    'version' => '1.0',
                    'method' => $getMethod,
                    'description' => 'API Description',
                    'content_type' => 'application/x-www-form-urlencoded'
                ],
                // 'method' => '__METHOD__',
                // 'function' => '__FUNCTION__',
                'result' => $processRequest,
                'loadView' => $loadView,
                'metadata' => [
                    'page_title' => 'Application title',
                    'getURI' => $this->uri->getSegments(),
                    // Você pode adicionar campos comentados anteriormente se forem relevantes
                    // 'method' => '__METHOD__',
                    // 'function' => '__FUNCTION__',
                ]
            ];
            if ($json == 1) {
                $response = $this->response->setJSON($apiRespond, 201);
            }
        } catch (\Exception $e) {
            $apiRespond = [
                'status' => 'error',
                'message' => $e->getMessage(),
                'date' => date('Y-m-d'),
                'api' => [
                    'version' => '1.0',
                    'method' => $getMethod,
                    'description' => 'API Criar Method',
                    'content_type' => 'application/x-www-form-urlencoded'
                ],
                'metadata' => [
                    'page_title' => 'ERRO - API Method',
                    'getURI' => $this->uri->getSegments(),
                ]
            ];
            if ($json == 1) {
                $response = $this->response->setJSON($apiRespond, 500);
            }
        }
        if ($json == 1) {
            return $apiRespond;
        } else {
            return $apiRespond;
            // return view($this->template, $apiRespond);
        }
    }

    # Consumo de API
    # route GET /www/sigla/rota
    # route POST /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function dbRead($parameter = NULL)
    {
        $this->token_csrf();
        $request = service('request');
        $getMethod = $request->getMethod();
        $getVar_page = $request->getVar('page');
        $processRequest = (array)$request->getVar();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        $id = (isset($processRequest['id'])) ? ('/' . $processRequest['id']) : ('/' . $parameter);
        // $processRequest = eagarScagaire($processRequest);
        #
        $loadView = array(
            $this->head,
            $this->menu,
            $this->message,
            $this->footer,
        );
        try {
            # URI da API                                                                                                          
            $endPoint['objeto'] = myEndPoint('index.php/projeto/endereco/api/verbo', '123');
            $requestJSONform['objeto'] = isset($endPoint['objeto']['result']) ? $endPoint['objeto']['result'] : array();
            # Configuração Paginate
            $totalItems = count($requestJSONform['objeto']);
            $itemsPerPage = 10; // Itens por página
            // $totalPages = ceil($totalItems / $itemsPerPage);
            $currentPage = isset($getVar_page) ? $getVar_page : 1;
            # Constrção Paginate
            $pager = service('pager');
            $pager->setPath('intranet/painel/endpoint/master');
            $pager->makeLinks($currentPage, $itemsPerPage, $totalItems);
            # Finalização Paginate
            $requestJSONform['objeto']['list'] = $this->paginateArray($requestJSONform['objeto'], $currentPage, $itemsPerPage);
            $requestJSONform['objeto']['pager'] = $pager;
            #
            $requestJSONform = array();
            $apiRespond = [
                'status' => 'success',
                'message' => 'API loading data (dados para carregamento da API)',
                'date' => date('Y-m-d'),
                'api' => [
                    'version' => '1.0',
                    'method' => $getMethod,
                    'description' => 'API Description',
                    'content_type' => 'application/x-www-form-urlencoded'
                ],
                // 'method' => '__METHOD__',
                // 'function' => '__FUNCTION__',
                'result' => $processRequest,
                'loadView' => $loadView,
                'metadata' => [
                    'page_title' => 'Application title',
                    'getURI' => $this->uri->getSegments(),
                    // Você pode adicionar campos comentados anteriormente se forem relevantes
                    // 'method' => '__METHOD__',
                    // 'function' => '__FUNCTION__',
                ]
            ];
            if ($json == 1) {
                $response = $this->response->setJSON($apiRespond, 201);
            }
        } catch (\Exception $e) {
            $apiRespond = [
                'status' => 'error',
                'message' => $e->getMessage(),
                'date' => date('Y-m-d'),
                'api' => [
                    'version' => '1.0',
                    'method' => $getMethod,
                    'description' => 'API Criar Method',
                    'content_type' => 'application/x-www-form-urlencoded'
                ],
                'metadata' => [
                    'page_title' => 'ERRO - API Method',
                    'getURI' => $this->uri->getSegments(),
                ]
            ];
            if ($json == 1) {
                $response = $this->response->setJSON($apiRespond, 500);
            }
        }
        if ($json == 1) {
            return $apiRespond;
        } else {
            return $apiRespond;
            // return view($this->template, $apiRespond);
        }
    }

    # Consumo de API
    # route GET /www/sigla/rota
    # route POST /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function dbUpdate($parameter = NULL)
    {
        $this->token_csrf();
        $request = service('request');
        $getMethod = $request->getMethod();
        $getVar_page = $request->getVar('page');
        $processRequest = (array)$request->getVar();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        $id = (isset($processRequest['id'])) ? ('/' . $processRequest['id']) : ('/' . $parameter);
        // $processRequest = eagarScagaire($processRequest);
        #
        $loadView = array(
            $this->head,
            $this->menu,
            $this->message,
            $this->footer,
        );
        try {
            # URI da API                                                                                                          
            $endPoint['objeto'] = myEndPoint('index.php/projeto/endereco/api/verbo', '123');
            $requestJSONform['objeto'] = isset($endPoint['objeto']['result']) ? $endPoint['objeto']['result'] : array();
            # Configuração Paginate
            $totalItems = count($requestJSONform['objeto']);
            $itemsPerPage = 10; // Itens por página
            // $totalPages = ceil($totalItems / $itemsPerPage);
            $currentPage = isset($getVar_page) ? $getVar_page : 1;
            # Constrção Paginate
            $pager = service('pager');
            $pager->setPath('intranet/painel/endpoint/master');
            $pager->makeLinks($currentPage, $itemsPerPage, $totalItems);
            # Finalização Paginate
            $requestJSONform['objeto']['list'] = $this->paginateArray($requestJSONform['objeto'], $currentPage, $itemsPerPage);
            $requestJSONform['objeto']['pager'] = $pager;
            #
            $requestJSONform = array();
            $apiRespond = [
                'status' => 'success',
                'message' => 'API loading data (dados para carregamento da API)',
                'date' => date('Y-m-d'),
                'api' => [
                    'version' => '1.0',
                    'method' => $getMethod,
                    'description' => 'API Description',
                    'content_type' => 'application/x-www-form-urlencoded'
                ],
                // 'method' => '__METHOD__',
                // 'function' => '__FUNCTION__',
                'result' => $processRequest,
                'loadView' => $loadView,
                'metadata' => [
                    'page_title' => 'Application title',
                    'getURI' => $this->uri->getSegments(),
                    // Você pode adicionar campos comentados anteriormente se forem relevantes
                    // 'method' => '__METHOD__',
                    // 'function' => '__FUNCTION__',
                ]
            ];
            if ($json == 1) {
                $response = $this->response->setJSON($apiRespond, 201);
            }
        } catch (\Exception $e) {
            $apiRespond = [
                'status' => 'error',
                'message' => $e->getMessage(),
                'date' => date('Y-m-d'),
                'api' => [
                    'version' => '1.0',
                    'method' => $getMethod,
                    'description' => 'API Criar Method',
                    'content_type' => 'application/x-www-form-urlencoded'
                ],
                'metadata' => [
                    'page_title' => 'ERRO - API Method',
                    'getURI' => $this->uri->getSegments(),
                ]
            ];
            if ($json == 1) {
                $response = $this->response->setJSON($apiRespond, 500);
            }
        }
        if ($json == 1) {
            return $apiRespond;
        } else {
            return $apiRespond;
            // return view($this->template, $apiRespond);
        }
    }

    # Consumo de API
    # route GET /www/sigla/rota
    # route POST /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [VIEW]
    public function dbDelete($parameter = NULL)
    {
        $this->token_csrf();
        $request = service('request');
        $getMethod = $request->getMethod();
        $getVar_page = $request->getVar('page');
        $processRequest = (array)$request->getVar();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        $id = (isset($processRequest['id'])) ? ('/' . $processRequest['id']) : ('/' . $parameter);
        // $processRequest = eagarScagaire($processRequest);
        #
        $loadView = array(
            $this->head,
            $this->menu,
            $this->message,
            $this->footer,
        );
        try {
            # URI da API                                                                                                          
            $endPoint['objeto'] = myEndPoint('index.php/projeto/endereco/api/verbo', '123');
            $requestJSONform['objeto'] = isset($endPoint['objeto']['result']) ? $endPoint['objeto']['result'] : array();
            # Configuração Paginate
            $totalItems = count($requestJSONform['objeto']);
            $itemsPerPage = 10; // Itens por página
            // $totalPages = ceil($totalItems / $itemsPerPage);
            $currentPage = isset($getVar_page) ? $getVar_page : 1;
            # Constrção Paginate
            $pager = service('pager');
            $pager->setPath('intranet/painel/endpoint/master');
            $pager->makeLinks($currentPage, $itemsPerPage, $totalItems);
            # Finalização Paginate
            $requestJSONform['objeto']['list'] = $this->paginateArray($requestJSONform['objeto'], $currentPage, $itemsPerPage);
            $requestJSONform['objeto']['pager'] = $pager;
            #
            $requestJSONform = array();
            $apiRespond = [
                'status' => 'success',
                'message' => 'API loading data (dados para carregamento da API)',
                'date' => date('Y-m-d'),
                'api' => [
                    'version' => '1.0',
                    'method' => $getMethod,
                    'description' => 'API Description',
                    'content_type' => 'application/x-www-form-urlencoded'
                ],
                // 'method' => '__METHOD__',
                // 'function' => '__FUNCTION__',
                'result' => $processRequest,
                'loadView' => $loadView,
                'metadata' => [
                    'page_title' => 'Application title',
                    'getURI' => $this->uri->getSegments(),
                    // Você pode adicionar campos comentados anteriormente se forem relevantes
                    // 'method' => '__METHOD__',
                    // 'function' => '__FUNCTION__',
                ]
            ];
            if ($json == 1) {
                $response = $this->response->setJSON($apiRespond, 201);
            }
        } catch (\Exception $e) {
            $apiRespond = [
                'status' => 'error',
                'message' => $e->getMessage(),
                'date' => date('Y-m-d'),
                'api' => [
                    'version' => '1.0',
                    'method' => $getMethod,
                    'description' => 'API Criar Method',
                    'content_type' => 'application/x-www-form-urlencoded'
                ],
                'metadata' => [
                    'page_title' => 'ERRO - API Method',
                    'getURI' => $this->uri->getSegments(),
                ]
            ];
            if ($json == 1) {
                $response = $this->response->setJSON($apiRespond, 500);
            }
        }
        if ($json == 1) {
            return $apiRespond;
        } else {
            return $apiRespond;
            // return view($this->template, $apiRespond);
        }
    }
}
