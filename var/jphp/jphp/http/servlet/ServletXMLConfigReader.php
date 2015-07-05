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

JPHP::import('jphp.xml.AbstractSAXParser');
JPHP::import('jphp.io.IReader');
JPHP::import('jphp.http.servlet.ServletConfig');

class ServletXMLConfigReader extends AbstractSAXParser
{
   var $reader = NULL;
   var $config = NULL;
   var $level = 0;
   var $accept = FALSE;
   var $stack = NULL;
   var $text = '';
   
   var $current_dbc_id = '';
   var $current_dbc_profile = '';
   var $current_login_profile = '';
   var $context_param_name = '';
   var $context_param_value = '';
   
   var $context_class_property = '';
   var $session_class_property = '';
   var $request_class_property = '';
   var $response_class_property = '';
   var $resource_count = 0;
   
   function ServletXMLConfigReader()
   {
      parent::AbstractSAXParser();
      $this->stack = array();
      $this->config = new ServletConfig();
   }
   
   function setReader(&$reader)
   {
      if (IReader::validClass($reader))
      {
         $this->reader =& $reader;
      }
   }
   
   function & getReader()
   {
      return $this->reader;
   }
   
   function readXMLConfig(&$reader)
   {
      static $xmlreader;
      if (!isset($xmlreader))
      {
         $xmlreader =& new ServletXMLConfigReader();
      }
      $xmlreader->setReader($reader);
      
      $document = $xmlreader->parseDocument();
      $xmlreader->close();
      return $document;
   }
   
   function parseDocument()
   {
      if (isset($this->reader) && $this->reader->ready())
      {
         $data = '';
         while(($data=$this->reader->read(4096))!='')
         {
            $this->parse($data);
         }
         if (isset($this->document))
         {
            return $this->document;
         }
      }
      return $this->config;
   }
   
   // event handler : start tag element
   function startTagElement(&$parserHandle, $elementName, $attributes)
   {
      if ($this->accept)
      {
         $this->attributes = $attributes;
         $this->stack[] = $elementName;
         $tree = implode('.', $this->stack);
         if ($tree==='datasource' && isset($attributes['id']))
         {
            $this->current_dbc_id = $attributes['id'];
            $this->config->datasources[$this->current_dbc_id] = array();
            $this->config->datasources[$this->current_dbc_id]['driver'] = '';
            $this->config->datasources[$this->current_dbc_id]['host'] = '';
            $this->config->datasources[$this->current_dbc_id]['database-name'] = '';
            $this->config->datasources[$this->current_dbc_id]['user-profile'] = array();
         }
         else if ($tree==='context.class-manager' && isset($attributes['package']))
         {
            $this->config->contexts['class-manager'] = array();
            $this->config->contexts['class-manager']['package'] = $attributes['package'];
            $this->config->contexts['class-manager']['class-properties'] = array();
         }
         else if ($tree==='context.class-manager.class-property' && isset($attributes['name']))
         {
            $this->context_class_property = $attributes['name'];
         }
         else if ($tree==='session.class-manager' && isset($attributes['package']))
         {
            $this->config->sessions['class-manager'] = array();
            $this->config->sessions['class-manager']['package'] = $attributes['package'];
            $this->config->sessions['class-manager']['class-properties'] = array();
         }
         else if ($tree==='session.class-manager.class-property' && isset($attributes['name']))
         {
            $this->session_class_property = $attributes['name'];
         }
         else if ($tree==='request.class-manager' && isset($attributes['package']))
         {
            $this->config->request['class-manager'] = array();
            $this->config->request['class-manager']['package'] = $attributes['package'];
            $this->config->request['class-manager']['class-properties'] = array();
         }
         else if ($tree==='request.class-manager.class-property' && isset($attributes['name']))
         {
            $this->request_class_property = $attributes['name'];
         }
         else if ($tree==='response.class-manager' && isset($attributes['package']))
         {
            $this->config->response['class-manager'] = array();
            $this->config->response['class-manager']['package'] = $attributes['package'];
            $this->config->response['class-manager']['class-properties'] = array();
         }
         else if ($tree==='response.class-manager.class-property' && isset($attributes['name']))
         {
            $this->response_class_property = $attributes['name'];
         }
         else if ($tree==='datasource.user-profile' && isset($attributes['name']))
         {
            $this->current_dbc_profile = $attributes['name'];
            $this->config->datasources[$this->current_dbc_id]['user-profile'][$this->current_dbc_profile] = array();
         }
         else if ($tree==='security-constraint.resource' && isset($attributes['auth-method']))
         {
            $this->config->securities[$this->resource_count] = array();
            $this->config->securities[$this->resource_count]['auth-method'] = $attributes['auth-method'];
         }
         else if ($tree==='security-constraint.resource.http-method')
         {
            $this->config->securities[$this->resource_count]['http-method'] = array();
            $this->config->securities[$this->resource_count]['http-method']['GET'] = FALSE;
            $this->config->securities[$this->resource_count]['http-method']['POST'] = FALSE;
            if (isset($attributes['GET']) && ($attributes['GET']==='true' || $attributes['GET']==='TRUE'))
            {
               $this->config->securities[$this->resource_count]['http-method']['GET'] = TRUE;
            }
            if (isset($attributes['POST']) && ($attributes['POST']==='true' || $attributes['POST']==='TRUE'))
            {
               $this->config->securities[$this->resource_count]['http-method']['POST'] = TRUE;
            }
         }
         else if ($tree==='login-config' && isset($attributes['auth-method']))
         {
            $this->current_login_profile = $attributes['auth-method'];
            $this->config->logins[$this->current_login_profile] = array();
         }
         else if ($tree==='login-config.authenticator' && isset($attributes['use-class']))
         {
            $this->config->logins[$this->current_login_profile]['use-class'] = $attributes['use-class'];
            $this->config->logins[$this->current_login_profile]['class-properties'] = array();
            $this->current_property_name = '';
         }
         else if ($tree==='login-config.authenticator.class-property' && isset($attributes['name']))
         {
            $this->current_property_name = $attributes['name'];
         }
      }
      else
      {
         if ($elementName==='web-app')
         {
            $this->accept = TRUE;
         }
      }
   }
   
   // event handler : end tag element
   function endTagElement(&$parserHandle, $elementName)
   {
      if ($this->accept)
      {
         $tree = implode('.', $this->stack);
         if ($tree==='display-name')
         {
            $this->config->displayname = $this->text;
         }
         else if ($tree==='datasource.driver' && $this->current_dbc_id!='')
         {
           $this->config->datasources[$this->current_dbc_id]['driver'] = $this->text;
         }
         else if ($tree==='datasource.host' && $this->current_dbc_id!='')
         {
           $this->config->datasources[$this->current_dbc_id]['host'] = $this->text;
         }
         else if ($tree==='datasource.database-name')
         {
            $this->config->datasources[$this->current_dbc_id]['database-name'] = $this->text;
         }
         else if ($tree==='datasource')
         {
            $this->current_driver = '';
         }
         else if ($tree==='datasource.user-profile.login')
         {
            $this->config->datasources[$this->current_dbc_id]['user-profile'][$this->current_dbc_profile]['login'] = $this->text;
         }
         else if ($tree==='datasource.user-profile.password')
         {
            $this->config->datasources[$this->current_dbc_id]['user-profile'][$this->current_dbc_profile]['password'] = $this->text;
         }
         else if ($tree==='datasource.user-profile')
         {
            $this->current_dbc_profile = '';
         }
         else if ($tree==='context.class-manager.class-property' && $this->context_class_property!='')
         {
            $this->config->contexts['class-manager']['class-properties'][$this->context_class_property] = $this->text;
            $this->context_class_property='';
         }
         else if ($tree==='context.context-param')
         {
            $this->config->setContextAttribute($this->context_param_name, $this->context_param_value);
            $this->context_param_name = '';
            $this->context_param_value = '';
         }
         else if ($tree==='context.context-param.name')
         {
            $this->context_param_name = $this->text;
         }
         else if ($tree==='context.context-param.value')
         {
            $this->context_param_value = $this->text;
         }
         else if ($tree==='context.context-name')
         {
            $this->config->setContextName($this->text);
         }
         else if ($tree==='session.session-timeout')
         {
            $this->config->setSessionTimeout($this->text);
         }
         else if ($tree==='session.class-manager.class-property' && $this->session_class_property!='')
         {
            $this->config->sessions['class-manager']['class-properties'][$this->session_class_property] = $this->text;
            $this->session_class_property='';
         }
         else if ($tree==='request.class-manager.class-property' && $this->request_class_property!='')
         {
            $this->config->request['class-manager']['class-properties'][$this->request_class_property] = $this->text;
            $this->request_class_property='';
         }
         else if ($tree==='response.class-manager.class-property' && $this->response_class_property!='')
         {
            $this->config->response['class-manager']['class-properties'][$this->response_class_property] = $this->text;
            $this->response_class_property='';
         }
         else if ($tree==='security-constraint.resource')
         {
            $this->resource_count++;
         }
         else if ($tree==='security-constraint.resource.resource-name')
         {
            $this->config->securities[$this->resource_count]['resource-name'] = $this->text;
         }
         else if ($tree==='security-constraint.resource.url-pattern')
         {
            $this->config->securities[$this->resource_count]['url-pattern'] = $this->text;
         }
         else if ($tree==='login-config.authenticator')
         {
            $this->current_property_name = '';
         }
         else if ($tree==='login-config.authenticator.class-property')
         {
            $this->config->logins[$this->current_login_profile]['class-properties'][$this->current_property_name] = $this->text;
         }
         //
         @array_pop($this->stack);
         if ($elementName==='web-app')
         {
            $this->accept = FALSE;
         }
      }
   }
   
   // event handler : cdata
   function cdataElement(&$parserHandle, $cdata)
   {
      if ($this->accept)
      {
         $this->text = $cdata;
      }
   }
   
   // event  handler : processing instruction element
   function instructionElement(&$parserHandle, $target , $data)
   {
      
   }
   
   // event handler : undeclare entity
   function undeclaredEntityElement(&$parserHandle, $entityName, $base, $systemId, $publicId, $notationName)
   {
      
   }
   
   // event handler : notation declaration
   function notationDeclarationElement(&$parserHandle, $notationName, $base, $systemId, $publicId)
   {
   
   }
   
   // event handler : external entity declaration
   function externalEntityElement(&$parserHandle, $openEntityNames, $base, $systemId, $publicId)
   {
      
   }
}
?>