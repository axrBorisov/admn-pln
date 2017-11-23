<?php

class Db
{
    private $connect;
    protected static $_instance;

    public static function getInstance(): \Db
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
     * Db constructor.
     */
    private function __construct()
    {
        try {
            $config = new Config();
            $dsn = "mysql:host={$config->ip_host};dbname={$config->name_db};charset={$config->charset_db}";
            $this->connect = new PDO($dsn, $config->user_db, $config->password, [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ]);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    private function __clone()
    {

        self::$_instance;
    }

    public function __wakeup()
    {
        self::$_instance;
    }

    public static function query($sql, array $values = null)
    {
        /** @var Db $obj */
        $obj = self::$_instance;
        if (isset($obj->connect)) {
            $result = $obj->connect->prepare($sql);
            $result->execute($values);
            return $result;
        }
        return false;
    }

    /**
     * @param $sql
     * @param null $switch
     * @param array|null $values
     * @return mixed
     */
    public static function select($sql, $switch = null, array $values = null)
    {
        if ($values !== null) {
            $res = self::getInstance()->query($sql, $values);
        } else {
            $res = self::getInstance()->query($sql);
        }
        if ($switch === 'object') {
            return self::getInstance()->fetch_object($res);
        }
        return self::getInstance()->fetch_array($res);
    }

    /**
     * @param $sql
     * @return bool
     */
    public static function freeSql($sql): bool
    {
        return self::getInstance()->query($sql);
    }

    /**
     * @param $switch
     * @param $table
     * @param array $fields
     * @param array $source
     * @param null $where
     * @return bool
     */
    public static function insert($switch, $table, array $fields, array $source = [], $where = null): bool
    {
        $set = '';
        $values = [];
        foreach ($fields as $field) {
            if (isset($source[$field])) {
                $set .= '`' . str_replace('`', '``', $field) . '`' . "=:$field, ";
                $values[$field] = $source[$field];
            }
        }
        switch ($switch) {
            case 'INSERT':
                $sql = "INSERT INTO $table SET " . substr($set, 0, -2);
                break;
            case 'UPDATE':
                $sql = "UPDATE $table SET " . substr($set, 0, -2) . " WHERE $where";
                break;
        }
        self::getInstance()->query($sql, $values);
        return true;
    }

    public static function delete($table, $var = null, $field, $where = null)
    {

        if ($where !== null) {
            $sql = "DELETE FROM `$table` WHERE $where";
        } else {
            $sql = "DELETE FROM `$table` WHERE $field = :id";
        }

        $values['id'] = GuardModel::cleanQuery($var);
        return self::getInstance()->query($sql, $values);
    }

    public static function fetch_object($object)
    {
        return $object->fetch(PDO::FETCH_OBJ);
    }

    public static function fetch_array($object)
    {
        return $object->fetchAll(PDO::FETCH_ASSOC);
    }

    public function lastInsertId(): int
    {
        return $this->connect->lastInsertId();
    }
}