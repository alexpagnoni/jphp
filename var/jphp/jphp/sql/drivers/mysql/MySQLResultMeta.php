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

class MySQLResultMeta extends IResultMeta
{
	function MySQLResultMeta($resultset)
	{
		parent::IResultMeta($resultset);
	}
	function countFields() 
	{ 
		$resulset =& $this->getResultSet();
      if (isset($resulset))
      {
   		$res = $resulset->getCurrentResult();
         $counter = @mysql_num_fields($res);
         return isset($counter) ? $counter : 0;
      }
		return 0;
	}
	function getFieldName($index) 
	{ 
		settype($index, 'integer');
		if ($index>0 && $index<=$this->countFields())
		{
			if (isset($resulset))
         {
            $resulset = $this->getResultSet();
   			$res = $resulset->getCurrentResult();
            $counter = @mysql_field_name($res, --$index);
            return isset($counter) ? $counter : 0;
         }
		}
		return NULL;
	}
}
?>