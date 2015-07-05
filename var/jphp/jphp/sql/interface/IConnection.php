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

class IConnection extends Object
{
	var $dblink = NULL;
	var $dbhost = NULL;
	var $dbport = 0;
	var $dbport_default = NULL;
	var $dbname = NULL;
	var $dbuser = NULL;
	var $dbpass = NULL;
	var $auto_commit = TRUE;
   
   function Connection()
	{
		
	}
	
	function getDatabaseLink()
	{
		return $this->dblink;
	}
	
	function setDBConnection($host, $dbname, $user, $pass)
	{
		$this->setHost($host);
		$this->setUser($user);
		$this->setPass($pass);
		$this->setDatabaseName($dbname);
	}
	
	function setDatabaseName($dbname)
	{
		$this->dbname = $dbname;
	}
	
	function getDatabaseName()
	{
		return $this->dbname;
	}
	
	function setHost($host)
	{
      $host = preg_split('/:/', $host);
		$this->dbhost = $host[0];
      if (count($host)==2)
      {
         $this->setPort-($host[1]);
      }
	}
	
	function getHost()
	{
		return $this->dbhost;
	}
	
	function setPort($port)
	{
      settype($port, 'integer');
		$this->dbport = $port>0 ? $post : $this->getDefaultPort();
	}
	
	function getPort()
	{
		return ( isset($this->dbport) && $this->dbport!=0 ) ? $this->dbport : $this->getDefaultPort();
	}
	
	function getDefaultPort()
	{
		return $this->dbport_default;
	}
	
	function setUser($user)
	{
		$this->dbuser = $user;
	}
	
	function getUser()
	{
		return $this->dbuser;
	}
	
	function setPass($pass)
	{
		$this->dbpass = $pass;
	}
	
	function getPass()
	{
		return $this->dbpass;
	}
	
	function createStatement() 
	{
		
	}
	
	function startConnection() 
	{
		
	}
	
	function endConnection() 
	{
		
	}
	
	function openConnection() 
	{
		return $this->startConnection();
	}
	
	function closeConnection() 
	{
		$this->endConnection();
	}
	
   function setAutoCommit($autocommit)
   {
      $this->auto_commit = $autocommit===TRUE ? TRUE : FALSE ;
   }
   
   function setTransactionMode($transaction)
   {
      $this->auto_commit = $transaction===TRUE ? FALSE : TRUE ;
   }
   
   function commit()
   {
   
   }
   
   function roolback()
   {
   
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'iconnection');
   }
}
?>