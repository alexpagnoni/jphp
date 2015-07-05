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

JPHP::import('jphp.util.locale.*');
class LocaleZone extends Object
{
	var $days_of_week = '';
	var $months_of_year = '';
	var $counter = '';
	var $local_code = '';
	var $default_lang = 'en';
	
	var $java_map = array( 
		"y" => "y", 
		"yyyy" => "Y",
		"MMMM" => "F", 
		"MMM" => "M", 
		"MM" => "m", 
		"M" => "n", 
		"dddd" => "d", 
		"d" => "j", 
		"F" => "w", 
		"FFFF" => "w", 
		"E" => "D", 
		"EEEE" => "l", 
		"a" => "A", 
		"aaaa" => "A", 
		"H" => "G", 
		"HHHH" => "H", 
		"k" => "G+1", 
		"kkkk" => "H+1", 
		"K" => "g", 
		"KKKK" => "h", 
		"h" => "g+1", 
		"hhhh" => "h+1", 
		"m" => "i",
		"mmmm" => "i",
		"s" => "s",
		"ssss" => "s"
	);
	
	function LocaleZone()
	{
		$this->days_of_week = array();
		$this->months_of_year = array();
	}
	
	function isSpecialChar($c)
	{
		$sep = array (
			"#",
			"(",
			")",
			"[",
			"]",
			"{",
			"}",
			"~",
			"\\",
			"@",
			"§",
			"!",
			"*",
			"+",
			"=",
			"$",
			"£",
			"µ",
			"?",
			";",
			",",
			":",
			"!",
			"&",
			"²",
			".", 
			"/",
			"|",
			"-",
			"_",
			"\"",
			" "
		);
		return in_array($c, $sep);
	}
	
	function getJavaMap($key)
	{
		$value = @$this->java_map[$key];
		return $value;
	}
	function getDefaultLanguage()
	{
		return $this->default_lang;
	}
	
	function getDate($date = "")
	{
		return getdate(($date!=""?$date:time()));
	}
	
	function getHour()
	{
		$date = $this->getDate($date);
		return $date["hours"];
	}
	
	function getMinute()
	{
		$date = $this->getDate($date);
		return $date["minutes"];
	}
	
	function getSecond()
	{
		$date = $this->getDate($date);
		return $date["seconds"];
	}
	
	function getDay($date)
	{
		return $this->getDayOfMonth();
	}
	
	function getDayOfWeekNumber($date = "")
	{
		$date = $this->getDate($date);
		return ($date["wday"]!=0?$date["wday"]:7);
	}
	
	function getDayOfMonth($date = "")
	{
		$date = $this->getDate($date);
		return $date["mday"];
	}
	
	function getDayOfYear($date = "")
	{
		$date = $this->getDate($date);
		return $date["yday"];
	}
	
	function getDayOfWeek($date = "")
	{
		return $this->getLocal("days_of_week", $this->getDayOfWeekNumber($date));
	}
	
	function getMonthOfYear($date)
	{
		$date = $this->getDate($date);
		return $this->getLocal("months_of_year", $date["mon"]);
	}
	
	function getYear($date)
	{
		$date = $this->getDate($date);
		return $date["year"];
	}
	
	
	function getLocal($value, $index)
	{
		switch($value)
		{
			case "days_of_week":
				return $this->days_of_week[$index];
				break;
			case "months_of_year":
				return $this->months_of_year[$index];
				break;
		}
		return FALSE;
	}
	
	function formatDate($dateformat, $date = "", $javaformat=FALSE)
	{
		return $this->formatPHPDate(($javaformat==FALSE?$dateformat:$this->convertFromJavaDate($dateformat)), $date);
	}
	
	function parseString($datestring)
	{
		
	}
	
	function formatPHPDate($dateformat, $date = "")
	{
		if ($date=="") $date = time();
		$newformat = "";
		for ($i=0; $i<strlen($dateformat); $i++)
		{
			$value = "";
			switch($dateformat[$i])
			{
				case "D": 
					# jour de la semaine en 3 lettres
					if ($i==0 || $dateformat[($i-1)]!="\\")
					{
						$value = $this->getDayOfWeek($date);
						if (strlen($value)>3)
						{
							$value = substr($value, 0 , 3);
						}
					}
					break;
				case "l":
					# jour de la semaine en complet
					if ($i==0 || $dateformat[($i-1)]!="\\")
					{
						$value = $this->getDayOfWeek($date);
					}
					break;
				case "M":
					# mois de l'année en 3 lettres
					if ($i==0 || $dateformat[($i-1)]!="\\")
					{
						$value = $this->getMonthOfYear($date);
						if (strlen($value)>3)
						{
							$value = substr($value, 0 , 3).'.';
						}
					}
					break;
				case "F":
					# mois de l'année en complet
					if ($i==0 || $dateformat[($i-1)]!="\\")
					{
						$value = $this->getMonthOfYear($date);
					}
					break;
			}
			
			if ($value!="")
			{
				$newformat = substr($dateformat,0, $i);
				for ($j=0; $j<strlen($value); $j++)
				{
					$newformat .= "\\".$value[$j] ;
				}
				$newformat .= substr($dateformat,($i+1));
				return $this->formatDate($newformat, $date);
			}
		}
		return date($dateformat, $date);
	}
	
	function getLocalCode()
	{
		return $this->local_code;
	}
	
	function negociateLanguage() 
	{ 
	    global $HTTP_ACCEPT_LANGUAGE, $REMOTE_HOST; 
		$language = "";
		if ($HTTP_ACCEPT_LANGUAGE) 
		{ 
			
        	$accepted = explode(",", $HTTP_ACCEPT_LANGUAGE); 
			if (count($accepted)>0)
			{
				$lang = $accepted[0];
				if (class_exists(strtoupper($lang)."Local"))
				{
					return $lang;
				}
			}
    	}
		if (eregi("\\.[^\\.]+$", $REMOTE_HOST, $arr)) 
		{ 
			$lang = strtolower($arr[1]); 
			if (class_exists(strtoupper($lang)."Local"))
			{
				return $lang;
			}
		}
		return "en";
    } 
	
	function getZone($lang)
	{
		$local = "\$local = new ".strtoupper($lang)."Locale();";
		if (class_exists(strtoupper($lang)."Locale"))
		{
			eval($local);
			return $local;
		}
		return $this->getDefaultZone();
	}
	
	function getDefaultZone()
	{
		$lang = $this->getDefaultLanguage();
      $local = "\$local = new ".strtoupper($lang)."Locale();";
      eval($local);
		return $local;
	}
	
	function convertFromJavaDate($dateformat)
	{
		$i = 0;
		$buff = "";
		$quotec = 0;
		$fulltext = "";
		$ccount = "";
		$count = 1;
		$prevc = "";
		while($i<=strlen($dateformat))
		{
			$c = ($i<strlen($dateformat)?$dateformat[$i]:'');
			if ($c=="'")
			{
				if ($prevc=="'" && $quotec==0)
				{
					$quotec++;
					$fulltext .= "'";
				}
				else
				{
					$quotec++;
					if ($quotec==1 && $c!=$prevc )
					{
						if ($this->getJavaMap($prevc)!="")
						{
							$comp = 2;
							if ($prevc=="Y" ||$prevc=="E")
							{
								$comp = 4;
							}
							else if ($prevc=="F")
							{
								$comp = 1;
							}
							
							if ($prevc=="M")
							{
								if ($count<=1)
								{
									$buff .= $this->getJavaMap($prevc);
								}
								else if ($count==2)
								{
									$buff .= $this->getJavaMap(str_repeat($prevc, 2));
								}
								else if ($count==3)
								{
									$buff .= $this->getJavaMap(str_repeat($prevc, 3));
								}
								else if($count>=4)
								{
									$buff .= $this->getJavaMap(str_repeat($prevc, 4));
								}
							}
							else
							{
								if ($count>=$comp)
								{
									$buff .=  $this->getJavaMap(str_repeat($prevc, 4));
								}
								else
								{
									$buff .= $this->getJavaMap($prevc);
								}
							}
						}
						$count = 1;
					}
					if ($quotec==2)
					{
						$tmp = "";
						for ($j=0; $j<strlen($fulltext); $j++)
						{
							$tmp .= "\\".$fulltext[$j];
						}
						$buff .= $tmp;
						$fulltext = "";
						$quotec = 0;
					}
				}
			}
			else if ($quotec==1)
			{
				$fulltext .= $c;
			}
			else if ($this->isSpecialChar($c))
			{
				if ($prevc=="")
				{
					$count = 1;
				}
				else
				{
					if ($c==$prevc)
					{
						$count++;
					}
					else
					{
						if ($c!="" && $this->getJavaMap($prevc)!="")
						{
							$comp = 2;
							if ($prevc=="y" ||$prevc=="E")
							{
								$comp = 4;
							}
							else if ($prevc=="F")
							{
								$comp = 1;
							}
							if ($prevc=="M")
							{
								if ($count<=1)
								{
									$buff .= $this->getJavaMap($prevc);
								}
								else if ($count==2)
								{
									$buff .= $this->getJavaMap(str_repeat($prevc, 2));
								}
								else if ($count==3)
								{
									$buff .= $this->getJavaMap(str_repeat($prevc, 3));
								}
								else if($count>=4)
								{
									$buff .= $this->getJavaMap(str_repeat($prevc, 4));
								}
							}
							else
							{
								if ($count>=$comp)
								{
									$buff .= $this->getJavaMap(str_repeat($prevc, 4));
								}
								else
								{
									$buff .= $this->getJavaMap($prevc);
								}
							}
						}
						$count = 1;
					}
				}
				$buff .= ($c!=" "?"\\":"").$c;
			}
			else
			{
				if ($prevc=="")
				{
					$count = 1;
				}
				else
				{
					if ($c==$prevc)
					{
						$count++;
					}
					else
					{
						if ($this->getJavaMap($prevc)!="")
						{
							$comp = 2;
							if ($prevc=="y")
							{
								$comp = 4;
							}
                     else if ($prevc=="E")
                     {
                        $comp = 4;
                     }
							else if ($prevc=="F")
							{
								$comp = 1;
							}
							
							if ($prevc=="M")
							{
								if ($count<=1)
								{
									$buff .= $this->getJavaMap($prevc);
								}
								else if ($count==2)
								{
									$buff .= $this->getJavaMap(str_repeat($prevc, 2));
								}
								else if ($count==3)
								{
									$buff .= $this->getJavaMap(str_repeat($prevc, 3));
								}
								else if($count>=4)
								{
									$buff .= $this->getJavaMap(str_repeat($prevc, 4));
								}
							}
							else
							{
								if ($count>=$comp)
								{
									$buff .= $this->getJavaMap(str_repeat($prevc, 4));
								}
								else
								{
									$buff .= $this->getJavaMap($prevc);
								}
							}
						}
						$count = 1;
					}
					
				}
				
			}
			$prevc = $c;
			$i++;
		}
      return $buff;
	}
	
}
?>