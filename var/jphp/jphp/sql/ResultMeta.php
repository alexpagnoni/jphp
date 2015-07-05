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

JPHP::import('jphp.sql.interface.IResultMeta');

class ResultMeta extends IResultMeta
{
   var $resultmeta = NULL;
   var $resultset = NULL;
   
   function ResultMeta(&$resultmeta, &$resultset)
	{
		if (isset($resultmeta) && isset($resultset))
      {
         $this->resultmeta =& $resultmeta;
         $this->resultset =& $resultset;
      }
	}
	
   function & getResultSet()
	{
      return $this->resultset;
	}
   
	function countFields() 
	{ 
		$this->resultmeta->countField();
	}
   
	function getFieldName($index) 
	{ 
	   $this->resultmeta->getFieldName($index);
	}
}
?>