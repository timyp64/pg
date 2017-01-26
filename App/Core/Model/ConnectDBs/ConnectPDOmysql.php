<?php
/** Date: 15.01.2017 */

namespace App\Core\Model\ConnectDBs;

use App\Core\ConfigLoad;

/**
 * Class ConnectPDOmysql
 * @package App\Core\Model\ConnectDBs
 * Класс подключения к БД MySQL выполненный по шаблону одиночка
 */
class ConnectPDOmysql {
    /**
     * @var
     * Переменная контейнер объекта класса PDO
     */
    private static $object;

    private function __construct() {
    }

    /**
     * @return \PDO|object
     * Метод проверяющий наличие в статической переменной объекта класса PDO
     * В случае отсутствия создает объект класса PDO
     */
    public static function getObjectPDOmysql() {
        if (self::$object === null) {
            self::$object = ConnectPDOmysql::_connect();
            return self::$object;
        }
        return self::$object;
    }

    /**
     * @return \PDO
     * Метод который подключается к базе данных.
     */
    private static function _connect() {
        $host = ConfigLoad::RMainIni('MyHost');
        $DBname = ConfigLoad::RMainIni('MyName');
        $charset = ConfigLoad::RMainIni('MyCharset');
        $user = ConfigLoad::RMainIni('MyUser');
        $pass = ConfigLoad::RMainIni('MyPass');
        self::$object = new \PDO("mysql:host=$host;dbname=$DBname;charset=$charset", "$user", "$pass");
        return self::$object;
    }

    private function __clone() {
    }

    private function __wakeup() {
    }
}