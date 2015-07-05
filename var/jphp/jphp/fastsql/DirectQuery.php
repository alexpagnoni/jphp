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


JPHP::import('jphp.sql.*');

class DirectQuery extends Object
{
   var $conn = NULL;
   function DirectQuery($driver, $host=NULL, $dbname=NULL, $user=NULL, $pass=NULL)
   {
      if (Connection::validClass($driver))
      {
         $this->conn =& $driver;
      }
      else if (URL::validclass($driver))
      {
         $this->conn =& Connection::getInstance($driver);
      }
      else
      {
         $this->conn =& Connection::getInstance($driver, $host, $dbname, $user, $pass);
      }
   }
   
   function query($query)
   {
      $query = StringBuffer::toStringBuffer($query);
      $query = $query->trimAll();
      $resuls = array();
      $this->conn->startConnection();
      $stm =  $this->conn->createStatement();
      if (preg_match('/^(delete from |insert into|update )/i',$query->toString()))
      {
         $res = $stm->execute($query->toString());
         $this->conn->endConnection();
         return $res;
      }
      else
      {
         $res = $stm->executeQuery($query->toString());
         while(($row = $res->nextRow()))
         {
            $results[] = $row;
         }
         $this->conn->endConnection();
         return $results;
     }
   }
   
   
   // direct insert
   function performInsert($table, $fields, $values)
   {
      $ifields = '';
      $ivalues = '';
      $fieldcount = 0;
      // failed if no values or fields and value must be store in an array
      if (!isset($fields)) return NULL;
      if (!isset($values) || !is_array($values)) return NULL;
      // validate field data 
      if (!is_array($fields))
      {
         $fields = StringBuffer::toStringBuffer($fields);
         $fields = preg_split('/,/', $fields->toString());
      }
      for ($i =0; $i<count($fields); $i++)
      {
         if (strlen(trim($fields[$i]))>0)
         {
            $ifields .= trim($fields[$i]).', ';
            $fieldcount++;
         }
      }
      $ifields = substr($ifields, 0, strlen($ifields)-2);
      // validate values
      if (count($values)!=$fieldcount) return;
      for ($i =0; $i<count($values); $i++)
      {
         if (strlen(trim($values[$i]))>0)
         {
            $ivalues .= '\''.str_replace("'","''",trim($values[$i])).'\' , ';
         }
      }
      $ivalues = substr($ivalues, 0, strlen($ivalues)-2);
      
      $query    =    'INSERT INTO ' . $table;
      $query   .=    ' ( '.$ifields.' ) VALUES ';
      $query   .=    ' ( '.$ivalues.' );';
      return $this->query($query);
   }
   // direct update
   function performUpdate($table, $fields, $values, $conditions)
   {
      $ifields = '';
      $ivalues = '';
      $fieldcount = 0;
      // failed if no values or fields and value must be store in an array
      if (!isset($fields)) return NULL;
      if (!isset($values) || !is_array($values)) return NULL;
      // validate field data 
      if (!is_array($fields))
      {
         $fields = StringBuffer::toStringBuffer($fields);
         $fields = preg_split('/,/', $fields->toString());
      }
      if (count($values)!=count($fields)) return;
      $query    =    'UPDATE ' . $table . ' SET ';
      for ($i =0; $i<count($fields); $i++)
      {
         if (strlen(trim($fields[$i]))>0)
         {
            $query   .= ' '.$fields[$i].'=';
            $query   .= '\''.str_replace("'","''",trim($values[$i])).'\',';
         }
      }
      $query    = substr($query, 0, strlen($query)-1);
      $query   .= ' WHERE ' . $conditions;
      
      return $this->query($query);
   }
   // direct delete
   function performDelete($table, $condition)
   {
      return $this->query('DELETE FROM '.$table.' WHERE '.$condition);
   }
   
   // direct select
   function performSelect($fields, $from, $where=NULL, $groupby=NULL,$orderby=NULL, $desc=NULL,$page=0,$record=0)
   {
      $query = new StringBuffer('SELECT ');
      if (isset($fields))
      {
         if (!is_array($fields))
         {
            $query->append($fields);
         }
      }
      if (isset($from))
      {
         if (is_array($from))
         {
            if (count($from)>0)
            {
               $query->append(implode(',', $from));
            }
         }
         else
         {
            $query->append(' FROM '.$from);
         }
      }
      $where = StringBuffer::toStringBuffer($where);
      if (isset($where) && $where->length()>0)
      {
         $query->append(' WHERE ' . $where->toString());
      }
      $groupby = StringBuffer::toStringBuffer($groupby);
      if (isset($groupby) && $groupby->length()>0)
      {
         $query->append(' GROUP BY ' . $groupby->toString());
      }
      if (isset($orderby))
      {
         if (!is_array($orderby))
         {
            $orderby = StringBuffer::toStringBuffer($orderby);
            $query->append(' ORDER BY ' . $orderby->toString());
            $query = $query->trimAll();
            if (isset($desc) && !$query->endsWith(' desc', TRUE) && $query->endsWith(' asc', TRUE))
            {
               $query->append(($desc==TRUE?' DESC':' ASC'));
            }
         }
         else
         {
            $query->append(' ORDER BY ' . implode(',',$orderby));
            $query = $query->trimAll();
            if (isset($desc) && !$query->endsWith(' desc', TRUE) && $query->endsWith(' asc', TRUE))
            {
               $query->append(($desc==TRUE?' DESC':' ASC'));
            }
         }
      }
      settype($record, 'integer');
      settype($page, 'integer');
      if ($record>0)
      {
         $query->append(' LIMIT '.$page.','.$record);
      }
      return $this->query($query);
   }
   
   // direct count
   function performCount($fields, $from, $where=NULL)
   {
      $query = new StringBuffer('SELECT ');
      if (isset($fields))
      {
         $query->append('Count('.$fields.') AS total');
      }
      else
      {
         $query->append('Count(*) AS total');
      }
      if (isset($from))
      {
         if (is_array($from))
         {
            if (count($from)>0)
            {
               $query->append(implode(',', $from));
            }
         }
         else
         {
            $query->append(' FROM '.$from);
         }
      }
      $where = StringBuffer::toStringBuffer($where);
      if (isset($where) && $where->length()>0)
      {
         $query->append(' WHERE ' . $where->toString());
      }
      
      $result = $this->query($query);
      if (isset($result) && is_array($result) && count($result)>0)
      {
         $result = $result[0];
         return $result['total'];
      }
      else
      {
         return 0;
      }
   }
   
   // direct max
   function performMax($fields, $from, $where=NULL)
   {
      $query = new StringBuffer('SELECT ');
      if (isset($fields))
      {
         $query->append('Max('.$fields.') AS total');
      }
      if (isset($from))
      {
         if (is_array($from))
         {
            if (count($from)>0)
            {
               $query->append(implode(',', $from));
            }
         }
         else
         {
            $query->append(' FROM '.$from);
         }
      }
      $where = StringBuffer::toStringBuffer($where);
      if (isset($where) && $where->length()>0)
      {
         $query->append(' WHERE ' . $where->toString());
      }
      
      $result = $this->query($query);
      if (isset($result) && is_array($result) && count($result)>0)
      {
         $result = $result[0];
         return $result['total'];
      }
      else
      {
         return 0;
      }
   }
   
   function validClass($object)
   {
      return Object::validClass($object,'directquery');
   }
}
?>