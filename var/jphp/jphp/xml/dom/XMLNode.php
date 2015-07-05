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

define('XML_ELEMENT',                     1);
define('XML_ATTRIBUTE',                   2);
define('XML_TEXT',                        3);
define('XML_CDATA',                       4);
define('XML_ENTITY_REFERENCE',            5);
define('XML_ENTITY',                      6);
define('XML_PROCESSING_INSTRUCTION',      7);
define('XML_COMMENT',                     8);
define('XML_DOCUMENT',                    9);
define('XML_DOCUMENT_TYPe',              10);
define('XML_DOCUMENT_FRAGMENT',          11);
define('XML_NOTATION',                   12);

JPHP::import('jphp.datastructure.interface.ITreeNode');

class XMLNode extends ITreeNode
{
   var $node_name       = NULL;
   var $node_type       = NULL;
   var $node_value      = NULL;
   var $node_level      = 0;
   
   // parent reference
   var $parent_node     = NULL;
   // child, previous and next brother
   var $child           = NULL;
   var $sibling         = NULL;
   var $previous_sibling = NULL;
   
   var $attributes      = NULL;
   var $document        = NULL;
   
   function XMLNode()
   {
      $this->attributes = array(); 
      $this->node_value = array();
      $this->node_type = XML_ELEMENT;
   }
   
   function setDocument(&$document)
   {
      if (XMLDocument::validClass($document))
      {
         $this->document =& $document;
      }
   }
   function & getDocument()
   {
      return $this->document;
   }
   
   function attributes()
   {
      return array_values($this->attributes);
   }
   
   function appendValue($value)
   {
      if (strlen(trim($value))>0)
      {
         $this->node_value[] = $value;
      }
   }
   
   function & setAttribute($attribute)
   {
      if (XMLAttribute::validClass($attribute) && isset($attribute->name))
      {
         $attribute->setParentNode($this);
         $this->attributes[$attribute->name] =& $attribute;
      }
      return $this;
   }
   
   function & getAttribute($name)
   {
      if (isset($name) && isset($this->attributes[$name]))
      {
           return $this->attributes[$name];
      }
      return NULL;
   }
   
   function & childNodes()
   {
      $node_list = new XMLNodeList();
      $sibling = NULL;
      if (isset($this->child))
      {
         $node_list->nodes[] =& $this->child;
         $sibling =& $this->child->nextSibling();
         while (isset($sibling))
         {
            $node_list->nodes[] =& $sibling;
            $sibling =& $sibling->nextSibling();
         }
      }
      return $node_list;
   }
   
   function & firstChild()
   {
      //Returns the first child node for this node 
      return $this->child;
   }
   
   function & lastChild()
   {
      //Returns the last child node for this node 
      if (isset($this->child))
      {
         $child =& $this->child;
         $sibling =& $child->nextSibling();
         while(isset($sibling))
         {
            $child =& $sibling;
            $sibling =& $child->nextSibling();
         }
         return $child;
      }
      return NULL;
   }
   
   function & nextSibling()
   {
      static $sibling;
      if (isset($sibling))
      {
         if (isset($sibling->sibling))
         {
            $sibling =& $sibling->sibling;
         }
      }
      else
      {
         if (isset($this->sibling))
         {
            $sibling =& $this->sibling;
         }
      }
      return $sibling;
   }
   
   function & previousSibling()
   {
      static $sibling;
      if (isset($sibling))
      {
         if (isset($sibling->previous_sibling))
         {
            $sibling =& $sibling->previous_sibling;
         }
      }
      else
      {
         if (isset($this->previous_sibling))
         {
            $sibling =& $this->previous_sibling;
         }
      }
      return $sibling;
   }
   
   function nodeName()
   {
      //Returns the nodeName, depending on the type 
      return $this->node_name;
   }
   
   function nodeType()
   {
      //Returns the nodeType as a number 
      return $this->node_type;
   }
   
   function nodeValue()
   {
      //Returns, or sets, the value of this node, depending on the type 
      return $this->node_value;
   }
   
   function & ownerDocument()
   {
      //Returns the root node of the document 
      return $this->document;
   }
   
   function & parentNode()
   {
      //Returns the parent node for this node 
      return $this->parent_node;
   }
   
   function & appendChild(&$newChild)
   {
      //Appends the node newChild at the end of the child nodes for this node 
      if (XMLNode::validClass($newChild))
      {
         // set current document
         $newChild->node_level = $this->node_level+1;
         $newChild->setDocument($this->getDocument());
         // no child
         if (!isset($this->child))
         {
            $newChild->parent_node =& $this;
            $this->child =& $newChild;
         }
         else
         {
            // get last child
            $child =& $this->child;
            while (isset($child->sibling))
            {
               $child =& $child->sibling;
            }
            $newChild->parent_node =& $this;
            $newChild->previous_sibling =& $child;
            $child->sibling =& $newChild;
         }
      }
      return $newChild;
   }
   
   function & cloneNode($including_child=TRUE)
   {
      //Returns an exact clone of this node. If the boolean value is set to true, the cloned node contains all the child nodes as well 
      $clone_node = new XMLNode();
      
      $clone_node->node_name = $this->node_name;
      $clone_node->node_type = $this->node_type;
      $clone_node->node_value = $this->node_value;
      $clone_node->parent_node =& $this->parent_node;
      $clone_node->document =& $this->document;
      if ($including_child===TRUE)
      {
         $clone_node->child =& $this->child;
      }
      return $clode_nome;
   }
   function hasChildNodes()
   {
      //Returns true if this node has any child nodes 
      return isset($this->child);
   }
   
   // detach this node and its childs
   function & detachNode()
   {
      $this->parent_node = NULL;
      $this->previous_sibling =& $this->sibling;
      $this->child = NULL;
      return $this;
   }
   
   // get child
   function & getLeft() 
   {
      return $this->child;
   }
   function setLeft(&$left_node) 
   {
      return $this->child =& $left_node;
   }
   
   // get brother/sibling
   function & getRight() 
   {
      return $this->sibling;
   }
   
   function setRight(&$right_node) 
   {
      $this->sibling =& $right_node;
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'xmlnode');
   }
   
   function toString()
   {
      $xml = str_repeat("&nbsp;&nbsp;", $this->node_level)."<".$this->node_name;
      $keys = array_keys($this->attributes);
      for($i=0; $i<count($keys);$i++)
      {
         $att = $this->attributes[$keys[$i]];
         $xml .= " ".$keys[$i]."=\"".$att->value."\"";
         if ($i<(count($keys)-1))
         {
            $xml .= " ";
         }
      }
      
      if (!isset($this->child) && count($this->node_value)<=0)
      {
         $xml .= "/>\n";
      }
      else
      {
         $xml .= ">";
         if (count($this->node_value)>0)
         {
            for($i=0; $i<count($this->node_value); $i++)
            {
               $xml .= $this->node_value[$i];
            }
         }
         else
         {
            $xml .= "\n";
            $childs =& $this->childNodes();
            for ($i=0; $i<$childs->length(); $i++)
            {
               $obj = $childs->item($i);
               $xml .=$obj->toString();
            }
            $xml .= str_repeat("&nbsp;&nbsp;", $this->node_level);
         }
         $xml .= "</".$this->node_name.">\n";
      }
      return $xml;
   }
}
?>