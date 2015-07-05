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

class IHttpSession extends Object
{
   /**
    * Get the current session id
    * @return core.StringBuffer  session id
    */
   function getId() { return NULL; }
   
   function setId($id) {  }
   
   /**
    * Get the current session id
    * @return core.StringBuffer  session id
    */
   function getSessionID() { return $this->getId(); }
   
   function setSessionID($id) { $this->setId($id); }
   
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
    * remove all atributes from the current session
    */
   function clearAttributes(){ }
   
   /**
    * returning and Enumeration of all attributes name in the current session
    * @return jphp.util.Enumeration enumeration of all attributes name
    */
   function getAttributeNames() { return NULL; }
   
   /**
    * Returns the time when this session was created in second since midnight 1er January 1970 GTM
    */
   function getCreationTime() {  return 0; }
   
   /**
    * return time of the last activitity that occur to the session in second since 1er January 1970 GTM
    */
   function getLastAccessedTime() { return 0; }
   
   /**
    * return the max interval time between request before the session close if there are no activities
    */
   function getMaxInactiveInterval() { return 0; }
   
   /**
    * set the max interval time between request before the session close 
    */
   function setMaxInactiveInterval($interval) {}
   /**
    * end current session
    */
   function invalidate() {}
   
   /**
    * return true if it's the first time connection
    * @return boolean TRUE if it's the first time connection
    */
   function isNew() { return FALSE; }
   
   /**
    * count attributes
    */
   function size() { return 0; }
   
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
   
}
?>