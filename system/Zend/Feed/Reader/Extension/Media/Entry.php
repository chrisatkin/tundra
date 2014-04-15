<?php

/**
 * @see Zend_Feed_Reader
 */
require_once 'Zend/Feed/Reader.php';

/**
 * @see Zend_Feed_Reader_Extension_EntryAbstract
 */
require_once 'Zend/Feed/Reader/Extension/EntryAbstract.php';

/**
 * @category   Zend
 * @package    Zend_Feed_Reader
 * @copyright  Copyright (c) 2005-2011 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Feed_Reader_Extension_Media_Entry extends Zend_Feed_Reader_Extension_EntryAbstract
{
	public function getThumbnail()
	{
		if(isset($this->_data['thumbnail']))
			return $this->_data['thumbnail'];
			
			
		var_dump($this->getXpathPrefix());
			
		$thumbnail = $this->_xpath->evaluate(
			'string(' . $this->getXpathPrefix() . '/media:thumbnail)'
		);
		
		var_dump($thumbnail);
		
		if(!$thumbnail)
			$thumbnail = null;
	
		$this->_data['thumbnail'] = $thumbnail;
		
		return $this->_data['thumbnail'];
	}

    /**
     * Register iTunes namespace
     *
     */
    protected function _registerNamespaces()
    {
        $this->_xpath->registerNamespace('media', 'http://search.yahoo.com/mrss');
    }
}