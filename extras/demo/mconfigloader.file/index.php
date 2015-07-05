<?php
/*----------------------------------------------------------------------*\
 *                      Calendar class demo                             *
\*----------------------------------------------------------------------*/
require_once('../_include.php');
JPHP::import('jphp.http.HttpRequest');
JPHP::import('jphp.util.MultiConfigLoader');

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
   <strong>jphp://jphp.demoMulti/ConfigLoader/<a href="<?php echo $request->getRequestPath(), ($source?'">display demo</a>':'?source=TRUE">show-source</a>');?></strong></font>
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
   <strong>Loading properties file from :</strong> ./mconfig.conf
   <br>
   <?php
   $config = new MultiConfigLoader('mconfig.conf');
   $config->loadFromFile();
   ?>
   <dl>
   <strong>Display properties context list :</strong>
   <?php
   for ($keys = $config->keys(); $keys->hasMoreElements();)
   {
      $key = $keys->nextElement();
      echo '<dd>&middot; ', $key;
      print('<ol>');
         $conf = $config->get($key);
         for ($ckeys = $conf->keys(); $ckeys->hasMoreElements();)
         {
            $ckey = $ckeys->nextElement();
            print('<li>'.$ckey . ' : ' . $conf->get($ckey));
         }
      print('</ol>');
   }
   ?>
   </dl>
   </td>
</tr>
</table>
