<?php

class MageTool_Tool_MageExtension_Context_Extension_ConfigFile extends Zend_Tool_Project_Context_Filesystem_File
{

    /**
     * @var string
     */
    protected $_filesystemName = 'config.xml';

    /**
     * getName()
     *
     * @return string
     */
    public function getName()
    {
        return 'ConfigFile';
    }

    /**
     * getContents()
     *
     * @return string
     */
    public function getContents()
    {
        $profile = $this->_resource->getProfile();
        $vendor = $profile->getAttribute('vendor');
        $xmlVendor = strtolower($vendor);
        $name = $profile->getAttribute('name');
        $xmlName = strtolower($name);
        $pool = $profile->getAttribute('pool');

        return <<< EOS
<?xml version="1.0"?>
<config>
    <modules>
        <{$vendor}_{$name}>
             <version>0.1.0</version>
        </{$vendor}_{$name}>
    </modules>
    <admin>
    </admin>
    <global>
        <models>
            <{$xmlName}>
                <class>{$vendor}_{$name}_Model</class>
                <resourceModel>{$xmlName}_entity</resourceModel>
            </{$xmlName}>
            <{$xmlName}_entity>
                <class>{$vendor}_{$name}_Model_Entity</class>
                <entities>
                </entities>
            </{$xmlName}_entity>
        </models>
        <blocks>
            <{$xmlName}>
                <class>{$vendor}_{$name}_Block</class>
            </{$xmlName}>
        </blocks>
        <helpers>
            <{$xmlName}>
                <class>{$vendor}_{$name}_Helper</class>
            </{$xmlName}>
        </helpers>
        <resources>
            <{$xmlVendor}_{$xmlName}_setup>
                <setup>
                    <module>{$vendor}_{$name}</module>
                    <class>{$vendor}_{$name}_Model_Entity_Setup</class>
                </setup>
            </{$xmlVendor}_{$xmlName}_setup>
        </resources>
        <events></events>
    </global>
    <adminhtml>
    </adminhtml>
    <frontend>
        <routers></routers>
        <translate>
            <modules>
                <{$vendor}_{$name}>
                    <files>
                        <default>{$vendor}_{$name}.csv</default>
                    </files>
                </{$vendor}_{$name}>
            </modules>
        </translate>
        <layout></layout>
    </frontend>
    <default>
        <{$xmlName}>
        </{$xmlName}>
    </default>
    <phpunit>
        <suite>
            <modules>
                 <{$vendor}_{$name} />
            </modules>
        </suite>
    </phpunit>
</config>
EOS;
    }

}