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

class IReader extends Object
{
	var $handle;
	
	function IReader() {}
	
	function read(){}
	function ready(){}
	function close(){}
	function skip($counter=1){}
	function reset(){}
   
   function validClass($object)
   {
      return Object::validClass($object, 'ireader');
   }
   
}
?>