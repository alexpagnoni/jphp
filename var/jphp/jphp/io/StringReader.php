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
JPHP::import('jphp.util.StringBuffer');

class StringReader extends IReader
{
   var $index = 0;
	var $handle;
	
	function StringReader($source) 
   {
      $this->handle  = StringBuffer::toStringBuffer($source);
   }
	
	function read($length=1)
   {
      if (!$this->ready()) return '';
      if ($length<=1)
      {
         $current = $this->index;
         $this->index++;
         return ( ($current<$this->handle->length()) ? $this->handle->charAt($current) : '' );
      }
      else
      {
         $len = $this->handle->length() - $this->index;
         if ($len<=$length)
         {
            $out = $this->handle->substring($this->index);
            $this->index = $this->handle->length();
            return $out->toString();
         }
         else
         {
            $len = $this->index + $length;
            $out = $this->handle->substring($this->index, $len);
            $this->index = $len;
            return $out->toString();
         }
      }
   }
   
	function ready()
   {
      return isset($this->handle);
   }
	
   function close()
   {
      $this->index = 0;
      unset($this->handle);
   }
	function skip($counter=1)
   {
      $this->index += $counter;
   }
	function reset()
   {
      $this->index = 0;
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'stringreader');
   }
   
}
?>