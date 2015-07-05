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

JPHP::import('jphp.datastructure.interface.INode');

class ILinkListNode extends INode
{
   function & getNext() {}
   function setNext(&$next_node) {}
   
   function isLeaf() {}
   
   function validClass($object)
   {
      return Object::validClass($object, 'ilinklistnode');
   }
}
?>