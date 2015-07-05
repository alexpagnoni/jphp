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

class URL extends Object
{
   var $protocol = NULL;
   var $username = NULL;
   var $password = NULL;
   var $host = NULL;
   var $port = 80;
   var $urlile = NULL;
   var $query = NULL;
   var $anchor = NULL;
   
   var $default_port = 80;
   var $default_protocol = "http";
   
   function URL($spec)
   {
      if (Object::validClass($spec))
      {
         $spec = $spec->toString();
      }
      $results = array();
      preg_match('/^((.*?):\/\/)?(([^:]*):([^@]*)@)?([^\/:]*)(:([^\/]*))?([^\?]*\/?)?(\?(.*))?$/', $spec, $results);
      $this->protocol = strlen($results[2])>0 ? $results[2] : 'http';
      $this->username = $results[4];
      $this->password = $results[5];
      $this->host  = $results[6];
      $this->port  = strlen($results[8])>0 ? $results[8] : $this->default_port;
      $temp = preg_split('/\#/', $results[9]);
      $this->urlfile  = $temp[0];
      $this->anchor = count($temp)>=2 ? $temp[1] : '';
      $this->query  = (isset($results[11]) && strlen($results[11])>0) ? $this->parseQuery($results[11]) : array();
   }
   
   function setURL($protocol, $host, $port=NULL, $urlfile=NULL,$anchor=NULL, $query=NULL,$username=NULL, $password=NULL)
   {
      $this->protocol = $protocol;
      $this->host = $host;
      $this->port  =  isset($port) ? $port : $this->default_port ;
      $temp = preg_split('/\#/', $results[9]);
      $this->urlfile = '';
      if (isset($urlfile))
      {
         $temp = preg_split('/\#/', $urlfile);
         $this->urlfile  = $temp[0];
         if (count($temp)>=2)
         {
            $this->anchor = $temp[1];
         }
      }
      $this->anchor = isset($anchor) ? $anchor : '';
      $this->query  = isset($query) ? $this->parseQuery($query) : array();
      $this->username = isset($username) ? $username : '' ;
      $this->password = isset($password) ? $password : '' ;
   }
   
   function getProtocol()
   {
      return $this->protocol;
   }
   
   function getUserName()
   {
      return $this->username;
   }
   
   function getPassword()
   {
      return $this->password;
   }
   
   function getHost()
   {
      return $this->host;
   }
   
   function getPort()
   {
      return $this->port;
   }
   
   function getFile()
   {
      return $this->urlfile;
   }
   
   function getAnchor()
   {
      return $this->anchor;
   }
   
   function getQuery()
   {
      return $this->query;
   }
   
   function getQueryString()
   {
      $str = '?';
      $keys = array_keys($this->query);
      $len = count($keys);
      if ($len===0)
      {
         return '';
      }
      for ($i=0;$i<$len;$i++)
      {
         $key = urlencode($keys[$i]);
         $value = urlencode($this->query[$key]);
         $str .= $key.'='.$value;
         if ($i<($len-1))
         {
            $str .= '&';
         }
      }
      return $str;
   }
   
   function setQueryArray($array)
   {
      $res = array();
      $keys = array_keys($array);
      $len = count($keys);
      for ($i=0;$i<$len;$i++)
      {
         $key = urldecode($keys[$i]);
         $value = urldecode($array[$key]);
         $res[$key] = $value;
      }
      $this->query = $res;
   }
   
   function parseQuery($query)
   {
      $values = array();
      $params = preg_split('/&/', $query);
      $len = count($params);
      for ($i=0; $i<$len; $i++)
      {
         $param = $params[$i];
         $keypair =  preg_split('/=/', $param);
         if (count($keypair)==2)
         {
            $values[urldecode($keypair[0])] = urldecode($keypair[1]);
         }
      }
      return $values;
   }
   
   function toString()
   {
      $str = $this->getProtocol() . '://';
      if ($this->getUserName()!='')
      {
         $str .= $this->getUserName().':';
         $str .= $this->getPassword().'@';
      }
      $str .= $this->getHost() . ( $this->getPort()!=80 ? ':'.$this->getPort() : '');
      $str .= $this->getFile() . ( strlen($this->getAnchor())>0 ? '#'.$this->getAnchor() : '');
      $str .= $this->getQueryString();
      return $str;
   }
   
   function validClass($object)
   {
      return Object::validClass($object, 'url');
   }
}
?>