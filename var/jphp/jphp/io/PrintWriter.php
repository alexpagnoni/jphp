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

JPHP::import('jphp.io.FilterWriter');
JPHP::import('jphp.io.StandardWriter');

class PrintWriter extends FilterWriter
{
	function PrintWriter(&$writer)
	{
      parent::FilterWriter($writer);
	}
	
   function standardWriter()
   {
      return new PrintWriter(new StandardWriter());
   }
   function validClass($object)
   {
      return Object::validClass($object, 'printstream');
   }
}
?>