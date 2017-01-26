<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12.01.2017
 * Time: 18:34
 */

namespace App\Controller;


class AccountController {

    public function actionIndex() {
        echo "Страница пользователя";
        return true;
    }

    public function actionFin() {
        echo "Страница с финансами пользователя";
        return true;
    }

    public function actionUser($id=0) {
        echo "Страница с юзером id = ".$id;
        return true;
    }

}