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

class BasicAuthenticator extends Object
{
   var $request = NULL;
   var $response = NULL;
   var $realm_name = '';
   var $pattern = '';
   
   var $user = '';
   var $password = '';
   function BasicAuthenticator($name, $pattern, &$request, &$response)
   {
      $this->realm_name = $name;
      $this->pattern = $pattern;
      
      if (IHttpRequest::validClass($request) && IHttpResponse::validClass($response))
      {
         $this->request =& $request;
         $this->response =& $response;
      }
   }
   function authenticate()
   {
      if (isset($this->request) && isset($this->response))
      {
         $session =& $this->request->createSession();
         $context =& $this->request->getServletContext();
         $check_hash = md5($this->user.':'.$this->password.':'.$this->pattern);
         $user = $this->request->getAuhtenticationUser();
         $password = $this->request->getAuhtenticationPassword();
         $hash = md5($user.':'.$password.':'.$this->pattern);
         $session_hash = $session->getAttribute('basic_authen_hash');
         if ($session_hash===$check_hash)
         {
            return TRUE;
         }
         if ($hash!==$check_hash)
         {
            $this->response->setHeader('WWW-Authenticate', 'Basic realm="'.$this->realm_name.'"');
            return FALSE;
         }
         else
         {
            $session->setAttribute('basic_authen_hash', $hash);
            return TRUE;
         }
      }
      return FALSE;
   }
   function setBasicUser($user)
   {
      $this->user = $user;
   }
   
   function setBasicPassword($password)
   {
      $this->password = $password;
   }
}
?>