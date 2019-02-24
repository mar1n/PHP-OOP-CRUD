<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 07/01/2019
 * Time: 13:36
 */

namespace App\Config;
use PDO;
use PDOException;
include('config.php');

/**
 * Class connectDb
 * @package App\Config
 */
class connectDb {

    /**
     * @var string type of database
     */
    private  $type = DBTYPE;
    /**
     * @var string host of database
     */
    private  $dbHost = DBHOST;
    /**
     * @var string user name of database
     */
    private  $dbName = DBNAME;
    /**
     * @var string user name of database
     */
    private  $user = DBUSER;

    /**
     * @var string password of database
     */
    private  $pass = DBPASSWORD;

    /**
     * @var array set error reporting, set default fetch mode
     */
    private $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);

    /**
     * @var PDO
     */
    protected $con;

    /**
     * @return PDO connection to database
     */
    public function openConnection()

    {

        try

        {
            $this->con = new PDO($this->type.':host='.$this->dbHost.';dbname='. $this->dbName, $this->user, $this->pass,$this->options);

            return $this->con;

        }

        catch (PDOException $e)

        {

            echo "There is some problem in connection: " . $e->getMessage();

        }

    }

    /**
     * close pdo connection
     */
    public function closeConnection() {

        $this->con = null;

    }
}
