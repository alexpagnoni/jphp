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

JPHP::import('jphp.util.Comparator');

class Arrays 
{ 
  function swap(&$array, $a, $b)
  {
      $object = $array[$a];
	   $array[$a] = $array[$b];
	   $array[$b] = $object;
  }
  
  function quickSort(&$array, &$comparator, $head_offset, $tail_offset)
  {
      $head = $head_offset;
      $tail = $tail_offset;
      
      $middle = intval(($head + $tail)/2);
      $pivot = $array[ $middle ];
      
      do
      {
         while($comparator->compare($array[$head], $pivot)<0 && $head<$tail_offset)
         {
            $head++;
         }
         while($comparator->compare($pivot,$array[$tail])<0 && $tail>$head_offset)
         {
             $tail--;
         }
         if( $head<=$tail )
         {
             Arrays::swap($array, $head++, $tail--);
         }
      }
      while( $head<=$tail );

      if( $head_offset<$tail )
      {
         Arrays::quickSort($array, $comparator, $head_offset, $tail);
      }
      
      if($head < $tail_offset)
      {
         Arrays::quickSort($array, $comparator, $head, $tail_offset);
      }
   }
   
   function bubbleSort(&$array, &$comparator, $head=0, $tail=0 )
   {
      $tail = (int)$tail;
      $head = (int)$head;
      $len = is_array($array) ? count($array) : 0;
      if ( ($tail-$head) == 2)
      {
         if ($comparator->compare($array[$head], $array[$head+1])<0)
         {
            Arrays::swap($array, $head, $head+1);
         }
         return;
      }
      
      for ($j = $tail; $j>$head; $j--)
      {
	      for ($i = $head; $i<$j; $i++)
	      {
	         if ($comparator->compare($array[$i],$array[$i+1])>0)
	         {
               Arrays::swap($array, $i, $i+1);
	         }
	      }
      }
   }
   
   function bubbleQuickSort(&$array, &$comparator, $head_offset, $tail_offset, $limit=10)
   {
      $head = (int)$head_offset;
      $tail = (int)$tail_offset;
      
      if (($tail-$head)<=$limit)
      {
         Arrays::bubbleSort($array, $comparator, $head, $tail);
      }
      $middle = intval(($head + $tail)/2);
      $pivot = $array[ $middle ];
      
      do
      {
         while($comparator->compare($array[$head], $pivot)<0 && $head<$tail_offset)
         {
            $head++;
         }
         while($comparator->compare($pivot,$array[$tail])<0 && $tail>$head_offset)
         {
             $tail--;
         }
         if( $head<=$tail )
         {
             Arrays::swap($array, $head++, $tail--);
         }
      }
      while( $head<=$tail );

      if( $head_offset<$tail )
      {
         Arrays::quickSort($array, $comparator, $head_offset, $tail);
      }
      
      if($head < $tail_offset)
      {
         Arrays::quickSort($array, $comparator, $head, $tail_offset);
      }
   }
   
   function insertQuickSort(&$array, &$comparator, $head_offset, $tail_offset, $limit=200)
   {
      $head = (int)$head_offset;
      $tail = (int)$tail_offset;
      
      if (($tail-$head)<=$limit)
      {
         Arrays::insertSort($array, $comparator, $head, $tail);
      }
      $middle = intval(($head + $tail)/2);
      $pivot = $array[ $middle ];
      
      do
      {
         while($comparator->compare($array[$head], $pivot)<0 && $head<$tail_offset)
         {
            $head++;
         }
         while($comparator->compare($pivot,$array[$tail])<0 && $tail>$head_offset)
         {
             $tail--;
         }
         if( $head<=$tail )
         {
             Arrays::swap($array, $head++, $tail--);
         }
      }
      while( $head<=$tail );

      if( $head_offset<$tail )
      {
         Arrays::quickSort($array, $comparator, $head_offset, $tail);
      }
      
      if($head < $tail_offset)
      {
         Arrays::quickSort($array, $comparator, $head, $tail_offset);
      }
   }
   
   function insertSort(&$array, &$comparator, $head, $tail)
   {
      for ($i = 1; $i<count($array); $i++)
      {
	      $j = $i;
	      $object = $array[$i];
	      while (($j > 0) && $comparator->compare($array[$j-1], $object)>0)
	      {
            $array[$j] = $array[$j - 1];
	         $j--;
	      }
	      $array[$j] = $object;
	   }
   }
   
   function trimMedianQuickSort(&$array, &$comparator, $head, $tail, $median=4)
   {
   	$median = (int)$median;
      if (($tail-$head)>$median)
	   {
		   $i = intval(($tail+$head)/2);
		   if ($comparator->compare($array[$head], $array[$i])>0)
         {
            Arrays::swap($array, $head, $i);
         }
		   if ($comparator->compare($array[$head], $array[$tail])>0) 
         {
            Arrays::swap($array, $head, $tail);
         }
		   if ($comparator->compare($array[$i], $array[$tail])>0)
         {
            Arrays::swap($array, $i, $tail);
         }
   		
         $j = $tail-1;
		   Arrays::swap($array, $i, $j);
		   $i = $head;
		   $v = $array[$j];
		   for(;;)
		   {
            $i++;
            while($comparator->compare($array[$i],$v)<0)
            {
               $i++;
            }
            $j--;
            while($comparator->compare($array[$j],$v)>0)
			   {
               $j--;
            }
			   if ($j<$i) 
            {
               break;
            }
			   Arrays::swap($array, $i, $j);
         }
         Arrays::swap($array, $i, $tail-1);
         Arrays::trimMedianQuickSort($array, $comparator, $head, $j, $median);
         Arrays::trimMedianQuickSort($array, $comparator, $i+1, $tail, $median);
   	}
      else
      {
         Arrays::insertSort($array, $comparator, $head, $tail);
      }
	}
   
   
   function validClass($object)
   {
      return (isset($object) && is_array($object));
   }
}
