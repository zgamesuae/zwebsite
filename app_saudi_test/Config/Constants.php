<?php
// Telr API INFO
defined('STOREID') || define('STOREID', '27872');
defined('AUTHKEY') || define('AUTHKEY', 'MgJr@KztnF-zcXxs');
defined('AUTHKEYREMOTE') || define('AUTHKEYREMOTE', 'nHGgq~n2QJL@P742');
defined('PGTEST') || define('PGTEST', '0');
// defined('PGTEST') || define('PGTEST', '1');

defined('CURRENCY') || define('CURRENCY', 'SAR');
defined('PHONE_CODE') || define('PHONE_CODE', '+966');
defined('TIME_ZONE') || define('TIME_ZONE', 'Asia/Riyadh');

// Tabby API INFO
/**------Live------- */
defined('TABBY_SECRET_KEY') || define('TABBY_SECRET_KEY', "sk_f5b5b0c4-eec9-4607-a284-56b3494607eb");
defined('TABBY_PUBLIC_KEY') || define('TABBY_PUBLIC_KEY', "pk_6c358e4f-fb51-4e6f-95db-7adb6702efcd");
/**------Live------- */

/**------Test------- */
// defined('TABBY_SECRET_KEY') || define('TABBY_SECRET_KEY', "sk_test_88d02523-25ef-49b3-8420-6f0b2ffc0c4b");
// defined('TABBY_PUBLIC_KEY') || define('TABBY_PUBLIC_KEY', "pk_test_2e120219-d410-428d-8052-13304e5990d1");
/**------Test------- */
defined('TABBY_MERCHANT_CODE') || define('TABBY_MERCHANT_CODE', 'ZGKSA');

// PayTab API INFO 

/**
 * Test Keys
 */
// defined('PAYTAB_PROFILE_ID') || define('PAYTAB_PROFILE_ID', '105195');
// defined('PAYTAB_SERVER_KEY') || define('PAYTAB_SERVER_KEY', 'S9JN6WHMLJ-JHMNNGTWRG-6K6Z9WK6GH');
// defined('PAYTAB_CLIENT_KEY') || define('PAYTAB_CLIENT_KEY', 'C2KMVK-VPB76H-NQQT7V-BP9RT2');

/**
 * LIVE KEYS
 */
defined('PAYTAB_PROFILE_ID') || define('PAYTAB_PROFILE_ID', '107052');
defined('PAYTAB_SERVER_KEY') || define('PAYTAB_SERVER_KEY', 'S6JN6WHLMK-JHL2MLBJKM-JMRTH6MLGW');
defined('PAYTAB_CLIENT_KEY') || define('PAYTAB_CLIENT_KEY', 'CMKMVK-VQGH6H-BMNB26-RM9MQK');


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
defined('MONTH')  || define('MONTH', 2592000);
defined('YEAR')   || define('YEAR', 31536000);
defined('DECADE') || define('DECADE', 315360000);

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
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code














