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

JPHP::import('jphp.sql.interface.IResultSet');

class MySQLResultSet extends IResultSet
{
	function MySQLResultSet(&$statement, &$result)
	{
		parent::ResultSet($statement, $result);
	}
   
	function nextRow() 
	{ 
		$this->currentRow = @mysql_fetch_array($this->getCurrentResult());
		return $this->currentRow;
	}
	
	function getNumberRows() 
	{ 
      $counter = @mysql_num_rows($this->getCurrentResult());
		return isset($counter) ? $counter : 0;
	}
	
	function getNumberField() 
	{ 
		$counter= @mysql_num_fields($this->getCurrentResult());
      return isset($counter) ? $counter : 0;
	}
	
	function closeResult() 
	{
		@mysql_free_result($this->getCurrentResult());
	}
	function getResultMeta()
	{
		$rsmeta = new MySQLResultMeta($this);
		return $rsmeta;
	}
	
	function getNumberRows() 
	{ 
      $counter = mysql_num_rows($this->getCurrentResult());
      return isset($counter) ? $counter : 0;
	}
}
?>