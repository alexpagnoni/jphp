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

JPHP::import('jphp.io.IWriter');
JPHP::import('jphp.util.StringBuffer');

class StringWriter extends IWriter
{
   var $stringbuffers = NULL;
   
   function StringWriter()
	{
	   $this->stringbuffers = new StringBuffer();
	}
	
   function write($stream)
   {
      $this->stringbuffers->append($stream);
   }
   
	function println($stream)
	{
      $this->write($stream);
      $this->write("\n");
	}
	
	function ready()
	{
	   return isset($this->stringbuffers);
	}
	
	function close()
	{
	   $this->stringbuffers = NULL;
	}
   
   function toString()
   {
      return $this->stringbuffers->toString();
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'stringwriter');
   }
}
?>