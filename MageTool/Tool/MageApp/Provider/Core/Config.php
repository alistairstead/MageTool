<?php

/**
 * MageTool_Tool_MageApp_Provider_Core_Config provides commands to read and update the Magento
 * config from the cli
 *
 * @package MageTool_MageApp_Providor_Core
 * @author Alistair Stead
 **/
class MageTool_Tool_MageApp_Provider_Core_Config extends MageTool_Tool_MageApp_Provider_Abstract
    implements Zend_Tool_Framework_Provider_Pretendable
{
    /**
     * Define the name of the provider
     *
     * @return string
     * @author Alistair Stead
     **/
    public function getName()
    {
        return 'MageCoreConfig';
    }
    
    /**
     * Retrive a list of installed resources
     *
     * @return void
     * @author Alistair Stead
     **/
    public function show($path = null, $scope = null)
    {
        $this->_bootstrap();
        
        $this->_response->appendContent(
            'Magento Config Data: $PATH [$SCOPE] = $VALUE',
            array('color' => array('yellow'))
        );
            
        $configCollection = $configs = Mage::getModel('core/config_data')->getCollection();

        if (is_string($path)) {
            $configCollection->addFieldToFilter('path', array("like" => "%$path%"));
        }
        if (is_string($scope)) {
            $configCollection->addFieldToFilter('scope', array("eq" => $scope));
        }
        $configCollection->load();

        foreach ($configs as $key => $config) {
            $this->_response->appendContent(
                "{$config->getPath()} [{$config->getScope()}] = {$config->getValue()}",
                array('color' => array('white'))
            );
        }
    }
    
    /**
     * Set the value of a config value that matches a path and scope.
     *
     * @return void
     * @author Alistair Stead
     **/
    public function set($path, $value, $scope = null)
    {
        /**
         * @var $config Mage_Core_Model_Config
         * @var $itemConfig Mage_Core_Model_Config_Data
         * @var $configCollection Mage_Core_Model_Resource_Config_Data_Collection
         */
        $this->_bootstrap();
        
        $this->_response->appendContent(
            'Magento Config updated to: $PATH [$SCOPE] = $VALUE',
            array('color' => array('yellow'))
        );
            
        $configCollection = Mage::getModel('core/config_data')->getCollection();
            
        $configCollection->addFieldToFilter('path', array("eq" => $path));
        if (is_string($scope)) {
            $configCollection->addFieldToFilter('scope', array("eq" => $scope));
        }
        $configCollection->load();
            
        if($configCollection->count()) {
            foreach ($configCollection as $key => $config) {
                $config->setValue($value);
                if ($this->_registry->getRequest()->isPretend()) {
                    $result = "Dry run";
                } else {
                    $result = "Saved";
                    $config->save();
                }

                $this->_response->appendContent(
                    "{$result} > {$config->getPath()} [{$config->getScope()}] = {$config->getValue()}",
                    array('color' => array('white'))
                );
            }
        } else {
            $itemConfig = Mage::getModel('core/config_data');
            $itemConfig->setData(array(
                    'path'=>$path,
                    'value'=>$value,
                    'scope'=>$scope)
            );
            if ($this->_registry->getRequest()->isPretend()) {
                $result = "Dry run";
            } else {
                $result = "Created";
                $itemConfig->save();
            }

            $this->_response->appendContent(
                "{$result} > {$itemConfig->getPath()} [{$itemConfig->getScope()}] = {$itemConfig->getValue()}",
                array('color' => array('white'))
            );
        }
    }
    
    /**
     * Update a config value that matches a path and scope by using str_replace
     *
     * @return void
     * @author Alistair Stead
     **/
    public function replace($match, $value, $path = null, $scope = null)
    {
        $this->_bootstrap();
        
        $this->_response->appendContent(
            'Magento Config updated to: $PATH [$SCOPE] = $VALUE',
            array('color' => array('yellow'))
        );
            
        $configCollection = $configs = Mage::getModel('core/config_data')->getCollection();

        if (is_string($path)) {
            $configCollection->addFieldToFilter('path', array("eq" => $path));
        }
        if (is_string($scope)) {
            $configCollection->addFieldToFilter('scope', array("eq" => $scope));
        }
        $configCollection->load();

        foreach ($configs as $key => $config) {
            if (strstr($config->getvalue(), $match)) {
                $config->setValue(str_replace($match, $value, $config->getvalue()));
                
                if ($this->_registry->getRequest()->isPretend()) {
                    $result = "Dry run";
                } else {
                    $result = "Saved";
                    $config->save();
                }  

                $this->_response->appendContent(
                    "{$result} > {$config->getPath()} [{$config->getScope()}] = {$config->getValue()}",
                    array('color' => array('white'))
                );
            }
        }
    }
    
    /**
     * Validate the Magento xml config using lint tests
     *
     * @return void
     * @author Alistair Stead
     **/
    public function lint($configFilePath = 'app/code/local', $lintFilePath = null)
    {
        $this->_bootstrap();
        // TODO search local file path and the supplied path for files that implement lint
        $lints = array(
          'MageTool_Lint_Xml' => 'MageTool/Lint/Xml.php',
          'MageTool_Lint_Config' => 'MageTool/Lint/Config.php',
          'MageTool_Lint_System' => 'MageTool/Lint/System.php',
          'MageTool_Lint_Adminhtml' => 'MageTool/Lint/Adminhtml.php',
          'MageTool_Lint_Api' => 'MageTool/Lint/Api.php'  
        );
        $lintObjects = array();
        foreach ($lints as $lintClass => $includePath) {
            try {
                include_once $includePath;
                $lintTest = new $lintClass;
                $lintObjects[] = $lintTest;
            } catch (MageTool_Lint_Exception $e) {
                $this->_response->appendContent(
                    "{$e->getMessage()}",
                    array('color' => array('red'))
                );
            }     
        }
        
        $lint = new MageTool_Lint();
        $lint->setPathFilter($configFilePath);
        // If an additional lint file path is supplied pass it to be loaded
        if (!is_null($lintFilePath)) {
            $lint->addLints($lintFilePath);
        } else {
            $lint->addLints($lintObjects);
        }
        $lint->run();
        foreach ($lint->getMessages() as $message) {
            $this->_response->appendContent(
                "{$message->getLevel()}: {$message->getMessage()}",
                array('color' => array($message->getColour()))
            );    
        }
        $count = count($lint->getMessages());
        if ($count > 0) {
            $this->_response->appendContent(
                "({$count}) Messages reported",
                array('color' => array('red'))
            );
        } else {
            $this->_response->appendContent(
                "No errors found",
                array('color' => array('green'))
            );
        }
    }
}