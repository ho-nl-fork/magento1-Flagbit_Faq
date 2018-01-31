<?php
/**
 * Copyright © Reach Digital (https://www.reachdigital.io/)
 * See LICENSE.txt for license details.
 */

class Flagbit_Faq_Controller_Router extends Mage_Core_Controller_Varien_Router_Standard
{
    /**
     * {@inheritdoc}
     */
    public function match(Zend_Controller_Request_Http $request)
    {
        if (! Mage::isInstalled()) {
            Mage::app()->getFrontController()->getResponse()
                ->setRedirect(Mage::getUrl('install'))
                ->sendResponse();
            exit;
        }

        if (!$this->_beforeModuleMatch()) {
            return false;
        }

        $this->fetchDefault();

        $front = $this->getFront();
        $path = trim($request->getPathInfo(), '/');

        if ($path) {
            $p = explode('/', $path);
        } else {
            $p = explode('/', $this->_getDefaultPath());
        }

        // get module name
        if ($request->getModuleName()) {
            $module = $request->getModuleName();
        } else {
            if (!empty($p[0])) {
                $module = $p[0];
            } else {
                $module = $this->getFront()->getDefault('module');
                $request->setAlias(Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS, '');
            }
        }
        if (!$module) {
            if (Mage::app()->getStore()->isAdmin()) {
                $module = 'admin';
            } else {
                return false;
            }
        }

        if (isset($p[1])) {
            $faqCategory = Mage::getModel('flagbit_faq/category')->loadByUrlKey($p[1]);

            if ($faqCategory->getId()) {
                $request->setAlias(
                    Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
                    ltrim($request->getOriginalPathInfo(), '/')
                );
                $request->setModuleName($module);
                $request->setControllerName($front->getDefault('controller'));
                $request->setActionName('category');

                $request->setParam('url_key', $p[1]);

                $controllerClassName = $this->_validateControllerClassName('Flagbit_Faq', $front->getDefault('controller'));
                $controllerInstance = Mage::getControllerInstance($controllerClassName, $request, $front->getResponse());

                // dispatch action
                $request->setDispatched();
                $controllerInstance->dispatch('category');

                return true;
            }
        }

        return false;
    }
}
