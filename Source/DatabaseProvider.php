<?php
namespace JSomerstone\JSFramework;

/**
 * Abstract class for getting mysqli-instances
 */
abstract class DatabaseProvider
{
    private static $databaseInstance;

    public static function init($userName, $password, $database, $host = 'localhost')
    {
        self::$databaseInstance = new \mysqli(
            $host, $userName, $password, $database
        );

        if (self::$databaseInstance->connect_errno)
        {
            throw new Exception\DatabaseException(
                printf("Connect failed: %s\n", self::$databaseInstance->connect_errno
            ));
        }
        return self::getInstanse();
    }

    /**
     * Get a MySQLi instance, to change login name / username, call Core_DatabaseProvider::init()
     * @return \mysqli
     */
    public static function getInstanse()
    {
        if (!self::$databaseInstance)
        {
            throw new Exception\DatabaseException(
                'DatabaseProvider is not initialzed, call \JSFramework\DatabaseProvider::init()'
            );
        }
        return self::$databaseInstance;
    }
}
