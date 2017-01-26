<?php
/** Date: 07.01.2017*/

namespace Test;

class Url {

    public function paseUrl() {
        return parse_url($_SERVER['REQUEST_URI']);
    }


    public static function test() {
        return self::paseUrl();
    }
}


/**
 * Создаем логичу чпу ссылок
 */