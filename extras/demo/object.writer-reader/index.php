<?php
/*----------------------------------------------------------------------*\
 *                      Calendar class demo                             *
\*----------------------------------------------------------------------*/
require_once('../_include.php');
JPHP::import('jphp.http.HttpRequest');
JPHP::import('jphp.io.FileReader,jphp.io.FileWriter');
JPHP::import('jphp.io.ObjectReader,jphp.io.ObjectWriter');

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
   <strong>jphp://jphp.demo/ObjectReader-ObjectWriter/<a href="<?php echo $request->getRequestPath(), ($source?'">display demo</a>':'?source=TRUE">show-source</a>');?></strong></font>
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
   <dl><strong>Writing some samples data and object to data.obj file :</strong>
   <?php
   $writer = new ObjectWriter(new FileWriter('data.obj'));
   ?>
   <dd>&middot;&nbsp;writing an object : <font color="#990000" style='font-weight: bold'>new StringBuffer('my string object')</font>
   <?php
   $writer->writeObject(new StringBuffer('my string object'));
   ?>
   <dd>&middot;&nbsp;writing an litteral string : <font color="#990000" style='font-weight: bold'>my litteral string</font>
   <?php
   $writer->writeObject('my litteral string');
   ?>
   <dd>&middot;&nbsp;writing an object : <font color="#990000" style='font-weight: bold'>HttpRequest</font>
   <?php
   $writer->writeObject($request);
   ?>
   <dd>&middot;&nbsp;writing an integer : <font color="#990000" style='font-weight: bold'>15</font>
   <?php
   $writer->writeObject(15);
   ?>
   <dd>&middot;&nbsp;writing an boolean : <font color="#990000" style='font-weight: bold'>TRUE</font>
   <?php
   $writer->writeObject(TRUE);
   $writer->close();
   ?>
   </dl>
   <dl><strong>Reading object from data.obj file :</strong>
   <?php
   $reader = new ObjectReader(new FileReader('data.obj'));
   $obj = NULL;
   while(($obj=$reader->readObject())!==NULL)
   {
      ?>
      <dd>&middot;&nbsp;type : <font color="#990000" style='font-weight: bold'><?php echo gettype($obj)?></font>
      , class : <font color="#990000" style='font-weight: bold'><?php echo (gettype($obj)=='object'?get_class($obj) : gettype($obj))?></font>
      <br>&nbsp;&nbsp;content : 
      <?php
      if (is_object($obj))
      {
         $string = $obj->toString();
         print($string);
      }
      else
      {
         print($obj);
      }
      ?>
      <?php
   }
   $reader->close();
   ?>
   </dl>
   </td>
</tr>
</table>
