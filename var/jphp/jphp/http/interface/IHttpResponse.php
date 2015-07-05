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

if ( !defined('HTTP_CRLF') ) 
{
   define( 'HTTP_CRLF', chr(13) . chr(10));
}
define( 'HTTP_VERSION_10',                      '1.0');
define( 'HTTP_VERSION_11',                      '1.1');
define( 'HTTP_STATUS_CONTINUE', 				      100 );
define( 'HTTP_STATUS_SWITCHING_PROTOCOLS', 		101 );
define( 'HTTP_STATUS_OK', 						      200 );
define( 'HTTP_STATUS_CREATED', 					   201 );
define( 'HTTP_STATUS_ACCEPTED', 				      202 );
define( 'HTTP_STATUS_NON_AUTHORITATIVE', 		   203 );
define( 'HTTP_STATUS_NO_CONTENT', 				   204 );
define( 'HTTP_STATUS_RESET_CONTENT', 			   205 );
define( 'HTTP_STATUS_PARTIAL_CONTENT', 			206 );
define( 'HTTP_STATUS_MULTIPLE_CHOICES', 		   300 );
define( 'HTTP_STATUS_MOVED_PERMANENTLY', 		   301 );
define( 'HTTP_STATUS_FOUND', 					      302 );
define( 'HTTP_STATUS_SEE_OTHER', 				   303 );
define( 'HTTP_STATUS_NOT_MODIFIED', 			   304 );
define( 'HTTP_STATUS_USE_PROXY', 				   305 );
define( 'HTTP_STATUS_TEMPORARY_REDIRECT', 		307 );
define( 'HTTP_STATUS_BAD_REQUEST', 				   400 );
define( 'HTTP_STATUS_UNAUTHORIZED', 			   401 );
define( 'HTTP_STATUS_FORBIDDEN', 				   403 );
define( 'HTTP_STATUS_NOT_FOUND', 				   404 );
define( 'HTTP_STATUS_METHOD_NOT_ALLOWED', 		405 );
define( 'HTTP_STATUS_NOT_ACCEPTABLE', 			   406 );
define( 'HTTP_STATUS_PROXY_AUTH_REQUIRED', 		407 );
define( 'HTTP_STATUS_REQUEST_TIMEOUT', 			408 );
define( 'HTTP_STATUS_CONFLICT', 				      409 );
define( 'HTTP_STATUS_GONE', 					      410 );
define( 'HTTP_STATUS_LENGTH_REQUIRED',          411 );
define( 'HTTP_STATUS_PRECONDITION_FAILED', 	   412 );
define( 'HTTP_STATUS_REQUEST_TOO_LARGE',		   413 );
define( 'HTTP_STATUS_URI_TOO_LONG', 			   414 );
define( 'HTTP_STATUS_UNSUPPORTED_MEDIA', 			415 );
define( 'HTTP_STATUS_SERVER_ERROR', 			   500 );
define( 'HTTP_STATUS_NOT_IMPLEMENTED',			   501 );
define( 'HTTP_STATUS_BAD_GATEWAY',				   502 );
define( 'HTTP_STATUS_SERVICE_UNAVAILABLE',		503 );
define( 'HTTP_STATUS_GATEWAY_TIMEOUT',		      504 );
define( 'HTTP_STATUS_VERSION_NOT_SUPPORTED',	   505 );

define( 'HTTP_STATUS_100', 				      'Continue' );
define( 'HTTP_STATUS_101', 		            'Switching protocol' );
define( 'HTTP_STATUS_200', 						'OK' );
define( 'HTTP_STATUS_201', 					   'Created' );
define( 'HTTP_STATUS_202', 				      'Accepted' );
define( 'HTTP_STATUS_203', 		            'Non-Authoritative Information' );
define( 'HTTP_STATUS_204', 				      'No Content' );
define( 'HTTP_STATUS_205', 		      	   'Reset Content' );
define( 'HTTP_STATUS_206', 		         	'Partial Content' );
define( 'HTTP_STATUS_300', 		            'Multiple Choices' );
define( 'HTTP_STATUS_301', 		            'Moved Permanently' );
define( 'HTTP_STATUS_302', 		            'Found' );
define( 'HTTP_STATUS_303', 				      'See Other' );
define( 'HTTP_STATUS_304', 			         'Not Modified' );
define( 'HTTP_STATUS_305', 				      'Use Proxy' );
define( 'HTTP_STATUS_307', 		            'Temporary Redirect' );
define( 'HTTP_STATUS_400', 				      'Bad Request' );
define( 'HTTP_STATUS_401', 			         'Unauthorized' );
define( 'HTTP_STATUS_403', 				      'Forbidden' );
define( 'HTTP_STATUS_404', 				      'Not Found' );
define( 'HTTP_STATUS_405', 		            'Method Not Allowed' );
define( 'HTTP_STATUS_406', 	      		   'Not Acceptable' );
define( 'HTTP_STATUS_407', 	            	'Proxy Authentication Required' );
define( 'HTTP_STATUS_408', 	         		'Request Time-out' );
define( 'HTTP_STATUS_409', 				      'Conflict' );
define( 'HTTP_STATUS_410', 		            'Gone' );
define( 'HTTP_STATUS_411', 		         	'Length Required');
define( 'HTTP_STATUS_412',                   'Precondition failed' );
define( 'HTTP_STATUS_413',		               'Request Entity Too Large' );
define( 'HTTP_STATUS_414', 			         'Request-URI Too Large' );
define( 'HTTP_STATUS_415',                   'Unsupported media type' );
define( 'HTTP_STATUS_500', 			         'Internal Server Error' );
define( 'HTTP_STATUS_501',			            'Not Implemented' );
define( 'HTTP_STATUS_502',				         'Bad gateway' );
define( 'HTTP_STATUS_503',		               'Service unavailable' );
define( 'HTTP_STATUS_504',	                  'Gateway timeout' );
define( 'HTTP_STATUS_505',	                  'HTTP Version not supported' );

class IHttpResponse extends Object
{
   function addCookie($cookie) 
   {
   }
   
   function sendRedirect($location)
   {
   }
   
   function setContentLength($length)
   {
   }
   
   function setContentType($content)
   {
   }
   
   function displayImage($file, $itype='')
   {
   }
   
   function sendFile(&$request, $file, $newname)
   {
   }
   
   function sendNoCacheHeaders()
   {
   }
   
   function setLastModified($time='')
   {
   }
   
   function setHeader($header, $value) 
   {
   }
    
   function setStatus($number, $message='') 
   {
   }
}
?>