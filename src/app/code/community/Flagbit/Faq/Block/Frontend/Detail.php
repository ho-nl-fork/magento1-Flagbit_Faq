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
class Flagbit_Faq_Block_Frontend_Detail extends Mage_Core_Block_Template {
	
	protected $_faq;
	protected $_images;
	
	
	protected function _prepareLayout()
    {
        $faq = $this->getFaq();

        if ($faq !== false && $head = $this->getLayout()->getBlock('head')) {
            $head->setTitle($this->htmlEscape($faq->getQuestion()) . ' - ' . $head->getTitle());
        }
    }
	
	/**
	 * Function to gather the current faq item
	 *
	 * @return Flagbit_Faq_Model_Faq The current faq item
	 */
	public function getFaq() {
		if (!$this->_faq) {
			$id = intval($this->getRequest()->getParam('faq'));
			try {
				$this->_faq = Mage :: getModel('flagbit_faq/faq')->load($id); 
				
				if ($this->_faq->getIsActive() != 1){
					Mage::throwException('Faq Item is not active');
				}
			}
			catch (Exception $e) {
				$this->_faq = false;
			}
		}
		
		return $this->_faq;
	}
}