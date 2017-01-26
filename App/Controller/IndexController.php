<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12.01.2017
 * Time: 18:34
 */

namespace App\Controller;

use App\Core\Model\ConnectDBs\ConnectPDOmysql;


class IndexController {

    public function actionHelp() {
        return true;
    }

    public function actionIndex() {
        echo "Main page";
        return true;
    }

}