<?php
/** Date: 02.01.2017 */

namespace App\Model;

use App\Core\ConfigLoad;
use App\Helpers\Genrendsequence;

class Firstlinedefensemod {

    /** ГЛАВНЫЙ МЕТОД КЛАССА
     *  !!!!!!!!!!!!!!!!!!Метод не доделанный до конца, т.к. необходимо переход на страницу с ошибкой!!!!!!!!!!!!
     * @return bool
     */
    static public function Firstlinedefense() {
        if (isset($_COOKIE[ConfigLoad::RMainIni('preaccesscookingname')])) { //  проверяем наличия кукизаполучаем куку доступа
            $c = $_COOKIE[ConfigLoad::RMainIni('preaccesscookingname')];
            if (Genrendsequence::DecoderInt($c)) { // проверяем содержимое куки на нашем алгоритме
                if (self::HendlerCook($c)) { // записываем куку в файл лог
                    echo 'Сервер перегружен КУКА, попробуйте зайти через пару минут';
                    return false;   // если превышено количество заходов, возвращаем false
                }
                return true;
            }
        } else {
            // считаем ip делаем соответствующие записи
            if (self::HendlerIP($_SERVER['REMOTE_ADDR'])) {
                echo 'Сервер перегружен IP, попробуйте зайти через пару минут';
                return false;// если превышено количество заходов, возвращаем false, если все хорошо продолжаем
            }
            $name = ConfigLoad::RMainIni('preaccesscookingname');
            $val = Genrendsequence::CoderInt();
            $exp = time() + ConfigLoad::RMainIni('exptimecookiesaccesslogs');
            setcookie($name, $val, $exp, '', '', '', true);
        }
        return true;
    }

    /** ЗАПИСЬ СОДЕРЖИМОГО В ФАЙЛ
     * @param $file - путь к файлу в котором мы делаем изменения
     * @param $str - строка которую мы хотим добавить
     *  FILE_APPEND - дописывание содержимого в конец файла
     *  LOCK_EX предотвращение записи данного файла кем-нибудь другим в данное время
     */
    static public function WriteContFile($file, $str) {
        if (!file_exists($file)) fopen($file, "w");
        file_put_contents($file, $str . PHP_EOL, FILE_APPEND | LOCK_EX);
    }


    /**
     * Обрабатываем IP адрес посетителя. Проверяем он зашел меньше разрешенного количества раз или больше
     * @param $ip - ip адрес переданный для обработки
     * @return bool - превышен ли допустимое число заходов. False - не превышенно
     */
    public static function HendlerIP($ip) {
        $fileIP = __DIR__ . DIRECTORY_SEPARATOR . "PreAccessLogs" . DIRECTORY_SEPARATOR . "IPAccessLogs.txt"; // если необходимо создаем файл и открываем лог ip
        if (!file_exists($fileIP)) fopen($fileIP, 'w');
        $res = file_get_contents($fileIP);  // в этом файле будет хранится следующая информация: IP число (количество зоходов) символы переноса строки
        if (substr_count($res, $ip) < ConfigLoad::RMainIni('ipcount')) {
            self::WriteContFile($fileIP, $ip); // добавляем IP в файл
            return false;
        } else return true;
    }

    /** ОБРАБАТЫВАЕМ КУКУ посетителя. Проверяем он зашел меньше разрешенного количества раз или больше
     * @param $c - содержание куки
     * @return bool - ревышен ли допустимое число заходов. False - не превышенно
     */
    public static function HendlerCook($c) {
        $fileCook = __DIR__ . DIRECTORY_SEPARATOR . "PreAccessLogs" . DIRECTORY_SEPARATOR . "CookAccessLogs.txt"; // если необходимо создаем файл и открываем лог куки
        if (!file_exists($fileCook)) fopen($fileCook, 'w');
        $res = file_get_contents($fileCook);  // в этом файле будет хранится следующая информация: содержание куки
        if (substr_count($res, $c) < ConfigLoad::RMainIni('cookcount')) {
            self::WriteContFile($fileCook, $c); // добавляем куку в файл
            return false;
        } else return true;
    }


}