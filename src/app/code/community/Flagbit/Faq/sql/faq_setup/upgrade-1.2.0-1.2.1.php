<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$connection = $installer->getConnection();

$connection->addColumn(
    $installer->getTable('flagbit_faq/category'),
    'hide_from_list',
    Varien_Db_Ddl_Table::TYPE_SMALLINT,
    null,
    array(),
    'Hide from list'
);

$installer->endSetup();
