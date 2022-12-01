<?php 

namespace App\sqlClass;

use \PDO;


class Crud 
{

	public $pdo;
	public $sql;

	public function __construct()
	{
		$this->pdo=InitPdo::newPdo("generateurDB");
	}

	public function lastId()
	{
		return $this->pdo->lastInsertId();
	}

	public function selectElement(string $column,string $table):self
	{
		$this->sql="SELECT $column FROM $table ";

		return $this;
	}

	public function insert(string $table,string $columnList):self
	{
		$this->sql="INSERT INTO $table ($columnList) ";

		return $this;
	}

	public function values(string $values):self
	{
		$this->sql.="VALUES ($values) ";

		return $this;
	}

	public function delete(string $table):self
	{
		$this->sql="DELETE FROM $table ";
		return $this;

	}

	public function update(string $table):self
	{
		$this->sql="UPDATE $table SET ";
		return $this;
	}

	public function leftJoin(string $joinTable,string $key,string $foreignKey ):self
	{
		$this->sql.=" LEFT JOIN $joinTable ON $key=$foreignKey ";

		return $this;
	}


	public function orderBY(string $column,?string $type=null):self
	{
		$this->sql.=" ORDER BY $column $type ";

		return $this;
	}

	public function where(string $column,$value):self
	{	
		
		if(is_array($value))
		{
			$imp=implode(",", $value);
			$req="IN ($imp)";
		}else
		{
			$req="=$value";
		}
		$this->sql.=" WHERE $column $req";
		return $this;
	}

	public function and(string $value):self
	{
		$this->sql.=" AND $value";
		return $this;
	}

	public function debug()
	{
		return $this->sql;
	}

	public function limit(string $limit="1")
	{
		$this->sql.=" LIMIT $limit ";

		return $this;

	}

	public function setNewValue(string $newValue):self
	{

		$this->sql.="$newValue ";

		return $this;

	}

	public function executeReq(?string $recupeDataType,array $params=[],$className=null)
	{
		$req= $this->pdo->prepare($this->sql);
		$req->execute($params);

		switch ($recupeDataType) 
		{
			
			case "fetch": return $req->fetch();break;
			case "fetchWhithClass": return $req->fetchObject($className);break;
			case "fetchAll": return $req->fetchAll();break;
			case "fetchAllWhithClass": return $req->fetchAll(PDO::FETCH_CLASS,$className);break;
			default:return true;break;
		}
		
	}




	
}

?>