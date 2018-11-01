<?php

/**
 * Class DBFactory
 */
class DBFactory
{

    const HOST = 'mysql:host=localhost;dbname=annahda';
    const USER = 'root';
    const PASSWORD = 'test';

    /**
     * @var
     */
    protected static $db;

    /**
     * DBFactory constructor.
     */
    private function __construct() {}

    /**
     *
     */
    private function __clone() {}

    /**
     * @return PDO
     */
    public function getMySqlConnection() {
        if(!isset(self::$db)) {
            try{
                self::$db = new PDO(DBFactory::HOST, DBFactory::USER, DBFactory::PASSWORD);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(Exception $e) {
                die(sprintf('Can`t connect to DB: %s', $e->getMessage()));
            }

        }
        return self::$db;
    }
}