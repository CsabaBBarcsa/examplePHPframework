<?php
use Examp\Core\Containers\ConfigContainer;

$config = new ConfigContainer();

/* Some basic config. That will return at usage. It is supplementable. */

$config->add('basePath', BASEPATH);

$config->add('dbDriver', 'mysql');
$config->add('dbHost', 'localhost');
$config->add('dbName', ''); // exmaple_db
$config->add('dbUser', ''); // example_user
$config->add('dbPass', ''); // example_password

return $config;