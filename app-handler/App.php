<?php

/**
 * Created by Maatify.dev
 * User: Maatify.dev
 * Date: 2022-12-12
 * Time: 1:36 AM
 */

namespace Maatify\App;

use Maatify\Json\Json;
use Maatify\Logger\Logger;
use Maatify\Model\DB;

class App
{
    private static DB $db;
    private Config $config;

    public function __construct()
    {
        if(empty(static::$db)){
            try {
                //            static::$db = new DB();
                $this->config = new Config($_ENV);

                static::$db = new DB($this->config->db ?? []);

            }
            catch (\PDOException $e){
                //            throw new \PDOException($e->getMessage(), (int)$e->getCode());
                Logger::RecordLog([$e->getMessage(), (int)$e->getCode()], 'app_connections');
                Json::DbError(__LINE__);
            }
        }

    }

    public static function db(): DB
    {
        return static::$db;
    }


}