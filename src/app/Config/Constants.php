<?php

/*
 | --------------------------------------------------------------------
 | App Namespace
 | --------------------------------------------------------------------
 |
 | This defines the default Namespace that is used throughout
 | CodeIgniter to refer to the Application directory. Change
 | this constant to change the namespace that all application
 | classes should use.
 |
 | NOTE: changing this will require manually modifying the
 | existing namespaces of App\* namespaced-classes.
 */
defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');
#
$varD1 = rota35('bXlzcWw4MA==');
$varD2 = rota35('cm9vdA==');
$varD3 = rota35('cm9vdHBhc3M=');
$varD4 = rota35('ZGI=');
$varD5 = rota35('TXlTUUxp');
$varD6 = rota35('MzMwNg==');
# "<br />".
$varH1 = rota35('MTAuMTEuNjMuMTM3');
$varH2 = rota35('UUxJS0FETUlO');
$varH3 = rota35('UWxpb2h2QDg2NQ==');
$varH4 = rota35('UUxJS0FETUlO');
$varH5 = rota35('TXlTUUxp');
$varH6 = rota35('MzMwNg==');
#
/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);

defined('ED9EE1E4CC5CD92C322E125509EC8320') or define('ED9EE1E4CC5CD92C322E125509EC8320', "{$varD1}");
defined('D0C54946F40F15EEEEF9966332EAAD1D') or define('D0C54946F40F15EEEEF9966332EAAD1D', "{$varD2}");
defined('C5F0D3F2D2DC4E7250341457D4AC72B4') or define('C5F0D3F2D2DC4E7250341457D4AC72B4', "{$varD3}");
defined('E0C2D38CBB08E7BA5F53B3480987776E') or define('E0C2D38CBB08E7BA5F53B3480987776E', "{$varD4}");
defined('E127BD6190ABB075312B371738FDE395') or define('E127BD6190ABB075312B371738FDE395', "{$varD5}");
defined('C510E1501A395D5EFD8C52EEE0658E9F') or define('C510E1501A395D5EFD8C52EEE0658E9F', $varD6);
#
defined('E1FCB69453DBFA454D712B6871150632') or define('E1FCB69453DBFA454D712B6871150632', "{$varH1}");
defined('FCB08FCEF3ED306A374491F84BCEDDD7') or define('FCB08FCEF3ED306A374491F84BCEDDD7', "{$varH2}");
defined('C397FED4A18313BEF4A52458D8657739') or define('C397FED4A18313BEF4A52458D8657739', "{$varH3}");
defined('D994F5B2C031D49B626DE169B4329658') or define('D994F5B2C031D49B626DE169B4329658', "{$varH4}");
defined('BF41BB7AF0CA86E72DD72AB88F9B7DDE') or define('BF41BB7AF0CA86E72DD72AB88F9B7DDE', "{$varH5}");
defined('AA4652BE126F5C4657F4B4EF1FCC7258') or define('AA4652BE126F5C4657F4B4EF1FCC7258', $varH6);
#
$variavel_banco = "dev_docker";
if ($_SERVER["SERVER_PORT"] == '80') {
    if (
        $_SERVER['SERVER_NAME'] == 'localhost' ||
        $_SERVER['SERVER_NAME'] == '10.11.62.138'
    ) {
        defined('GRUPO_DB_CONFIG') or define('GRUPO_DB_CONFIG', "{$variavel_banco}");
    }
} elseif (
    $_SERVER["SERVER_PORT"] == '443'
) {
    // SSL
} elseif (
    $_SERVER["SERVER_PORT"] == '5601'
) {
    if (
        $_SERVER['SERVER_NAME'] == 'localhost' ||
        $_SERVER['SERVER_NAME'] == '127.0.0.1' ||
        $_SERVER['SERVER_NAME'] == '10.146.84.140' ||
        $_SERVER['SERVER_NAME'] == '10.11.62.138'
    ) {
        defined('GRUPO_DB_CONFIG') or define('GRUPO_DB_CONFIG', "{$variavel_banco}");
    }
} else {
    exit('Linha 239: www\projeto\src\app\Config\Constants.php. Não foi possível encontrar o ambinete do sistema. -> ' . $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER["SERVER_PORT"]);
}

#
# Modo Debug MyPrint
# 
if (
    $_SERVER['SERVER_NAME'] == 'localhost'
    || $_SERVER['SERVER_NAME'] == '127.0.0.1'
    || $_SERVER['SERVER_NAME'] == '10.146.84.140'
) {
    # Ambiente DEV
    defined('DEBUG_MY_PRINT') or define('DEBUG_MY_PRINT', true);
} else {
    defined('DEBUG_MY_PRINT') or define('DEBUG_MY_PRINT', false);
}
#
function rota35($parameter)
{
    return base64_decode($parameter);
}
