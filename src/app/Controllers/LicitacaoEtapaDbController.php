<?php
namespace App\Controllers;

use App\Models\LicitacaoEtapaModel;
use App\Controllers\SystemMessageController;
use Exception;

class LicitacaoEtapaDbController extends BaseController
{ // src\app\Controllers\EtapaDbController.php
    private $ModelLicitacaoEtapa;
    private $dbFields;
    private $message;
    private $uri;

    public function __construct()
    {
        $this->ModelLicitacaoEtapa = new LicitacaoEtapaModel();
        $this->uri = new \CodeIgniter\HTTP\URI(current_url());
        $this->message = new SystemMessageController();
    }
    #
    public function index($parameter = NULL)
    {
        exit('403 Forbidden - Directory access is forbidden.');
    }

    # use App\Controllers\LicitacaoEtapaDbController;
    # private $EtapaDb;
    # $this->EtapaDb = new LicitacaoEtapaDbController();
    # $this->EtapaDb->selectBase();
    public function selectBase($parameter1 = NULL, $parameter2 = 1000)
    {
        try {
            if ($parameter1 !== NULL) {
                $dbResponse = $this
                    ->ModelLicitacaoEtapa
                    ->where('ID', $parameter1)
                    ->where('deleted_at', NULL)
                    ->orderBy('orderc', 'asc')
                    ->limit(1)
                    ->dBread()
                    ->find();
            } else {
                $dbResponse = $this
                    ->ModelLicitacaoEtapa
                    ->where('deleted_at', NULL)
                    ->orderBy('orderc', 'asc')
                    ->limit($parameter2)
                    ->dBread()
                    ->find();
            }
        } catch (Exception $e) {
            $this->message->message(['ERRO: ' . $e->getMessage()], 'danger');
            $dbResponse = array();
        }
        return $dbResponse;
    }

    # use App\Controllers\LicitacaoEtapaDbController;
    # private $EtapaDb;
    # $this->EtapaDb = new LicitacaoEtapaDbController();
    # $this->EtapaDb->currentStage();
    public function currentStage($parameter1 = NULL)
    {
        try {
            $dbResponse = $this
                ->ModelLicitacaoEtapa
                ->where('pk_bidding', $parameter1)
                ->where('deleted_at', NULL)
                ->where('date_end', NULL)
                ->orderBy('orderc', 'asc')
                ->limit(1)
                ->dBread()
                ->find();
        } catch (Exception $e) {
            $this->message->message(['ERRO: ' . $e->getMessage()], 'danger');
            $dbResponse = array();
        }
        return $dbResponse;
    }

    public function curentBidding($parameter1 = NULL, $parameter2 = NULL, $parameter3 = 1000)
    {
        // myPrint($parameter1, $parameter2, true);
        // myPrint($parameter1, $parameter3, true);
        try {
            if (
                $parameter1 !== NULL
                && $parameter2 == NULL
            ) {
                $dbResponse = $this
                    ->ModelLicitacaoEtapa
                    ->where('pk_bidding', $parameter1)
                    ->where('deleted_at', NULL)
                    ->orderBy('orderc', 'asc')
                    ->limit($parameter3)
                    ->dBread()
                    ->findAll();
            } else if (
                $parameter1 !== NULL
                && $parameter2 !== NULL
            ) {
                $dbResponse = $this
                    ->ModelLicitacaoEtapa
                    ->where('pk_bidding', $parameter1)
                    ->where('ID', $parameter2)
                    ->where('deleted_at', NULL)
                    ->orderBy('orderc', 'asc')
                    ->limit(1)
                    ->dBread()
                    ->find();
            } else {
                $dbResponse = array();
                $this->message->message(['ERRO: ' . 'Parametros passados não é o suficiente'], 'danger');
            }
        } catch (Exception $e) {
            $dbResponse = array();
            $this->message->message(['ERRO: ' . $e->getMessage()], 'danger');
        }
        return $dbResponse;
    }
}
?>