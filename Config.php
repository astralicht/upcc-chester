<?php
namespace Main;

// Set error_reporting to 0 in the line below to enable showing of PHP errors.
// It is adviseable to disable error reporting on production version to prevent security leaks.
error_reporting(1);
/** */

date_default_timezone_set("Asia/Manila");

/**
 * Contains configurations for the system.
 */
class Config {

    private static $URI_OFFSET;
    private static array $db_config;

    function __construct($override = null) {
        // Environment options are either OFFSET-1 or OFFSET-2 in all caps.
        // OFFSET-1 offsets (removes a part of) the URI by 1 from the left.
        // OFFSET-2 offsets (removes a part of) the URI by 2 from the left.
        self::$URI_OFFSET = 'OFFSET-2';

        // Up to the user to implement database connection.
        // MySQLi connections are compatible.
        self::$db_config = [
            'host' => 'localhost',
            'username' => 'root',
            'password' => '',
            'db_name' => 'upcc',
        ];

        if ($override !== null) {
            self::$db_config = $override;
        }

        // self::$db_config = [
        //     'host' => 'localhost',
        //     'username' => 'eneiopzv_upcc_admin',
        //     'password' => 'upcc2022A!',
        //     'db_name' => 'eneiopzv_upcc',
        // ];
    }

    /**
     * Returns a new mysqli object using data from config.
     * Can be replaced with another kind of database connection.
     */
    public function openDbConnection(): \mysqli {
        return new \mysqli(self::$db_config['host'], self::$db_config['username'], self::$db_config['password'], self::$db_config['db_name']);
    }

    /**
     * Returns URI offset.
     */
    public function getURIOffset() {
        return self::$URI_OFFSET;
    }

}