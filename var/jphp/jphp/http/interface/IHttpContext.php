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

class IHttpContext extends Object
{
   /**
    * return the name of the current context
    * @return core.StringBuffer  the context name
    */
   function getContextName() {}
   
   /**
    * return the name of the current context
    * @return core.StringBuffer  the context name
    */
   function setContextName($contextname) {}
   
   /**
    * Get a value of a attribute
    * @param string|core.StringBuffer the attribute name
    * @return core.Object the value
    */
   function getAttribute($property) { return NULL; }
   
   /**
    * Set a new attribute
    * @param string|core.StringBuffer the attribute name
    * @param core.Object the attribute value
    */
   function setAttribute($property, $value) {}
   
   /**
    * Remove an attribute by name
    * @param string|core.StringBuffer the attribute name
    * @return core.Object the removed object
    */
   function removeAttribute($property){ return NULL; }
   
   /**
    * returning and Enumeration of all attributes name in the current session
    * @return jphp.util.Enumeration enumeration of all attributes name
    */
   function getAttributeNames() { return NULL; }
   
   /**
    * remove all atributes from the current session
    */
   function clearAttributes(){ }
   
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
    * rerturn the real path for a given virtual path.
    * @param string|core.StringBuffer  the virtual path
    * @return core.StringBuffer the real path
    */
   function getRealPath($path) { return NULL; }
   
   /**
    * write a message to a log
    * @param string|core.StringBuffer  the message
    */
   function log($msg) {}
   
   
   /* maybe will be implement later
    function getInitParameter($name)  {}
    function getInitParameterNames()
   */
}
?>