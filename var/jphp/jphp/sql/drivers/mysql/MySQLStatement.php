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
JPHP::import('jphp.sql.drivers.mysql.MySQLResultSet');
JPHP::import('jphp.util.StringBuffer');

class MySQLStatement extends IStatement
{
	function MySQLStatement(&$connection)
	{
		parent::IStatement($connection);
	}
	
	function execute($query) 
	{
		$query = StringBuffer::toStringBuffer($query);
      $query = $query->trimAll();
      $conn =& $this->getCurrentConnection();
      $res = mysql_query ($query->toString(), $conn->getDatabaseLink());
		if (preg_match('/^(delete from |update )/i', $query->toString()))
      {
         return $this->getUpdateCount();
      }
      else if (preg_match('/^(insert into)/i', $query->toString()))
      {
         return $this->getLastInsertId();
      }
      else
      {
		   return isset($res) ? TRUE : FALSE;
      }
	}
	
   function getLastInsertId()
   {
      $conn =& $this->getCurrentConnection();
      $count = mysql_affected_rows($conn->getDatabaseLink());
      return ($count>=0 ? mysql_insert_id($conn->getDatabaseLink()) : -1);
   }
	function getUpdateCount()
	{
		$conn =& $this->getCurrentConnection();
		return mysql_affected_rows($conn->getDatabaseLink());
	}
	
	function executeQuery($query) 
	{
      $query = StringBuffer::toStringBuffer($query);
      $query = $query->trimAll();
      $conn =& $this->getCurrentConnection();
		$res = mysql_query($query->toString(), $conn->getDatabaseLink());
      if (preg_match('/^(delete from |update )/i', $query->toString()))
      {
         return $this->getUpdateCount();
      }
      else if (preg_match('/^(insert into)/i', $query->toString()))
      {
         return $this->getLastInsertId();
      }
      else if (isset($res))
      {
         $this->setResult($res);
   		$err = @mysql_error($conn->getDatabaseLink());
   		if ($err=="")
   		{
   			$result = new MySQLResultSet($this, $res);
   			return $result;
   		}
      }
		return NULL;
	}
	
	function getResultSet()
	{
		$result = $this->getResult();
		if (isset($result))
		{
			$result = new MySQLResultSet($this, $result);
			return $result;
		}
		return FALSE;
	}
}
?>