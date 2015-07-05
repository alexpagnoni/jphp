<?php
/*----------------------------------------------------------------------*\
 *                      Calendar class demo                             *
\*----------------------------------------------------------------------*/
require_once('../_include.php');
JPHP::import('jphp.http.HttpRequest');
JPHP::import('jphp.io.FileReader');

$request = new HttpRequest();
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
   <strong>jphp://jphp.demo/FileReader/<a href="<?php echo $request->getRequestPath(), ($source?'">display demo</a>':'?source=TRUE">show-source</a>');?></strong></font>
   </td>
</tr>
<tr>
   <td bgcolor=#ffffff>
   <br>
   <br>
   <?php
   if ($source)
   {
      highlight_string(implode('', file(__FILE__)));
      exit();
   }
   ?>
   <strong>Loading properties file from :</strong> ./config.conf
   <br>
   <br>
   Display <strong>config.conf</strong> content :
   <dl><dd>
   <?php  
   $reader = new FileReader('config.conf');
   if ($reader->ready())
   {
      while( ($line=$reader->read()) != '' )
      {
         if ($line=="\n" || $line=="\r\n")
         {
            print("<br>\n");
         }
         else
         {
            print(htmlentities($line));
         }
      }
   }
   ?>
   </dl>
   </td>
</tr>
</table>
