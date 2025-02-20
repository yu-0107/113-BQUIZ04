<?php
date_default_timezone_set('Asia/Taipei');
session_start();

class DB
{
    protected $dsn = "mysql:host=localhost;charset=utf8;dbname=db18";
    protected $pdo;
    protected $table;

    public function __construct($table)
    {
        $this->table = $table;
        $this->pdo   = new PDO($this->dsn, 'root', '');
    }

    public function all(...$arg)
    {
        $sql = "select * from $this->table ";
        if (! empty($arg[0]) && is_array($arg[0])) {
            $tmp = $this->arrayToSQL($arg[0]);
            $sql .= " where " . join(" && ", $tmp);
        } else if (isset($arg[0]) && is_string($arg[0])) {
            $sql .= $arg[0];
        }

        if (! empty($arg[1])) {
            $sql .= $arg[1];
        }
        return $this->fetch_all($sql);
    }

    public function find($array)
    {
        $sql = "select * from $this->table ";
        if (is_array($array)) {
            $tmp = $this->arrayToSQL($array);
            $sql .= " where " . join(" && ", $tmp);
        } else {
            $sql .= " where `id`='$array'";
        }

        return $this->fetch_one($sql);
    }
    public function save($array)
    {
        if (isset($array['id'])) {
            //update
            $id = $array['id'];
            unset($array['id']);
            $tmp = $this->arrayToSQL($array);
            $sql = "update $this->table set " . join(",", $tmp) . " where `id`='$id'";

        } else {
            //insert
            $keys   = join("`,`", array_keys($array));
            $values = join("','", $array);
            $sql    = "insert into $this->table (`{$keys}`) values('{$values}')";
        }

        return $this->pdo->exec($sql);

    }
    public function del($array)
    {
        $sql = "delete  from $this->table ";
        if (is_array($array)) {
            $tmp = $this->arrayToSQL($array);
            $sql .= " where " . join(" && ", $tmp);
        } else {
            $sql .= " where `id`='$array'";
        }

        return $this->pdo->exec($sql);
    }
    public function count(...$arg)
    {
        $sql = "select count(*) from $this->table ";
        if (! empty($arg[0]) && is_array($arg[0])) {
            $tmp = $this->arrayToSQL($arg[0]);
            $sql .= " where " . join(" && ", $tmp);
        } else if (isset($arg[0]) && is_string($arg[0])) {
            $sql .= $arg[0];
        }

        if (! empty($arg[1])) {
            $sql .= $arg[1];
        }
        //echo $sql;
        return $this->pdo->query($sql)->fetchColumn();
    }

    public function arrayToSQL($array)
    {
        $tmp = [];
        foreach ($array as $key => $value) {
            $tmp[] = "`$key`='$value'";
        }

        return $tmp;

    }
    public function fetch_one($sql)
    {
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    public function fetch_all($sql)
    {
        return $this->pdo->query($sql)->fetchALL(PDO::FETCH_ASSOC);
    }

}

function to($url)
{
    header("location:" . $url);
}

function q($sql)
{
    $dsn = "mysql:host=localhost;charset=utf8;dbname=db18";
    $pdo = new PDO($dsn, 'root', '');
    return $pdo->query($sql)->fetchALL();
}
function dd($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

$Mem   = new DB("members");
$Admin = new DB("admins");
$Bot   = new DB("bottom");
$Type  = new DB("types");
$Item  = new DB("items");
$Order = new DB("orders");
