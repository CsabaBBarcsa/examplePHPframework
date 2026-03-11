<?php

namespace Examp\Core;

defined('ISRUN') OR exit('Direct access to the script not allowed!');

use PDO;

class Database extends PDO
{    
    private $_dbType;
    private $_dbHost;
    private $_dbName;
    private $_dbUser;
    private $_dbPass;

    public function __construct( Containers\ConfigContainer $config)
    {
        $this->_dbType = $config->get('dbDriver');
        $this->_dbHost = $config->get('dbHost');
        $this->_dbName = $config->get('dbName');
        $this->_dbUser = $config->get('dbUser');
        $this->_dbPass = $config->get('dbPass');
        
        $this->_setConnection();
    }
    
    private function _setConnection()
    {
        try
        {
            parent::__construct(
                $this->_dbType.':host='.$this->_dbHost.';dbname='.$this->_dbName,
                $this->_dbUser,
                $this->_dbPass,
                [
                    PDO::ATTR_ERRMODE => self::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_FOUND_ROWS => true,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                ]);
        }
        catch ( \PDOException $e )
        {
            print_r('ErrorPdo:'.$e->getMessage());
        }
    }

}