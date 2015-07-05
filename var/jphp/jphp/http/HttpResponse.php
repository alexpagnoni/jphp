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

JPHP::import('jphp.http.interface.IHttpResponse');
JPHP::import('jphp.util.StringBuffer');

class HttpResponse extends IHttpResponse
{
   var $output_buffering = FALSE;
   
   function HttpResponse($buffering=FALSE)
   {
      $this->output_buffering = (boolean)$buffering;
   }
   
   function addCookie($cookie) 
   {
      if (Cookie::validClass($cookie) && $cookie->getName()!='')
      {
         $v = $cookie->getValue();
         if (!isset($v) || strlen(trim($v))==0)
         {
            return setCookie($cookie->getName());
         }
         else
         {
            return setCookie (   $cookie->getName(), 
                                 $cookie->getValue() , 
                                 $cookie->getMaxAge(), 
                                 $cookie->getPath() , 
                                 $cookie->getDomain(),
                                 $cookie->isSecure());
         }
      }
      return -1;
   }
   
   function sendRedirect($location)
   {
      if (isset($location) && !empty($location))
      {
         $this->setHeader('Location', $location);
         exit();
      }
   }
   
   function setContentLength($length)
   {
      $length = (int)$length;
      $this->setHeader('Content-length', $length);
   }
   function setContentType($content)
   {
      $this->setHeader('Content-type', $content);
   }
   
   function displayImage($file, $itype='')
   {
      $file = StringBuffer::toStringBuffer($file);
      $type = '';
      if (isset($file) && $file->length()>0 && file_exists($file->toString()) && is_file($file->toString()))
      {
         $file = $file->toLowerCase();
         if ($file->endsWith('jpg') || $file->endsWith('jpeg'))
         {
            $type = 'jpeg';
         }
         else if ($file->endsWith('gif'))
         {
            $type = 'gif';
         }
         else if ($file->endsWith('png'))
         {
            $type = 'png';
         }
         else if ($itype!='')
         {
            $type = explode('/', $itype);
            if (count($type)>1)
            {
               $type = $type[1];
            }
            else
            {
               $type = $itype;
            }
         }
         if ($type!='')
         {
            $this->setContentType($type);
            $this->setHeader('Content-Disposition', 'inline; filename=image/'.$type);
         }
     }
   }
   
   function sendFile(&$request, $file, $newname)
   {
      $useragent = $request->getUserAgent();
      $file = StringBuffer::toStringBuffer($file);
      $newname = StringBuffer::toStringBuffer($newname);
      $this->setContentType('application/force-download');
      
      if (isset($file) && $file->length()>0 && file_exists($file->toString()) && is_file($file->toString()))
      {
         if (!empty($useragent) && strstr($user, 'MSIE'))
         {
            $this->setHeader('Content-Disposition', 'filename='.((isset($newname) && $newname->length()>0)? $newname->toString() : $file->toString()).'%20'); // For IE
         }
         else
         {
            $this->setHeader('Content-Disposition', 'attachment; filename='.((isset($newname) && $newname->length()>0)? $newname->toString() : $file->toString()));
         }
         $this->setContentLength(filesize($file->toString()));
         $this->setHeader('Cache-control', 'private');
         readfile();
         exit();
      }
   }
   
   function sendNoCacheHeaders()
   {
      // HTTP 1.1 compatible
      $this->setHeader('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');
      $this->setLastModified(time());
      $this->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
      // HTTP 1.0 fix
      $this->setHeader('Pragma', 'no-cache');
   }
   
   function setLastModified($time='')
   {
      if ($time=='')
      {
         $time = time();
      }
      return $this->setHeader('Last-Modified', gmdate('D, d M Y H:i:s').' GMT');
   }
   
   function setHeader($header, $value) 
   {
      header($header.': '.$value);
   }
    
   function setStatus($number, $message='') 
   {
      if (defined('HTTP_STATUS_'.$number))
      {
         $msg = 'NO MESSAGE ...';
         if (isset($message) && strlen(trim($message))>0)
         {
            $msg = $message;
         }
         else
         {
            eval('if (defined("HTTP_STATUS_'.$number.'")) { $msg = HTTP_STATUS_'.$number.'; }');
         }
         $this->setHeader('Status', $number.' '.$msg);
         $this->setHeader('HTTP/1.0', $number.' '.$msg);
         return TRUE;
      }
      return FALSE;
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'httpresponse');
   }
}
?>