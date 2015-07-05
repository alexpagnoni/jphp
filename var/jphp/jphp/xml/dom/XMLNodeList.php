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

class XMLNodeList
{
   var $nodes = NULL;
   
   function XMLNodeList()
   {
      $nodes = array();
   }
   
   function length()
   {
      return count($this->nodes);
   }
   
   function & item($index)
   {
      return $this->nodes[$index];
   }
}
?>