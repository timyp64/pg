<?php
/** 02.01.2017 */

use App\Core\ConfigLoad;

/** Функция очищает файл лога. Зупускается кроном
 * @return bool
 */
function clearpreaccesslog() {
    if ((string)$_GET['clear'] === ConfigLoad::RMainIni('getclearpreaccesslogs')) {
        file_put_contents("App" . DIRECTORY_SEPARATOR . "Model" . DIRECTORY_SEPARATOR . "PreAccessLogs" . DIRECTORY_SEPARATOR . "IPAccessLogs.txt", '');  // очищаем фал лога IP
        file_put_contents("App" . DIRECTORY_SEPARATOR . "Model" . DIRECTORY_SEPARATOR . "PreAccessLogs" . DIRECTORY_SEPARATOR . "CookAccessLogs.txt", '');  // очищаем фал лога Кук
    } else return false;
}