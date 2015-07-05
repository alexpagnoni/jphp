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

class IHttpRequest extends Object
{
   
   function getAuhtenticationUser() { return NULL; }
   
   function getAuhtenticationPassword() { return NULL; }
   /**
    * Check if the parameter name is an uploaded file
    *
    * @param string|core.StringBuffer  parameter name
    * @return boolean TRUE if the given parameter name is an uploaded file
    * @access public
    */
   function isUploadFile($key) { return FALSE; }
   
   /**
    * Get the uploaded file name of the given parameter name
    *
    * @param string|core.StringBuffer  parameter name
    * @return core.StringBuffer  the uploaded file name
    * @access public
    */
	function getUploadFileName($key) { return NULL; }
	
   /**
    * get the uploaded file type of the given parameter name
    *
    * @param string|core.StringBuffer  parameter name
    * @return core.StringBuffer the uploaded file type
    * @access public
    */
	function getUploadFileType($key) { return NULL; }
   
   /**
    * get the uploaded file size of the given parameter name
    *
    * @param string|core.StringBuffer  parameter name
    * @return integer  the uploaded file size
    * @access public
    */
	function getUploadFileSize($key) { return 0; }
	
   /**
    * get the uploaded file temp path/name of the given parameter name
    *
    * @param string|core.StringBuffer  parameter name
    * @return core.StringBuffer  the uploaded file
    * @access public
    */
	function getUploadFileTempPath($key) { return NULL; }
	
   /**
    * get the uploaded file temp path/name of the given parameter name
    *
    * @param string|core.StringBuffer  parameter name
    * @return core.File  the uploaded file
    * @access public
    */
	function getUploadFile($key) { return NULL; }
	
   /**
    * get the uploaded file temp path/name of the given parameter name
    *
    * @param string|core.StringBuffer  parameter name
    * @return core.File[]  the uploaded file
    * @access public
    */
	function getUploadFiles() { return NULL; }
	
   /**
    * move the upload file to another location of the given parameter name
    *
    * @param string|core.StringBuffer  parameter name
    * @param string|core.StringBuffer|core.File  parameter name
    * @return core.StringBuffer  the uploaded file name
    * @access public
    */
	function moveUploadedFileTo($key, $path) { return FALSE; }
	
   /**
    * get the HTTP_CONNECTION header
    *
    * @return core.StringBuffer  the HTTP_CONNECTION header
    * @access public
    */
	function getHttpConnection() { return NULL; }
	
   /**
    * get the current request path
    *
    * @return core.StringBuffer  the current request path
    * @access public
    */
	function getRequestPath() { return NULL; }
	
   /**
    * get the request URI
    *
    * @return core.StringBuffer  the request URI
    * @access public
    */
	function getRequestURI() { return NULL; }
	
   /**
    * get the query string
    *
    * @return core.StringBuffer  the current request path
    * @access public
    */
	function getQueryString() { return NULL; }
	
   /**
    * get the script file name
    *
    * @return core.StringBuffer  the script file name
    * @access public
    */
	function getScriptFilename() { return NULL; }
	
   /**
    * get the script namae
    *
    * @return core.StringBuffer  the script name
    * @access public
    */
	function getScriptName() { return NULL; }
	
   /**
    * get the CGI version
    *
    * @return core.StringBuffer  the CGI version
    * @access public
    */
	function getGatewayInterface() { return NULL; }
	
   /**
    * get the translated path of the request
    *
    * @return core.StringBuffer  the translated path
    * @access public
    */
	function getPathTranslated() { return NULL; }
   
   /**
    * the media type content accept by the client
    *
    * @return core.StringBuffer  the content accept
    * @access public
    */
	function getHttpAccept() { return NULL; }
	
   /**
    * return the encoding accept by the client
    *
    * @return core.StringBuffer  the content enconding
    * @access public
    */
	function getHttpAcceptEncoding() { return NULL; }
	
   /**
    * return the language using by the client
    *
    * @return core.StringBuffer  the content language
    * @access public
    */
	function getHttpAcceptLanguage() { return NULL; }
	
   /**
    * return the request method POST/GET
    *
    * @return core.StringBuffer  the request method
    * @access public
    */
	function getMethod() { return NULL; }
	
   /**
    * return the request method POST/GET
    *
    * @return core.StringBuffer  the request method
    * @access public
    * @see #getMethod
    */
	function getRequestMethod() { return NULL; }
   
	/**
    * return the IP of the client who sent the request
    *
    * @return core.StringBuffer  the IP address
    * @access public
    */
	function getRemoteAddr() { return NULL; }
   
   /**
    * return the browser user-agent of the client
    *
    * @return core.StringBuffer  the browser user agent
    * @access public
    */
	function getUserAgent() { return NULL; }
   
   /**
    * get a parameter value by name
    *
    * @param string|core.StringBuffer  the parameter name
    * @return core.StringBuffer the parameter value
    * @access public
    */
	function getParameter($key) { return NULL; }
   
   /**
    * get all parameter names available as Enumeration
    *
    * @return jphp.util.Enumeration the parameter value
    * @access public
    */
	function getParameterNames() { return NULL; }
   
   /**
    * get all parameter values available as Enumeration
    *
    * @return jphp.util.Enumeration the parameter value
    * @access public
    */
	function getParameterValues() { return NULL; }
   
   /**
    * get the server name if available
    *
    * @return core.StringBuffer the server name
    * @access public
    */
	function getServerName() { return NULL; }
   
   /**
    * get the server port
    *
    * @return int the server port
    * @access public
    */
	function getServerPort() { return 0; }
   
	/**
    * get the server protocol
    *
    * @return core.StringBuffer the server protocol
    * @access public
    */
	function getServerProtocol() { return NULL; }
	
	/**
    * get the server ip address
    *
    * @return core.StringBuffer the server ip address
    * @access public
    */
	function getServerAddr() { return NULL; }
	
   /**
    * get the server software information
    *
    * @return core.StringBuffer the server software information
    * @access public
    */
	function getServerSoftware() { return NULL; }
	
   /**
    * get the server signature
    *
    * @return core.StringBuffer the server signature
    * @access public
    */
	function getServerSignature() { return NULL; }
	
   /**
    * get a cookie
    *
    * @return core.StringBuffer the the cookie name
    * @access public
    */
	function getCookie($key) { return NULL; } 
   
   /**
    * get all cookies available
    *
    * @return jphp.http.Cookie[] the cookies
    * @access public
    */
	function getCookies() { return NULL; } 
   
   /**
    * get a parameter value by name
    *
    * @param string|core.StringBuffer  the parameter name
    * @return core.StringBuffer the parameter value
    * @access public
    * @see #getParameter
    */
   function get($key) 
   { 
      return $this->getParameter($key);
   }
   
   function createSession($create=TRUE)
   {
      return NULL;
   }
}
?>
