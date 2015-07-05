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

JPHP::import('jphp.xml.AbstractSAXParser');
JPHP::import('jphp.xml.dom.*');
JPHP::import('jphp.io.IReader');

class XMLTreeReader extends AbstractSAXParser
{
   var $reader = NULL;
   var $document = NULL;
   var $node = NULL;
   var $level = 0;
   function XMLTreeReader()
   {
      parent::AbstractSAXParser();
   }
   
   function setReader(&$reader)
   {
      if (IReader::validClass($reader))
      {
         $this->reader =& $reader;
      }
   }
   
   function & getReader()
   {
      return $this->reader;
   }
   
   function createDocument(&$reader)
   {
      static $xmlreader;
      if (!isset($xmlreader))
      {
         $xmlreader =& new XMLTreeReader();
      }
      $xmlreader->setReader($reader);
      
      $document = $xmlreader->parseDocument();
      $xmlreader->close();
      return $document;
   }
   
   function parseDocument()
   {
      if (isset($this->reader) && $this->reader->ready())
      {
         $data = '';
         while(($data=$this->reader->read(4096))!='')
         {
            $this->parse($data);
         }
         if (isset($this->document))
         {
            return $this->document;
         }
      }
      return NULL;
   }
   
   // event handler : start tag element
   function startTagElement(&$parserHandle, $elementName, $attributes)
   {
      if (!isset($this->node))
      {
         if (!isset($this->document))
         {
            $this->document = new XMLDocument();
            $this->node =& new XMLNode();
            $this->node->node_type = XML_ELEMENT;
            $this->node->node_name = $elementName;
            $this->node->node_value = array();
            $keys = array_keys($attributes);
            for ($i=0; $i<count($keys); $i++)
            {
               $this->node->setAttribute( new XMLAttribute( $keys[$i] , $attributes[$keys[$i]] ) );
            }
            $this->document->setRootNode($this->node);
         }
         else
         {
            print("ERROR !");
         }
      }
      else
      {
         $new_node = new XMLNode();
         $new_node->node_type = XML_ELEMENT;
         $new_node->node_name = $elementName;
         $keys = array_keys($attributes);
         for ($i=0; $i<count($keys); $i++)
         {
            $new_node->setAttribute( new XMLAttribute( $keys[$i] , $attributes[$keys[$i]] ) );
         }
         $this->node->node_value = array();
         $this->node =& $this->node->appendChild($new_node);
      }
   }
   
   // event handler : end tag element
   function endTagElement(&$parserHandle, $elementName)
   {
      if (isset($this->node) && $this->node->node_name===$elementName)
      {
         if (isset($this->node->parent_node))
         {
            $this->node =& $this->node->parentNode();
         }
         else
         {
            unset($this->node);
         }
      }
      else
      {
         print($this->node->node_name . '===' . $elementName.'<br>');
         die("error");
      }
   }
   
   // event handler : cdata
   function cdataElement(&$parserHandle, $cdata)
   {
      if (isset($this->node))
      {
         $this->node->appendValue($cdata);
      }
   }
   
   // event  handler : processing instruction element
   function instructionElement(&$parserHandle, $target , $data)
   {
      print($target.':'.$data);
   }
   
   // event handler : undeclare entity
   function undeclaredEntityElement(&$parserHandle, $entityName, $base, $systemId, $publicId, $notationName)
   {
      
   }
   
   // event handler : notation declaration
   function notationDeclarationElement(&$parserHandle, $notationName, $base, $systemId, $publicId)
   {
   
   }
   
   // event handler : external entity declaration
   function externalEntityElement(&$parserHandle, $openEntityNames, $base, $systemId, $publicId)
   {
      
   }
}
?>