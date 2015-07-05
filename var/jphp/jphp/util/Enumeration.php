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

class Enumeration extends Object
{
	var $index = 0;
	var $value = NULL;
	function Enumeration()
	{
		$this->value = array();
	}
	
	function nextElement()
	{
		$index = $this->index;
		$this->index++;
		return (isset($this->value[$index])?$this->value[$index]:NULL);
	}
	
	function hasMoreElements()
	{
		return $this->index<count($this->value);
	}
   
   function rewind()
   {
      $index = 0;
   }
   function validClass($object)
   {
      return Object::validClass($object, 'enumeration');
   }
   
}
?>