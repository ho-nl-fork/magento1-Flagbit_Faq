<?php
/**
 * FAQ for Magento
 *
 * @category   Flagbit
 * @package    Flagbit_Faq
 * @copyright  Copyright (c) 2010 Flagbit GmbH & Co. KG <magento@flagbit.de>
 */

/**
 * Category Model for FAQ Items
 *
 * @category   Flagbit
 * @package    Flagbit_Faq
 * @author     Flagbit GmbH & Co. KG <magento@flagbit.de>
 */
class Flagbit_Faq_Model_Category extends Mage_Core_Model_Abstract
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init('flagbit_faq/category');
    }
    
    public function getName()
    {
        return $this->getCategoryName();
    }
    
    public function getItemCollection()
    {
        $collection = $this->getData('item_collection');

        if ($collection === null) {
            $collection = Mage::getResourceModel('flagbit_faq/faq_collection')
                ->addCategoryFilter($this)
                ->addStoreFilter(Mage::app()->getStore()->getId());

            $this->setData('item_collection', $collection);
        }

        return $collection;
    }

    /**
     * @param string    $urlKey
     * @param bool      $activeOnly
     *
     * @return Flagbit_Faq_Model_Category
     */
    public function loadByUrlKey($urlKey, $activeOnly = true)
    {
        $this->_getResource()->loadByUrlKey($this, $urlKey, $activeOnly);

        return $this;
    }
}
