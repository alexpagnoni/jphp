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

class IResultMeta  extends Object
{
	var $resultset = NULL;
	
	function IResultMeta(&$resultset)
	{
		$this->setResultSet($resultset);
	}
	
	function setResultSet(&$resultset)
	{
		if (IResultSet::validClass($resultset))
		{
			$this->resultset =& $resultset;
		}
	}
	
	function &getResultSet()
	{
		return $this->resultset;
	}
	
	function countFields() 
	{ 
		
	}
	function getFieldName($index) 
	{ 
	
	}
   
   function validClass($object)
   {
      return Object::validClass($object, 'iresultmeta');
   }
}
?>