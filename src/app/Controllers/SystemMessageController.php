<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use Exception;

class SystemMessageController extends Controller
{
    private $message;
    public function __construct()
    {
        $this->message = array();
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

    public function message($message = array(), $typeMessage, $dataValue = array(), $tempData = 5)
    {
        try {
            // ['success', 'warning', 'danger'];
            if (session()->get('message')) {
                $recebe = session()->get('message');
                foreach ($recebe as $key_recebe => $value_recebe) {
                    $this->message[] = $value_recebe;
                }
            }
            #
            if ($this->message !== array()) {
                $message['message'][$typeMessage] = $this->message;
                session()->set('message', $message);
                session()->markAsTempdata('message', $tempData);
            }
            #
            if ($dataValue !== array()) {
                session()->set('value_form', $dataValue);
            }
            session()->markAsTempdata(
                'message',
                $tempData
            );
        } catch (Exception $e) {
            $message['message']['danger'] = $e->getMessage();
            session()->set('message', $message);
            session()->markAsTempdata('message', $tempData);
        }
    }
}
?>