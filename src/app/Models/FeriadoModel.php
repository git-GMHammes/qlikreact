<?php
namespace App\Models;

use CodeIgniter\Database\Query;
use CodeIgniter\Model;

// use system\Database\Exceptions\DatabaseException;

class FeriadoModel extends Model
{

    protected $DBGroup = GRUPO_DB_CONFIG;

    protected $table = 'feriado';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [];
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $dbInsert;
    protected $dbReplace;
    protected $dbRead;
    protected $message;
    protected $affectedRows;

    public function getColumnsFromTable($table_name, $parameter1 = 'column', $parameter2 = 'value_type', $parameter3 = 'value_key')
    {
        $getTable = array();
        # input: getColumnsFromTable('tab_link', 'column', 'type', 'key')
        if ($parameter1 == 'column' && $parameter2 == 'value_type' && $parameter3 == 'value_key') {
            $query = $this->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name';");
            foreach ($query->getResultArray() as $key => $value_columns) {
                $getTable['COLUMN'][] = $value_columns['COLUMN_NAME'];
            }
        } elseif ($parameter1 == 'column' && $parameter2 == 'type' && $parameter3 == 'value_key') {
            $query = $this->query("SELECT COLUMN_NAME, DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name';");
            foreach ($query->getResultArray() as $key => $value_columns) {
                $getTable['COLUMN'][] = $value_columns['COLUMN_NAME'] . ', ' . $value_columns['DATA_TYPE'];
            }
        } elseif ($parameter1 == 'column' && $parameter2 == 'type' && $parameter3 == 'key') {
            $query = $this->query("SELECT COLUMN_NAME, DATA_TYPE, COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$table_name';");
            foreach ($query->getResultArray() as $key => $value_columns) {
                $getTable['COLUMN'][] = $value_columns['COLUMN_NAME'] . ', ' . $value_columns['DATA_TYPE'] . ', ' . $value_columns['COLUMN_KEY'];
            }
        }
        return $getTable;
    }

    public function dbCreate($dbCreate)
    {
        try {
            $this->allowedFields = array_keys($dbCreate);
            $this->dbInsert = $this->insert($dbCreate);
            $this->affectedRows = $this->db->affectedRows();
            // myPrint($this->allowedFields, true);
            // myPrint($dbCreate, true);
            // myPrint($this->dbInsert);
        } catch (\Throwable $th) {
            if (DEBUG_MY_PRINT) {
                myPrint($th->getMessage(), 'src/app/Models/AcessoRapidoModel.php');
            }
            $this->message['message']['danger'] = array(
                $th->getMessage(),
            );
            session()->set('message', $this->message);
            session()->markAsTempdata('message', 5);
            myPrint($this->getMessage(), 'src/app/Models/');
        }
        return $this;
    }

    public function dbRead($keyVariable = NULL, $keyValue = NULL)
    {
        $getColumnsFromTable = array();
        // $getColumnsFromTable = $this->getColumnsFromTable($this->table)['COLUMN'];
        $this->allowedFields = $getColumnsFromTable;
        // myPrint($getColumnsFromTable, 'src/app/Models/ComCategoriaModel.php');
        #
        try {
            if ($keyVariable !== NULL && $keyValue !== NULL) {
                $this->dbRead = $this->where($keyVariable, $keyValue);
            } elseif ($keyVariable !== NULL && $keyValue == NULL) {
                $this->dbRead = $this->select($this->allowedFields);
            } else {
                $this->dbRead = $this->select($this->allowedFields);
                $this->affectedRows = $this->db->affectedRows();
            }
        } catch (\Throwable $th) {
            $this->message['message']['danger'] = array(
                $th->getMessage(),
            );
            session()->set('message', $this->message);
            session()->markAsTempdata('message', 5);
            myPrint($this->getMessage(), 'src/app/Models/');
        }
        return $this;
    }

    public function dbUpdate($key, $dbUpdate)
    {
        try {
            if (isset($key) && isset($dbUpdate)) {
                $this->allowedFields = array_keys($dbUpdate);
                // myPrint($this->allowedFields, true);
                $this->update($key, $dbUpdate);
                // myPrint($dbUpdate, true);
            }
            $this->affectedRows = $this->db->affectedRows();
            if ($this->affectedRows > 0) {
                $this->message['success'] = 'Atualização reaizada com sucesso.';
            } else {
                $this->message['warning'] = 'Não foi possível realizar a atulização';
            }
        } catch (\Throwable $th) {
            $this->message['message']['danger'] = array(
                $th->getMessage(),
            );
            session()->set('message', $this->message);
            session()->markAsTempdata('message', 5);
            myPrint($this->getMessage(), 'src/app/Models/');
        }
        return $this;
    }

    public function dBdelete()
    {
        try {
            $this->delete();
        } catch (\Throwable $th) {
            $this->message['message']['danger'] = array(
                $th->getMessage(),
            );
            session()->set('message', $this->message);
            session()->markAsTempdata('message', 5);
            myPrint($this->getMessage(), 'src/app/Models/');
        }
        return $this;
    }
}
?>