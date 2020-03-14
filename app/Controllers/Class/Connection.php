<?php


class Connection
{
    private $driver;
    public $db_connection = false;
    private $connection;
    private $host, $user, $pass, $database, $charset;

    /**
     * @return mixed
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param mixed $driver
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param mixed $host
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @param mixed $pass
     */
    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    /**
     * @return mixed
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @param mixed $database
     */
    public function setDatabase($database)
    {
        $this->database = $database;
    }

    /**
     * @return mixed
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * @param mixed $charset
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    }

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param mixed $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }





    /**
     * constructor.
     */
    public function __construct()
    {
        $db_cfg = require_once path_URL . '/config/database.php';
        $this->driver = $db_cfg["driver"];
        $this->host = $db_cfg["host"];
        $this->user = $db_cfg["user"];
        $this->pass = $db_cfg["pass"];
        $this->database = $db_cfg["database"];
        $this->charset = $db_cfg["charset"];
    }

    /**
     * @return mysqli
     */
    public function connection()
    {
        if ($this->db_connection == false) {
            if ($this->driver == "mysql" || $this->driver == null) {

                $con = new mysqli($this->host, $this->user, $this->pass, $this->database);
                $con->query("SET NAMES '" . $this->charset . "'");
                $this->db_connection = true;
                $this->setConnection($con);
            }
        }else{
            $con = $this->getConnection();
            $con->query("SET NAMES '" . $this->charset . "'");
            $this->db_connection = true;
        }


        return $con;
    }

    public function closeConnection()
    {

    }

    /**
     * @return FluentPDO
     */
    public function startFluent()
    {
        require_once  path_URL . '/app/Model/FluentPDO/FluentPDO.php';

        if ($this->driver == "mysql" || $this->driver == null) {
            $pdo = new PDO($this->driver . ":dbname=" . $this->database, $this->user, $this->pass);
            $fpdo = new FluentPDO($pdo);
        }

        return $fpdo;
    }
}

?>
