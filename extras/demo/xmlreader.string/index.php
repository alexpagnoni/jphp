<?php
/*----------------------------------------------------------------------*\
 *                      Calendar class demo                             *
\*----------------------------------------------------------------------*/
require_once('../_include.php');
JPHP::import('jphp.http.HttpRequest');
JPHP::import('jphp.io.StringReader');
JPHP::import('jphp.xml.dom.*');

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
   <strong>jphp://jphp.demo/XMLTreeReader/<a href="<?php echo $request->getRequestPath(), ($source?'">display demo</a>':'?source=TRUE">show-source</a>');?></strong></font>
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
   
   $buffers = '<?xml version="1" encoding="iso-8859-1"?><company name="My Widgets Inc."><employees><employee><deg value="1"/><name><first>John</first><last>Dole</last></name><office>1-50</office><telephone><![CDATA[123456]]></telephone></employee><employee><deg value="2"/><name><first>Jane</first><last>Dole</last></name><office>1-51</office><telephone><![CDATA[6749879879879879sdsdsds&nbsp;<b>8]]></telephone></employee></employees></company>';
   $document = XMLTreeReader::createDocument(new StringReader($buffers));
   ?>
   <strong>Loading XML content from :</strong> string buffer
   <br>
   <br>
   <dl><strong>Display string representation of XML content (XML generated from XML DOM Tree): </strong>
   <dd>
   <?
   $data = new StringBuffer($document->toString());
   $data = $data->replace('<','&lt;');
   $data = $data->replace('>','&gt;');
   $data = $data->replace("\r\n",'<br>');
   $data = $data->replace("\n",'<br>');
   $data = $data->replace("\t",'&nbsp;&nbsp;&nbsp;&nbsp;');
   print($data->toString());
   ?>
   </dl>
   </td>
</tr>
</table>
