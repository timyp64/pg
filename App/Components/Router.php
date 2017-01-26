<?php
/** Date: 01.01.2017  */

namespace App\Components;

class Router {

    private $routes;

    public function __construct() {
        $routesPath = ROOT . '/Config/Routes.php';
        $this->routes = include($routesPath);
    }

    /**
     * Главный метод класса роут. Ищет соответствие введеного URI в петернах регулярок в массиве
     * роутов. В случае нахождения создает заданный класс и вызывает заданый метод. В случае
     * наличия в URI параметров передает их в метод созданного класса. В случае неудачи перенаправляет
     * на 404 страницу
     */
    public function run() {
        $uri = $this->getURI();                                                                         // получаем введеную пользователяем URI
        $findcontroller = false;                                                                        // флаг результата создания класса, вызова метода
        foreach ($this->routes as $uriPattern => $path) {                                               // начинаем перебирать массив роутов
            if (preg_match_all("~^$uriPattern$~", $uri, $m)) {                                          // если в строке $uri есть точное соответствие с паттерном $uriPattern, тогда в $m передаем все маски (массив)
                array_shift($m);                                                                        // удаляем из массива $m первый эллемент т.к. в нем не нужная строка
                $param = array();                                                                       // будущий массив с параметрами передаваемыми в будущий метод созданного классаfor ($i = 0; $i < count($m); $i++) $param[$i] = $m[$i][0];
                $segments = explode('/', $path);                                                        // разбиваем строку с класс/метод и заносим в массив $segments название контроллера и названия экшена
                $controllerName = 'App\Controller\\' . ucfirst(array_shift($segments) . 'Controller');  // получаем название контроллера, удаляем первый элемент массива $segments за ненадобностью, добавляем нэймспэйс иначе без него не работает, добавляем строку Controller чтобы без проблем вызвать класс и делаем с большой буквы имя класса
                $actionName = 'action' . ucfirst(array_shift($segments));                               // получаем первый элемент массива с именем метода, делаем его с большой буквы и добавляем строку action
                $controllerObject = new $controllerName;                                                // создаем класс с известным именем и известным namespace
                $result = call_user_func_array([$controllerObject, $actionName], $param);               // вызываем пользовательскую функцию и передаем её массив параметров ранее полученных, если нет, тогда туда ничего не передается и все работает
                if ($result != null) {                                                                  // если есть результат
                    $findcontroller = true;                                                             // изменяем флаг
                    break;                                                                              // выходим из цикла
                }
            }
        }
        if ($findcontroller === false) echo "Страница 404";                                              // если флаг не изменился, значит класс не создался отправляем на 404 страницуу
    }

    /**
     * Получаем адресную строку и обрезаем слеш
     * @return string
     */
    private function getURI() {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], "/");
        }
    }

    private function preRout() {
        return true;
    }



}



