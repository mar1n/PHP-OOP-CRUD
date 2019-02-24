<?php
/**
 * Created by PhpStorm.
 * User: Szymon
 * Date: 08/01/2019
 * Time: 14:05
 */

namespace App\Config;
use PDO;
use PDOException;

/**
 * Class crud
 * @package App\Config
 */
class crud {
    /**
     * @var connectDb
     */
    private $connectDb;

    /**
     * crud constructor.
     * @param connectDb $connectDb
     */
    public function __construct(connectDb $connectDb)
    {
        $this->connectDb = $connectDb->openConnection();
    }

    /**
     * @param string $sql this is example we can put simple query "SELECT * FROM Table"
     * @return array $result
     */
    public function read($sql) {
        $data = $this->connectDb->prepare($sql);
        $data->execute();
        $result = $data->fetchAll();
        return isset($result) ? $result : "Is empty";
    }

    /**
     * Insert multiple rows inside table
     * @param array $multiArray two dimensional array as example [[1,2], [4,5],[7,8]]
     * @return int last insert Id inside table
     */
    public function insert($multiArray) {

        $table = 'books';
        $columns = array('title', 'primary_author');
        $columns2 = implode(",",$columns);
        $pdo = $this->connectDb;
        $pdo->beginTransaction();
        $sql = "insert into $table ($columns2) values ";

        $paramArray = array();
        $sqlArray = array();

        foreach($multiArray as $row)
        {
            $sqlArray[] = '(' . implode(',', array_fill(0, count($row), '?')) . ')';
            foreach($row as $element)
            {
                $paramArray[] = $element;
            }
        }

        $sql .= implode(',', $sqlArray);
        $stmt = $pdo->prepare($sql);
        try {
            $stmt->execute($paramArray);
            $count = $stmt->rowCount();
            $pdo->commit();

            return print("rows CREATED successfully  $count \n");
        } catch (PDOException $e){
            $pdo->rollBack();
            echo $e->getMessage();
        }
        $pdo = null;
    }

    /**
     * delete multiple rows inside table
     * @param array $ids one dimensional
     * @return int number of deleted records
     */
    public function remove($ids)
    {
        $pdo = $this->connectDb;
        $id = array();
        foreach ($ids as $val) {
            $id[] = (int)$val;
        }
        $id = implode(',', $id);
        $stmt = $pdo->prepare("DELETE FROM books WHERE id IN ($id)");
        $stmt->execute();

        $countDel = $stmt->rowCount();
        return ($countDel != 0) ?  print  "rows DELETED successfully ". $countDel  :  print $countDel . "rows DELETED";
    }

    /**
     * update multiple rows inside table
     * $array = [
    "title"  => "primary_author"
    ];
     * @param array $arrayUpdate
     * @return int number of updated records
     */
    public function update($arrayUpdate) {
        $pdo = $this->connectDb;
        $stmt = $pdo->prepare("UPDATE books SET title = ? WHERE primary_author = ?");
        foreach($arrayUpdate as $k => $v) {
            $id = $k;
            $column_value = $v;
            $stmt->execute(array($id,$column_value));
        }

        $rowCounter = $stmt->rowCount();
        return ($rowCounter != 0) ? print  " records UPDATE successfully " . $rowCounter : print $rowCounter . " records UPDATED";
    }
}

