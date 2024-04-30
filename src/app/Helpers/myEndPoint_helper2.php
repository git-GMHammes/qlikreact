<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// CodeIgniter Consumo de APIs

if (!function_exists('myEndPoint')) {
    function myEndPoint($uri = NULL, $token='123')
    {
        $requestJSONform = [];
        $result = array();
        try {
            // myPrint($uri, '');
            $cpf_consulta = strpos($uri, 'cpf-consulta');
            if ($cpf_consulta === false) {
                $result[] = 'false';
            } else {
                $result[] = 'true';
            }
            if (in_array('false', $result)) {
                if ($_SERVER["SERVER_PORT"] !== 80) {
                    # Garante que o endereço da API sempre seja com porta 80.
                    $base = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/';
                } else {
                    $base = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER["SERVER_PORT"] . '/';
                }
                $uri = $base . $uri;
                // $uri = 'http://makeup-api.herokuapp.com/api/v1/products.json?brand=maybelline';
            }
            myPrint($uri, '', true);
            
            // Verificar se a URI é válida
            if (!filter_var($uri, FILTER_VALIDATE_URL)) {
                throw new \Exception('A URI fornecida é inválida.');
            }
            // myPrint($uri, 'src\app\Helpers\myEndPoint_helper.php');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $uri);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Desabilita a verificação SSL, mas isso é inseguro em produção

            // Inserir o cabeçalho de autorização
            if ($token) {
                $headers = ['Authorization: Bearer ' . $token];
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            }

            $result = curl_exec($ch);
            if ($result === false) {
                throw new \Exception('Curl error: ' . curl_error($ch));
            } else {
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($httpCode == 404) {
                    throw new \Exception("Error 404: $uri não encontrado.");
                } else {
                    $requestJSONform = json_decode($result, true); // Converte em array
                }
            }
            curl_close($ch);
        } catch (\Exception $e) {
            return ["error" => $e->getMessage()];
        }

        return $requestJSONform;
    }
}

// CodeIgniter Libera Sistema

if (!function_exists('releaseAccess')) {
    function releaseAccess($token = FALSE, $getSession = FALSE)
    {
        if ($token == TRUE && $getSession == TRUE) {
            $releaseAccess = TRUE;
        } else {
            $releaseAccess = FALSE;
        }
        return $releaseAccess;
    }
}
