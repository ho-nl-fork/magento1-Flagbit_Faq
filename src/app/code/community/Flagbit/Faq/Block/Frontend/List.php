<?php
/**
 * FAQ for Magento
 *
 * @category   Flagbit
 * @package    Flagbit_Faq
 * @copyright  Copyright (c) 2009 Flagbit GmbH & Co. KG <magento@flagbit.de>
 */

/**
 * FAQ for Magento
 *
 * @category   Flagbit
 * @package    Flagbit_Faq
 * @author     Flagbit GmbH & Co. KG <magento@flagbit.de>
 */
class Flagbit_Faq_Block_Frontend_List extends Mage_Core_Block_Template
{
	protected $_faqCollection;
	
	protected function _prepareLayout()
    {
        if ($head = $this->getLayout()->getBlock('head')) {
            $head->setTitle($this->htmlEscape($this->__('Frequently Asked Questions')) . ' - ' . $head->getTitle());
        }

        if ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')) {
            /** @var Mage_Page_Block_Html_Breadcrumbs $breadcrumbs */

            $breadcrumbs->addCrumb('home', ['label' => Mage::helper('cms')->__('Home'), 'title' => Mage::helper('cms')->__('Go to Home Page'), 'link' => Mage::getBaseUrl()]);
            $breadcrumbs->addCrumb('faq', ['label' => Mage::helper('flagbit_faq')->__('FAQ'), 'title' => Mage::helper('flagbit_faq')->__('FAQ'), 'readonly' => true]);
        }
    }
	
	/**
	 * Returns collection of current FAQ entries
	 *
	 * @param int $pageSize
	 * @return Flagbit_Faq_Model_Resource_Faq_Collection collection of current FAQ entries
	 */
	public function getFaqCollection($pageSize = null)
	{
		if (!$this->_faqCollection || (intval($pageSize) > 0
			&& $this->_faqCollection->getSize() != intval($pageSize))
		) {
			$this->_faqCollection = Mage :: getModel('flagbit_faq/faq')
				->getCollection()
				->addStoreFilter(Mage :: app()->getStore())
				->addIsActiveFilter();
			
			$this->_faqCollection->getSelect()->order('sort_order ASC');
			if (isset($pageSize) && intval($pageSize) && intval($pageSize) > 0) {
				$this->_faqCollection->setPageSize(intval($pageSize));
			}
		}
		
		return $this->_faqCollection;
	}
	
	/**
	 * Returns all active categories
	 * 
	 * @return Flagbit_Faq_Model_Resource_Category_Collection
	 */
	public function getCategoryCollection()
	{
	    $categories = $this->getData('category_collection');
	    if (is_null($categories)) {
    	    $categories =  Mage::getResourceSingleton('flagbit_faq/category_collection')
    	       ->addStoreFilter(Mage::app()->getStore())
    	       ->addIsActiveFilter();
    	    $this->setData('category_collection', $categories);
	    }
	    return $categories;
	}
	
	/**
	 * Returns the item collection for the given category 
	 * 
	 * @param Flagbit_Faq_Model_Category $category
	 * @return Flagbit_Faq_Model_Resource_Faq_Collection
	 */
	public function getItemCollectionByCategory(Flagbit_Faq_Model_Category $category)
	{
	    return $category->getItemCollection()->addIsActiveFilter();
	}

    /**
     * @param $faqItem
     *
     * @internal param $faqItems
     * @return string
     */
    public function getIntro($faqItem)
	{
        $content = $this->stripTags($this->getAnswerHtml($faqItem));
		return $this->helper('core/string')->truncate($content,200,'…');
	}



    public function getAnswerHtml($faqItem) {
        /* @var $helper Mage_Cms_Helper_Data */
        $helper = Mage::helper('cms');
        $processor = $helper->getPageTemplateProcessor();
        return $processor->filter($faqItem->getAnswer());
    }
}
