<?php
/**
 * @version 2.0
 * @author Nicolas BUI <nbui@wanadoo.fr>
 * 
 * This source file is part of JPHP Library Project.
 * Copyright: 2002 Vitry sur Seine/FRANCE
 *
 * The latest version can be obtained from:
 * http://www.jphplib.org
 */

JPHP::import('jphp.sql.interface.IStatement');
JPHP::import('jphp.sql.ResultSet');

class Statement extends IStatement
{
   var $statement = NULL;
   var $connection = NULL;
   
   function Statement(&$statement, &$connection)
   {
      if (isset($statement) && isset($connection))
      {
         $this->statement =& $statement;
         $this->connection =& $connection;
      }
   }
   
   function & getCurrentConnection()
	{
		return $this->connection;
	}
	
	function addBatch($query) 
	{ 
		$this->statement->batchQuery->addElement($query);
	}
	
	function getResult() 
	{
		return $this->statement->result;
	}
	
   function getResultSet()
	{
	   return $this->statement->getResultSet();
	}
	
	function getUpdateCount()
	{
		return $this->statement->getUpdateCount();
	}
	function getSelectCount()
	{
		return $this->statement->getSelectCount();
	}
	
	function execute($query) 
	{
		return $this->statement->execute($query);
	}
	
	function executeQuery($query) 
	{
      $res  = $this->statement->executeQuery($query);
		return new ResultSet($res, $this);
	}
	
	function executeBatch($query) 
	{
		$this->statement->executeBatch($query);
	}
	
	function getCurrentResultMeta()
	{
		return $this->statement->getCurrentResultMeta();
	}
}
?>