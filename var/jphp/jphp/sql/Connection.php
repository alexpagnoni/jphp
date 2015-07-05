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

JPHP::import('jphp.sql.interface.IConnection');
JPHP::import('jphp.net.URL');

class Connection extends IConnection
{
	var $driver = NULL;
	var $drivername = NULL;
   
	function & getInstance($driver, $host=NULL, $dbname=NULL, $user=NULL, $pass=NULL)
	{
		$url = '';
      if (isset($driver))
      {
		   if (URL::validClass($driver))
         {
            $url = $driver;
            $res = '';
            if (preg_match('/^jdbc:([aA-zZ]+):?\s*/i', $url->protocol, $res))
            {
               $url->protocol = $res[1];
            }
         }
         else if (isset($host) && isset($dbname) && isset($user))
         {
            $url = new URL($driver.'://'.$user.':'.$pass.'@'.$host.'/'.$dbname);
            $res = '';
            if (preg_match('/^jdbc:([aA-zZ]+):?\s*/i', $url->protocol, $res))
            {
               $url->protocol = $res[1];
            }
         }
         else
         {
            return NULL;
         }
         $conn =&  new Connection($url);
         return $conn;
      }
      return NULL;
	}
   
	function Connection($driver)
	{
		if (URL::validClass($driver))
		{
			$db_driver = $driver->getProtocol().'Connection';
         if (!JPHPClassRegistry::isRegistered($db_driver))
         {
            JPHP::import('jphp.sql.drivers.'.$driver->getProtocol().'.*');
         }
			if (JPHPClassRegistry::isRegistered($db_driver))
			{
				$db_driver = '$this->driver = new '.$db_driver.'();';
            $this->drivername = $driver;
            eval($db_driver);
            $this->setDBConnection($driver->getHost(), substr($driver->getFile(),1), $driver->getUserName(), $driver->getPassword());
			}
         else
         {  
            die("no driver found ... ");
         }
         // should throw an exception
		}
	}
	
	function & getDatabaseDriver()
	{
		return $this->driver;
	}
	
   function getDriverName()
   {
      return $this->drivername;
   }
   
	function getDatabaseLink()
	{
      return $this->driver->getDatabaseLink();
	}
	
	function setDBConnection($host, $dbname, $user, $pass)
	{
		$this->driver->setDBConnection($host, $dbname, $user, $pass);
	}
	
	function setDatabaseName($dbname)
	{
		$this->driver->setDatabaseName($dbname);
	}
	
	function getDatabaseName()
	{
		return $this->driver->getDatabaseName();
	}
	
	function setHost($host)
	{
		$this->driver->setHost($host);
	}
	
	function getHost()
	{
		return $this->driver->getHost();
	}
	
	function getPort()
	{
		return $this->driver->getPort();
	}
	
	function getDefaultPort()
	{
		return $this->driver->getDefaultPort();
	}
	
	
	function setUser($user)
	{
		$this->driver->setUser($user);
	}
	
	function getUser()
	{
		return $this->driver->getUser();
	}
	
	function setPass($pass)
	{
		$this->driver->setPass($pass);
	}
	
	function getPass()
	{
		return $this->driver->getPass();
	}
	
	function createStatement() 
	{
		return new Statement($this->driver->createStatement(), $this);
	}
	
	
	function startConnection() 
	{
		return $this->driver->startConnection();
	}
	
	function endConnection() 
	{
		$this->driver->endConnection();
	}
   
   function setAutoCommit($autocommit)
   {
      $this->driver->setAutoCommit($autocommit);
   }
   
   function setTransactionMode($transaction)
   {
      $this->driver->setTransactionMode($transaction);
   }
   
   function commit()
   {
      return $this->driver->commit();
   }
   
   function roolback()
   {
      return $this->driver->rollback();
   }
}
?>