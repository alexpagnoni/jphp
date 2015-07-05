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
JPHP::import('jphp.sql.drivers.mysql.MySQLStatement');

class MySQLConnection extends IConnection
{
	var $dbport_default = 3306;
	
	function startConnection() 
	{
		$this->dblink = @mysql_connect($this->getHost().':'.$this->getPort(), $this->getUser(), $this->getPass());
		if ($this->dblink)
		{
         @mysql_select_db ($this->getDatabaseName(), $this->getDatabaseLink());
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function endConnection() 
	{
		if ($this->getDatabaseLink()) 
      {
         @mysql_close($this->getDatabaseLink());
      }
	}
	
	function createStatement() 
	{
      return $this->getDatabaseLink() ? new MySQLStatement($this) : NULL;
	}
}
?>