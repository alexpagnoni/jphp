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

JPHP::import('jphp.io.IReader,jphp.io.File');
JPHP::import('jphp.net.URL');
JPHP::import('jphp.util.StringBuffer');

class FileReader extends IReader
{
	var $handle = NULL;
	var $file = NULL;
	function FileReader($file=NULL)
	{
		$fileobj = NULL;
		if (!isset($file)) 
      {
         return;
      }
		if (URL::validClass($file))
      {
         $fileobj = $file;
         $path = $fileobj->toString();
      }
      else if (File::validClass($file))
      {
         $fileobj = $file;
         $path = $fileobj->getFilePath();
      }
      else
		{
         $str = StringBuffer::toStringBuffer($file);
         if ( $str->startsWith('http://') || $str->startsWith('ftp://') || $str->startsWith('php://') )
         {
            $fileobj = new URL($str);
            $path = $fileobj->toString();
         }
         else
         {
   			$fileobj = new File($file);
            $path = $fileobj->getFilePath();
         }
		}
      if (isset($fileobj))
		{
         $this->handle = @fopen($path, 'r');
         if (isset($this->handle))
			{
            $this->file = $fileobj;
			}
		}
	}
	
	function ready()
	{
		return (isset($this->file) && isset($this->handle));
	}
	
	function skip($count=1)
	{
		@settype($count, 'integer');
		if ($this->ready()==FALSE || $count<=0)
      {
         return;
      }
		return fseek($this->handle, $count, SEEK_CUR);
	}
	
	function read($length=1)
	{
		if ($this->ready()==FALSE)
      {
         return '';
      }
      return ( $length==1 ? fgetc($this->handle) : fread($this->handle, $length) );
	}
	
	function readLine()
	{
		if ($this->ready()==FALSE)
      {
         return '';
      }
		return fgets($this->handle, 4096);
	}
	
	function reset()
	{
		if ($this->ready()==FALSE)
      {
         return;
      }
		@rewind($this->handle);
	}
	
	function close()
	{
		if ($this->ready()==FALSE)
      {
         return;
      }
		@fclose($this->handle);
	}
	
	function isEOF()
	{
		return feof($this->handle);
	}
	
	function cursorPosition()
	{
		if ($this->ready()==FALSE)  
      {
         return -1;
      }
		return ftell($this->handle);
	}
   
   // static function to read direct all file content
   function readFileContent($file)
   {
      $file = new File($file);
      
      if ($file->exists())
      {
         $handle = @fopen($file->getFilePath(), "r"); 
         if (!empty($handle)) 
         {
            $contents = fread ($handle, filesize ($file->getFilePath())); 
            fclose ($handle); 
            return $contents;
         }
      }
      return NULL;
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'filereader');
   }
}
?>