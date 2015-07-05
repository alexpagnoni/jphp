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


class AbstractSAXParser extends Object
{
   var $parserResource = NULL;
   var $documentHandler = NULL;
   function AbstractSAXParser()
   {
      // create a parser
      $this->parserResource = xml_parser_create();
      if (isset($this->parserResource))
      {
         // allowing object instance to use the xml parser
         xml_set_object($this->parserResource, $this);
         // set tag event handler
         xml_set_element_handler( $this->parserResource, "startTagElement", "endTagElement" );
         // set CDATA event handler
         xml_set_character_data_handler( $this->parserResource, "cdataElement");
         // set processing instruction handler
         xml_set_processing_instruction_handler ( $this->parserResource, "instructionElement");
         // set undeclare entity
         xml_set_unparsed_entity_decl_handler ( $this->parserResource, "undeclaredEntityElement" );
         // set notation delcaration handler
         xml_set_notation_decl_handler ( $this->parserResource, "notationDeclarationElement");
         // set external entity handler
         xml_set_external_entity_ref_handler ( $this->parserResource, "externalEntityElement");

         // seat default parser option
         xml_parser_set_option($this->parserResource, XML_OPTION_SKIP_WHITE, 1); 
         xml_parser_set_option($this->parserResource, XML_OPTION_CASE_FOLDING, 0);
         xml_parser_set_option($this->parserResource, XML_OPTION_TARGET_ENCODING, 'UTF-8');
      }
   }
   
   // parse function
   function parse($data)
   {
      $res = xml_parse($this->parserResource, $data);
      return $res;
   }
   
   // free resource 
   function close()
   {
      return @xml_parser_free($this->parserResource);
   }
   // get error code
   function getExceptionNumber()
   {
      return xml_get_error_code($this->parserResource);
   }
   
   // get error message
   function getExceptionMessage()
   {
      return xml_error_string($this->parserResource);
   }
   
   // event handler : start tag element
   function startTagElement(&$parserHandle, $elementName, $attributes)
   {
      
   }
   
   // event handler : end tag element
   function endTagElement(&$parserHandle, $elementName)
   {
      
   }
   
   // event handler : cdata
   function cdataElement(&$parserHandle, $cdata)
   {
      
   }
   
   // event  handler : processing instruction element
   function instructionElement(&$parserHandle, $target , $data)
   {
   
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