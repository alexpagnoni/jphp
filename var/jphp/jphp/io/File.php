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

JPHP::import('jphp.util.StringBuffer');

class File extends Object
{
	var $path  = NULL;
	var $separator = NULL;
	var $os = NULL;
	
	function File($path=NULL)
	{
		$this->separator = DIRECTORY_SEPARATOR;
		$this->os = getenv('OS');
		$this->setFilePath($path);
	}
	
	function setFilePath($path)
	{
      if (File::validClass($path))
      {
         $this->path  = $path->getFilePath();
      }
      else
      {
         $this->path = StringBuffer::validClass($path) ? $path->toString() : $path;
      }
	}
	
	function getFilePath()
	{
		return $this->path;
	}
	
	function getFileName()
	{
		return basename($this->getFilePath());
	}
	
	function getParentDirectory()
	{
		return dirname($this->getFilePath());
	}
	
	function getRealPath()
	{
		return realpath($this->getFilePath());
	}
	
	function exists()
	{
		return file_exists($this->getFilePath());
	}
	
	function isDirectory()
	{
      return is_dir($this->getFilePath());
	}
	
	function isFile()
	{
      return is_file($this->getFilePath());
	}
	
	function lists($filenameFilter=NULL)
	{
		$path = StringBuffer::toStringBuffer($this->getFilePath());
      if (!isset($path)) 
      {
         return array();
      }
		$filter = FilenameFilter::validClass($filenameFilter) ? $filenameFilter : new FilenameFilter();
		$files = array();
		$folders = array();
		if ($this->exists() && $this->isDirectory())
		{
			$path = $path->replace('/', DIRECTORY_SEPARATOR);
			if (!$path->endsWith(DIRECTORY_SEPARATOR)) 
         {
            $path->append(DIRECTORY_SEPARATOR);
         }
			$handle=opendir($path->toString());
			while ($file = readdir($handle)) 
			{
				$filename = new StringBuffer($file);
				if (!$filename->equals('.') && !$filename->equals('..'))
				{
					$filename->prepend($path);
					$validfile = new File($filename);
					if ($filter->accept($validfile, $validfile->getParentDirectory()))
					{
						if ($validfile->isFile())
                  {
                  	$files[] = $filename->toString();
                  }
						else if ($validfile->isDirectory())	
                  {
							$folders[] = $filename->toString();
                  }
					}
				}
			}
			closedir($handle);
		}
		return array_merge($folders,$files);
	}
	
	function listFiles($filenameFilter=NULL)
	{
		$path = StringBuffer::toStringBuffer($this->getFilePath());
		$s = NULL;
      if (!isset($path)) 
      {
         return array();
      }
		$filter = isset($filenameFilter) ? $filenameFilter : new FilenameFilter();
		$files = array();
		$folders = array();
		if ($this->exists() && $this->isDirectory())
		{
			$path = $path->replace('/', DIRECTORY_SEPARATOR);
			if (!$path->endsWith(DIRECTORY_SEPARATOR))
         {
            $path->append(DIRECTORY_SEPARATOR);
         }
			$handle=opendir($path->toString());
         while ($file = readdir($handle)) 
			{
            $filename = new StringBuffer($file);
				if (!$filename->equals('.') && !$filename->equals('..'))
				{
					$filename->prepend($path);
               $validfile = new File($filename);
               if ($filter->accept($validfile, $validfile->getParentDirectory()))
					{
                  if ($validfile->isFile())
                  {
							$files[] = $validfile;
                  }
						else if ($validfile->isDirectory())	
                  {
							$folders[] = $validfile;
                  }
					}
				}
			}
			closedir($handle);
		}
		return array_merge($folders,$files);
	}
	
	function length()
	{
		if (!$this->isFile()) 
      {
         return 0;
      }
		return filesize($this->getFilePath());
	}
	
   function lastModified()
   {
      return filemtime($this->getFilePath());
   }
   
   function lastAccessed()
   {
      return fileatime($this->getFilePath());
   }
   
   function setModification($time=NULL)
   {
      if (!$this->isFile())
      {
         return;
      }
		touch ( $this->getFilePath(), $time);
   }
   
	function isReadable()
	{
      if (!$this->isFile())
      {
         return FALSE;
      }
		return is_readable($this->getFilePath());
	}
	
	function isWriteable()
	{
		if (!$this->isFile())
      {
         return FALSE;
      }
		return is_writeable( $this->getFilePath() );
	}
	
	function toString()
   {
      return $this->getFilePath();
   }
   
   function copyTo($file, $only_if_inexist = FALSE)
   {
      if (File::validClass($file) && $this->exists())
      {
         if ($only_if_inexist==TRUE)
         {
            if ($file->exists()==FALSE)
            {
               return copy($this->getFilePath(), $file->getFilePath());
            }
         }
         else 
         {
            return copy($this->getFilePath(), $file->getFilePath());
         }
      }
      return FALSE;
   }
   
   function moveTo($file, $only_if_inexist = FALSE)
   {
      if (File::validClass($file) && $this->exists())
      {
         if ($only_if_inexist==TRUE)
         {
            if ($file->exists()==FALSE)
            {
               return rename($this->getFilePath(), $file->getFilePath());
            }
         }
         else 
         {
            return rename($this->getFilePath(), $file->getFilePath());
         }
      }
      return FALSE;
   }
   
   function mkdirs($perms)
   {
      $path = StringBuffer::toStringBuffer($this->getFilePath());
      if ($path->startsWith(".\\") || $path->startsWith("./"))
      {
         $path = $path->substring(2);
         $path = $path->toString();
      }
      else
      {
         $path = $this->toString();
      }
    
      $struct = preg_split('!\\/+!xsmi', $path, -1, PREG_SPLIT_NO_EMPTY);
      $part = '';
      $len = count($struct);
      for ($i=0; $i<$len; $i++)
      {
         $part .= $struct[$i];
         @mkdir($part, $perms);
         $part .= '/';
      }
      return $this->exists();
   }
   function validClass($object)
   {
      return Object::validClass($object, 'file');
   }
}
?>