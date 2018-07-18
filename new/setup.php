<?php
namespace setup;
use DateTime;
use PDO;
use PDOException;

$GLOBALS['config'] = array(
    'app' => array(
        'name' => 'PoolProbe',
        'version' => "1.0",
        'title' => "Poolprobe",
        'header' => "Admin",
        'copyright' => "valence solutions",
        'designer' => "CEO"
    ),
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => 'christo16',
        'db' => 'poolprobe'
    ),
    'session' => array(
        'session_admin' => 'admin',
        'token_name' => 'token'
    ),
    'cookie' => array(
        'cookie_name' => 'cook',
        'remember' => 'remember',
        'expiry_one_day' => 86400,
        'expiry_one_week' => 604800
    ),
);

class Config {
    public static function get($path = null ){
        if($path) {
            $config = $GLOBALS['config'];
            //creates an array to loop through
            $path = explode('/', $path);

            foreach ($path as $bit) {
                if(isset($config[$bit])) {
                    //sets congif to the current array to search it
                    $config = $config[$bit];
                }
            }

            return $config;
        }
        return false;
    }
}

class DB {
    private static $_instance = null;
    private $_pdo,
        $_query,
        $_error = false,
        $_results,
        $_count = 0;

    private function __construct() {
        //connect to the database
        try {
            $this->_pdo = new PDO('mysql:host='.config::get('mysql/host').';dbname='.config::get('mysql/db'),config::get('mysql/username'),config::get('mysql/password'));
            //$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance() {
        if(!isset(self::$_instance)) {
            //checks if instance is set and sets it if not
            //makes connection to db to be done once in __construct
            //creates an instance of the DB class
            self::$_instance = new DB();
        }
        //returns an instance of the connection ie object
        return self::$_instance;
    }

    //method used to run queries and bind values
    public function query($sql, $params = array()) {
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql) ) {
            $x = 1;
            if(count($params)) {
                foreach($params as $param) {
                    $this->_query->bindValue($x,$param);
                    $x++;
                }
            }
            // to avoid iterating over the array above and binding values, pass in the array of values you want to bind to execute()
            // if($this->_query->execute($params))
            if($this->_query->execute()) {
                //$this->_query->setFetchMode(PDO::FETCH_OBJ);
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
                //print_r($this->_query->errorInfo());
            }
        }
        return $this;
    }

    //prototype method for mysql actions
    public  function action($action, $table, $where = array(), $order = "id DESC") {
        $operators = array('=', '>', '<', '>=', '<=', '<>', '<=>', '!=', 'LIKE');
        if(count($where) % 3 == 0) {
            $z = count($where) / 3;
            $wherestr = "";
            $value = array();
            $operator = array();
            for($x = 0,$y= 1; $y <= $z; $y++, $x += 3) {
                $whr = array_slice($where, $x, 3);
                $wherestr .= "{$whr[0]} {$whr[1]} ?";
                if($z - $y >= 1) {
                    $wherestr .= " AND ";
                }
                $operator[] = $whr[1];
                $value[] = $whr[2];
            }
            foreach ($operator as $key => $valueop) {
                if(!in_array($valueop, $operators)) {
                    return false;
                }
            }
            $sql = "{$action} FROM {$table} WHERE ".$wherestr. " ORDER BY ". $order;
            //print_r($sql);
            if(!$this->query($sql,$value)->error()) {
                return $this;
            }
        }

        return false;
    }

    public function get($table, $where, $fields = '*', $order = "id DESC") {
        return $this->action("SELECT {$fields}", $table, $where, $order);
    }

    public function delete($table, $where) {
        return $this->action("DELETE", $table, $where);
    }

    //method for inserting values into tables specified in the parameter
    public function insert($table, $fields = array()) {
        $keys = array_keys($fields);
        $values = '';
        $x = 1;

        foreach($fields as $field) {
            $values .= '?';
            if($x < count($fields)) {
                $values .= ', ';
            }
            $x++;
        }

        $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys). "`) VALUES ({$values})";

        if(!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }

    //methos for updating values in table specified in the parameter
    public function update($table, $id, $fields, $key = 'id') {
        $set ='';
        $x = 1;

        foreach ($fields as $name => $value) {
            $set .= "{$name} = ?";
            if($x < count($fields)) {
                $set .= ', ';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE {$key} = {$id}";

        if(!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;
    }

    public function results() {
        return $this->_results;
    }

    public function first() {
        return $this->results()[0];
    }

    public function error() {
        return $this->_error;
    }

    public function count() {
        return $this->_count;
    }
    /*
     * get the kpi of a query result
     *
     * @param array $arr
     * @param string $col
     *
     * @return array
     * */
    public static function KPI($arr = [], $col) {
        foreach ($arr as $value) {
            $arr2[] = $value->{$col};
        }
        $values = array_count_values($arr2);        //count the number of times each value appears in the array
        arsort($values);        //sorts the array by number of occurence in reverse order
        return array_keys($values)[0];      //gets the actual value which is now the array key
    }

    public static function areaGraphFromat($result = array()) {
        $str = "[";
        foreach ($result as $key => $value) {
            $mon = (new DateTime($value->timestamp))->format('h:i:s');
            $str .= "[\"$mon\", $value->atlas_temp]";
            if($key < count($result) - 1) $str .= ",";
        }
        $str .= "]";
        return $str;
    }

//x: ["2018-06-06 08:26:20","2018-06-06 08:21:08","2018-06-06 08:15:55","2018-06-06 08:10:42","2018-06-06 08:05:30","2018-06-06 08:00:17","2018-06-06 07:55:03","2018-06-06 07:49:51","2018-06-06 07:44:37","2018-06-06 07:39:24"],
//y: ["26.60","26.60","26.60","26.60","26.60","26.60","26.60","26.60","26.60","26.60"],

    public static function lineGraphFromat($result = array()) {
        $arr = [];
        $arr['x'] = "[";
        $arr['y'] = "[";
        foreach ($result as $key => $value) {
            $arr['x'] .= "\"$value->timestamp\"";
            $arr['y'] .= "\"$value->atlas_temp\"";
            if($key < count($result) - 1) {
                $arr['x'] .= ",";
                $arr['y'] .= ",";
            }
        }
        $arr['x'] .= "]";
        $arr['y'] .= "]";
        return $arr;
    }
}
