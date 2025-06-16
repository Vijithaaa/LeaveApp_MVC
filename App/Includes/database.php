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




    public function select_queryfun($querydata, $multiple = false)
    {
        $columns = is_array($querydata['column_name']) ? implode(", ", $querydata['column_name']) : $querydata['column_name'];
      
        $table = $querydata['table_name'];
        $conditions = $querydata['condition']; 
        
        $orderby = isset($querydata['orderby']) ? $querydata['orderby'] : null;


        $whereSql = '';
        if (!empty($conditions)) {
            $whereClauses = [];
            foreach ($conditions as $key => $value) {
                $whereClauses[] = "$key = :$key";
            }
            $whereSql = ' WHERE ' . implode(" AND ", $whereClauses);
        }

        $orderBySql = '';
        if (!empty($orderby)) {
            $orderBySql = ' ORDER BY ' . $orderby;

        }

        $sql = "SELECT $columns FROM $table" . $whereSql . $orderBySql;
        // echo "$sql";

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





    public function insert_queryfun($querydata, $returnId = false)
    {
        $table = $querydata['table_name'];
        $data = $querydata['data'];

        $columns = implode(",", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        // echo "$sql";
        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $key => $val) {
            $stmt->bindvalue(":$key", $val);
        }
        if ($stmt->execute()) {
            if ($returnId) { //true
                return [
                    'status' => 'success',
                    'msg' => ['last_id' => $this->pdo->lastInsertId()]
                ];
            } else {
                return [
                    'status' => 'success',
                    'msg' => true
                ];
            }
        } else {
            return [
                'status' => 'error',
                'msg' => 'Insert failed'
            ];
        }
    }


    public function update_queryfun($querydata)
    {
        $table = $querydata['table_name'];
        $data = $querydata['data'];
        $condition = $querydata['condition'];

        $setParts = [];
        foreach ($data as $key => $value) {
            $setParts[] = "$key = :$key";
        }
        $setClause = implode(", ", $setParts);

        $whereClause = "";
        $condParams = [];

        if (!empty($condition)) {
            $whereParts = [];
            foreach ($condition as $key => $value) {
                $param = "cond_$key";
                $whereParts[] = "$key = :$param";
                $condParams[$param] = $value;
            }
            $whereClause = " WHERE " . implode(" AND ", $whereParts);
        }

        $sql = "UPDATE $table SET $setClause $whereClause";
        // print_r($sql);

        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }

        foreach ($condParams as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return ['status' => "success", 'msg' => "Updated successfully"];
        } else {
            return ['status' => "error", 'msg' => "No rows affected"];
        }
    }








    public function delete_queryfun($querydata)
    {

        $table = $querydata['table_name'];
        $conditions = $querydata['condition'];


        $whereSql = '';
        if (!empty($conditions)) {
            $whereClauses = [];
            foreach ($conditions as $key => $value) {
                $whereClauses[] = "$key = :$key";
            }
            $whereSql = " WHERE " . implode(" AND ", $whereClauses);
        }

        $sql = "DELETE FROM $table $whereSql ";

        $stmt = $this->pdo->prepare($sql);
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return ['status' => 'success', 'msg' => true];
        } else {
            return ['status' => 'error', 'msg' => false];
        }
    }
}
