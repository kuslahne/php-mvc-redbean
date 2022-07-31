<?php


namespace app\core;

use RedBeanPHP\Facade as R;

class Database
{
    public \PDO $pdo;

    public function __construct()
    {
	R::setup( 'sqlite:../db_app.db' );
	R::freeze(false);
    }    
}

