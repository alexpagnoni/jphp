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

class FRLocale extends LocaleZone
{
	function FRLocale()
	{
		$this->local_code = "FR";
		$this->days_of_week = array(
			1 => "Lundi",
			2 => "Mardi",
			3 => "Mercredi",
			4 => "Jeudi",
			5 => "Vendredi",
			6 => "Samedi",
			7 => "Dimanche"
		);
		
		$this->months_of_year = array(
			1 => "Janvier",
			2 => "Février",
			3 => "Mars",
			4 => "Avril",
			5 => "Mai",
			6 => "Juin",
			7 => "Juillet",
			8 => "Aout",
			9 => "Septembre",
			10 => "Octobre",
			11 => "Novembre",
			12 => "Decembre"
		);
	}
}
?>