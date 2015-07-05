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

class XMLAttribute extends Object
{
   var $name = NULL;
   var $value = NULL;
   
   var $parent_node = NULL;
   
   function XMLAttribute($name, $value)
   {
      $this->name = $name;
      $this->value = $value;
   }
   
   function setParentNode(&$parent_node)
   {
      $this->parent_node =& $parent_node;
   }
   
   function & getParentNode()
   {
      return $this->parent_node;
   }
   
   function & getDocument()
   {
      return $this->parent_node->getDocument();
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'xmlattribute');
   }
}
?>