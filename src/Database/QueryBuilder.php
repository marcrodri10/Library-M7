<?php

namespace App\Database;
class QueryBuilder{
    private $selectables=[];
    private $query;
    private $table;
    private $whereClause;
    private $limit;
    private $params = [];
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
    public function condition(array $conditionFieldNames, string $table, array $values, string $symbol)
    {   
        $this->whereClause = " WHERE";
        
        $this->generateBindParams($conditionFieldNames, $values);
        
        $i = 0;
        foreach($conditionFieldNames as $condition){
            if($i == 0){
                $this->whereClause .=  " $table.$condition $symbol :$condition";
            }
            else $this->whereClause .=  " AND $table.$condition $symbol :$condition ";
            $i++;
        }
        $this->query .= $this->whereClause;
        return $this;
        
    }

    public function insert(string $table, array $fields){
        $columns = implode(', ', array_keys($fields));
        
        $values = array_map(function($value){
            return is_string($value) ? "'" . $value ."'" : $value;
        }, $fields);
        
        $this->generateBindParams(array_keys($fields), array_values($fields));
        
        $values = implode(', ', array_keys($this->params));
        
        $this->query = "insert into {$table} ({$columns}) values ({$values})";
        
        return $this;
    }

    public function update(string $table, array $fields){
        $this->query = "UPDATE {$table} SET ";

        $this->generateBindParams(array_keys($fields), array_values($fields));

        foreach($fields as $field => $value){
            $this->query .= $field ." = :". $field.", ";
        }
        $this->query = rtrim($this->query, ', ');
        
        return $this;
    }
    public function join(string $table1, string $table2, string $field, string $join){
        $this->query .= " ".$join." JOIN {$table2} ON ".$table1.".".$field." = ". $table2.".".$field;
        return $this;
    }
    public function get() {
        try{       
            $statement = $this->pdo->prepare($this->query);
            $statement->execute($this->params);
            $this->params = [];
            return $statement->fetchAll(\PDO::FETCH_CLASS);
            
        }
        catch(\Exception $e){
            if($e->getCode() == 23000){
                preg_match("/'([^']+)' for key '([^']+)'/", $e->errorInfo[2], $matches);
                throw new \Exception($matches[2]." already exists");
            }
            else {
                throw new \Exception("An error has occurred. Try later");
            }
            
            
        }
        
    }

    private function generateBindParams(array $fieldNames, array $values){
        foreach($values as $value => $v){
            $this->params = array_merge($this->params, [':'.$fieldNames[$value] =>  $v]);
        }
    }
}