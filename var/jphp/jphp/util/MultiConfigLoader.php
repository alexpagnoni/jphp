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

JPHP::import('jphp.util.ConfigLoader');

define(  'MULTICONFIG_START',        '[config:');
define(  'MULTICONFIG_END',          ']');

class MultiConfigLoader extends ConfigLoader
{
   function MultiConfigLoader($reader)
	{
		parent::ConfigLoader($reader);
	}
   
	function loadFromFile()
	{
		$configname = new StringBuffer();
		$buffers = new StringBuffer();
		$conf = NULL;
		$key = '';
		$value = '';
		
      $skipline = 0;
		$c = '';
		if ($this->reader->ready())
		{
			while(($c = $this->reader->read())!='')
			{
            if ($c==CONFIG_END_KEY)
				{
					if (isset($conf) && $buffers->length()>0)
					{
						$buffers = $buffers->trimAll();
						if (!$buffers->startsWith(CONFIG_COMMENT))
						{
							$key_separator_pos = $buffers->indexOf('=');
							if ($buffers->startsWith(MULTICONFIG_START) && $buffers->endsWith(MULTICONFIG_END))
							{
								if ($conf->size()>0)
								{
									$this->put($configname->toString(), $conf);
								}
								$i = $buffers->indexOf(':')+1;
								
                        $configname = $buffers->substring($i, $buffers->length()-1);
								$conf = new Hashtable();
							}
							else if ($key_separator_pos>0)
							{
								$key = $buffers->substring(0, $key_separator_pos);
								$key = $key->trimAll();
								
								$value = $buffers->substring($key_separator_pos+1);
								$value = $value->trimAll();
								
								if ($key->length()>0 && $value->length()>0)
								{
									$str = $conf->get($key->toString()) . $value->toString();
									$conf->put($key->toString(), $str);
								}
							}
						}
					}
					else
					{
						$buffers = $buffers->trimAll();
						if ($buffers->startsWith(MULTICONFIG_START) && $buffers->endsWith(MULTICONFIG_END))
						{
							$i = $buffers->indexOf(':')+1;
							$configname = $buffers->substring($i, $buffers->length()-1);
							$conf = new Hashtable();
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
				$key_separator_pos = $buffers->indexOf('=');
				if ($key_separator_pos>0)
				{
					$key = $buffers->substring(0, $key_separator_pos);
					$key = $key->trimAll();
					
					$value = $buffers->substring($key_separator_pos+1);
					$value = $value->trimAll();
					
               if ($key->length()>0 && $value->length()>0)
					{
						$conf->put($key->toString(), $value->toString());
					}
				}
			}
			if (isset($conf) && $conf->size()>0)
			{
				$this->put($configname, $conf);
			}
		}
	}
	
	function configSize()
	{
		return $this->size();
	}
	
	function configNameList()
	{
		return $this->keys();
	}
	
   function getConfig($configname)
	{
      $configname = StringBuffer::toStringBuffer($configname);
		return $this->get($configname->toString());
	}
	
	function getConfigValue($configname, $key)
	{
      $configname = StringBuffer::toStringBuffer($configname);
      $key  = StringBuffer::toStringBuffer($key);
		$cf = $this->getConfig($configname->toString());
      if (isset($cf))
      {
         return $cf->get($key->toString());
      }
		return NULL;
	}
   
   function validClass($object)
   {
      return Object::validClass($object, 'multiconfigloader');
   }
}
?>