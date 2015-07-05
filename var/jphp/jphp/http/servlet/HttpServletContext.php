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

JPHP::import('jphp.http.HttpContext');

class HttpServletContext extends HttpContext
{
   var $context = NULL;
   
	function HttpServletContext(&$servletcontext)
	{
		parent::HttpContext();
      if (ServletContext::validClass($servletcontext))
      {
         $this->context =& $servletcontext;
      }
	}
   
   function & getServletContext()
   {
      return $this->context;
   }
}
?>