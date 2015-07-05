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

JPHP::import('jphp.http.interface.IHttpSession');
JPHP::import('jphp.util.StringBuffer');

class HttpSession extends IHttpSession
{
   var $path = '';
   var $sessionID = NULL;
   
   var $isNewSession = FALSE;
   
   var $creationTime = '';
   var $lastAccessedTime = '';
   var $maxInactiveInterval = '';
   var $cache = NULL;
   
   function HttpSession($path='', $sessionID='', $maxInactiveInterval=1800)
   {
      $this->path = $path;
      $maxInactiveInterval = (integer)$maxInactiveInterval;
      $this->maxInactiveInterval = $maxInactiveInterval>0 ? $maxInactiveInterval : 1800 ;
      $this->sessionID = $sessionID;
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
    * Get the current session id
    * @return core.StringBuffer  session id
    */
   function getId() 
   { 
      return $this->sessionID; 
   }
   
   /**
    * Get the current session id
    * @return core.StringBuffer  session id
    */
   function setId($id) 
   { 
      $this->sessionID = $id; 
   }
   
   /**
    * Get a value of a attribute
    * @param string|core.StringBuffer the attribute name
    * @return core.Object the value
    */
   function getAttribute($name)
   {
      return isset($this->cache[$name]) ? $this->cache[$name] : NULL ;
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
         $this->cache[$name] = $object;
         $this->saveSessionObject();
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
      if (!empty($name) && isset($this->cache[$name]))
      {
         $object = $this->cache[$name];
         unset($this->cache[$name]);
         $this->saveSessionObject();
      }
      return NULL;
   }
   
   /**
    * remove all atributes from the current session
    */
   function clearAttributes()
   {
      $this->cache = array();
      $this->saveSessionObject();
   }
   
   /**
    * returning and Enumeration of all attributes name in the current session
    * @return jphp.util.Enumeration enumeration of all attributes name
    */
   function getAttributeNames()
   {
      if ($this->isValidSession==FALSE || !isset($this->sessionID)) die('Session no longer valid');
      $enum = new Enumeration();
		$enum->value = array_keys($this->cache);
		return $enum;
   }
   
   /**
    * Returns the time when this session was created in second since midnight 1er January 1970 GTM
    */
   function getCreationTime() 
   {  
      if ($this->isValidSession==FALSE || !isset($this->sessionID)) die('Session no longer valid');
      return $this->creationTime; 
   }
   
   /**
    * return time of the last activitity that occur to the session in second since 1er January 1970 GTM
    */
   function getLastAccessedTime() 
   { 
      if ($this->isValidSession==FALSE || !isset($this->sessionID)) die('Session no longer valid');
      return $this->lastAccessedTime; 
   }
   
   /**
    * return the max interval time between request before the session close if there are no activities
    */
   function getMaxInactiveInterval() 
   { 
      return $this->maxInactiveInterval; 
   }
   
   /**
    * set the max interval time between request before the session close 
    */
   function setMaxInactiveInterval($interval) 
   {
      $this->maxInactiveInterval = (int)$interval;
   }
   
   /**
    * end current session
    */
   function invalidate()
   {
      // end session
      @unlink($this->path.$this->sessionID.'.cache');
   }
   
   /**
    * return true if it's the first time connection
    * @return boolean TRUE if it's the first time connection
    */
   function isNew() 
   { 
      return $this->isNewSession; 
   }
   
   /**
    * count attributes
    */
   function size() 
   { 
      return count($this->getAttributeNames()); 
   }
   
   /**
    * end current session
    * @see #invalidate
    */
   function endSession()
   {
      $this->invalidate();
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
   
   /**
    * load session from file
    */
   function loadSessionObject()
   {
      $filename = $this->path . $this->sessionID . '.cache';
      $file = @fopen( $filename , "r"); 
      if (!empty ($file)) 
      { 
         $contents = fread ($file, filesize( $filename ) ); 
         fclose ($file); 
         $object = unserialize($contents);
         $this->creationTime = $object['creation_time'];
         $this->lastAccessedTime = $object['last_accessed_time'];
         $this->maxInactiveInterval = $object['max_inactive_interval'];
         $this->cache = $object['data'];
         
         $now = time();
         $inter = $now - $object['last_accessed_time'];
         if ($this->maxInactiveInterval>0 && $inter>$this->maxInactiveInterval)
         {
            unlink($filename);
            return FALSE;
         }
         return TRUE;
      }
      return FALSE;
   }
   
   /**
    * save session data to file
    */
   function saveSessionObject()
   {
      // register that file has been modified
      $this->lastAccessedTime = time();
      $object = array();
      $object['creation_time'] = $this->creationTime;
      $object['last_accessed_time'] = $this->lastAccessedTime;
      $object['max_inactive_interval'] = $this->maxInactiveInterval;
      $object['data'] = $this->cache;
      
      $serialized = serialize($object);
      $path = $this->path;
      if ($path[strlen($path)-1]!=='/')
      {
         $path .= '/';
      }
      $filename = $path . $this->sessionID . '.cache';
      $file = fopen( $filename , 'w');
      if (!empty ($file)) 
      { 
         fputs($file, $serialized, strlen($serialized));
         fclose ($file); 
      }
      else
      {
         die('<strong>failed to save</strong>');
      }
   }
   
   // verify that session can be store 
   function initialize()
   {
      // path existance
      if (!file_exists($this->path))
      {
         if (!$this->createStructure($this->path))
         {
            die('I/O Exception : '.$this->path.' cannot be create ...');
         }
      }
      else if (!is_dir($this->path))
      {
         die('I/O Exception : '.$this->path.' exists and it\' a file ...');
      }
      // load session object
      if (isset($this->sessionID))
      {
         if (!file_exists($this->path.$this->sessionID.'.cache'))
         {
            $this->cache = array();
            $this->creationTime = time();
            $this->lastAccessedTime = $this->creationTime;
            $this->isNewSession = TRUE;
            $this->saveSessionObject();
         }
         else
         {
            if (!$this->loadSessionObject())
            {
               $this->sessionID =  md5(StringBuffer::generateKey(16));
               $this->cache = array();
               $this->creationTime = time();
               $this->lastAccessedTime = $this->creationTime;
               $this->isNewSession = TRUE;
               $this->saveSessionObject();
            }
         }
      }
   }
   
   // create directory structure
   function createStructure($path)
   {
      $parts = preg_split('!\\/+!xsmi', $path, -1, PREG_SPLIT_NO_EMPTY);
      $struct = '';
      foreach( $parts as $part )
      {
         $struct .= $part;
         if ($struct!='.' && !file_exists($struct))
         {
            @mkdir($struct, 0755);
         }
         $struct .= '/';
      }
      return file_exists($path);
   }
}
?>