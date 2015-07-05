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

JPHP::import('jphp.io.IReader,jphp.io.FileReader');
JPHP::import('jphp.util.Hashtable');

define(  'CONFIG_COMMENT',          '#');
define(  'CONFIG_SEPARATOR',        '=');
define(  'CONFIG_END_KEY',        "\n");

class ConfigLoader extends Hashtable
{
	var $reader       = NULL;
	
   function ConfigLoader($reader)
	{
      if (IReader::validClass($reader))
      {
		   $this->reader =&  $reader;
      }
      else 
      {
         $this->reader =& new FileReader($reader);
      }
	}
   
	function loadFromFile()
	{
		$configname = new StringBuffer();
      $buffers = new StringBuffer();
		$key = '';
		$value = '';
		$conf = '';
		
		$skipline = 0;
		
		$c = '';
      if ($this->reader->ready())
		{
         while(($c = $this->reader->read())!='')
			{
            if ($c==CONFIG_END_KEY)
				{
					if ($buffers->length()>0)
					{
						$buffers = $buffers->trimAll();
						if (!$buffers->startsWith(CONFIG_COMMENT))
						{
                     $key_separator_pos = $buffers->indexOf(CONFIG_SEPARATOR);
							if ($key_separator_pos>0)
							{
								$key = $buffers->substring(0, $key_separator_pos);
								$key = $key->trimAll();
								
								$value = $buffers->substring($key_separator_pos+1);
								$value = $value->trimAll();
								
								if ($key->length()>0 && $value->length()>0)
								{
									$str = $this->get($key->toString()) . $value->toString();
									$this->put($key->toString(), $str);
								}
							}
						}
					}
					$buffers = new StringBuffer();
				}
				else
				{
					$buffers->append($c);
				}
			}
			if ($buffers->length()>0)
			{
				$key_separator_pos = $buffers->indexOf(CONFIG_SEPARATOR);
				if ($key_separator_pos>0)
				{
					$key = $buffers->substring(0, $key_separator_pos);
					$key = $key->trimAll();
					
					$value = $buffers->substring($key_separator_pos+1);
					$value = $value->trimAll();
					if ($key->length()>0 && $value->length()>0 && $this->acceptableKey($key))
					{
						$str = $this->get($key->toString()) . $value->toString();
						$this->put($key->toString(), $str);
					}
				}
         }
         
		}
	}
   
   function validClass($object)
   {
      return Object::validClass($object, 'calendar');
   }
}
?>