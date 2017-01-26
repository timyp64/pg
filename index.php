<?php

ini_set('display_errors', 1);   // ОТОБРАЖЕНИЕ ОШИБОК ВКЛЮЧЕНО!!!
error_reporting(E_ALL);         // ОТОБРАЖЕНИЕ ОШИБОК ВКЛЮЧЕНО!!!

define('ROOT', dirname(__FILE__));   // путь к папке с сайтом
define('DS', DIRECTORY_SEPARATOR);   // путь к папке с сайтом

require_once('App' . DS . 'Core' . DS . 'Autoload.php');
require_once('Crone/ClearPreAccessLogs.php');

use App\Components\ExceptionHandler\MainException;
use App\Components\Router;
use App\Model\Firstlinedefensemod;
use Vendor\Debugging\RunTime;

// логируем частоту посещения сайта
if (isset($_GET['clear'])) clearpreaccesslog(); // очистка логов IP. Выполняет Крон
Firstlinedefensemod::Firstlinedefense();// метод вызывающий первую линию обороны защищающей от массового конекта.

$router = new Router();
$router->run();














