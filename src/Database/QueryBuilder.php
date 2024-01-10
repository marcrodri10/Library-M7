<?php

namespace App\Database;
class QueryBuilder{
    private $selectables=[];
    private $query;
    private $table;
    private $whereClause;
    private $limit;
    protected $pdo;

    function __construct($pdo)
    {
        $this->pdo=$pdo;
    }

    function selectAll($table){
        /*
        $statement = $this->pdo->prepare("select * from {$table}");
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS);
        */
        $this->query = "SELECT * FROM {$table}";
        return $this;
    }

    public function selec(){
        $this->selectables=func_get_args();
        return $this;
    }
    public function select($table, $fields){
        $columns = implode(', ', $fields);
        $this->query = "SELECT $columns FROM {$table}";
        
        return $this;
    }
    public function condition(string $conditionFieldName, string $table, $value, string $symbol)
    {
        if($symbol == '=') $this->whereClause =  " WHERE $table.$conditionFieldName = '$value'";
        else if($symbol == 'like') $this->whereClause = " WHERE $table.$conditionFieldName LIKE '%$value%'";
        else $this->whereClause =  " WHERE $table.$conditionFieldName != '$value'";
        
        $this->query .= $this->whereClause;
        return $this;
        
    }

    public function insert(string $table, array $fields){
        $columns = implode(', ', array_keys($fields));
        
        $values = array_map(function($value){
            return is_string($value) ? "'" . $value ."'" : $value;
        }, $fields);

       
        $values = implode(', ', array_values($values));
        
        $this->query = "insert into {$table} ({$columns}) values ({$values})";
        
        $statement = $this->pdo->prepare($this->query);

        $statement->execute();

    }

    public function update(string $table, array $fields){
        $this->query = "UPDATE {$table} SET ";
        
        foreach($fields as $field => $value){
            $this->query .= $field ." = '". $value."', ";
        }
        $this->query = rtrim($this->query, ', ');
        
        return $this;
    }
    public function join(string $table1, string $table2, string $field, string $join){
        $this->query .= " ".$join." JOIN {$table2} ON ".$table1.".".$field." = ". $table2.".".$field;
        return $this;
    }
    public function get() {
        $statement = $this->pdo->prepare($this->query);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_CLASS);
    }
}