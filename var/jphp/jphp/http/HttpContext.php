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

JPHP::import('jphp.http.interface.IHttpContext');
JPHP::import('jphp.util.Enumeration,jphp.util.StringBuffer');

class HttpContext extends IHttpContext
{
   var $path = '';
   var $name = '';
   
   function HttpContext($path='', $name='')
   {
      $this->path = $path;
      $this->name = $name;
   }
   
   /**
    * return the name of the current context
    * @return core.StringBuffer  the context name
    */
   function getContextName() 
   {
      return $this->name;
   }
   
   /**
    * return the name of the current context
    * @return core.StringBuffer  the context name
    */
   function setContextName($contextname) 
   {
      $this->name = $contextname;
   }
   
   function setPath($path)
   {
      $this->path = $path;
   }
   
   function getPath()
   {
      return $this->path;
   }
   
   /**
    * Get a value of a attribute
    * @param string|core.StringBuffer the attribute name
    * @return core.Object the value
    */
   function getAttribute($name)
   {
      $object = $this->loadObjectFromFile( $this->getObjectPath($name) );
      if (isset($object) && $object['name']===$name)
      {
         return $object['object'];
      }
      return NULL;
   }
   
   /**
    * Set a new attribute
    * @param string|core.StringBuffer the attribute name
    * @param core.Object the attribute value
    */
   function setAttribute($name, $object)
   {
      if (!empty($name) && !isset($object))
      {
         $this->removeAttrinute($name);
      }
      else if (!empty($name) && isset($object))
      {
         $path = $this->getObjectPath($name);
         $lock = $this->getObjectLockPath($name);
         $data = array();
         $data['name'] = $name;
         $data['object'] = $object;
         
         if (!file_exists($lock))
         {
            if ($this->acquireObjectLock($name))
            {
               $serialized = serialize($data);
               $file = fopen($path, 'w');
               if (!empty ($file)) 
               { 
                  fputs($file, $serialized, strlen($serialized));
                  fclose ($file); 
               }
               $this->freeObjectLock($name);
            }
            else die('cannot procced');
         }
      }
      return $object;
   }
   
   /**
    * Remove an attribute by name
    * @param string|core.StringBuffer the attribute name
    * @return core.Object the removed object
    */
   function removeAttribute($name)
   {
      if (file_exists($this->getObjectPath($name)) && !file_exists($this->getObjectLockPath($name)))
      {
         $object = $this->getAttribute($name);
         unlink($this->getObjectPath($name));
         return $object;
      }
      return NULL;
   }
   
   /**
    * returning and Enumeration of all attributes name in the current session
    * @return jphp.util.Enumeration enumeration of all attributes name
    */
   function getAttributeNames() 
   { 
      
      $keys = array();
      $contents = opendir( $this->path . $this->name );
      while ($file = readdir($contents)) 
      {
         if (preg_match('/('.preg_quote('.cache').')$/i', $file))
         {
            $object = $this->loadObjectFromFile($this->path . $this->name.'/'. $file);
            if (isset($object))
            {
               $keys[] = $object['name'];
            }
         }
      }
      
      $enum = new Enumeration();
		$enum->value = $keys;
		return $enum;
   }
   
   /**
    * remove all atributes from the current session
    */
   function clearAttributes()
   {
      $keys = $this->keys();
      foreach ($keys as $name)
      {
         $this->removeAttribute($name);
      }
   }
   
   /**
    * returning and Enumeration of all attributes name in the current session
    * @return jphp.util.Enumeration enumeration of all attributes name
    */
    function keys()
    {
      return $this->getAttributeNames();
    }
   /**
    * Get a value of a attribute
    * @param string|core.StringBuffer the attribute name
    * @return core.Object the value
    * @see #getAttribute
    */
   function get($property)
   {
      return $this->getAttribute($property);
   }
   
   /**
    * Set a new attribute
    * @param string|core.StringBuffer the attribute name
    * @param core.Object the attribute value
    * @see #setAttribute
    */
   function set($property, $value)
   {
      return $this->getAttribute($property, $value);
   }
   
   /**
    * Remove an attribute by name
    * @param string|core.StringBuffer the attribute name
    * @return core.Object the removed object
    * @see #removeAttribute
    */
   function remove($property)
   {
      return $this->removeAttribute($property);
   }
   
   
   function loadObjectFromFile($path)
   {
      $file = fopen ($path, "r"); 
      if (!empty ($file)) 
      { 
         $contents = fread ($file, filesize ($path)); 
         fclose ($file); 
         return unserialize($contents); 
      }
      return NULL;
   }
   
   function initialize()
   {
      $path = $this->path . $this->name;
      if (!file_exists($path))
      {
         if (!$this->createStructure($path))
         {
            die('I/O Exception : '.$path.' cannot be create ...');
         }
      }
      else if (!is_dir($path))
      {
         die('I/O Exception : '.$path.' exists and it\' a file ...');
      }
   }
   
   function createStructure($path)
   {
      $parts = preg_split('!\\/+!xsmi', $path, -1, PREG_SPLIT_NO_EMPTY);
      $struct = '';
      foreach( $parts as $part )
      {
         $struct .= $part;
         if ($struct!='.' && !file_exists($struct))
         {
            @mkdir($struct, $perms);
         }
         $struct .= '/';
      }
      return file_exists($path);
   }
   
   function getObjectPath($name)
   {
      $path = $this->path . $this->name;
      $path .= '/'.md5($name).'.cache';
      return $path;
   }
   
   function getObjectLockPath($name)
   {
      $path = $this->path . $this->name;
      $path .= '/'.md5($name).'.lock';
      return $path;
   }
   
   function acquireObjectLock($name)
   {
      if (!file_exists($this->getObjectLockPath($name)))
      {
         return touch($this->getObjectLockPath($name));
      }
      return FALSE;
   }
   
   function freeObjectLock($name)
   {
      @unlink($this->getObjectLockPath($name));
      return file_exists($this->getObjectLockPath($name));
   }
   
}
?>