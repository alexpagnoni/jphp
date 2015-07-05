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

class IWriter extends Object
{
	function IWriter()
	{
	
	}
	
   function write($stream)
   {
   
   }
   
	function println($stream)
	{
		
	}
	
	function ready()
	{
	
	}
	
	function close()
	{
	
	}
   
   function validClass($object)
   {
      return Object::validClass($object, 'iwriter');
   }
   
}
?>