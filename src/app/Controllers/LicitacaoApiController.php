<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\LicitacaoModel;
use App\Models\LicitacaoEtapaModel;
// use App\Models\NomeModel;
use Exception;

class LicitacaoApiController extends ResourceController
{ // src\app\Controllers\LicitacaoApiController.php
    use ResponseTrait;
    private $ModelLicitacao;
    private $ModelLicitacaoEtapa;
    private $dbFields;
    private $uri;

    public function __construct()
    {
        // $this->ModelResponse = new NomeModel();
        $this->ModelLicitacao = new LicitacaoModel();
        $this->ModelLicitacaoEtapa = new LicitacaoEtapaModel();
        $this->uri = new \CodeIgniter\HTTP\URI(current_url());
        // helper([
        //'myPrint',
        //'myDate',
        //'myIdUFF',
        //'myFake'
        // ]);
    }
    #
    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function index($parameter = NULL)
    {
        # Parâmentros para receber um POST
        $request = service('request');
        $getMethod = $request->getMethod();
        $getVar_page = $request->getVar('page');
        $processRequest = (array)$request->getVar();
        $uploadedFiles = $request->getFiles();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        // $processRequest = eagarScagaire($processRequest);
        #
        try {
            if (isset($processRequest['id'])) {
                # CRUD da Model
                // $dbResponse[] = $this->ModelResponse
                //    ->dBcreate($processRequest);
                #
                // $dbResponse[] = $this->ModelResponse
                //    ->where('id', $processRequest['id'])
                //     ->where('deleted_at', NULL)
                //     ->orderBy('updated_at', 'asc')
                //     ->dBread()
                //     ->find();
                #
                // $dbResponse[] = $this->ModelResponse
                //     ->dBupdate($processRequest['id'], $processRequest);
                #
                // $dbResponse[] = $this->ModelResponse
                //     ->where('id', $processRequest['id'])
                //     ->dBdelete();
                #
            } elseif ($parameter !== NULL) {
                # CRUD da Model
                // $dbResponse[] = $this->ModelResponse
                //     ->dBcreate($processRequest);
                #
                // $dbResponse[] = $this->ModelResponse
                //     ->where('id', $parameter)
                //     ->where('deleted_at', NULL)
                //     ->orderBy('updated_at', 'asc')
                //     ->dBread()
                //     ->find();
                #
                // $dbResponse[] = $this->ModelResponse
                //     ->dBupdate($parameter, $processRequest);
                #
                // $dbResponse[] = $this->ModelResponse
                //     ->where('id', $parameter)
                //     ->dBdelete();
                #
            } else {
                // $dbResponse[] = $this->ModelResponse
                //     ->dBcreate($processRequest);
                #
                // $dbResponse[] = $this->ModelResponse
                //     ->where('deleted_at', NULL)
                //     ->orderBy('updated_at', 'asc')
                //     ->dBread()
                //     ->findAll();
            };
            $apiRespond = [
                'status' => 'success',
                'message' => 'API loading data (dados para carregamento da API)',
                'date' => date('Y-m-d'),
                'api' => [
                    'version' => '1.0',
                    'method' => isset($getMethod) ? $getMethod : 'unknown',
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
            if ($json == 1) {
                return $response;
                // return redirect()->back();
                // return redirect()->to('project/endpoint/parameter/parameter/' . $parameter);
            } else {
                return $response;
                // return redirect()->back();
                // return redirect()->to('project/endpoint/parameter/parameter/' . $parameter);
            }
        }
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
        $processRequest = (array)$request->getVar();
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
            };
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

    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function dbOrder($parameter = NULL)
    {
        # Parâmentros para receber um POST
        $request = service('request');
        $getMethod = $request->getMethod();
        $processRequest = (array)$request->getVar();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        // $processRequest = eagarScagaire($processRequest);
        #
        try {
            if (isset($processRequest['id'])) {
                # CRUD da Model
                // $dbResponse[] = $this->ModelResponse
                //    ->dBcreate($processRequest);
                #
                // $dbResponse[] = $this->ModelResponse
                //    ->where('id', $processRequest['id'])
                //     ->where('deleted_at', NULL)
                //     ->orderBy('updated_at', 'asc')
                //     ->dBread()
                //     ->find();
                #
                // $dbResponse[] = $this->ModelResponse
                //     ->dBupdate($processRequest['id'], $processRequest);
                #
                // $dbResponse[] = $this->ModelResponse
                //     ->where('id', $processRequest['id'])
                //     ->dBdelete();
                #
            } elseif ($parameter !== NULL) {
                # CRUD da Model
                // $dbResponse[] = $this->ModelResponse
                //     ->dBcreate($processRequest);
                #
                // $dbResponse[] = $this->ModelResponse
                //     ->where('id', $parameter)
                //     ->where('deleted_at', NULL)
                //     ->orderBy('updated_at', 'asc')
                //     ->dBread()
                //     ->find();
                #
                // $dbResponse[] = $this->ModelResponse
                //     ->dBupdate($parameter, $processRequest);
                #
                // $dbResponse[] = $this->ModelResponse
                //     ->where('id', $parameter)
                //     ->dBdelete();
                #
            } else {
                // $dbResponse[] = $this->ModelResponse
                //     ->dBcreate($processRequest);
                #
                // $dbResponse[] = $this->ModelResponse
                //     ->where('deleted_at', NULL)
                //     ->orderBy('updated_at', 'asc')
                //     ->dBread()
                //     ->findAll();
            };
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
                    'message' => array('danger'=>$e->getMessage()),
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

    # route POST /www/qlikreact/licitacao/api/listar/(:any)
    # route GET /www/qlikreact/licitacao/api/listar/(:any)
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function dbRead($parameter = NULL)
    {
        # Parâmentros para receber um POST
        $dbResponse = array();
        $request = service('request');
        $getMethod = $request->getMethod();
        $processRequest = (array)$request->getVar();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        // $processRequest = eagarScagaire($processRequest);
        #
        try {
            if (isset($processRequest['id'])) {
                $dbResponse['listar_licitacao'] = $this->ModelLicitacao
                    ->where('pk_bidding', $processRequest['pk_bidding'])
                    ->where('deleted_at', NULL)
                    ->orderBy('priority', 'asc')
                    ->dBread()
                    ->find();
                #
            } elseif ($parameter !== NULL) {
                $dbResponse['listar_licitacao'] = $this->ModelLicitacao
                    ->where('pk_bidding', $parameter)
                    ->where('deleted_at', NULL)
                    ->orderBy('priority', 'asc')
                    ->dBread()
                    ->find();
                #
            } else {
                $dbResponse['listar_licitacao'] = $this->ModelLicitacao
                    ->where('deleted_at', NULL)
                    ->orderBy('priority', 'asc')
                    ->dBread()
                    ->findAll();
            };
            foreach ($dbResponse['listar_licitacao'] as $key_dbResponse => $value_dbResponse) {
                $pk_bidding = isset($value_dbResponse['pk_bidding']) ? ($value_dbResponse['pk_bidding']) : (NULL);
                // myPrint($pk_bidding, 'src\app\Controllers\AcquisitionProcessManagementApiController.php', true);
                if ($pk_bidding !== NULL) {
                    $ind_dead_line = 0;
                    $ind_made_true = 0;
                    $ind_made_false = 0;
                    $etapa_licitacao = $this->ModelLicitacaoEtapa
                        ->where('pk_bidding', $pk_bidding)
                        ->where('deleted_at', NULL)
                        ->orderBy('orderc', 'asc')
                        ->dBread()
                        ->findAll();
                    foreach ($etapa_licitacao as $key_bidding => $value_bidding) {
                        // myPrint($value_bidding, '$value_bidding', true);
                        if ($value_bidding['pk_bidding'] === 'ata_aquisicao_de_computadores_cmacbookdit_') {
                            // myPrint($value_bidding, '$value_bidding', true);
                        }
                        if (
                            $value_bidding['deadline'] === NULL
                        ) {
                            // echo $value_bidding['deadline'] . ' === ' . 'NULL';
                            $ind_dead_line++;
                        }
                        if (
                            $value_bidding['deadline'] !== NULL && $value_bidding['deadline'] > date('Y-m-d H:i:s')
                            && $value_bidding['deadline'] > $value_bidding['date_end']
                            || $value_bidding['deadline'] == NULL
                            && $value_bidding['date_start'] == NULL
                            && $value_bidding['date_end'] !== NULL
                            || $value_bidding['date_end'] !== NULL
                            && $value_bidding['deadline'] !== NULL
                            && $value_bidding['date_start'] !== NULL
                            && $value_bidding['date_end'] == $value_bidding['deadline']
                            && $value_bidding['deadline'] == $value_bidding['date_start']
                            && $value_bidding['date_start'] == $value_bidding['date_end']
                        ) {
                            // echo $value_bidding['deadline'] . ' > ' . date('Y-m-d H:i:s');
                            $ind_made_true++;
                        }
                        if (
                            $value_bidding['deadline'] !== NULL
                            && $value_bidding['deadline'] < $value_bidding['date_end']
                            || $value_bidding['deadline'] < date('Y-m-d H:i:s')
                            && $value_bidding['date_end'] == NULL
                            && $value_bidding['date_start'] !== NULL
                            || $value_bidding['deadline'] !== NULL
                            && $value_bidding['deadline'] < date('Y-m-d H:i:s')
                            && $value_bidding['date_start'] == NULL
                            && $value_bidding['date_end'] == NULL
                        ) {
                            // echo $value_bidding['deadline'] . ' < ' . date('Y-m-d H:i:s');
                            $ind_made_false++;
                            // myPrint($value_bidding, '$value_bidding', true);
                        }
                        // echo "<br>";
                    }
                    // exit();
                    // myPrint('Licitação: ', $pk_bidding, true);
                    // myPrint('Sem Prazo', $ind_dead_line, true);
                    // myPrint('Sem Atraso', $ind_made_true, true);
                    // myPrint('Com atraso', $ind_made_false, true);
                    // #
                    if (
                        $ind_dead_line > 1
                        && $ind_made_true === 0
                        && $ind_made_false === 0
                    ) {
                        // echo "Bateu com tudo em Branco";
                        // $dbResponse[$pk_bidding]['emoji'] = 'emoji_neutral_fill';
                        $dbResponse['carinha'][] = array(
                            'pk_bidding' => $pk_bidding,
                            'sem_prazo' => $ind_dead_line,
                            'sem_atraso' => $ind_made_true,
                            'com_atraso' => $ind_made_false,
                            'emoji' => 'emoji_neutral_fill'
                        );
                        $dbUpdate = [
                            'not_fulfilled' => 'Y'
                        ];
                        $this->ModelLicitacao->dbUpdate($pk_bidding, $dbUpdate);
                    } elseif (
                        $ind_made_false > 0
                    ) {
                        // echo "Com atraso";
                        // $dbResponse[$pk_bidding]['emoji'] = 'emoji_frown_fill';
                        $dbResponse['carinha'][] = array(
                            'pk_bidding' => $pk_bidding,
                            'sem_prazo' => $ind_dead_line,
                            'sem_atraso' => $ind_made_true,
                            'com_atraso' => $ind_made_false,
                            'emoji' => 'emoji_frown_fill'
                        );
                        $dbUpdate = [
                            'not_fulfilled' => 'N'
                        ];
                        $this->ModelLicitacao->dbUpdate($pk_bidding, $dbUpdate);
                    } elseif (
                        $ind_dead_line > 0
                    ) {
                        // echo "Sem atraso";
                        // $dbResponse[$pk_bidding]['emoji'] = 'emoji_smile_fill';
                        $dbResponse['carinha'][] = array(
                            'pk_bidding' => $pk_bidding,
                            'sem_prazo' => $ind_dead_line,
                            'sem_atraso' => $ind_made_true,
                            'com_atraso' => $ind_made_false,
                            'emoji' => 'emoji_smile_fill'
                        );
                        $dbUpdate = [
                            'not_fulfilled' => 'Y'
                        ];
                        $this->ModelLicitacao->dbUpdate($pk_bidding, $dbUpdate);
                    } elseif (
                        $ind_dead_line == 0
                        && $ind_made_true > 0
                        && $ind_made_false == 0
                    ) {
                        // echo "Sem atraso";
                        // $dbResponse[$pk_bidding]['emoji'] = 'emoji_smile_fill';
                        $dbResponse['carinha'][] = array(
                            'pk_bidding' => $pk_bidding,
                            'sem_prazo' => $ind_dead_line,
                            'sem_atraso' => $ind_made_true,
                            'com_atraso' => $ind_made_false,
                            'emoji' => 'emoji_smile_fill'
                        );
                        $dbUpdate = [
                            'not_fulfilled' => 'Y'
                        ];
                        $this->ModelLicitacao->dbUpdate($pk_bidding, $dbUpdate);
                    } else {
                        // $dbResponse[$pk_bidding]['emoji'] = '';
                        $dbResponse['carinha'][] = array(
                            'pk_bidding' => $pk_bidding,
                            'sem_prazo' => $ind_dead_line,
                            'sem_atraso' => $ind_made_true,
                            'com_atraso' => $ind_made_false,
                            'emoji' => 'emoji_smile_fill'
                        );
                    }
                }
            }
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
            // myPrint($dbResponse, 'src\app\Controllers\LicitacaoApiController.php');
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
            myPrint($e->getMessage(), 'src\app\Controllers\LicitacaoApiController.php');
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
        $processRequest = (array)$request->getVar();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        // $processRequest = eagarScagaire($processRequest);
        #
        try {
            // DELETE LOGICO
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
        $processRequest = (array)$request->getVar();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        // $processRequest = eagarScagaire($processRequest);
        #
        try {
            // DELETE DEFINITIVO
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
