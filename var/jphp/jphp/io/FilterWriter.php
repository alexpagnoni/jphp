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

class FilterWriter extends IWriter
{
   var $writer = NULL;
   
   function FilterWriter(&$writer)
   {
      if (IWriter::validClass($writer))
      {
         $this->writer =& $writer;
      }
   }
   
   function write($stream)
   {
      $this->writer->write($stream);
   }
   
	function println($stream)
	{
		$this->writer->println($stream);
	}
	
	function ready()
	{
	   return $this->writer->ready();
	}
	
	function close()
	{
	   $this->writer->close();
	}
   
   function validClass($object)
   {
      return Object::validClass($object, 'filteredwriter');
   }
}
?>