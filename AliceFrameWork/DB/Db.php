<?php namespace AliceFrameWork\DB;
/*
 * 数据库扩展脚本
 * @leunico
 */

class Db
{
    public static function factor()
    {
        $dbType = strtolower(DB_TYPE);
        switch ($dbType) {
            case 'mysql':
                $className = 'Mysql';
                break;
            default:
                die('Error: Database Type');
        }
        $className = 'AliceFrameWork\\DB\\' . $className;
        return new $className();
    }
}
