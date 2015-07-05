<?php
/*----------------------------------------------------------------------*\
 *                      Calendar class demo                             *
\*----------------------------------------------------------------------*/
require_once('../_include.php');
JPHP::import('jphp.http.HttpRequest');
JPHP::import('jphp.io.FileReader');
JPHP::import('jphp.http.servlet.*');

$request = new HttpRequest();
$source = (boolean)$request->getParameter('source');

$context =& new ServletContext('web.xml');
$request =& $context->getServletRequest();
$session =& $request->createSession();
$data =& $context->getServletConfig();
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
   <strong>jphp://jphp.demo/<a href="<?php echo $request->getRequestPath()?>">ServletXMLConfigReader</a>/<a href="<?php echo $request->getRequestPath(), ($source?'">display demo</a>':'?source=TRUE">show-source</a>');?></strong></font>
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
  <strong>Display name : </strong> 
      <font color="#990000" style='font-weight: bold'><?php echo $data->getDisplayName(); ?></font>
   <br>
   <br>
   <dl><strong>Context : </strong>
      <dd>&middot;&nbsp;Class use : 
         <font color="#990000" style='font-weight: bold'><?php echo $data->getContextManager(); ?></font>
      <dd><dl>&middot;&nbsp;Class properties : 
      <?php
         $names = $data->getContextManagerPropertyNames();
         while($names->hasMoreElements())
         {
            $name = $names->nextElement();
            ?>
            <dd>&middot;&nbsp;Name : <font color="#990000" style='font-weight: bold'><?php echo $name; ?></font>
            <dd>&middot;&nbsp;Value : <font color="#990000" style='font-weight: bold'><?php echo $data->getContextManagerProperty($name); ?></font>
            <?php
         }
      ?>
      </dl>
      <dd>&middot;&nbsp;Name : <font color="#990000" style='font-weight: bold'><?php echo $data->getContextName()?></font>
      <dd><dl>&middot;&nbsp;Attributes :
      <?php
         $names = $data->getContextAttributeNames();
         while($names->hasMoreElements())
         {
            $name = $names->nextElement();
            ?>
            <dd>&middot;&nbsp;Name : <font color="#990000" style='font-weight: bold'><?php echo $name; ?></font>
            <dd>&middot;&nbsp;Value : <font color="#990000" style='font-weight: bold'><?php echo $data->getContextAttribute($name);?></font>
            <?php
         }
      ?>
      </dl>
   </dl>
   <dl><strong>Session : </strong>
      <dd>&middot;&nbsp;Class use : <font color="#990000" style='font-weight: bold'><?php echo $data->getSessionManager(); ?></font>
      <dd><dl>&middot;&nbsp;Class properties : 
      <?php
         $names = $data->getSessionManagerPropertyNames();
         while($names->hasMoreElements())
         {
            $name = $names->nextElement();
            ?>
            <dd>&middot;&nbsp;Name : <font color="#990000" style='font-weight: bold'><?php echo $name; ?></font>
            <dd>&middot;&nbsp;Value : <font color="#990000" style='font-weight: bold'><?php echo $data->getSessionManagerProperty($name);?></font>
            <?php
         }
      ?>
      </dl>
      <dd>&middot;&nbsp;Timeout: <font color="#990000" style='font-weight: bold'><?php echo $data->getSessionTimeout()?></font>
   </dl>
   <dl><strong>Datasources :</strong>
   <?php
      $names = $data->getDataSourceNames();
      while($names->hasMoreElements())
      {
         $name = $names->nextElement();
         $users = $data->getDataSourceUsers($name);
         print('<dd><dl>Datasource ID : <strong>'.$name.'</strong>');
         while($users->hasMoreElements())
         {
            $user = $users->nextElement();
            $url = $data->getDataSourceURL($name, $user);
            ?>
            <dd>&middot;&nbsp;Profile : <font color="#990000" style='font-weight: bold'><?php echo $user; ?></font>
            <dd>&middot;&nbsp;URL : <font color="#990000" style='font-weight: bold'><?php echo $url->toString();?></font>
            <?php
         }
         print('</dl>');
      }
   ?>
   </dl>
   <dl><strong>Authenticator : </strong>
   <?php
      $names = $data->getAuthenticatorManagerNames();
      while($names->hasMoreElements())
      {
         $name = $names->nextElement();
         $authen = $data->getAuthenticatorManager($name);
         ?>
         <dd>
         <dl>&middot;&nbsp;Name : <font color="#990000" style='font-weight: bold'><?php echo $name; ?></font>
            <dd>&middot;&nbsp;Class use : <font color="#990000" style='font-weight: bold'><?php echo $authen; ?></font>
            <dd><dl>&middot;&nbsp;Class properties : 
            <?php
               $properties = $data->getAuthenticatorPropertyNames($name);
               while($properties->hasMoreElements())
               {
                  $property = $properties->nextElement();
                  ?>
                  <dd>&middot;&nbsp;Name :<font color="#990000" style='font-weight: bold'><?php echo $property?></font>
                  <br>&nbsp;&nbsp;Value : <font color="#990000" style='font-weight: bold'><?php echo $data->getAuthenticatorProperty($name, $property);?></font>
                  
                  <?php
               }
            ?>
            </dl>
         </dl>
         <?php
         
      }
   ?>   
   </dl>
   
   <dl><strong>Protected resource :</strong>
      <dd>&middot;&nbsp;Number of resources : <font color="#990000" style='font-weight: bold'><?php echo count($data->getResources())?></font>
      <?php
      for($i=0; $i<count($data->getResources()); $i++)
      {
      ?>
      <dd><dl>&middot;&nbsp;Resource n° <font color="#990000" style='font-weight: bold'><?php echo ($i+1)?></font>
         <dd>&middot;&nbsp;Name : <font color="#990000" style='font-weight: bold'><?php echo $data->getResourceName($i)?></font>
         <dd>&middot;&nbsp;URL Pattern : <font color="#990000" style='font-weight: bold'><?php echo $data->getResourceURLPattern($i)?></font>
         <dd>&middot;&nbsp;Protect GET request : <font color="#990000" style='font-weight: bold'><?php echo $data->protectGetOnResource($i) ? 'yes' : 'no' ?></font>
         <dd>&middot;&nbsp;Protect POST request : <font color="#990000" style='font-weight: bold'><?php echo $data->protectPostOnResource($i) ? 'yes' : 'no' ?></font>
      </dl>
      <?php
      }
      ?>
   </dl>
   </td>
</tr>
</table>
