<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$connection = $installer->getConnection();

$installer->run("ALTER TABLE `{$this->getTable('flagbit_faq/category')}` CONVERT TO CHARACTER SET utf8;");

$installer->endSetup();
