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

JPHP::import('jphp.io.FilterReader');
JPHP::import('jphp.util.ObjectSerializer');

class ObjectReader extends FilterReader
{
   function ObjectReader(&$reader)
   {
      parent::FilterReader($reader);
   }
   
   
   function readObject()
   {
      $data = '';
      if ($this->ready())
      {
         while(($c=$this->read())!='')
         {
            $data .= $c;
            if ($data==='obj[') 
            {
               break;
            }
         }
         if ($data=='obj[')
         {
            $count = '';
            while(($c=$this->read())!='')
            {
               if ($c===']')
               {
                  break;
               }
               $count .= $c;
            }
            settype($count, 'integer');
            $c=$this->read();
            if ($c==='[' && ($count>0))
            {
               $pos = 0;
               $data = '';
               while(($c=$this->read())!='' && $pos<$count)
               {
                  $data .= $c;
                  $pos++;
               }
               if ($c===']' && strlen($data)===$count)
               {
                  return ObjectSerializer::load($data);
               }
            }
         }
      }
      return NULL;
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'objectreader');
   }
}
?>