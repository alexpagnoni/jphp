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

class Stack extends Object
{
   var $objects = NULL;
   function Stack()
   {
      $this->objects = array();
   }
   function push(&$object)
   {
      array_push($this->objects, $object);
   }
   
   function elementAt($index)
   {
      if ($index>=0 && $index<count($this->objects))
      {
         return $this->objects[$index];
      }
      return NULL;
   }
   
   function & topElement()
   {
      return $this->objects[count($this->objects)];
   }
   
   function & pop()
   {
      return array_pop($this->objects);
   }
   
   function size()
   {
      count($this->objects);
   }
   function isEmpty()
   {
      return count($this->objects) > 0;
   }
   
   function & remove() 
   {
      return $this->pop();
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'stack');
   }
}
?>