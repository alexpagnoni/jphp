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

class Comparator extends Object
{
   function compare($object_a, $object_b)
   {
      
   }
   
   function equals($object)
   {
      
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'comparator');
   }
}
?>