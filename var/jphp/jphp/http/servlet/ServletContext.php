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
JPHP::import('jphp.http.servlet.ServletXMLConfigReader');
JPHP::import('jphp.http.servlet.ServletConfig');
JPHP::import('jphp.io.File,jphp.io.FileReader,jphp.io.FileWriter');

class ServletContext extends IHttpContext
{
   var $config = NULL;
   var $file = NULL;
   
   var $request = NULL;
   var $response = NULL;
   var $session = NULL;
   var $context = NULL;
   
   var $default_context_manager = 'jphp.http.servlet.HttpServletContext';
   var $default_session_manager = 'jphp.http.servlet.HttpServletSession';
   var $default_request_manager = 'jphp.http.servlet.HttpServletRequest';
   var $default_response_manager = 'jphp.http.servlet.HttpServletResponse';
   
   function ServletContext($web_xml_file)
   {
      $web_xml_file = new File($web_xml_file);
      if (File::validClass($web_xml_file) && $web_xml_file->exists())
      {
         $this->file =& $web_xml_file;
         $cache_file = new File($web_xml_file->getFilePath().'cached');
         $valid_cache = FALSE;
         if ($cache_file->exists() && $web_xml_file->lastModified()==$cache_file->lastModified())
         {
            $this->config = @unserialize(FileReader::readFileContent($cache_file)); 
            if (ServletContext::validClass($this->config))
            {
               $valid_cache = TRUE;
            }
         }
         if (!$valid_cache)
         {
            $this->config =& ServletXMLConfigReader::readXMLConfig(new FileReader($web_xml_file));
            FileWriter::writeToFile($cache_file, serialize($this->config), $web_xml_file->lastModified());
         }
      }
      if (isset($this->config))
      {
         $this->initServletContext();
      }
   }
   
   function getDisplayName()
   {
      return $this->config->getDisplayName();
   }
   
   function & getServletConfig()
   {
      return $this->config;
   }
   
   function initServletContext()
   {
      $this->initContext();
      $this->initRequest();
      $this->initResponse();
      $this->initSession();
      $this->initSecurity();
   }
   
   function initSecurity()
   {
      for($i=0; $i<count($this->config->getResources()); $i++)
      {
         $name = $this->config->getResourceName($i);
         $pattern = $this->config->getResourceURLPattern($i);
         $method = $this->config->getRessourcesMethod($i);
         $class = $this->config->getAuthenticatorManager($method);
         if (isset($class))
         {
            $authen = JPHP::loadClass($class, array($name, $pattern, &$this->request, &$this->response));
            $properties = $this->config->getAuthenticatorPropertyNames($method);
            while($properties->hasMoreElements())
            {
               $property = $properties->nextElement();
               $value = $this->config->getAuthenticatorProperty($method, $property);
               eval('$authen->set'.ucfirst($property).'("'.$value.'");');
            }
            $current_script = $this->request->getScriptName();
            $script_name = basename($current_script);
            $script_base = dirname($current_script);
            if ($current_script==$pattern || $script_base===$pattern || ($script_base.'/')===$pattern)
            {
               $authen->authenticate();
            }
         }
      }
   }
   
   function initContext()
   {
      $class = trim($this->config->getContextManager());
      if ($class==='')
      {
         $class = $this->default_context_manager;
      }
      $this->context = JPHP::loadClass($class, array(&$this));
      if (IHttpContext::validClass($this->context))
      {
         $this->context->setContextName($this->getContextName());
         $names = $this->config->getContextManagerPropertyNames();
         while($names->hasMoreElements())
         {
            $name = $names->nextElement();
            $value = $this->config->getContextManagerProperty($name);
            eval('$this->context->set'.ucfirst($name).'("'.$value.'");');
         }
         $this->context->initialize();
         $names = $this->config->getContextAttributeNames();
         while($names->hasMoreElements())
         {
            $name = $names->nextElement();
            $value = $this->config->getContextAttribute($name);
            $this->context->setAttribute($name, $value);
         }
      }
   }
   
   function initSession()
   {
      $class = trim($this->config->getSessionManager());
      if ($class==='')
      {
         $class = $this->default_session_manager;
      }
      $this->session = JPHP::loadClass($class, array(&$this));
      if (IHttpContext::validClass($this->context))
      {
         $this->session->setMaxInactiveInterval($this->config->getSessionTimeout());
         $names = $this->config->getSessionManagerPropertyNames();
         while($names->hasMoreElements())
         {
            $name = $names->nextElement();
            $value = $this->config->getSessionManagerProperty($name);
            eval('$this->session->set'.ucfirst($name).'("'.$value.'");');
         }
      }
   }
   
   function initResponse()
   {
      $class = trim($this->config->getResponseManager());
      if ($class==='')
      {
         $class = $this->default_response_manager;
      }
      $this->response = JPHP::loadClass($class, array(&$this));
      if (IHttpResponse::validClass($this->response))
      {
         $names = $this->config->getResponseManagerPropertyNames();
         while($names->hasMoreElements())
         {
            $name = $names->nextElement();
            $value = $this->config->getResponseManagerProperty($name);
            eval('$this->response->set'.ucfirst($name).'("'.$value.'");');
         }
      }
   }
   
   function initRequest()
   {
      $class = trim($this->config->getRequestManager());
      if ($class==='')
      {
         $class = $this->default_request_manager;
      }
      $this->request = JPHP::loadClass($class, array(&$this));
      if (IHttpRequest::validClass($this->request))
      {
         $names = $this->config->getRequestManagerPropertyNames();
         while($names->hasMoreElements())
         {
            $name = $names->nextElement();
            $value = $this->config->getRequestManagerProperty($name);
            eval('$this->request->set'.ucfirst($name).'("'.$value.'");');
         }
      }
   }
   
   function & getServletRequest()
   {
      return $this->request;
   }
   
   function & getServletResponse()
   {
      return $this->response;
   }
   
   function & getServletSession()
   {
      return $this->session;
   }
   
   /**
    * return the name of the current context
    * @return core.StringBuffer  the context name
    */
   function getContextName() 
   {
      return isset($this->config) ? $this->config->getContextName() : NULL;
   }
   
   /**
    * Get a value of a attribute
    * @param string|core.StringBuffer the attribute name
    * @return core.Object the value
    */
   function getAttribute($property) 
   { 
      return isset($this->context) ? $this->context->getAttribute($property) : NULL; 
   }
   
   /**
    * Set a new attribute
    * @param string|core.StringBuffer the attribute name
    * @param core.Object the attribute value
    */
   function setAttribute($property, $value) 
   {
      if (isset($this->context))
      {
         $this->context->setAttribute($property, $value);
      }
   }
   
   /**
    * Remove an attribute by name
    * @param string|core.StringBuffer the attribute name
    * @return core.Object the removed object
    */
   function removeAttribute($property)
   { 
      return isset($this->context) ? $this->context->removeAttribute($property) : NULL; 
   }
   
   /**
    * returning and Enumeration of all attributes name in the current session
    * @return jphp.util.Enumeration enumeration of all attributes name
    */
   function getAttributeNames() 
   { 
      return isset($this->context) ? $this->context->getAttributeNames() : NULL; 
   }
   
   /**
    * remove all atributes from the current session
    */
   function clearAttributes()
   { 
      if (isset($this->context))
      {
         $this->context->clearAttributes();
      }
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