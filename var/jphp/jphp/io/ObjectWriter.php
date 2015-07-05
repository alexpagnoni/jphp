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

JPHP::import('jphp.io.FilterWriter');
JPHP::import('jphp.util.ObjectSerializer');

class ObjectWriter extends FilterWriter
{
   function ObjectWriter(&$writer)
   {
      parent::FilterWriter($writer);
   }
   
   
   function writeObject($object)
   {
      if (isset($object))
      {
         $serialized = ObjectSerializer::save($object);
         $len = strlen($serialized);
         $data = 'obj['.$len.']['.$serialized.']';
         $this->write($data);
      }
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'objectwriter');
   }
}
?>