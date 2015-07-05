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

class Vector
{
	var $index = -1;
	var $content = NULL;
	var $size = 0;
	
	function Vector($array='') 
	{
		$this->index = -1;
		$this->content = array();
		$this->addArray($array);
	}
	
	function size() 
	{
		return count($this->content);
	}
	
	function & elementAt($index) 
	{
      settype($index, 'integer');
		if( $this->size()>0 && $index<=$this->size()) 
		{
			return $this->content[$index];
		}
		return NULL;
	}
	
	function addArray($array)
	{
		if (is_array($array) && count($array)>0)
		{
			for ($i=0; $i<count($array); $i++)
			{
				$this->addElement($array[$i]);
			}
		}
	}
   
	function addElement(&$object) 
	{
		$this->content[] =& $object;
	}
	
	function insertElementAt($index, &$object) 
	{
      settype($index, 'integer');
		if ( $index <= $this->size() ) 
		{
			if ( $index < $this->size() ) 
			{
				$obj_tmp = array_slice($this->content, 0, $index);
				$obj_tmp[] =& $object;
				for ( $i=$index, $len = count($this->content); $i<$len ; $i++ ) 
				{
					array_push($obj_tmp, $this->content[$i]);
				}
				$this->content =& $obj_tmp;
			}
			else 
			{
				$this->content[] =& $object;
			}
		}
	}
	
	function & removeElementAt($index) 
	{
      settype($index, 'integer');
		if ( $index < $this->size() ) 
		{
			$temp_a = array_slice($this->content, 0, $index);
         $obj =& $this->content[$index];
			for ($i=($index+1), $len=count($this->content) ;$i<$len ; $i++ ) 
			{
				array_push($temp_a,$this->content[$i]);
			}
			$this->content =& $temp_a;
         return $obj;
		}
      return NULL;
	}
	
	function replaceElementAt($index, $object) 
	{
		settype($index, 'integer');
		if ( $index < $this->size() )
		{
			$this->content[$index] =& $object;
		}
	}
	
	function findValue($object)
	{
		return $this->findValueIndex($object)>=0?TRUE:FALSE;
	}
   
	function findValueIndex($object)
	{
		$objtype = gettype($object);
		for ( $i=0, $len=$this->size() ; $i<$len ; $i++ )
		{
         $target_type = gettype($this->content[$i]);
         if ($objtype==$target_type && $object==$this->content[$i])
         {
            return $i;
         }
		}
		return -1;
	}
   
   function validClass($object)
   {
      return Object::validClass($object, 'vector');
   }
   
}
?>