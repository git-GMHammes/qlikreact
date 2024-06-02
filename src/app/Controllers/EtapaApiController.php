<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EtapaModel;
use App\Controllers\EtapaDbController;
use Exception;

class EtapaApiController extends ResourceController
{ // src\app\Controllers\EtapaApiController.php
    use ResponseTrait;
    private $ModeEtapa;
    private $EtapaDb;
    private $dbFields;
    private $uri;

    public function __construct()
    {
        $this->ModeEtapa = new EtapaModel();
        $this->EtapaDb = new EtapaDbController();
        $this->uri = new \CodeIgniter\HTTP\URI(current_url());
    }
    #
    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function index($parameter = NULL)
    {
        exit('403 Forbidden - Directory access is forbidden.');
    }

    private function validtoken_csrf($token)
    {
        if ($token = '$ywB9i/CRwduLN0lgDED2jR.UrpxAw1eHBThgNYG.xfBfrhHr8IBOY2') {
            return true;
        }
        if (session()->get('token_csrf')) {
            $token_csrf = session()->get('token_csrf');
        } else {
            $token_csrf = 'FALSE';
        }
        if ($token_csrf == $token) {
            return true;
        } else {
            return false;
        }
    }

    private function dbFields($processRequestFields = array())
    {
        $dbCreate = array();
        (isset($processRequestFields['fieldForm'])) ? ($dbCreate['fieldDb01'] = $processRequestFields['fieldForm']) : (NULL);
        (isset($processRequestFields['fieldForm'])) ? ($dbCreate['fieldDb02'] = $processRequestFields['fieldForm']) : (NULL);
        (isset($processRequestFields['fieldForm'])) ? ($dbCreate['fieldDb03'] = $processRequestFields['fieldForm']) : (NULL);
        (isset($processRequestFields['fieldForm'])) ? ($dbCreate['fieldDb04'] = $processRequestFields['fieldForm']) : (NULL);
        (isset($processRequestFields['fieldForm'])) ? ($dbCreate['fieldDb05'] = $processRequestFields['fieldForm']) : (NULL);
        (isset($processRequestFields['fieldForm'])) ? ($dbCreate['fieldDb06'] = $processRequestFields['fieldForm']) : (NULL);
        (isset($processRequestFields['fieldForm'])) ? ($dbCreate['fieldDb07'] = $processRequestFields['fieldForm']) : (NULL);
        (isset($processRequestFields['created_at'])) ? ($dbCreate['created_at'] = $processRequestFields['created_at']) : (NULL);
        (isset($processRequestFields['updated_at'])) ? ($dbCreate['updated_at'] = $processRequestFields['updated_at']) : (NULL);
        return ($dbCreate);
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

    # route POST /www/crud/api/criar/(:any)
    # route GET /www/crud/api/criar/(:any)
    # route POST /www/crud/api/atualizar/(:any)
    # route GET /www/crud/api/atualizar/(:any)
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function create_update($parameter = NULL)
    {
        # Parâmentros para receber um POST
        $request = service('request');
        $getMethod = $request->getMethod();
        $getVar_page = $request->getVar('page');
        $processRequest = (array) $request->getVar();
        // $uploadedFiles = $request->getFiles();
        $token_csrf = (isset($processRequest['token_csrf']) ? $processRequest['token_csrf'] : NULL);
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        $choice_update = (isset($processRequest['id'])) ? (true) : (false);
        // $processRequest = eagarScagaire($processRequest);
        #
        // $processRequest = array();
        try {
            if ($choice_update === true) {
                if ($this->validtoken_csrf($token_csrf)) {
                    $this->ModelResponse->dbUpdate(
                        $processRequest['id'],
                        $this->dbFields($processRequest)
                    );
                    if ($this->ModelResponse->affectedRows() > 0) {
                        $this->returnMyFunction(['Update realizado com sucesso'], 'success');
                        $processRequestSuccess = true;
                    }
                }
            } elseif ($choice_update === false) {
                if ($this->validtoken_csrf($token_csrf)) {
                    $this->ModelResponse->dbCreate($this->dbFields($processRequest));
                    $id = ($this->ModelResponse->affectedRows() > 0) ? ($this->ModelResponse->insertID()) : (NULL);
                    if ($this->ModelResponse->affectedRows() > 0) {
                        $this->returnMyFunction(['Create realizado com sucesso'], 'success');
                        $processRequestSuccess = true;
                    }
                }
            } else {
                $this->returnMyFunction(['ERRO: Dados enviados inválidos'], 'danger');
            }
            ;
            $status = (!isset($processRequestSuccess) || $processRequestSuccess !== true) ? ('trouble') : ('success');
            $message = (!isset($processRequestSuccess) || $processRequestSuccess !== true) ? ('Erro - requisição que foi bem-formada mas não pôde ser seguida devido a erros semânticos.') : ('API loading data (dados para carregamento da API)');
            $cod_http = (!isset($processRequestSuccess) || $processRequestSuccess !== true) ? (422) : (201);
            $apiRespond = [
                'status' => $status,
                'message' => $message,
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
                'metadata' => [
                    'page_title' => 'Application title',
                    'getURI' => $this->uri->getSegments(),
                    // Você pode adicionar campos comentados anteriormente se forem relevantes
                    // 'method' => '__METHOD__',
                    // 'function' => '__FUNCTION__',
                ]
            ];
            $response = $this->response->setJSON($apiRespond, $cod_http);
        } catch (\Exception $e) {
            $apiRespond = [
                'status' => 'error',
                'message' => $e->getMessage(),
                'date' => date('Y-m-d'),
                'api' => [
                    'version' => '1.0',
                    'method' => isset($getMethod) ? $getMethod : 'unknown',
                    'description' => 'API Criar Method',
                    'content_type' => 'application/x-www-form-urlencoded'
                ],
                'metadata' => [
                    'page_title' => 'ERRO - API Method',
                    'getURI' => $this->uri->getSegments(),
                ]
            ];
            $response = $this->response->setJSON($apiRespond, 500);
        }
        if ($json) {
            return $response;
            // return redirect()->to('project/endpoint/parameter/parameter/' . $parameter);
        } else {
            return $response;
            // return redirect()->back();
        }
    }

    # route POST /www/qlikreact/etapa/api/ordem/(:any)
    # route GET /www/qlikreact/etapa/api/ordem/(:any)
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function dbOrder($parameter = NULL)
    {
        # Parâmentros para receber um POST
        $request = service('request');
        $getMethod = $request->getMethod();
        $processRequest = (array) $request->getVar();
        // myPrint($processRequest, 'src\app\Controllers\EtapaApiController.php', true);
        $setFormOrder = isset($processRequest['setFormOrder']) ? ($processRequest['setFormOrder']) : (array());
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        #
        try {
            foreach ($setFormOrder as $key_setFormOrder => $value_setFormOrder) {
                $setFormOrder = explode('|', $value_setFormOrder);
                $pk_stage = isset($setFormOrder[1]) ? ($setFormOrder[1]) : (NULL);
                $order = isset($setFormOrder[0]) ? ($setFormOrder[0]) : (NULL);
                $dbUpdate = array(
                    'pk_stage' => $pk_stage,
                    'order' => $order
                );
                // myPrint($dbUpdate, '', true);
                $this->ModeEtapa
                    ->dbUpdate($pk_stage, $dbUpdate);
            }
            $ModeEtapa['read'] = $this->ModeEtapa
                ->dbRead()
                ->orderBy('order', 'asc')
                ->findAll();
            // myPrint($ModeEtapa, '');
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
                'result' => $ModeEtapa,
                'metadata' => [
                    'page_title' => 'Application title',
                    'getURI' => $this->uri->getSegments(),
                    // Você pode adicionar campos comentados anteriormente se forem relevantes
                    // 'method' => '__METHOD__',
                    // 'function' => '__FUNCTION__',
                ]
            ];
            $response = $this->response->setJSON($apiRespond, 201);
        } catch (\Exception $e) {
            $apiRespond = array(
                'result' => array('danger' => $e->getMessage()),
                'message' => array('danger' => $e->getMessage()),
                'page_title' => 'Application title',
                'getURI' => $this->uri->getSegments(),
            );
            // $this->returnFunction(array($e->getMessage()), 'danger',);
            $response = $this->response->setJSON($apiRespond, 500);
        }
        if ($json == 1) {
            return $response;
            // return redirect()->to('project/endpoint/parameter/parameter/' . $parameter);
        } else {
            return $response;
            // return redirect()->back();
        }
    }

    # route POST /qlikreact/etapa/api/listar/(:any)
    # route GET /qlikreact/etapa/api/listar/(:any)
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function dbRead($parameter = NULL)
    {
        # Parâmentros para receber um POST
        $request = service('request');
        $getMethod = $request->getMethod();
        $processRequest = (array) $request->getVar();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        // $processRequest = eagarScagaire($processRequest);
        #
        try {
            if (isset($processRequest['id'])) {
                // use App\Controllers\EtapaDbController;
                $dbResponse = $this->EtapaDb->selectBase($processRequest['id']);
            } elseif ($parameter !== NULL) {
                // use App\Controllers\EtapaDbController;
                $dbResponse = $this->EtapaDb->selectBase($parameter);
            } else {
                // use App\Controllers\EtapaDbController;
                $dbResponse = $this->EtapaDb->selectBase();
            }
            // myPrint($dbResponse, 'src\app\Controllers\EtapaApiController.php');
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
                'result' => $dbResponse,
                'metadata' => [
                    'page_title' => 'Application title',
                    'getURI' => $this->uri->getSegments(),
                    // Você pode adicionar campos comentados anteriormente se forem relevantes
                    // 'method' => '__METHOD__',
                    // 'function' => '__FUNCTION__',
                ]
            ];
            $response = $this->response->setJSON($apiRespond, 201);
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
            $response = $this->response->setJSON($apiRespond, 500);
        }
        if ($json == 1) {
            return $response;
            // return redirect()->to('project/endpoint/parameter/parameter/' . $parameter);
        } else {
            return $response;
            // return redirect()->back();
        }
    }

    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function dbDelete($parameter = NULL)
    {
        # Parâmentros para receber um POST
        $request = service('request');
        $getMethod = $request->getMethod();
        $processRequest = (array) $request->getVar();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        // $processRequest = eagarScagaire($processRequest);
        #
        try {
            // Colocar logica de UPDATE para DELETE LOGICO
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
                'metadata' => [
                    'page_title' => 'Application title',
                    'getURI' => $this->uri->getSegments(),
                    // Você pode adicionar campos comentados anteriormente se forem relevantes
                    // 'method' => '__METHOD__',
                    // 'function' => '__FUNCTION__',
                ]
            ];
            $response = $this->response->setJSON($apiRespond, 201);
        } catch (\Exception $e) {
            $apiRespond = array(
                'message' => array('danger' => $e->getMessage()),
                'page_title' => 'Application title',
                'getURI' => $this->uri->getSegments(),
            );
            // $this->returnFunction(array($e->getMessage()), 'danger',);
            $response = $this->response->setJSON($apiRespond, 500);
        }
        if ($json == 1) {
            return $response;
            // return redirect()->back();
            // return redirect()->to('project/endpoint/parameter/parameter/' . $parameter);
        } else {
            return $response;
        }
    }

    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function clear($parameter = NULL)
    {
        # Parâmentros para receber um POST
        $request = service('request');
        $getMethod = $request->getMethod();
        $processRequest = (array) $request->getVar();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        // $processRequest = eagarScagaire($processRequest);
        #
        try {
            // DELETE PERMANENTE
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
                'metadata' => [
                    'page_title' => 'Application title',
                    'getURI' => $this->uri->getSegments(),
                    // Você pode adicionar campos comentados anteriormente se forem relevantes
                    // 'method' => '__METHOD__',
                    // 'function' => '__FUNCTION__',
                ]
            ];
            $response = $this->response->setJSON($apiRespond, 201);
        } catch (\Exception $e) {
            $apiRespond = array(
                'message' => array('danger' => $e->getMessage()),
                'page_title' => 'Application title',
                'getURI' => $this->uri->getSegments(),
            );
            // $this->returnFunction(array($e->getMessage()), 'danger',);
            $response = $this->response->setJSON($apiRespond, 500);
        }
        if ($json == 1) {
            return $response;
            // return redirect()->back();
            // return redirect()->to('project/endpoint/parameter/parameter/' . $parameter);
        } else {
            return $response;
        }
    }
}
