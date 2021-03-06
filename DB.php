<?php

declare(strict_types = 1);

class DB 
{
    protected PDO $db;
    protected const DATABASE = '';

    
    public function __construct(string $dsn = 'mysql:host=localhost', string $username = 'root', string $password = 'root')
    {

        // should check if the database is set
        try {
            $this->db = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            print $this->dbError($e);
            return;
        }
    }


    public function dbError(PDOException $error): string
    {
        return $error->getMessage();
    }


    public function __call($name, $arguments)
    {
        print $name.' method does not exsit...';
    }


    // should check if databse is set

    public function isDBSet () {
       
    }


    public function getAllDBS(): void
    {
        $query = $this->db->prepare('SHOW DATABASES');
        $query->execute();

        $databases = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach($databases as $database){
            print $database['Database'].'<br>';
        }
    }
    
    
    public function createDB(string $name): void
    {
        $this->db->exec("CREATE DATABASE $name");
    }

    public function deleteDB($name): void
    {
        $this->db->exec("DROP DATABASE $name");
    }


    public function createTable(string $db, string $table, array $columns = ['id' => 'int(11) PRIMARY KEY AUTO_INCREMENT']): void
    {
        $cols = '';

        foreach($columns as $key => $column){
            $cols .= "$key $column, ";
        }

        $cols = rtrim($cols, ', ');

        $this->db->exec("USE $db; CREATE TABLE $table ($cols)");
    }


    public function deleteTable(string $db, string $table): void
    {
        $this->db->exec("USE $db; DROP TABLE $table");
    }

    // update table

    public function addColumn(string $db, string $table, string $col): void
    {
        $this->db->exec("USE $db;");
        $this->db->exec("ALTER TABLE $table ADD $col");
    }


    public function deleteColumn(string $db, string $table, string $col): void
    {
        $this->db->exec("USE $db;");
        $this->db->exec("ALTER TABLE $table DROP $col");
    }


    public function getTableColumns(string $db, string $table): array
    {
        $colsArray = [];
        $query = $this->db->prepare("SHOW COLUMNS FROM $table FROM $db");
        $query->execute();

        $cols = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($cols as $key => $col) {
            foreach($col as $key => $info){
                if ($key === 'Field') {
                    $colsArray[] .= $info;
                }
            }
        }

        return $colsArray;
    }

    // CRUD

    public function select(string $db, string $table, $condition): string|array
    {
        $this->db->exec("USE $db");

        $query = $this->db->prepare("SELECT * FROM $table WHERE $condition");
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        print $query->debugDumpParams();
        print_r($result);

        die;

    }


    public function insert(string $db, string $table, array $colValues): void
    {
        $colsStr = '';
        $valuesStr = '';

        foreach ($colValues as $col => $val) {
            $colsStr .= "`$col`, ";
            $valuesStr .= "'$val', ";
        }

        $colsStr = trim($colsStr, ', ');
        $valuesStr = trim($valuesStr, ', ');


        $this->db->exec("USE $db; INSERT INTO `$table` ($colsStr) VALUES ($valuesStr)");
    }

    // update

    public function update(
        string $db,
        string $table,
        array $columns,
        array $values,
        string $condition
    ): void
    {
        if (count($columns) !== count($values)) {
            throw new RuntimeException('Columns and values should contain the same amount of items');
        }

        $colvalues = '';

        foreach ($columns as $key => $column) {
            $colvalues .= "$column = '$values[$key]', ";
        }

        $colvalues = trim($colvalues, ', ');

        print($colvalues);

        $this->db->exec("USE $db; UPDATE $table SET $colvalues WHERE $condition");
    }


    public function delete(string $db, string $table, string $condition): void
    {
        $this->db->exec("USE $db; DELETE FROM $table WHERE $condition");
    }

}