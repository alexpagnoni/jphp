<?php
/*----------------------------------------------------------------------*\
 *                      Calendar class demo                             *
\*----------------------------------------------------------------------*/
require_once('../_include.php');
JPHP::import('jphp.http.HttpRequest');
JPHP::import('jphp.util.ConfigLoader');

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
   <strong>jphp://jphp.demo/ConfigLoader.File/<a href="<?php echo $request->getRequestPath(), ($source?'">display demo</a>':'?source=TRUE">show-source</a>');?></strong></font>
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
   $url = 'http://'.$request->getServerName().dirname($request->getScriptName()).'/config.conf';
   
   $config = new ConfigLoader($url);
   $config->loadFromFile();
   ?>
   <strong>Loading properties file from :</strong>
   <br>
   <?php echo '<dd>',$url ?>
   <br>
   <br>
   <strong>Properties keys :</strong>
   <br>
   <?php
   for ($keys = $config->keys(); $keys->hasMoreElements();)
   {
      $key = $keys->nextElement();
      echo '<dd>&middot; ', $key, '<br>';
   }
   ?>
   <br>
   <strong>Keys and assigned value :</strong>
   <dd><table cellpadding=4 cellspacing=1 bgcolor=#ececec border=0>
   <?php
   for ($keys = $config->keys(); $keys->hasMoreElements();)
   {
      $key = $keys->nextElement();
   ?>
   <tr>
      <td class='name'><?php echo $key?></td>
      <td class='value'><?php echo $config->get($key)?></td>
   </tr>
   <?php
   }
   ?>
   </td>
</tr>
</table>
