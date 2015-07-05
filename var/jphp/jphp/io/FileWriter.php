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

JPHP::import('jphp.io.File');
JPHP::import('jphp.io.IWriter');
JPHP::import('jphp.util.StringBuffer');

class FileWriter extends IWriter
{
	var $file = NULL;
	var $handle = NULL;
	
	function FileWriter($file, $append = FALSE)
	{
		if (isset($file))
		{
         $file = new File($file);
			$this->handle = fopen($file->getFilePath(), ( $append==TRUE ? 'a' : 'w' ));
         $this->file = $file;
		}
	}
	
	function write($stream)
	{
		$stream = StringBuffer::toStringBuffer($stream);
		if ($this->ready())
		{
			@fputs($this->handle, $stream->toString());
		}
	}
   
   function println($stream)
	{
		$stream = StringBuffer::toStringBuffer($stream);
		$stream->append('\n');
		$this->write($stream);
	}
	
	function ready()
	{
		return (isset($this->file) && isset($this->handle));
	}
	
	function close()
	{
		if ($this->ready()==FALSE)
      {
         return;
      }
		@fclose($this->handle);
	}
   
   
   function writeToFile($file, $contents, $last_modified='0')
   {
      $file = new File($file);
      $handle = @fopen ($file->getFilePath(), "w"); 
      if (!empty ($handle)) 
      {
         fputs($handle, $contents, strlen($contents));
         fclose ($handle); 
         if ($last_modified>0)
         {
            touch($file->getFilePath(), $last_modified);
         }
         return TRUE;
      }
      return FALSE;
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'filewriter');
   }
   
}
?>