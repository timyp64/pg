<?php
/** 02.01.2017 */
namespace App\Core;

class ConfigLoad{
    /**
     * Метод извлечения настроек приложения
     * @param $param - параметр который необходимо извлечь из настроек ini afqkf
     * @return mixed - возвращает строку которая пренадлежит $param
     */
    public static function RMainIni($param){
        $res = parse_ini_file('Config'.DIRECTORY_SEPARATOR.'Config.ini');
        return $res[$param];
    }
}
