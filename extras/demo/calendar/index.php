<?php
/*----------------------------------------------------------------------*\
 *                      Calendar class demo                             *
\*----------------------------------------------------------------------*/
require_once('../_include.php');
JPHP::import('jphp.http.HttpRequest');
JPHP::import('jphp.util.Calendar');
JPHP::import('jphp.util.Date');
JPHP::import('jphp.util.LocaleZone');

$request = new HttpRequest();
$cal = new Calendar();
$source = (boolean)$request->getParameter('source');
?>
<style type='text/css'>
<!--
   FONT,TD { font-family: Verdana; font-size: 11px}
   TD.name { background-color: #ffffff; color: #00000 }
   TD.value { background-color: #ffffff; color: #ff3300; font-weight: bold; width: 80px;}
//-->
</style>
<table cellspacing=1 cellpadding=4 border=0 width='760' bgcolor=#ececec>
<tr>
   <td bgcolor=#ffffff>
   <strong>jphp://jphp.demo/Calendar/<a href="<?php echo $request->getRequestPath(), ($source?'">display demo</a>':'?source=TRUE">show-source</a>');?></strong></font>
   </td>
</tr>
<tr>
   <td bgcolor=#ffffff>
   <br>
   <?php
   if ($source)
   {
      highlight_string(implode('', file(__FILE__)));
      exit();
   }
   ?>
   <dd><table cellpadding=4 cellspacing=1 bgcolor=#ececec border=0>
   <tr>
      <td class='name'>Time in second</td>
      <td class='value'><?php echo $cal->getTime()?></td>
   </tr>
   <tr>
      <td class='name'>current day of month</td>
      <td class='value'><?php echo $cal->getDay()?></td>
   </tr>
   <tr>
      <td class='name'>current month</td>
      <td class='value'><?php echo $cal->getMonth()?></td>
   </tr>
   <tr>
      <td class='name'>current year</td>
      <td class='value'><?php echo $cal->getYear()?></td>
   </tr>
   <tr>
      <td class='name'>current year is a leap year ?</td>
      <td class='value'><?php echo $cal->isLeapYear()?'Yes':'No'?></td>
   </tr>
   <tr>
      <td class='name'>day of year</td>
      <td class='value'><?php echo $cal->getDayOfYear()?></td>
   </tr>
   <tr>
      <td class='name'>Hour 12h/24h</td>
      <td class='value'><?php echo $cal->getHour(TRUE)?> / <?=$cal->getHour()?></td>
   </tr>
   <tr>
      <td class='name'>Minute</td>
      <td class='value'><?php echo $cal->getMinute()?></td>
   </tr>
   <tr>
      <td class='name'>Second</td>
      <td class='value'><?php echo $cal->getSecond()?></td>
   </tr>
   <tr>
      <td class='name'>day name</td>
      <td class='value'><?php echo $cal->getDayName()?></td>
   </tr>
   <tr>
      <td class='name'>Month name</td>
      <td class='value'><?php echo $cal->getMonthName()?></td>
   </tr>
   <tr>
      <td class='name'>Count days in month <?=$cal->getMonthName()?></td>
      <td class='value'><?php echo $cal->countDaysInMonth()?></td>
   </tr>
   <tr>
      <td class='name'>First day name of the month</td>
      <td class='value'><?php echo $cal->getFirstDayName()?></td>
   </tr>
   <tr>
      <td class='name'>Timezone offset in second</td>
      <td class='value'><?php echo $cal->getTimezoneOffset()?></td>
   </tr>
   <tr>
      <td class='name'>Date list from -5 days to now</td>
      <td class='value'>
      <?php 
         $date_from = new Calendar();
         $date_to = new Calendar();
         $date_from->add('day', -5);
         $list = Calendar::generateDateList($date_from, $date_to, 'dd/MM/yyyy');
         $list_len = count($list);
         for($i=0; $i<$list_len; $i++)
         {
           echo $list[$i], '<br>';
         }
      ?>
      </td>
   </tr>
   </table>
   </td>
</tr>
</table>
