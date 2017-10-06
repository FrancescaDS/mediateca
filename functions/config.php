<?php

/*    define('MYSQL_HOSTNAME','localhost');
    define('MYSQL_USER','root');
    define('MYSQL_PASSWORD','');
    define('MYSQL_DATABASE','mediateca');
*/
    
/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

define('MEDIA_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
//require_once(ABSPATH . 'settings.php');





namespace TodoList\Config;

use \Exception;

/**
 * Application configuration.
 */
final class Config {

    /** @var array config data */
    private static $DATA = null;


    /**
     * @return array
     * @throws Exception
     */
    public static function getConfig($section = null) {
        if ($section === null) {
            return self::getData();
        }
        $data = self::getData();
        if (!array_key_exists($section, $data)) {
            throw new Exception('Unknown config section: ' . $section);
        }
        return $data[$section];
    }

    /**
     * @return array
     */
    private static function getData() {
        if (self::$DATA !== null) {
            return self::$DATA;
        }
        self::$DATA = parse_ini_file(__DIR__ . '/config.ini', true);
        return self::$DATA;
    }

}
