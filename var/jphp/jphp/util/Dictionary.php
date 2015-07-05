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

class Dictionary extends Object
{
   /**
    * Get a value by key name
    *
    * @param string|core.StringBuffer a key name
    * @return objet the object mapped to the key
    * @access public
    */
	function get($key) { }
   
   /**
    * Map a value object to a key
    *
    * @param string|core.StringBuffer the key name
    * @param object  the object to be map
    * @access public
    */
	function put($key, $value) { }
	
   /**
    * Check if the dictionnary contains any pair of key/value
    *
    * @param string|core.StringBuffer the key name
    * @return boolean TRUE if the there no content
    * @access public
    */
	function isEmpty() { }
	
	/**
    * Remove and value object by a key name
    *
    * @param string|core.StringBuffer the key name
    * @return object the removed object 
    * @access public
    */
	function remove($key) { }
    
	/**
    * Get the number of entries in the dictionary object
    *
    * @return integer number of entries
    * @access public
    */
	function size() { }
   
   /**
    * Enumerate all keys entry in the dictionary
    *
    * @return jphp.util.Enumeration
    * @access public
    */
	function keys() { }
	
   /**
    * Get all value object element of the dictionary
    *
    * @return array  value objects
    * @access public
    */
	function elements() { }
	
   /**
    * Check if the dictionary contain and object mapped to a specific key
    * 
    * @param string|core.StringBuffer  a key name to search
    * @return boolean TRUE if the key was found
    * @access public
    */
	function containsKey($key) {}
   
   /**
    * Check if the dictionary contain the object. Object inserted to the dictionary
    * should overide Object->equals() to provide a way to compare object
    *
    * @param object the object to search
    * @return boolean TRUE if the object was foud
    * @access
    */
	function contains($obj) { }
   
   function validClass($object)
   {
      return Object::validClass($object, 'dictionary');
   }
   
}
?>