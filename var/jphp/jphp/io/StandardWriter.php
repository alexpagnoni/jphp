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

class StandardWriter extends IWriter
{
   function StandardWriter()
	{
	
	}
	
   function write($stream)
   {
      $stream = StringBuffer::toStringBuffer($stream);
      print($stream->toString());
   }
	function println($stream)
	{
		$this->write($stream."\n");
	}
	
	function ready()
	{
		return TRUE;
	}
	
	function close()
	{
		return;
	}
   
   function validClass($object)
   {
      return Object::validClass($object, 'standardwriter');
   }
   
}
?>