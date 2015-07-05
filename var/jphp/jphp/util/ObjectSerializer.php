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

class ObjectSerializer extends Object
{
   var $version = '1.0';
   
   function save($obj)
   {
      if (!isset($obj)) return NULL;
      $object = ( is_array($obj) ? $obj : (object)$obj );
      $serialized_object = serialize($object);
      return $serialized_object;
   }
   
   function load($datasource)
   {
      $classname = NULL;
      $hash = NULL;
      $obj = NULL;
      $data = StringBuffer::toStringBuffer($datasource);
      if (isset($data))
      {
         $res = array();
         if (preg_match('/^[aA-zZ]:[0-9]+:"([aA-zZ]+)"\s*/', $data->toString(), $res))
         {
            if ($res[1]=='stdClass')
            {
               $obj = unserialize($data->toString());
               return $obj->scalar;
            }
            else if (class_exists($res[1]))
            {
               return unserialize($data->toString());
            }
         }
         else if ($data->startsWith('a'))
         {
           return unserialize($data->toString());
         }
      }
      return NULL;
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'ObjectSerializer');
   }
}
?>