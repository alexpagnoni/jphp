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

define( 'XML_START_ELEMENT',     0 );
define( 'XML_END_ELEMENT',       1 );
define( 'XML_ATT_ELEMENT',       2 );
define( 'XML_TEXT_ELEMENT',      3 );
define( 'XML_CDATA_ELEMENT',     4 );
define( 'XML_COMMENT_ELEMENT',   5 );
define( 'XML_START_ELEMENT',     6 );
JPHP::import('jphp.io.IWriter');


class XMLWriter
{
   var $writer = NULL;
   var $previous = -1;
   
   function XMLWriter($writer)
   {
      if (IWriter::validClass($writer))
      {
         $this->writer =& $writer;
      }
   }
   
   function writeStartElement($name)
   {
      // close previous
      if ( $this->previous === XML_START_ELEMENT || $this->previous === XML_ATT_ELEMENT)
      {
         $this->writer->print('>');
      }
      
      // write new startelement
      $this->writer->print('<'.$name);
      $this->previous = XML_START_ELEMENT;
   }
   
   function writeEndElement($name)
   {
      if (  $this->previous === XML_START_ELEMENT || 
            $this->previous === XML_ATT_ELEMENT || 
            $this->previous === XML_TEXT_ELEMENT || 
            $this->previous === XML_CDATA_ELEMENT)
      {
         $this->writer->print('/>');
      }
      else
      {
         $this->writer->print('</'.$name.'>');
      }
   }
   
   function writeAttribute($name, $value)
   {
      if ( $this->previous === XML_START_ELEMENT )
      {
         $this->writer->print(' '.$name.'="'.$value.'"');
      }
   }
   
   function writeComment($comments)
   {
      if ( $this->previous === XML_COMMENT_ELEMENT || $this->previous === XML_END_ELEMENT || $this->previous < 0))
      {
         $this->writer->print('<!-- '.$comments.' -->\n');
      }
   }
   
   function writeText($text)
   {
      if (  $this->previous === XML_START_ELEMENT || 
            $this->previous === XML_ATT_ELEMENT)
      {
         $this->writer->print('>');
         $this->previous = XML_TEXT_ELEMENT;
         $this->writer->print($text);
      }
   }
   
   function writeCData($cdata)
   {
      if (  $this->previous === XML_START_ELEMENT || 
            $this->previous === XML_ATT_ELEMENT)
      {
         $this->writer->print('><![CDATA[');
         $this->previous = XML_TEXT_ELEMENT;
         $this->writer->print($text.']]>');
      }
   }
   
   function writeBase64($text)
   {
   
   }
   
   function writeBinHex($text)
   {
   
   }
   
   function writeProcessInstruction($target, $instruction)
   {
      
   }
}
?>