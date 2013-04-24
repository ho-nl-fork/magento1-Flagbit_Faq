<?php
/**
 * Ho_Bootstrap
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
 * @category    Ho
 * @package     Ho_Bootstrap
 * @copyright   Copyright © 2013 H&O (http://www.h-o.nl/)
 * @license     H&O Commercial License (http://www.h-o.nl/license)
 * @author      Paul Hachmang – H&O <info@h-o.nl>
 *
 *
 */
class Flagbit_Faq_Block_Adminhtml_Category_Widget_Chooser extends Flagbit_Faq_Block_Adminhtml_Category_Grid
{
    /**
     * Block construction, prepare grid params
     *
     * @param array $arguments Object data
     */
    public function __construct($arguments=array())
    {
        parent::__construct($arguments);
        $this->setDefaultSort('category_id');
        $this->setUseAjax(true);
        $this->setDefaultFilter(array('is_active' => '1'));
    }

    /**
     * Prepare chooser element HTML
     *
     * @param Varien_Data_Form_Element_Abstract $element Form Element
     * @return Varien_Data_Form_Element_Abstract
     */
    public function prepareElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $uniqId = Mage::helper('core')->uniqHash($element->getId());
        $sourceUrl = $this->getUrl('*/faq/categoryChooser', array('uniq_id' => $uniqId));

        $chooser = $this->getLayout()->createBlock('widget/adminhtml_widget_chooser')
            ->setElement($element)
            ->setTranslationHelper($this->getTranslationHelper())
            ->setConfig($this->getConfig())
            ->setFieldsetId($this->getFieldsetId())
            ->setSourceUrl($sourceUrl)
            ->setUniqId($uniqId);

        if ($element->getValue()) {
            /* @var $gallery Flagbit_Faq_Model_Category */
            $gallery = Mage::getModel('flagbit_faq/category')->load($element->getValue());
            if ($gallery->getId()) {
                $chooser->setLabel($gallery->getCategoryName());
            }
        }

        $element->setData('after_element_html', $chooser->toHtml());
        return $element;
    }

    /**
     * Grid Row JS Callback
     * @return string
     */
    public function getRowClickCallback()
    {
        $chooserJsObject = $this->getId();
        $js = '
            function (grid, event) {
                var trElement = Event.findElement(event, "tr");
                var galleryId = trElement.down("td").innerHTML.replace(/^\s+|\s+$/g,"");
                var galleryTitle = trElement.down("td").next().innerHTML;
                '.$chooserJsObject.'.setElementValue(galleryId);
                '.$chooserJsObject.'.setElementLabel(galleryTitle);
                '.$chooserJsObject.'.close();
            }
        ';
        return $js;
    }

    /**
     * Prepare columns
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        parent::_prepareColumns();

        $this->removeColumn('is_enabled');
        $this->removeColumn('action');

        return $this;
    }


    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/faq/categoryChooser', array('_current' => true));
    }

}