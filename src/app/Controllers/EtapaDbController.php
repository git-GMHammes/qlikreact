<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EtapaModel;
use Exception;

class EtapaDbController extends ResourceController
{ // src\app\Controllers\EtapaDbController.php
    use ResponseTrait;
    private $ModelEtapa;
    private $dbFields;
    private $uri;

    public function __construct()
    {
        $this->ModelEtapa = new EtapaModel();
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
        exit('403 Forbidden - Directory access is forbidden.');
        # Parâmentros para receber um POST
        $request = service('request');
        $getMethod = $request->getMethod();
        $getVar_page = $request->getVar('page');
        $processRequest = (array) $request->getVar();
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
            }
            ;
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

    private function returnMyFunction($message = array(), $typeMessage, $dataValue = array())
    {
        // ['success', 'warning', 'danger'];
        if (session()->get('message')) {
            $recebe = session()->get('message');
            foreach ($recebe as $key_recebe => $value_recebe) {
                $message[] = $value_recebe;
            }
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

    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function selectBase($parameter1 = NULL, $parameter2 = 1000)
    {
        try {
            if ($parameter1 !== NULL) {
                $dbResponse = $this
                    ->ModelEtapa
                    ->where('pk_stage', $parameter1)
                    ->where('deleted_at', NULL)
                    ->orderBy('order', 'asc')
                    ->limit($parameter2)
                    ->dBread()
                    ->find();
            } else {
                $dbResponse = $this
                    ->ModelEtapa
                    ->where('deleted_at', NULL)
                    ->orderBy('order', 'asc')
                    ->limit($parameter2)
                    ->dBread()
                    ->findAll();
            }
        } catch (Exception $e) {
            $this->returnMyFunction(array($e->getMessage()), 'danger');
            $dbResponse = array();
        }
        return $dbResponse;
    }

}
?>