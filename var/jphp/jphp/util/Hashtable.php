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

JPHP::import("jphp.util.Dictionary");
JPHP::import("jphp.util.Enumeration");

class Hashtable extends Dictionary
{
	var $entries = array();
	
	function Hashtable() 
	{
		$this->entries = array();
	}
	
   /**
    *
    * @param string|core.StringBuffer
    * @param primitive|object
    * @access public
    */
	function put($key, $object) 
   {
      $this->set($key, $object);
   }
	
   /**
    *
    * @param string|core.StringBuffer
    * @param primitive|object
    * @access public
    */
	function set($key, $object) 
	{
      $key = StringBuffer::toStringBuffer($key);
      if (isset($key) && isset($object))
      {
   		$this->entries[$key->toString()] =  $object;
      }
	}
	
   function remove($key)
   {
      $key = StringBuffer::toStringBuffer($key);
      if (isset($key) && isset($this->entries[$key->toString()]))
      {
        $obj = $this->entries[$key->toString()];
        unset($this->entries[$key->toString()]);
        return $obj;
      }
		return NULL;
   }
   
	function get($key) 
	{
      $key = StringBuffer::toStringBuffer($key);
      if (isset($key) && isset($this->entries[$key->toString()]))
      {
         return $this->entries[$key->toString()];
      }
		return NULL;
	}
	
   function keys() 
	{
		$enum = new Enumeration();
		$enum->value = array_keys($this->entries);
		return $enum;
	}
	
   function elements()
	{
		$keys = $this->keys();
      $values = array();
      while($keys->hasMoreElements())
      {
         $k = $keys->nextElement();
         $values[] = $this->get($k);
      }
      return $values;
	}
	
   function size() 
	{
		return count(array_keys($this->entries));
	}
   
   function containsKey($key)
   {
      $key = StringBuffer::toStringBuffer($key);
      return isset($key) && isset($this->entries[$key->toString()]);
   }
   
   function contains($obj)
   {
      $keys = $this->keys();
      $values = array();
      while($keys->hasMoreElements())
      {
         $k = $keys->nextElement();
         $object = $this->get($k);
         if (is_object($obj) && is_object($object))
         {
            if ($object->equals($obj)) return TRUE;
         }
         else if (!is_object($obj) && !is_object($object))
         {
            if ($object==$obj) return TRUE;
         }
      }
      return FALSE;
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'hashtable');
   }
   
}
?>