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

JPHP::import('jphp.io.File');

class UploadFile extends File
{
   var $upload_name = NULL;
   var $upload_type = NULL;
   var $upload_size = NULL;
   
   function UploadFile($name, $type, $size, $tmpfile)
   {
      parent::File($tmpfile);
      $this->setUploadFileType($type);
      $this->setUploadFileName($name);
      $this->setUploadFileSize($size);
   }
   
   function setUploadFileName($name)
   {
      $name = StringBuffer::toStringBuffer($name);
      $this->upload_name = $name;
   }
   
   function getUploadFileName()
   {
      return $this->upload_name;
   }
   
   function getUploadFileTempPath()
   {
      return $this->getFilePath();
   }
   
   function setUploadFileType($type)
   {
      $type = StringBuffer::toStringBuffer($type);
      $this->upload_type = $type;
   }
   
   function getUploadFileType()
   {
      return $this->upload_type;
   }
   
   function setUploadFileSize($size)
   {
      $this->upload_size = $size;
   }
   
   function getUploadFileSize()
   {
      return $this->upload_size;
   }
}
?>