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

JPHP::import('jphp.net.URL');
JPHP::import('jphp.util.Enumeration');
JPHP::import('jphp.util.Arrays');

class ServletConfig extends Object
{
   var $displayname = '';
   var $datasources = NULL;
   var $contexts = NULL;
   var $sessions = NULL;
   var $request = NULL;
   var $response = NULL;
   
   var $securities = NULL;
   var $logins = NULL;
   
   function ServletConfig()
   {
      $this->datasources = array();
      $this->contexts = array();
      $this->sessions = array();
      $this->securities = array();
      $this->request = array();
      $this->response = array();
      $this->logins = array();
   }
   
   /**
    * CONTEXT
    */
   function getDisplayName()
   {
      return $this->displayname;
   }
   
   function setDisplayName($name)
   {
      $this->displayname = $name;
   }
   
   function getContextName()
   {
      if (Arrays::validClass($this->contexts) && isset($this->contexts['name']))
      {
         return $this->contexts['name'];
      }
   }
   
   function getContextManager()
   {
      return $this->contexts['class-manager']['package'];
   }
   
   function getContextManagerProperties()
   {
      return $this->contexts['class-manager']['class-properties'];
   }
   
   function getContextManagerProperty($name)
   {
      return isset($this->contexts['class-manager']['class-properties'][$name]) ? $this->contexts['class-manager']['class-properties'][$name] : '';
   }
   
   function getContextManagerPropertyNames()
   {
      $enum = new Enumeration();
      if (Arrays::validClass($this->contexts) && Arrays::validClass($this->contexts['class-manager']['class-properties']))
      {
   		$enum->value = array_keys($this->contexts['class-manager']['class-properties']);
      }
      return $enum;
   }
   
   function setContextName($name)
   {
      if (Arrays::validClass($this->contexts))
      {
         $this->contexts['name'] = $name;
      }
   }
   
   function getContextAttributeNames()
   {
      $enum = new Enumeration();
      if (Arrays::validClass($this->contexts) && Arrays::validClass($this->contexts['context-param']))
      {
         $enum->value = array_keys($this->contexts['context-param']);
      }
      return $enum;
   }
   
   function getContextAttribute($name)
   {
      if (Arrays::validClass($this->contexts) && Arrays::validClass($this->contexts['context-param']))
      {
         if (isset($this->contexts['context-param'][$name]))
         {
            return $this->contexts['context-param'][$name];
         }
      }
      return NULL;
   }
   
   function setContextAttribute($name, $value)
   {
      if (Arrays::validClass($this->contexts) && !empty($name) && isset($value))
      {
         if (!isset($this->contexts['context-param']) || !Arrays::validClass($this->contexts['context-param']))
         {
            $this->contexts['context-param'] = array();
         }
         $this->contexts['context-param'][$name] = $value;
      }
   }
   
   /**
    * DATASOURCE
    */
   function getDataSourceURL($name, $userprofile='anonymous')
   {
      if (Arrays::validClass($this->datasources[$name]))
      {
         $database_drivers = isset($this->datasources[$name]['driver']) ? $this->datasources[$name]['driver']: '';
         $database_host = isset($this->datasources[$name]['host']) ? $this->datasources[$name]['host']: '';
         $database_name = isset($this->datasources[$name]['database-name']) ? $this->datasources[$name]['database-name']: '';
         
         if ($database_host!='' && $database_name!='')
         {
            if (  Arrays::validClass($this->datasources[$name]['user-profile']) 
                  && isset($this->datasources[$name]['user-profile'][$userprofile]))
            {
               $user = isset($this->datasources[$name]['user-profile'][$userprofile]['login']) ? $this->datasources[$name]['user-profile'][$userprofile]['login'] : '';
               $password = isset($this->datasources[$name]['user-profile'][$userprofile]['password']) ? $this->datasources[$name]['user-profile'][$userprofile]['password'] : '';
               
               $url = $database_drivers.'://'.$user.':'.$password.'@'.$database_host.'/'.$database_name;
               return new URL($url);
            }
         }
      }
      return NULL;
   }
   
   function getDataSourceUsers($name)
   {
      $enum = new Enumeration();
      if (Arrays::validClass($this->datasources[$name]) && Arrays::validClass($this->datasources[$name]['user-profile']))
      {
         $enum->value = array_keys($this->datasources[$name]['user-profile']);
      }
      return $enum;
   }
   
   function getDataSourceNames()
   {
      $enum = new Enumeration();
      if (Arrays::validClass($this->datasources))
      {
         $enum->value = array_keys($this->datasources);
      }
      return $enum;
   }
   
   /**
    * SESSION
    */
   function getSessionTimeout()
   {
      if (Arrays::validClass($this->sessions))
      {
         if (isset($this->sessions['timeout']))
         {
            return $this->sessions['timeout'];
         }
      }
      return 0;
   }
   
   function setSessionTimeout($timeout)
   {
      if (Arrays::validClass($this->sessions))
      {
         $this->sessions['timeout'] = (int)$timeout;
      }
      return 0;
   }
   
   function getSessionManager()
   {
      return $this->sessions['class-manager']['package'];
   }
   
   function getSessionManagerProperties()
   {
      return $this->sessions['class-manager']['class-properties'];
   }
   
   function getSessionManagerProperty($name)
   {
      return isset($this->sessions['class-manager']['class-properties'][$name]) ? $this->sessions['class-manager']['class-properties'][$name] : '';
   }
   
   function getSessionManagerPropertyNames()
   {
      $enum = new Enumeration();
      if (isset($this->sessions['class-manager']['class-properties']) && Arrays::validClass($this->sessions))
      {
         $enum->value = array_keys($this->sessions['class-manager']['class-properties']);
      }
      return $enum;
   }
   
   /**
    * SECURITY CONSTRAIN
    */
   function getResources()
   {
      return $this->securities;
   }
   
   function getRessourcesMethod($i)
   {
      return ($i<count($this->securities) && isset($this->securities[$i]['auth-method']))? $this->securities[$i]['auth-method'] : NULL;
   }
   function getResource($i)
   {
      return $i<count($this->securities) ? $this->securities[$i] : array();
   }
   
   function getResourceName($i)
   {
      return ($i<count($this->securities) && isset($this->securities[$i]['resource-name']))? $this->securities[$i]['resource-name'] : NULL;
   }
   
   function getResourceURLPattern($i)
   {
      return ($i<count($this->securities) && isset($this->securities[$i]['url-pattern']))? $this->securities[$i]['url-pattern'] : NULL;
   }
   
   function protectPostOnResource($i)
   {
      return ($i<count($this->securities) && isset($this->securities[$i]['http-method']['POST']))? $this->securities[$i]['http-method']['POST'] : NULL;
   }
   
   function protectGetOnResource($i)
   {
      return ($i<count($this->securities) && isset($this->securities[$i]['http-method']['GET']))? $this->securities[$i]['http-method']['GET'] : NULL;
   }
   /**
    * AUHTENTICATION
    */
   function getAuthenticatorManagerNames()
   {
      $enum = new Enumeration();
      if (Arrays::validClass($this->logins))
      {
         $enum->value = array_keys($this->logins);
      }
      return $enum;
   }
   
   function getAuthenticatorManager($method_name)
   {
      if (isset($this->logins[$method_name]) && isset($this->logins[$method_name]['use-class']))
      {
         return $this->logins[$method_name]['use-class'];
      }
      return NULL;
   }
   
   function getAuthenticatorProperties($method_name)
   {
      return $this->logins[$method_name]['class-properties'];
   }
   
   function getAuthenticatorProperty($method_name, $name)
   {
      return isset($this->logins[$method_name]['class-properties'][$name]) ? $this->logins[$method_name]['class-properties'][$name] : '';
   }
   
   function getAuthenticatorPropertyNames($method_name)
   {
      $enum = new Enumeration();
      if (isset($this->logins[$method_name]['class-properties']) && Arrays::validClass($this->logins[$method_name]['class-properties']))
      {
         $enum->value = array_keys($this->logins[$method_name]['class-properties']);
      }
      return $enum;
   }
   
   /**
    * REQUEST
    */
   function getRequestManager()
   {
      return $this->request['class-manager']['package'];
   }
   
   function getRequestManagerProperties()
   {
      return $this->request['class-manager']['class-properties'];
   }
   
   function getRequestManagerProperty($name)
   {
      return isset($this->request['class-manager']['class-properties'][$name]) ? $this->request['class-manager']['class-properties'][$name] : '';
   }
   
   function getRequestManagerPropertyNames()
   {
      $enum = new Enumeration();
      if (isset($this->request['class-manager']['class-properties']) && Arrays::validClass($this->request['class-manager']['class-properties']))
      {
         $enum->value = array_keys($this->request['class-manager']['class-properties']);
      }
      return $enum;
   }
   /**
    * RESPONSE
    */
   function getResponseManager()
   {
      return $this->response['class-manager']['package'];
   }
   
   function getResponseManagerProperties()
   {
      return $this->response['class-manager']['class-properties'];
   }
   
   function getResponseManagerProperty($name)
   {
      return isset($this->response['class-manager']['class-properties'][$name]) ? $this->response['class-manager']['class-properties'][$name] : '';
   }
   
   function getResponseManagerPropertyNames()
   {
      $enum = new Enumeration();
      if (isset($this->response['class-manager']['class-properties']) && Arrays::validClass($this->response['class-manager']['class-properties']))
      {
         $enum->value = array_keys($this->response['class-manager']['class-properties']);
      }
      return $enum;
   }
}
?>