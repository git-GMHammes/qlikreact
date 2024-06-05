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

    private function setSmile_made($pk, $start, $deadline, $end)
    {
        $start = normatizaData($start);
        $deadline = normatizaData($deadline);
        $end = normatizaData($end);
        if (
            $end == NULL
            && $start == NULL
            && $deadline == NULL
        ) {
            $dbUpdate = [
                'made' => NULL
            ];
            $this->ModelLicitacaoEtapa->dbUpdate($pk, $dbUpdate);
        } elseif (
            $end == $start
            && $start == $deadline
            && $deadline == $end
        ) {
            $dbUpdate = [
                'made' => 'Y'
            ];
            $this->ModelLicitacaoEtapa->dbUpdate($pk, $dbUpdate);
        } elseif (
            $end == NULL
            && $start !== NULL
            && $deadline == NULL
        ) {
            $dbUpdate = [
                'made' => 'Y'
            ];
            $this->ModelLicitacaoEtapa->dbUpdate($pk, $dbUpdate);
        } elseif (
            $end == NULL
            && $start !== NULL
            && $deadline !== NULL
            && $deadline < date('Y-m-d')
        ) {
            $dbUpdate = [
                'made' => 'N'
            ];
            $this->ModelLicitacaoEtapa->dbUpdate($pk, $dbUpdate);
        } elseif (
            $end == NULL
            && $start !== NULL
            && $deadline !== NULL
            && $start == $deadline
            && $deadline < date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d'))))
        ) {
            $dbUpdate = [
                'made' => 'Y'
            ];
            $this->ModelLicitacaoEtapa->dbUpdate($pk, $dbUpdate);
        } elseif (
            $end == NULL
            && $start !== NULL
            && $deadline !== NULL
            && $deadline > date('Y-m-d')
        ) {
            $dbUpdate = [
                'made' => 'Y'
            ];
            $this->ModelLicitacaoEtapa->dbUpdate($pk, $dbUpdate);
        } elseif (
            $end == NULL
            && $start !== NULL
            && $deadline !== NULL
            && $deadline > date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d'))))
        ) {
            $dbUpdate = [
                'made' => 'N'
            ];
            $this->ModelLicitacaoEtapa->dbUpdate($pk, $dbUpdate);
        } elseif (
            $end == NULL
            && $start !== NULL
            && $deadline !== NULL
            && $start == $deadline
            // && $deadline < date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d'))))
        ) {
            $dbUpdate = [
                'made' => 'Y'
            ];
            $this->ModelLicitacaoEtapa->dbUpdate($pk, $dbUpdate);
        } elseif (
            $end == NULL
            && $start !== NULL
            && $deadline !== NULL
            && $deadline < date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d'))))
        ) {
            $dbUpdate = [
                'made' => 'Y'
            ];
            $this->ModelLicitacaoEtapa->dbUpdate($pk, $dbUpdate);
        } elseif (
            $end == NULL
            && $start == NULL
            && $deadline !== NULL
            && $deadline < date('Y-m-d')
        ) {
            $dbUpdate = [
                'made' => 'N'
            ];
            $this->ModelLicitacaoEtapa->dbUpdate($pk, $dbUpdate);
        } elseif (
            $end == NULL
            && $start == NULL
            && $deadline !== NULL
            && $deadline > date('Y-m-d')
        ) {
            $dbUpdate = [
                'made' => 'Y'
            ]; #
            $this->ModelLicitacaoEtapa->dbUpdate($pk, $dbUpdate);
        } elseif (
            $end !== NULL
            && $start !== NULL
            && $deadline !== NULL
            && $deadline == $end
        ) {
            $dbUpdate = [
                'made' => 'Y'
            ];
            $this->ModelLicitacaoEtapa->dbUpdate($pk, $dbUpdate);
        } elseif (
            $end !== NULL
            && $start == NULL
            && $deadline !== NULL
            && $end == $deadline
        ) {
            $dbUpdate = [
                'made' => 'Y'
            ];
            $this->ModelLicitacaoEtapa->dbUpdate($pk, $dbUpdate);
        } elseif (
            $end !== NULL
            && $start == NULL
            && $deadline == NULL
            && $end < date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d'))))
        ) {
            $dbUpdate = [
                'made' => 'Y'
            ];
            $this->ModelLicitacaoEtapa->dbUpdate($pk, $dbUpdate);
        } elseif (
            $end !== NULL
            && $start !== NULL
            && $deadline == NULL
            // && $end < date('Y-m-d', strtotime('+1 day', strtotime(date('Y-m-d'))))
        ) {
            $dbUpdate = [
                'made' => 'Y'
            ];
            $this->ModelLicitacaoEtapa->dbUpdate($pk, $dbUpdate);
        } elseif (
            $end !== NULL
            && $start == NULL
            && $deadline !== NULL
            && $deadline > $end
        ) {
            $dbUpdate = [
                'made' => 'Y'
            ];
            $this->ModelLicitacaoEtapa->dbUpdate($pk, $dbUpdate);
        } elseif (
            $end !== NULL
            && $start == NULL
            && $deadline !== NULL
            && $deadline < $end
        ) {
            $dbUpdate = [
                'made' => 'N'
            ];
            $this->ModelLicitacaoEtapa->dbUpdate($pk, $dbUpdate);
        }
        return (NULL);
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
    
    # use App\Controllers\LicitacaoEtapaDbController;
    # private $EtapaDb;
    # $this->EtapaDb = new LicitacaoEtapaDbController();
    # $this->EtapaDb->curentBidding();
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
                #
                foreach ($dbResponse as $key_dbResponse => $value_dbResponse) {
                    // myPrint($value_dbResponse, '', true);
                    $pk = isset($value_dbResponse['ID']) ? ($value_dbResponse['ID']) : ('NULL');
                    $start = isset($value_dbResponse['date_start']) ? ($value_dbResponse['date_start']) : (NULL);
                    $deadline = isset($value_dbResponse['deadline']) ? ($value_dbResponse['deadline']) : (NULL);
                    $end = isset($value_dbResponse['date_end']) ? ($value_dbResponse['date_end']) : (NULL);
                    $this->setSmile_made($pk, $start, $deadline, $end);
                }
                $dbResponse = $this
                    ->ModelLicitacaoEtapa
                    ->where('pk_bidding', $parameter1)
                    ->where('deleted_at', NULL)
                    ->orderBy('orderc', 'asc')
                    ->limit($parameter3)
                    ->dBread()
                    ->findAll();
                #
                // exit('src\app\Controllers\LicitacaoEtapaDbController.php');
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