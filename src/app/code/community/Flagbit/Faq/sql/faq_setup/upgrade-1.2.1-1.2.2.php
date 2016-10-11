<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$connection = $installer->getConnection();

$connection->addColumn(
    $installer->getTable('flagbit_faq/faq'),
    'sort_order',
    Varien_Db_Ddl_Table::TYPE_INTEGER
);

$installer->endSetup();
