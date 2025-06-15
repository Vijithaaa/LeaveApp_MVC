<?php
include 'config.php';

class Database
{
    public $pdo;
    public function __construct()
    {
        try {
            $dsn = "mysql:host=" . host . ";dbname=" . dbname . ";port=" . port;
            $this->pdo = new PDO($dsn, user, password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connection Success!";
        } catch (PDOException $e) {
            die("Not connected: " . password . $e->getMessage());
        }
    }

    // public function getConnection(){
    //     return $this->pdo;
    // }


    // $obj = new Database();
    // $obj->getConnection();

    //    $querydata = [
    //             'column_name'=>"*",
    //             'table_name'=>"admin",
    //             'condition'=>[
    //                 'user'=>$username,
    //                 'pass'=>$password
    //             ]
    //         ];


    // public function select($querydata){
    //     foreach($querydata['condition'] $key => $value){

    //      $stmt = $this->pdo->prepare("SELECT" .$querydata['column_name']. "from" .$querydata['table_name']. 
    //                                       "WHERE" 
    //                                       .$key."=:".$key ."AND" .$key."=:".$key);
    //         // $stmt->bindParam(':name', $username);
    //         // $stmt->bindParam(':pass', $password);
    //         $stmt->bindParam(':'.$key, $value);
    //         $stmt->execute();
    //         if ($stmt->rowCount() > 0) {
    //             $value = $stmt->fetch(PDO::FETCH_ASSOC);
    //             return (['status' => 'success', 'msg' => $value]);
    //         } 
    //         else {
    //             return (['status' => 'error', 'msg' => false]);
    //         }
    //     }

    // }



    // public function select($querydata, $multiple = false)
    // {
    //     $columns = $querydata['column_name'];
    //     $table = $querydata['table_name'];
    //     $conditions = $querydata['condition'];

    //     // Build WHERE clause dynamically
    //     $whereClauses = [];
    //     foreach ($conditions as $key => $value) {
    //         $whereClauses[] = "$key = :$key";
    //     }
    //     $whereSql = implode(" AND ", $whereClauses);

    //     // Final SQL query
    //     $sql = "SELECT $columns FROM $table WHERE $whereSql";
    //     // echo $sql;
    //     // print_r($querydata);

    //     // Prepare and bind
    //     $stmt = $this->pdo->prepare($sql);
    //     foreach ($conditions as $key => $value) {
    //         $stmt->bindValue(":$key", $value);
    //         // echo $key . " " . $value;
    //     }

    //     $stmt->execute();
      
    //     // print_r($stmt->rowCount() > 0);

    //     if ($stmt->rowCount() > 0) {
    //         $data = $multiple ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->fetch(PDO::FETCH_ASSOC);
    //         return ['status' => 'success', 'msg' => $data];
    //     } else {
    //         return ['status' => 'error', 'msg' => false];
    //     }
    // }


    


    public function select($querydata, $multiple = false)
{
    $columns = $querydata['column_name'];
    $table = $querydata['table_name'];
    $conditions = $querydata['condition'];

    $columns = is_array($querydata['column_name']) ? implode(", ", $querydata['column_name']) : $querydata['column_name'];

    // Build WHERE clause only if conditions exist
    $whereSql = '';
    if (!empty($conditions)) {
        $whereClauses = [];
        foreach ($conditions as $key => $value) {
            $whereClauses[] = "$key = :$key";
        }
        $whereSql = ' WHERE ' . implode(" AND ", $whereClauses);
    }

    // Final SQL query
    $sql = "SELECT $columns FROM $table" . $whereSql;

    // Prepare and bind
    $stmt = $this->pdo->prepare($sql);
    if (!empty($conditions)) {
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
    }

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $data = $multiple ? $stmt->fetchAll(PDO::FETCH_ASSOC) : $stmt->fetch(PDO::FETCH_ASSOC);
        return ['status' => 'success', 'msg' => $data];
    } else {
        return ['status' => 'error', 'msg' => false];
    }
}

    
}
