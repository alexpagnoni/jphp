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

class IResultSet extends Object
{
	var $statement = NULL;
	var $result = NULL;
	
	var $current_row = array();
	
	function ResultSet(&$statement, &$result)
	{
		$this->setCurrentStatement($statement);
		$this->setCurrentResult($result);
	}
	
	function setCurrentStatement(&$statement)
	{
		if (IStatement::validClass($statement))
		{
			$this->statement =& $statement;
		}
	}
	
	function setCurrentResult($result)
	{
		$this->result = $result;
	}
   
	function getCurrentResult()
	{
		return $this->result;
	}
	function getResultMeta()
	{
		
	}
	function getCurrentRow()
	{
		return $this->currentRow;
	}
	
	function nextRow() 
	{ 
		
	}
	
	function getNumberRows() 
	{ 
		
	}
	
	function getNumberField() 
	{ 
		
	}
	
	function closeResult() 
	{
		
	}
	
	function get($field)
	{
		if (is_integer($field)) $field--;
		if ($this->currentRow) 
		{
			$value = @$this->currentRow[$field];
			return $value;
		}
		return "";
	}
	
	function getString($field)
	{
		return $this->get($field);
	}
	function getInteger($field)
	{
		$value = $this->get($field);
		settype($value, 'integer');
		return $value;
	}
   
   function validClass($object)
   {
      return Object::validClass($object, 'iresultset');
   }
}
?>