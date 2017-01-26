<?php
/** Date: 15.01.2017 */

namespace App\Core\Model;

use App\Core\Model\ConnectDBs\ConnectPDOmysql;

abstract class DBMySQLModelAbst {

    public $db;

    public function __construct() {
    ConnectPDOmysql::getObjectPDOmysql();
    $this->db = ConnectPDOmysql::getObjectPDOmysql();
    }

}