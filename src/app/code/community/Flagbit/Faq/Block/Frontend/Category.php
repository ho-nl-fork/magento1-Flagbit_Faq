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
class Flagbit_Faq_Block_Frontend_Category extends Flagbit_Faq_Block_Frontend_List {
	
	/**
	 * Stores the current category model
	 *
	 * @var Flagbit_Faq_Model_Category
	 */
	protected $_category;

	protected $_images;

	protected function _prepareLayout()
    {
		$category = $this->getCategory();

		if ($category !== false && $head = $this->getLayout()->getBlock('head')) {
			$head->setTitle($this->htmlEscape($faq->getCategoryName()) . ' - ' . $head->getTitle());
		}
    }
	
	/**
	 * Function to gather the current category
	 *
	 * @return  Flagbit_Faq_Model_Category  The current category item
	 */
	public function getCategory() {

		if ( ! $this->_category)
		{
			$id = intval($this->getRequest()->getParam('id'));

			$this->_category = Mage::getModel('flagbit_faq/category');

			// We shuold also be able to load by names for SEO purposes.
			if ( ! $id && $name = $this->getRequest()->getParam('name'))
			{
				// Ensure hyphens are translated to spaces.
				$name = str_replace('-', ' ', $name);
				$this->_category->load($name, 'category_name');
			}
			else
			{
				$this->_category->load($id);
			}

			// Couldn't load anything; return FALSE
			if ( ! $this->_category->getId() OR $this->_category->getIsActive !== 1)
				return FALSE;
		}

		return $this->_category;
	}

}
