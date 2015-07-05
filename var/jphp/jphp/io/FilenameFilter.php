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

JPHP::import('jphp.io.File');
JPHP::import('jphp.util.StringBuffer');

class FilenameFilter
{
	function FilenameFilter()
	{
	
	}
	
	function accept($fileobj, $dirname)
	{
      if (File::validClass($fileobj) && (StringBuffer::validClass($dirname) || is_string($dirname)))
		{
			return TRUE;
		}
		else
      {
			return FALSE;
      }
	}
   
   function validClass($object)
   {
      return Object::validClass($object, 'filenamefilter');
   }
   
}
?>