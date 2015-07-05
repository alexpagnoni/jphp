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

JPHP::import('jphp.http.HttpRequest');

class HttpServletRequest extends HttpRequest
{
   var $context = NULL;
   
	function HttpServletRequest(&$servletcontext)
	{
   	parent::HttpRequest();
      if (ServletContext::validClass($servletcontext))
      {
         $this->context =& $servletcontext;
      }
	}
   
   function & getServletContext()
   {
      return $this->context;
   }
   
   function & createSession($create=TRUE)
   {
      if (ServletContext::validClass($this->context))
      {
         $response =& $this->context->getServletResponse();
         $session =& $this->context->getServletSession();
         if (IHttpResponse::validClass($response) && IHttpSession::validClass($session))
         {
            $sessionid = '';
            $cookie = $this->getCookie('_JPHPSESSIONID');
            if (!isset($cookie))
            {
               $sessionid = $this->getParameter('_JPHPSESSIONID');
            }
            else
            {
               $sessionid = $cookie->getValue();
            }
            if (strlen(trim($sessionid))<8) 
            {
               if ($create==FALSE)
               {
                  return NULL;
               }
               else
               {
                  $sessionid = md5(StringBuffer::generateKey(16));
               }
            }
            $session->setSessionID($sessionid);
            $session->initialize();
            $cookie = new Cookie('_JPHPSESSIONID', $sessionid);
            if ($session->getMaxInactiveInterval()>0)
            {
               $cookie->setMaxAge(time()+$session->getMaxInactiveInterval());
            }
            else
            {
               $cookie->setMaxAge(0);
            }
            $response->addCookie($cookie);
            return $session;
         }
      }
      return NULL;
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'httpservletrequest');
   }
}
?>