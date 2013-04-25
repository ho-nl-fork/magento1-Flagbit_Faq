<?php
/**
 * Flagbit_Faq
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the H&O Commercial License
 * that is bundled with this package in the file LICENSE_HO.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.h-o.nl/license
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@h-o.com so we can send you a copy immediately.
 *
 * @category    Flagbit
 * @package     Flagbit_Faq
 * @copyright   Copyright © 2013 H&O (http://www.h-o.nl/)
 * @license     H&O Commercial License (http://www.h-o.nl/license)
 * @author      Paul Hachmang – H&O <info@h-o.nl>
 *
 * 
 */

class Flagbit_Faq_Block_Frontend_List_Widget extends Mage_Core_Block_Template
{

    /**
   	 * Returns collection of current FAQ entries
   	 *
   	 * @param int $pageSize
   	 * @return Flagbit_Faq_Model_Resource_Faq_Collection collection of current FAQ entries
   	 */
   	public function getFaqCollection($pageSize = null)
   	{
   		if (parent::getFaqCollection() === null) {
            /* @var $collection Flagbit_Faq_Model_Resource_Faq_Collection */
   			$collection = Mage::getModel('flagbit_faq/faq')->getCollection()
   				->addStoreFilter(Mage::app()->getStore())
                ->addCategoryFilter(1)
   				->addIsActiveFilter();

   			parent::setFaqCollection($collection);
   		}

   		return parent::getFaqCollection();
   	}


    /**
     * @param Flagbit_Faq_Model_Faq $faqItem
     * @return string
     */
    public function getAnswerHtml(Flagbit_Faq_Model_Faq $faqItem) {
        /* @var $helper Mage_Cms_Helper_Data */
        $helper = Mage::helper('cms');
        $processor = $helper->getPageTemplateProcessor();
        return $processor->filter($faqItem->getAnswer());
    }
}
