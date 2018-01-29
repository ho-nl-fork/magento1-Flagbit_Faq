<?php
/**
 * FAQ for Magento
 *
 * @category   Flagbit
 * @package    Flagbit_Faq
 * @copyright  Copyright (c) 2009 Flagbit GmbH & Co. KG <magento@flagbit.de>
 */

class Flagbit_Faq_IndexController extends Mage_Core_Controller_Front_Action
{
	/**
	 * Displays the FAQ list.
	 */
	public function indexAction()
	{
		$this->loadLayout()->renderLayout();
	}

	/**
	 * Displays the current FAQ's detail view.
	 */
	public function showAction()
	{
		$this->loadLayout()->renderLayout();
	}

    /**
     * Displays the current FAQ category.
     */
    public function categoryAction()
    {
        /** @var Flagbit_Faq_Model_Category $category */
        $category = Mage::getModel('flagbit_faq/category')->loadByUrlKey($this->getRequest()->getParam('url_key'));

        if (! $category->getId()) {
            $this->norouteAction();
            return;
        }

        $this->loadLayout()->renderLayout();
    }
}
