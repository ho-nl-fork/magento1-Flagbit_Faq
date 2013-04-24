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
/**
 * @method int getFaqId()
 * @method Flagbit_Faq_Model_Faq setFaqId(int $faqId)
 * @method string getQuestion()
 * @method Flagbit_Faq_Model_Faq setQuestion(string $question)
 * @method string getAnswer()
 * @method Flagbit_Faq_Model_Faq setAnwer(string $answer)
 * @method string getCreationTime()
 * @method Flagbit_Faq_Model_Faq setCreationTime(string $creationTime)
 * @method string getUpdateTime()
 * @method Flagbit_Faq_Model_Faq setUpdateTime(string $updateTime)
 * @method int getIsActive()
 * @method Flagbit_Faq_Model_Faq setIsActive(int $isActive)
 */
class Flagbit_Faq_Model_Faq extends Mage_Core_Model_Abstract
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init('flagbit_faq/faq');
    }
}
