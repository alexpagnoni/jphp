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

class XMLDocument extends Object
{
   var $root_node = NULL;
   function XMLDocument() 
   {
      
   }
   
   function & setRootNode(&$node)
   {
      if (XMLNode::validClass($node))
      {
         $node->setDocument($this);
         $node->node_level = 0;
         $this->root_node =& $node;
      }
      return $this->root_node;
   }
   
   function & getRootNode()
   {
      return $this->root_node;
   }
   
   function validClass($object)
   {
      return parent::validClass($object, 'xmldocument');
   }
   function toString()
   {
      $xml = "<?xml version=1.0?>\n";
      $xml .= $this->root_node->toString();
      return $xml;
   }
}
?> 

