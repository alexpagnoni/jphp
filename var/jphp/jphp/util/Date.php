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

class Date extends Object
{
   var $timestamp = 0;
   
   function Date($timestamp=0)
   {
      $this->setTime($timestamp);
   }
   
   function getTime()
   {
      return $this->timestamp;
   }
   
   function setTime($timestamp)
   {
      $timestamp = (int)$timestamp;
      $this->timestamp = ( $timestamp>0 ? $timestamp : time() );
   }
   
   function compareTo($object)
   {
      if (Date::validClass($object) || Calendar::validClass($objet))
      {
         if ($this->getTime()==$object->getTime())
         {
            return 0;
         }
         else if ($this->getTime()>$object->getTime())
         {
            return 1;
         }
         else
         {
            return -1;
         }
     }
     return FALSE;
   }
   
   function equals($object)
   {
      return (Date::validClass($object) && $this->getTime()==$object->getTime());
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'date');
   }
}
?>