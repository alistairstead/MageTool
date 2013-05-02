# MageTool #

Additional ZF tools specifically for use during Magento development. Although Magento uses a great number of Zend Framework components and has a similar architecture to a Zend Framework application. It does not have any command line tools for use during development.

These tools have been created to facilitate a number of repetitive tasks during development. Rather than switching between mysql tools and the Magento admin system you can run simple command and improve your workflow greatly. Since the 0.5.* release it also provides access to the commands from Mtool http://github.com/dankocherga/MTool

## Notice ##

First ensure you are using the latest version of PEAR

    $ sudo pear upgrade pear

----
***NOTE: The 0.5.* release requires an update to your user .zf.ini as I have simplified the tool manifest for future releases.***

This is intended to make future release of additional tools and commands much more simple. Please ensure you update your .zf.ini file to match the line shown in the "Installation Instructions" below 
----

## Installation Instructions ##

First install ZF on your development machine.

	$ sudo pear channel-discover pear.zfcampus.org
	$ sudo pear install zfcampus/zf
	
Install MageTool on your development machine.

	$ sudo pear channel-discover pear.magetool.co.uk
	$ sudo pear install magetool/magetool
	
Once you have installed ZF and MageTool you will need to create configuration for your user by creating a .zf.ini file using the following command:

	$ echo 'basicloader.classes.1 = "MageTool_Tool_Manifest"' | tee ~/.zf.ini 
	
*** If you are upgrading from previous versions you will need to ensure you update the .zf.ini file. ***
	
After creating the user specific configuration file and adding the additional config lines the additional MageTool commands will be available for you to use with zf. To confirm that everything is installed correctly run the following command:

	$ zf
	
Your Zend Framework zf command line tool will now have the following additional commands:

    MageAdminUser
      zf show mage-admin-user
      zf create mage-admin-user username email password firstname[=Admin] lastname[=User]

    MageCoreCache
      zf clear mage-core-cache tags[=all]
      zf flush mage-core-cache
      zf enable mage-core-cache tags[=all]
      zf disable mage-core-cache tags[=all]

    MageCoreCompiler
      zf run mage-core-compiler
      zf clear mage-core-compiler
      zf enable mage-core-compiler
      zf disable mage-core-compiler
      zf stat mage-core-compiler

    MageCoreIndexer
      zf info mage-core-indexer code[=all]
      zf mode mage-core-indexer mode code[=all]
      zf run mage-core-indexer code[=all]

    MageCoreResource
      zf show mage-core-resource code
      zf delete mage-core-resource code
      zf update mage-core-resource module

    MageCoreConfig
      zf show mage-core-config path scope
      zf set mage-core-config path value scope
      zf replace mage-core-config match value path scope
      zf lint mage-core-config config-file-path[=app/code/local] lint-file-path

    MageApp
      zf version mage-app
      zf dispatch-event mage-app name data

    MageExtension
      zf create mage-extension vendor name pool[=local] file-of-profile

    mtool
      zf info mtool

    mage-module
      zf create mage-module name
      zf install mage-module name version
      zf upgrade mage-module name mode version

    mage-model
      zf create mage-model target-module model-path
      zf add mage-model model-path
      zf rewrite mage-model target-module origin-model your-model

    mage-rmodel
      zf rewrite mage-rmodel target-module origin-model your-model

    mage-helper
      zf create mage-helper target-module helper-path
      zf add mage-helper helper-path
      zf rewrite mage-helper target-module origin-helper your-helper

    mage-block
      zf create mage-block target-module block-path
      zf add mage-block block-path
      zf rewrite mage-block target-module origin-block your-block
	
## Example Usage ##

MageTool provides commands for use during Magento development.

	zf show mage-core-config --path web/unsecure/base_url
	
## Showing your appreciation ##

Of course, the best way to show your appreciation for the magetool itself remains
contributing by forking this project.  If you'd like to show your appreciation in
another way, however, consider Flattr'ing me:

[![Flattr this][2]][1]

[1]: http://flattr.com/thing/71078/MageTool
[2]: http://api.flattr.com/button/button-compact-static-100x17.png	
