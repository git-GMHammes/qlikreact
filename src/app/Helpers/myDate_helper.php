<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// CodeIgniter My Date validation Helpers

if (!function_exists('myDateDay')) {
    /**
     * Calcula numero de dias de uma data
     */
    function myDateDay($date_start = NULL, $date_end = NULL)
    {
        if ($date_start !== NULL && $date_end !== NULL) {
            if (strtotime($date_end) > strtotime($date_start)) {
                $diferenca = strtotime($date_end) - strtotime($date_start);
                $days = floor($diferenca / (60 * 60 * 24));
                return ($days);
            }
        }
        return 0;
    }
}
/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// CodeIgniter Show Data System

if (!function_exists('myDateSystem')) {
    /**
     * Calcula numero de dias de uma data
     */
    function myDateSystem($nameSistem)
    {
        echo "{$nameSistem}, ";
        $date = new DateTime();
        $formatter = new IntlDateFormatter(
            'pt_BR',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'America/Sao_Paulo',
            IntlDateFormatter::GREGORIAN
        );
        echo $formatter->format($date);
        return NULL;
    }
}

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// Data em formato brasileiro

if (!function_exists('myDateFormatPTBR')) {
    /**
     * Calcula numero de dias de uma data
     */
    function myDateFormatPTBR($parameter, $choice)
    {
        $data_brasileira = date("d-m-Y");
        // Formatar a data por extenso
        $dt_choice = new DateTime($parameter);
        if ($choice == 1) {
            $data_brasileira = $dt_choice->format('d-m-Y'); // Formato Brasileiro
        } elseif ($choice == 2) {
            $data_brasileira = $dt_choice->format('d \d\e F \d\e Y'); // Exemplo: 17 de novembro de 2023
        } elseif ($choice == 3) {
            $data_brasileira = $dt_choice->format('d \d\e M Y'); // Exemplo: 17 de Nov 2023
        } elseif ($choice == 4) {
            $data_brasileira = $dt_choice->format('d \d\e M Y') . ' ' . $dt_choice->format('H:i'); // Formato 24 horas
        } elseif ($choice == 5) {
            $data_brasileira = $dt_choice->format('d \d\e M Y') . ' ' . $dt_choice->format('h:i A'); // Formato 12 horas com AM/PM
        }
        return $data_brasileira;
    }
}

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// CodeIgniter Show Data System

if (!function_exists('myDateRemoveTime')) {
    /**
     * Calcula numero de dias de uma data
     */
    function myDateRemoveTime($dateTime)
    {
        // $dateTime = "2023-04-01 15:30:00";
        $data = date("Y-m-d", strtotime($dateTime));
        return $data; // Isso imprimirá "2023-04-01"
    }

}
/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// CodeIgniter Show Data System

if (!function_exists('myConverteTimeStump')) {
    /**
     * Calcula numero de dias de uma data
     */
    function myConverteTimeStump($data_original)
    {
        // Converter a data para um timestamp
        $timestamp = strtotime($data_original);

        // Formatar a data no formato "dd/mm/yyyy"
        return date('d/m/Y', $timestamp);
    }

}
/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// CodeIgniter Show Data System

if (!function_exists('normatizaData')) {
    /**
     * Calcula numero de dias de uma data
     */
    function normatizaData($dateTime)
    {
        if ($dateTime === '30/11/-0001') {
            return null;
        } elseif ($dateTime === '0000-00-00') {
            return null;
        } elseif ($dateTime === '0000-00-00 00:00:00') {
            return null;
        } else {
            return $dateTime;
        }
    }

}