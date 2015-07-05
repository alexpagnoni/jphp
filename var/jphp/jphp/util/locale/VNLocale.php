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

class VNLocale extends LocaleZone
{
	function VNLocale()
	{
		$this->local_code = "VN";
		$this->days_of_week = array(
			1 => "Thu*' Hai",
			2 => "Thu*' Ba",
			3 => "Thu*' Tu*",
			4 => "Thu*' Na(m",
			5 => "Thu*' Sa'o",
			6 => "Thu*' Bâ?y",
			7 => "Chu? Nhâ.t"
		);
		
		$this->months_of_year = array(
			1 => "Tha'ng Mô.t",
			2 => "Tha'ng Hai",
			3 => "Tha'ng Ba",
			4 => "Tha'ng Tu*",
			5 => "Tha'ng na(m",
			6 => "Tha'ng Sa'o",
			7 => "Tha'ng Bâ?y",
			8 => "Tha'ng Ta'm",
			9 => "Tha'ng Chi'nh",
			10 => "Tha'ng Mu*o*\i",
			11 => "Tha'ng Mu*o*\i Mô.t",
			12 => "Tha'ng Mu*o*\i Hai"
		);
	}
}
?>