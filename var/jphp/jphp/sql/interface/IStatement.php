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

class IStatement  extends Object
{
	var $connection = NULL;
	var $result = NULL;
	
	function IStatement(&$connection)
	{
		if (IConnection::validClass($connection))
		{
			$this->connection =& $connection;
		}
	}
	
	function & getCurrentConnection()
	{
		return $this->connection;
	}
	
	function addBatch($query) 
	{ 
		$this->batchQuery->addElement($query);
	}
	
	function getResult() 
	{
		return $this->result;
	}
	
	function setResult($result) 
	{
		$this->result = $result;
	}
	
	
	function getResultSet()
	{
	
	}
	
	function getUpdateCount()
	{
		return -1;
	}
	function getSelectCount()
	{
		return -1;
	}
	
	function execute($query) 
	{
		return FALSE;
	}
	
	function executeQuery($query) 
	{
		return FALSE;
	}
	
	function executeBatch($query) 
	{
		
	}
	
	function getCurrentResultMeta()
	{
		$result = $this->getResultSet();
		if (isset($result))
		{
			return $result->getResultMeta();
		}
		return FALSE;
	}
   
   function validClass($object)
   {
      return Object::validClass($object, 'istatement');
   }
}
?>