<?php
/**
 * Copyright © Reach Digital (https://www.reachdigital.io/)
 * See LICENSE.txt for license details.
 */

/* @var Mage_Core_Model_Resource_Setup $installer */
$installer = $this;

$installer->startSetup();

$installer->getConnection()->addColumn($installer->getTable('flagbit_faq/category'), 'url_key', [
    'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
    'length'    => 255,
    'nullable'  => false,
    'comment'   => 'URL Key'
]);

foreach (Mage::getResourceModel('flagbit_faq/category_collection') as $category) {
    /** @var Flagbit_Faq_Model_Category $category */

    /** @noinspection PhpParamsInspection */
    $category->load();

    $categoryName = str_replace([' ', '.', '?'], ['-', '', ''], strtolower($category->getData('category_name')));
    $category->setData('url_key', $categoryName);
    $category->setData('stores', $category->getData('store_id'));

    $category->save();
}

$installer->getConnection()
    ->addIndex(
        $installer->getTable('flagbit_faq/category'),
        $installer->getIdxName(
            $installer->getTable('flagbit_faq/category'),
            ['url_key'],
            Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
        ),
        ['url_key'],
        Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
    );

$installer->endSetup();
