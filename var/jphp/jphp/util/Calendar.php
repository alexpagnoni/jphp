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

JPHP::import('jphp.util.Date,jphp.util.StringBuffer,jphp.util.Date,jphp.util.LocaleZone');

class Calendar extends Object
{
	var $dateobj = NULL;
	var $locale = NULL;
   
	function Calendar($dateobj='', $locale='')
	{
		if (!LocaleZone::validClass($locale)) 
		{
         $locale = new LocaleZone();
			$locale = $locale->getDefaultZone();
		}
      $this->locale = $locale; 
      
      if (Date::validClass($dateobj))
      {
         $this->dateobj = $dateobj;
      }
      else
      {
         $this->dateobj = new Date($dateobj);
      }
	}
	
	function setDate($year='', $month='', $day='', $hour='', $min='', $sec='')
	{
		$year = (int)$year;
		$month = (int)$month;
		$day = (int)$day;
		$hour = (int)$hour;
		$min = (int)$min;
		$sec = (int)$sec;
      $this->dateobj = new Date(mktime($hour, $min, $sec, $month, $day, $year));
	}
	
   function getDate()
   {
      return $this->dateobj();
   }
   
   function getLocale()
   {
      return $this->locale;
   }
   
	function setLocale($locale)
   {
      $this->locale = $locale;
   }
   
	function getTime()
	{
		return $this->dateobj->getTime();
	}
	
	function setTime($time)
	{
		$this->dateobj->setTime($time);
	}
	
	function getDay($prefix=TRUE)
	{
		return $this->get('day',$prefix);
	}
	
	function getDayOfWeek()
	{
		$date = getdate($this->getTime());
		return $date['wday'];
	}
	
	function getDayName()
	{
      return $this->locale->getDayOfWeek($this->getTime());
	}
	
	function getMonth($prefix=TRUE)
	{
		return $this->get('month', $prefix);
	}
	
	function getMonthName()
	{
		return $this->locale->getMonthOfYear($this->getTime());
	}
	
	function getYear()
	{
		return $this->get('year');
	}
	
	function getHour($pm=FALSE)
	{
		return $this->get('hour', FALSE, $pm);
	}
	
	function getMinute()
	{
		return $this->get('minute');
	}
	
	function getSecond()
	{
		return $this->get('second');
	}
	
	function countDaysInMonth($year='', $month = '')
	{
      $month = (int)$month;
		$year = (int)$year;
				
		if ($year==0)
      {
         $year = $this->getYear();
      }
      if ($month==0)
      {
         $month = $this->getMonth();
      }
		$month = ($month<10 && $month>0) ? '0'.$month : $month;
		$dummies = $year.'-'.$month.'-01';
		$t = strtotime($dummies);
		return date('t', $t);
	}
	
   function getFirstDayName($year='', $month='')
	{
		$month = (int)$month;
		$year = (int)$year;
		if ($year==0)
      {
         $year = $this->getYear();
      }
      if ($month==0)
      {
         $month = $this->getMonth();
      }
		$month = ( ($month<10 && $month>0) ? '0'.$month : $month);
		$dummies = $year.'-'.$month.'-01';
      $t = strtotime($dummies);
      return $this->locale->getDayOfWeek($t);//date('w', $t);
	}
	
   function getTimezoneOffset()
   {
      return $this->get('timezone');
   }
   
   function getDayOfYear()
   {
      return $this->get('dayofyear');
   }
	function get($field, $prefix=FALSE, $pm=FALSE)
	{
      $field = StringBuffer::toStringBuffer($field);
		if ($field->equalsIgnoreCase('year'))
		{
			return date('Y', $this->getTime());
		}
		if ($field->equalsIgnoreCase('month'))
		{
		   $f = ( $prefix==TRUE ? 'm' : 'n' );
   		return date($f, $this->getTime());
      }
		if ($field->equalsIgnoreCase('day'))
      {
		   $f = ( $prefix==TRUE ? 'd' : 'j' );
      	return date($f, $this->getTime());
		}
      if ($field->equalsIgnoreCase('dayofyear'))
      {
		   return date('z', $this->getTime());
		}
      if ($field->equalsIgnoreCase('hour'))
      {
		   $f = ( $pm==TRUE ? ( $prefix==TRUE ? 'h' : 'g' ) : ( $prefix==TRUE ? 'H' : 'G' ) );
      	return date($f, $this->getTime());
		}
      if ($field->equalsIgnoreCase('minute'))
      {
         $s = date('i', $this->getTime());
         if ($prefix==FALSE && $s[0]=='0')
         {
            $s = substr($s, 1);
         }
		   return $s;
		}
      if ($field->equalsIgnoreCase('second'))
      {
         $s = date('s', $this->getTime());
         if ($prefix==FALSE && $s[0]=='0')
         {
            $s = substr($s, 1);
         }
		   return $s;
		}
      if ($field->equalsIgnoreCase('timezone'))
      {
         return date('Z', $this->getTime());
      }
      return FALSE;
	}
	
	function set($field, $value)
	{
      $value = StringBuffer::toStringBuffer($value);
		$day =   $this->get('day');
		$month = $this->get('month');
		$year =  $this->get('year');
		$hour =   $this->get('hour');
		$min = $this->get('minute');
		$sec =  $this->get('second');
		
		if ($field=='year')
		{
			$year = $value->intValue();
		}
		else if ($field=='month')
		{
			$month = $value->intValue();
		}
		else if ($field=='day')
		{
			$day = $value->intValue();
		}
      else if ($field=='hour')
      {
         $hour = $value->intValue();
      }
      else if ($field=='minute')
      {
         $min = $value->intValue();
      }
      else if ($field=='second')
      {
         $sec = $value->intValue();
      }
		
		$this->dateobj =  new Date(mktime($hour, $min, $sec, $month, $day, $year));
	}
	
	function add($field, $offset)
	{
		$offset = StringBuffer::toStringBuffer($offset);
		$day = $this->get('day');
		$month = $this->get('month');
		$year = $this->get('year');
		$hour =   $this->get('hour');
		$min = $this->get('minute');
		$sec =  $this->get('second');
      
		if ($field=='year')
		{
			$year = $year + $offset->intValue();
		}
		else if ($field=='month')
		{
			$month = $month + $offset->intValue();
		}
		else if ($field=='day')
		{
			$day = $day + $offset->intValue();
		}
		else if ($field=='hour')
		{
			$hour = $hour + $offset->intValue();
		}
		else if ($field=='minute')
		{
			$minute = $minute + $offset->intValue();
		}
		else if ($field=='second')
		{
			$second = $second + $offset->intValue();
		}
		
      $this->dateobj =  new Date(mktime($hour, $min, $sec, $month, $day, $year));
	}
	
	function isLeapYear($year='')
	{
		$month = 2;
		$year = (int)$year;
		if ($year==0) 
      {
         $year = $this->get('year');
      }
		$count = $this->countDaysInMonth($year, $month);
		return ($count==29);
	}
	
   function compare($cal)
	{
      if (Calendar::validClass($cal))
      {
   		$ta = $this->getTime();
   		$tb = $cal->getTime();
   		if ($ta>$tb)
   		{
   			return 1;
   		}
   		else if ($ta<$tb)
   		{
   			return -1;
   		}
   		else
   		{
   			return 0;
   		}
      }
      return FALSE;
	}
	
	function format($pattern, $time='', $javapattern=TRUE)
	{
      if ($time=='') 
      {
         $time = $this->getTime();
      }
      return $this->locale->formatDate($pattern, $time, $javapattern);
	}
	
	function generateDateList($from, $to, $pattern, $step=1)
	{
      $values = array();
		if (Calendar::validClass($from) && Calendar::validClass($to))
		{
			$start_str = $from->format($pattern);
         $stop_str = $to->format($pattern);
			$comp = $from->compare($to);
			if ($comp>0)
			{
				$step = -$step;
			}
         $values[count($values)] = $start_str;
			while ($start_str!=$stop_str)
			{
				$from->add('day', $step);
				$start_str = $from->format($pattern);
				$values[count($values)] = $start_str;
      	}
         return $values;
		}
	}
   
   function validClass($object)
   {
      return Object::validClass($object, 'calendar');
   }
}
?>