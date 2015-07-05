<?php
$dir = dirname(__FILE__);
$handle=opendir($dir);
?>
<font style='font-family: Verdana; font-size: 11px'>
<strong>Demo</strong>
<ol>
<?php
while ($file = readdir($handle)) 
{
   $path = $dir . '/' . $file;
   if ($file!=='.' && $file!=='..' && $file[0]!=='_' && is_dir($path))
   {
      ?>
      <a href="<?php echo isset($GLOBALS['PHP_SELF']) ? dirname($GLOBALS['PHP_SELF']).'/'.$file : ''?>"><?php echo $file?></a>
      <br>
      
      <?php
   }
}
?>
</ol>
</font>