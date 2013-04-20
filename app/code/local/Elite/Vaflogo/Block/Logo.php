<?php

class Elite_Vaflogo_Block_Logo extends Mage_Core_Block_Abstract
{

    /** @var Zend_Config */
    protected $config;

    function getConfig()
    {
        if( !$this->config instanceof Zend_Config )
        {
            $this->config = Elite_Vaf_Helper_Data::getInstance()->getConfig();
        }
        return $this->config;
    }

    function setConfig( Zend_Config $config )
    {
        $this->config = $config;
    }

    function _toHtml()
    {
	if (Elite_Vaf_Helper_Data::getInstance()->getConfig()->logo->disable)
	{
	    return;
	}
	if (!$this->selectionPart())
	{
	    return;
	}
	$pathSuffix = $this->selectionToken() . '.' . $this->extension();
	return '<img class="vafLogo" src="/logos/' . $pathSuffix . '" />';
    }

    function extension()
    {
	if($this->getConfig()->logo->extension)
	{
	    return $this->getConfig()->logo->extension;
	}
	return 'PNG';
    }

    function selectionPart()
    {
	$vehicleSelection = Elite_Vaf_Helper_Data::getInstance()->vehicleSelection();
	if ($vehicleSelection->isEmpty())
	{
	    return false;
	}
	
	if($this->getConfig()->logo->level)
	{
	    $level = $this->getConfig()->logo->level;
	    return $vehicleSelection->getLevel($level)->__toString();
	}

	$schema = new VF_Schema;
	if(in_array('make', $schema->getLevels()))
	{
	    $make = $vehicleSelection->getLevel('make');
	    if (!$make)
	    {
		return false;
	    }
	    return $make->__toString();
	}

	$rootLevel = $schema->getRootLevel();
	return $vehicleSelection->getLevel($rootLevel)->__toString();
    }

    function selectionToken()
    {
	$selectionPart = $this->selectionPart();
	return basename(strtoupper(str_replace(' ', '-', $selectionPart)));
    }

}