<?php


namespace app\controllers;


use crm\core\App;
use crm\core\base\Controller;
use crm\core\Db;

class AppController extends Controller
{
    public function __construct($route)
    {
        parent::__construct($route);
        Db::instance();
    }
}