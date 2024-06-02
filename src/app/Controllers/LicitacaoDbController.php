<?php
namespace App\Controllers;

use App\Models\LicitacaoModel;
use App\Models\LicitacaoEtapaModel;
use App\Controllers\SystemMessageController;
use Exception;

class LicitacaoDbController extends BaseController
{
    private $ModelLicitacao;
    private $ModelLicitacaoEtapa;
    private $dbFields;
    private $message;
    private $uri;

    public function __construct()
    {
        $this->ModelLicitacao = new LicitacaoModel();
        $this->ModelLicitacaoEtapa = new LicitacaoEtapaModel();
        $this->message = new SystemMessageController();
        $this->uri = new \CodeIgniter\HTTP\URI(current_url());
    }
    #
    public function index($parameter = NULL)
    {
        exit('403 Forbidden - Directory access is forbidden.');
    }

    # use App\Controllers\LicitacaoDbController;
    # private $LicitacaoDb;
    # $this->LicitacaoDb = new LicitacaoDbController();
    # $this->LicitacaoDb->selectBase();
    public function selectBase($parameter1 = NULL, $parameter2 = 1000)
    {
        #
        try {
            if ($parameter1 !== NULL) {
                $dbResponse = $this->ModelLicitacao
                    ->where('pk_bidding', $parameter1)
                    ->where('deleted_at', NULL)
                    ->orderBy('priority', 'asc')
                    ->limit(1)
                    ->dBread()
                    ->find();
            } else {
                $dbResponse = $this->ModelLicitacao
                    ->where('deleted_at', NULL)
                    ->orderBy('priority', 'asc')
                    ->limit($parameter2)
                    ->dBread()
                    ->find();
            }
        } catch (Exception $e) {
            $dbResponse = array();
            
            $this->message->message(['ERRO: ' . $e->getMessage()], 'danger');
        }
        return $dbResponse;
    }
}
?>