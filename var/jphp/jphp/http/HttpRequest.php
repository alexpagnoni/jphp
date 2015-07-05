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
 *                      import declaration                              *
\*----------------------------------------------------------------------*/
JPHP::import('jphp.http.interface.IHttpRequest,jphp.http.UploadFile,jphp.http.Cookie');
JPHP::import('jphp.util.StringBuffer,jphp.util.Enumeration,jphp.util.Hashtable');
/*----------------------------------------------------------------------*\
 *                   Request class declaration                          *
\*----------------------------------------------------------------------*/

class HttpRequest extends IHttpRequest
{
	var $http_post_request = NULL;
   var $http_get_request = NULL;
   var $files = NULL;
	var $cookies = NULL;
	var $headers = NULL;
	
   function HttpRequest()
	{
      $header_keys = array(
         'REMOTE_ADDR', 'REQUEST_METHOD', 'HTTP_ACCEPT', 'HTTP_ACCEPT_ENCODING',
   		'HTTP_ACCEPT_LANGUAGE', 'HTTP_USER_AGENT', 'SERVER_ADDR', 
         'SERVER_NAME', 'SERVER_PORT', 'SERVER_PROTOCOL', 'SERVER_SOFTWARE',
   		'SERVER_SIGNATURE', 'GATEWAY_INTERFACE', 'PATH_TRANSLATED', 
         'SCRIPT_FILENAME', 'SCRIPT_NAME', 'QUERY_STRING', 'REQUEST_URI', 
         'PHP_SELF',	'HTTP_CONNECTION', 'DOCUMENT_ROOT', 'PHP_AUTH_USER', 'PHP_AUTH_PW'
      );
      $this->headers = new Hashtable();
      for ($i=0; $i<count($header_keys); $i++)
      {
         if (isset($GLOBALS[$header_keys[$i]]))
         {
            $this->headers->set($header_keys[$i], $GLOBALS[$header_keys[$i]]);
         }
      }
      
      /*-------------------------------------------------------*\
       *          extracting request information               *
       *       note: Post vars will overide Get vars if        *
       *             exists conflict                           *
      \*-------------------------------------------------------*/
      $this->files = new Hashtable();
      if (isset($GLOBALS['_FILES']) || $GLOBALS['HTTP_FILE_VARS'])
      {
   		$upload_files = isset($GLOBALS['_FILES']) ? array_keys($GLOBALS['_FILES']) : array_keys($GLOBALS['HTTP_FILE_VARS']);
   		if (is_array($upload_files) && count($upload_files)>0)
   		{
   			for ($i=0; $i<count($upload_files); $i++)
   			{
   				$key = $upload_files[$i];
   				$value = isset($GLOBALS['_FILES']) ? $GLOBALS['_FILES'][$key] : $GLOBALS['HTTP_FILE_VARS'][$key];
   				$upload = new UploadFile($value['name'], $value['type'], $value['size'], $value['tmp_name']);
   				$this->files->put($key, $upload);
   			}
   		}
      }
      
      /*-------------------------------------------------------*\
       *          extracting request information               *
       *       note: Post vars will overide Get vars if        *
       *             exists conflict                           *
      \*-------------------------------------------------------*/
      $this->http_post_request = new Hashtable();
      $this->http_get_request = new Hashtable();
      if (isset($GLOBALS['_GET']) || $GLOBALS['HTTP_GET_VARS'])
      {
         $get = isset($GLOBALS['_GET']) ? array_keys($GLOBALS['_GET']) : array_keys($GLOBALS['HTTP_GET_VARS']);
   		if (is_array($get) && count($get)>0)
   		{
   			for ($i=0; $i<count($get); $i++)
   			{
               $key = $get[$i];
               $value = isset($GLOBALS['_GET']) ? $GLOBALS['_GET'][$key] : $GLOBALS['HTTP_GET_VARS'][$key];
   				$this->http_get_request->put($key, $value);
   			}
   		}
      }
      
		if (isset($GLOBALS['_POST']) || $GLOBALS['HTTP_POST_VARS'])
      {
         $post = isset($GLOBALS['_POST']) ? array_keys($GLOBALS['_POST']) : array_keys($GLOBALS['HTTP_POST_VARS']);
   		if (is_array($post) && count($post)>0)
   		{
   			for ($i=0; $i<count($post); $i++)
   			{
               $key = $post[$i];
               $value = isset($GLOBALS['_POST']) ? $GLOBALS['_POST'][$key] : $GLOBALS['HTTP_POST_VARS'][$key];
   				$this->http_post_request->put($key, $value);
   			}
   		}
      }
		
      $this->cookies = new Hashtable();
      if (isset($GLOBALS['_COOKIE']) || $GLOBALS['HTTP_COOKIE_VARS'])
      {
         $post = isset($GLOBALS['_COOKIE']) ? array_keys($GLOBALS['_COOKIE']) : array_keys($GLOBALS['HTTP_COOKIE_VARS']);
   		if (is_array($post) && count($post)>0)
   		{
   			for ($i=0; $i<count($post); $i++)
   			{
               $key = $post[$i];
               $value = isset($GLOBALS['_COOKIE']) ? $GLOBALS['_COOKIE'][$key] : $GLOBALS['HTTP_COOKIE_VARS'][$key];
               $cookie = new Cookie($key, $value);
   				$this->cookies->put($key, $cookie);
   			}
   		}
      }
	}
	
   function getDocumentRoot()
   {
      return $this->headers->get('DOCUMENT_ROOT');
   }
   
   function getRealPath($path)
   {
      if (!empty($path) && strlen($path)>0)
      {
         if ($path[0]==='/' || $path[0]===DIRECTORY_SEPARATOR)
         {
            return $this->getDocumentRoot().$path;
         }
         else 
         {
            return realpath($path);
         }
      }
      return NULL;
   }
	function getAuhtenticationUser() 
   { 
      return $this->headers->get('PHP_AUTH_USER');
   }
   
   function getAuhtenticationPassword() 
   { 
      return $this->headers->get('PHP_AUTH_PW');
   }
   
   /**
    * check if the parameter name is an uploaded file
    * @param string|core.StringBuffer  parameter name
    * @return boolean TRUE if the given parameter name is an uploaded file
    * @see jphp.http.interface.IHttpRequest#isUploadFile
    */
   function isUploadFile($key)
   {
		return $this->files->containsKey($key);
	}
	
   /**
    * get the uploaded file name of the given parameter name
    * @param string|core.StringBuffer  parameter name
    * @return core.StringBuffer  the uploaded file name
    * @see jphp.http.interface.IHttpRequest#getUploadFileName
    */
	function getUploadFileName($key)
	{
      $fileobj = $this->files->get($key);
      if (isset($fileobj))
      {
         return $fileobj->getUploadFileName();
      }
      return NULL;
	}
	
   /**
    * get the uploaded file type of the given parameter name
    * @param string|core.StringBuffer  parameter name
    * @return core.StringBuffer the uploaded file type
    * @see jphp.http.interface.IHttpRequest#getUploadFileType
    */
	function getUploadFileType($key)
	{
		$fileobj = $this->files->get($key);
      if (isset($fileobj))
      {
         return $fileobj->getUploadFileType();
      }
      return NULL;
	}
	
   /**
    * get the uploaded file size of the given parameter name
    * @param string|core.StringBuffer  parameter name
    * @return integer  the uploaded file size
    * @see jphp.http.interface.IHttpRequest#getUploadFileSize
    */
	function getUploadFileSize($key)
	{
		$fileobj = $this->files->get($key);
      if (isset($fileobj))
      {
         return $fileobj->getUploadFileSize();
      }
      return NULL;
	}
	
   /**
    * get the uploaded file temp path/name of the given parameter name
    * @param string|core.StringBuffer  parameter name
    * @return core.StringBuffer  the uploaded file temp. name
    * @see jphp.http.interface.IHttpRequest#getUploadFileTempPath
    */
	function getUploadFileTempPath($key)
	{
		$fileobj = $this->files->get($key);
      if (isset($fileobj))
      {
         return $fileobj->getUploadFileTempPath();
      }
      return NULL;
	}
	
	/**
    * get the uploaded file temp path/name of the given parameter name
    * @param string|core.StringBuffer  parameter name
    * @return core.File  the uploaded file temp. name
    * @see jphp.http.interface.IHttpRequest#getUploadFile
    */
	function getUploadFile($key)
	{
		return $this->files->get($key);
	}
	
   /**
    * get the uploaded file temp path/name of the given parameter name
    * @param string|core.StringBuffer  parameter name
    * @return array of core.File  the uploaded file temp. name
    * @see jphp.http.interface.IHttpRequest#getUploadFiles
    */
	function & getUploadFiles()
	{
     return $this->files->elements();
	}
	
	/**
    * move the upload file to another location of the given parameter name
    * @param string|core.StringBuffer  parameter name
    * @param string|core.StringBuffer|core.File  parameter name
    * @return core.StringBuffer  the uploaded file name
    * @see jphp.http.interface.IHttpRequest#moveUploadedFileTo
    */
	function moveUploadedFileTo($key, $path)
	{
		$file = NULL;
		$basefile = $this->files->get($key);
      if (isset($basefile))
      {
         if (File::validClass($path) || StringBuffer::validClass($path) || is_string($path))
         {
            $targetfile = new File($path);
            return $basefile->moveTo($targetfile);
         }
      }
      return FALSE;
	}
	
	/**
    * get the HTTP_CONNECTION header
    * @return core.StringBuffer  the HTTP_CONNECTION header
    * @see jphp.http.interface.IHttpRequest#getHttpConnection
    */
	function getHttpConnection()
	{
		return $this->headers->get('HTTP_CONNECTION');
	}
	
	/**
    * get the current request path
    * @return core.StringBuffer  the current request path
    * @see jphp.http.interface.IHttpRequest#getRequestPath
    */
	function getRequestPath()
	{
		return $this->headers->get('PHP_SELF');
	}
	
	/**
    * get the request URI
    * @return core.StringBuffer  the request URI
    * @see jphp.http.interface.IHttpRequest#getRequestURI
    */
	function getRequestURI()
	{
		return $this->headers->get('REQUEST_URI');
	}
	
	/**
    * get the query string
    * @return core.StringBuffer  the current request path
    * @see jphp.http.interface.IHttpRequest#getQueryString
    */
	function getQueryString()
	{
	 	return $this->headers->get('QUERY_STRING');
	}
	
	/**
    * get the script file name
    * @return core.StringBuffer  the script file name
    * @see jphp.http.interface.IHttpRequest#getScriptFilename
    */
	function getScriptFilename()
	{
		return $this->headers->get('SCRIPT_FILENAME');
	}
	
	/**
    * get the script namae
    * @return core.StringBuffer  the script name
    * @see jphp.http.interface.IHttpRequest#getScriptName
    */
	function getScriptName()
	{
	 	return $this->headers->get('SCRIPT_NAME');
	}
	
	/**
    * get the CGI version
    * @return core.StringBuffer  the CGI version
    * @see jphp.http.interface.IHttpRequest#getGatewayInterface
    */
	function getGatewayInterface()
	{
		return $this->headers->get('GATEWAY_INTERFACE');
	}
	
	/**
    * get the CGI version
    * @return core.StringBuffer  the CGI version
    * @see jphp.http.interface.IHttpRequest#getGatewayInterface
    */
	function getCGIVersion()
	{
		return $this->getGatewayInterface();
	}
	
	/**
    * get the translated path of the request
    * @return core.StringBuffer  the translated path
    * @see jphp.http.interface.IHttpRequest#getPathTranslated
    */
	function getPathTranslated()
	{
		return $this->headers->get('PATH_TRANSLATED');
	}
	
	/**
    * the media type content accept by the client
    * @return core.StringBuffer  the content accept
    * @see jphp.http.interface.IHttpRequest#getHttpAccept
    */
	function getHttpAccept()
	{
		return $this->headers->get('HTTP_ACCEPT');
	}
	
	/**
    * return the encoding accept by the client
    * @return core.StringBuffer  the content enconding
    * @see jphp.http.interface.IHttpRequest#getHttpAccept
    */
	function getHttpAcceptEncoding()
	{
		return $this->headers->get('HTTP_ACCEPT_ENCODING');
	}
	
	/**
    * return the language using by the client
    * @return core.StringBuffer  the content language
    * @see jphp.http.interface.IHttpRequest#getHttpAcceptLanguage
    */
	function getHttpAcceptLanguage()
	{
		return $this->headers->get('HTTP_ACCEPT_LANGUAGE');
	}
	
	/**
    * return the request method POST/GET
    * @return core.StringBuffer  the request method
    * @see jphp.http.interface.IHttpRequest#getMethod
    */
	function getMethod()
	{
		return $this->getRequestMethod();
	}
	
	/**
    * return the request method POST/GET
    * @return core.StringBuffer  the request method
    * @see #getMethod
    * @see jphp.http.interface.IHttpRequest#getRequestMethod
    * @see jphp.http.interface.IHttpRequest#getMethod
    */
	function getRequestMethod()
	{
		return $this->headers->get('REQUEST_METHOD');
	}
	
   function isPOST()
	{
		return $this->headers->get('REQUEST_METHOD')==='POST';
	}
	function isGET()
	{
		return $this->headers->get('REQUEST_METHOD')==='GET';
	}
	
	/**
    * return the IP of the client who sent the request
    * @return core.StringBuffer  the IP address
    * @see jphp.http.interface.IHttpRequest#getRemoteAddr
    */
	function getRemoteAddr()
	{
		return $this->headers->get('REMOTE_ADDR');
	}
	
	/**
    * return the browser user-agent of the client
    * @return core.StringBuffer  the browser user agent
    * @see jphp.http.interface.IHttpRequest#getUserAgent
    */
	function getUserAgent()
	{
		return $this->headers->get('USER_AGENT');
	}
	
	/**
    * get a parameter value by name
    * @param string|core.StringBuffer  the parameter name
    * @return core.StringBuffer the parameter value
    * @see #getParameter
    * @see jphp.http.interface.IHttpRequest#getParameter
    * @see jphp.http.interface.IHttpRequest#get
    */
   function get($key)
	{
		return $this->getParameter($key);
	}
	
   /**
    * get a parameter value by name
    * @param string|core.StringBuffer  the parameter name
    * @return core.StringBuffer the parameter value
    * @see jphp.http.interface.IHttpRequest#getParameter
    */
	function getParameter($key, $type='all')
	{
      if (empty($key)) return NULL;
      $type = StringBuffer::toStringBuffer($type);
      $get = $this->http_get_request->get($key);
      $post = $this->http_post_request->get($key);
		if ($type->equals('get'))
      {
         return $get;
      }
      else if ($type->equals('post'))
      {
         return $post;
      }
      else
      {
         if (isset($get)) return $get;
         if (isset($post)) return $post;
      }
      return NULL;
	}

   /**
    * get all parameter names available as Enumeration
    * @return jphp.util.Enumeration the parameter value
    * @see jphp.http.interface.IHttpRequest#getParameterNames
    */
	function getParameterNames($type='all')
	{
      $type = StringBuffer::toStringBuffer($type);
      $get_keys = $this->http_get_request->keys();
      $post_keys = $this->http_post_request->keys();
      $type = $type->toLowerCase();
      if ($type->equals('get'))
      {
         return $get_keys;
      }
      else if ($type->equals('post'))
      {
         return $post_keys;
      }
      else
      {
         return array_merge( $post_keys, $get_keys );
      }
	}
	
   /**
    * get all parameter values available as Enumeration
    * @return jphp.util.Enumeration the parameter value
    * @see jphp.http.interface.IHttpRequest#getParameterValues
    */
	function getParameterValues($type='all')
	{
      $keys = $this->getParameterNames($type);
      $values = array();
      for ($i=0; $i<count($keys); $i++)
      {
         $values[] = $this->getParameter( $keys[$i], $type);
      }
      return $values;
	}
	
   /**
    * get the server name if available
    * @return core.StringBuffer the server name
    * @see jphp.http.interface.IHttpRequest#getServerName
    */
	function getServerName()
	{
		return $this->headers->get('SERVER_NAME');
	}

   /**
    * get the server port
    * @return int the server port
    * @see jphp.http.interface.IHttpRequest#getServerPort
    */
	function getServerPort()
	{
		return $this->headers->get('SERVER_PORT');
	}
	
	/**
    * get the server protocol
    * @return core.StringBuffer the server protocol
    * @see jphp.http.interface.IHttpRequest#getServerProtocol
    */
	function getServerProtocol()
	{
		return $this->headers->get('SERVER_PROTOCOL');
	}
	
	/**
    * get the server ip address
    * @return core.StringBuffer the server ip address
    * @see jphp.http.interface.IHttpRequest#getServerAddr
    */
	function getServerAddr()
	{
		return $this->headers->get('SERVER_ADDR');
	}
	
   /**
    * get the server software information
    * @return core.StringBuffer the server software information
    * @see jphp.http.interface.IHttpRequest#getServerSoftware
    */
	function getServerSoftware()
	{
		return $this->headers->get('SERVER_SOFTWARE');
	}
	
   /**
    * get the server signature
    * @return core.StringBuffer the server signature
    * @see jphp.http.interface.IHttpRequest#getServerSignature
    */
	function getServerSignature()
	{
      return $this->headers->get('SERVER_SIGNATRUE');
	}
	
   /**
    * get a cookie
    *
    * @param string|core.StringBuffer cookie name
    * @return core.Cookie the the cookie name
    * @access public
    */
	function getCookie($key) 
   {
      return $this->cookies->get($key);
   }
   
   /**
    * get all cookies available
    *
    * @return jphp.http.Cookie[] the cookies
    * @access public
    */
	function getCookies() 
   { 
      return $this->cookies->elements();
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'httprequest');
   }
}
?>