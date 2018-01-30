<?php
/**
 * Copyright © Reach Digital (https://www.reachdigital.io/)
 * See LICENSE.txt for license details.
 */

class Flagbit_Faq_Block_Frontend_Category extends Mage_Core_Block_Template
{
    /**
     * {@inheritdoc}
     */
	protected function _prepareLayout()
    {
        $category = $this->getCategory();

        if ($head = $this->getLayout()->getBlock('head')) {
            $head->setTitle($this->escapeHtml($category->getName()));
        }

        if ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')) {
            /** @var Mage_Page_Block_Html_Breadcrumbs $breadcrumbs */

            $breadcrumbs->addCrumb('home', ['label' => Mage::helper('cms')->__('Home'), 'title' => Mage::helper('cms')->__('Go to Home Page'), 'link' => Mage::getBaseUrl()]);
            $breadcrumbs->addCrumb('faq', ['label' => Mage::helper('flagbit_faq')->__('FAQ'), 'title' => Mage::helper('flagbit_faq')->__('FAQ'), 'link' => Mage::helper('flagbit_faq')->getFaqIndexUrl()]);
            $breadcrumbs->addCrumb('faq_category', ['label' => $this->escapeHtml($category->getName()), 'title' => $this->escapeHtml($category->getName()), 'readonly' => true]);
        }
    }

    public function getCategory()
    {
        return Mage::getModel('flagbit_faq/category')->loadByUrlKey($this->getRequest()->getParam('url_key'));
    }

    public function renderText($text)
    {
        if (Mage::helper('core')->isModuleEnabled('Ho_Bootstrap')) {
            return Mage::helper('ho_bootstrap')->renderText($text);
        }

        return $text;
    }
}
