<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use Exception;

class SystemMessageController extends Controller
{
    private $variavel;
    public function __construct()
    {
        $this->variavel = 'variavel';
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

    public function returnMyFunction($message = array(), $typeMessage, $dataValue = array())
    {
        try {
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
    } catch (\Exception $e) {
        return $e->getMessage();
    }
        return (NULL);
    }

    # route POST /www/sigla/rota
    # route GET /www/sigla/rota
    # Informação sobre o controller
    # retorno do controller [JSON]
    public function onRest($parameter = NULL)
    {
        # Parâmentros para receber um POST
        $request = service('request');
        $getMethod = $request->getMethod();
        $processRequest = (array)$request->getVar();
        $json = isset($processRequest['json']) && $processRequest['json'] == 1 ? 1 : 0;
        // $processRequest = eagarScagaire($processRequest);
        #
        try {
            
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
}
?>