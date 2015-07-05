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

JPHP::import('jphp.io.IReader');

class FilterReader extends IReader
{
   var $reader = NULL;
   function FilterReader($reader) 
   {
      if (IReader::validClass($reader))
      {
         $this->reader =& $reader;
      }
   }
	
	function read()
   {
      return $this->reader->read();
   }
	
   function ready()
   {
      return $this->reader->ready();
   }
	
   function close()
   {
      $this->reader->close();
   }
	
   function skip($counter=1)
   {
      $this->reader->skip($counter);
   }
	
   function reset()
   {
      $this->reader->reset();
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'filterreader');
   }
}
?>