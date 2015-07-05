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
JPHP::import('jphp.sql.ResultMeta');

class ResultSet extends IResultSet
{
   var $resultset = NULL;
   var $statement = NULL;
   
   function ResultSet(&$resultset, &$statement)
   {
      if (isset($resultset) && isset($statement))
      {
         $this->resultset =& $resultset;
         $this->statement =& $statement;
      }
   }
   
   function & getStatement()
   {
      return $this->statement;
   }
   function getCurrentResult()
	{
		return $this->resultset->getCurrentResult();
	}
	
   function getResultMeta()
	{
		return new ResultMeta($this->resultset->getResultMeta(), $this);
	}
	function getCurrentRow()
	{
		return $this->resultset->getCurrentRow();
	}
	
	function nextRow() 
	{ 
		return $this->resultset->nextRow();
	}
	
	function getNumberRows() 
	{ 
		return $this->resultset->getNumberRow();
	}
	
	function getNumberField() 
	{ 
		return $this->resultset->getNumberField();
	}
	
	function closeResult() 
	{
		$this->resultset->closeResult();
	}
	
	function get($field)
	{
		return $this->resultset->get($field);
	}
	
	function getString($field)
	{
		return $this->resultset->get($field);
	}
   
	function getInteger($field)
	{
		$this->resultset->getInteger($field);
	}
}
?>