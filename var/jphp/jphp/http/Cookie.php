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


/*----------------------------------------------------------------------*\
 *                   Cookie class declaration                           *
\*----------------------------------------------------------------------*/
JPHP::import('jphp.util.StringBuffer');

class Cookie extends Object
{
   
   /*----------------------------------------------------------------------*\
    *                   Cookie constructor                                 *
   \*----------------------------------------------------------------------*/
   /**
    * create a new Cookie object
    * @param string|core.StringBuffer name of the cookie
    * @param string|core.StringBuffer the cookie value
    * @param integer expiration value
    * @param string|core.StringBuffer path restriction
    * @param string|core.StringBuffer domain restriction
    * @param boolean TRUE if it's  a secure cookie
    */
   function Cookie($name, $value=NULL, $expire = 0, $path='/', $domain=NULL, $secure=FALSE)
   {
      $this->setName($name);
      $this->setValue($value);
      $this->setMaxAge($value);
      $this->setPath($path);
      $this->setDomain($domain);
      $this->setSecure($secure);
   }
   
   /*----------------------------------------------------------------------*\
    *                   Cookie methods                                     *
   \*----------------------------------------------------------------------*/
   /**
    * set the cookie name
    * @param string|core.StringBuffer the cookie name
    */
   function setName($name)
   {
      $this->name = $name;
   }
   
   /**
    * get the cookie name
    * @return core.StringBuffer the cookie name
    */
   function getName()
   {
      return $this->name;
   }
   
   /**
    * set the cookie value
    * @param string|core.StringBuffer the cookie value
    */
   function setValue($value)
   {
      $this->value = $value;
   }
   
   /**
    * get the cookie value
    * @return string|core.StringBuffer the cookie value
    */
   function getValue()
   {
      return isset($this->value) ? $this->value : '';
   }
   
   /**
    * set the cookie expiration timeout
    * @param integer timeout value
    */
   function setMaxAge($expire)
   {
      settype($expire, 'integer');
      $this->expire = $expire;
   }
   
   /**
    * get the cookie expiration timeout
    * @return integer timeout value
    */
   function getMaxAge()
   {
      return $this->expire;
   }
   
   /**
    * set the cookie path restriction
    * @param string|core.StringBuffer the path restriction
    */
   function setPath($path)
   {
      $this->path = $path;
   }
   
   /**
    * get the cookie path restriction
    * @return string|core.StringBuffer the path restriction
    */
   function getPath()
   {
      return $this->path;
   }
   
   /**
    * set the cookie domain restriction
    * @param string|core.StringBuffer the domain restriction
    */
   function setDomain($domain)
   {
      $this->domain = $domain;
   }
   
   /**
    * get the cookie domain restriction
    * @param string|core.StringBuffer the domain restriction
    */
   function getDomain()
   {
      return $this->domain;
   }
   
   /**
    * set the cookie secure state
    * @param boolean TRUE if the cookie is secure
    */
   function setSecure($secure)
   {
      $this->secure = ($secure==TRUE?TRUE:FALSE);
   }
   
   /**
    * check if the cookie is secure
    * @param boolean TRUE if the cookie is secure
    */
   function isSecure()
   {
      return $this->secure;
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'cookie');
   }
   
   /*----------------------------------------------------------------------*\
    *                   Private member variables                           *
   \*----------------------------------------------------------------------*/
   var $name = NULL;
   var $value = NULL;
   var $expire = 0;
   var $path = '/';
   var $domain = NULL;
   var $secure = FALSE;
}
?>