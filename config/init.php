<?php

const DEBUG = 1;
define("ROOT", dirname(__DIR__));
const WEB = ROOT . '/public';
const APP = ROOT . '/app';
const CORE = ROOT . '/vendor/crm/core';
const LIBS = ROOT . '/vendor/crm/core/libs';
const CACHE = ROOT . '/cash';
const CONF = ROOT . '/config';
const LAYOUT = 'default';
define("PATH", $_SERVER['HTTP_HOST']);

require_once ROOT . '/vendor/autoload.php';