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

JPHP::import('jphp.http.HttpResponse');

class HttpServletResponse extends HttpResponse
{
   var $context = NULL;
   
	function HttpServletResponse(&$servletcontext)
	{
		parent::HttpResponse();
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