<?php

class VS7_CheckCustomerExists_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        if (!$this->_validateFormKey()) {
            return false;
        }
        $email = Mage::app()->getRequest()->getParam('email');
        $storeId = Mage::app()->getStore()->getStoreId();
        $response = array(
            'exists' => false
        );
        if ($this->_customerExists($email, $storeId)) {
            $response = array(
                'exists' => true
            );
        };
        $this->getResponse()->clearHeaders()->setHeader('Content-type','application/json',true);
        $this->getResponse()->setBody(json_encode($response));
    }

    protected function _customerExists($email, $websiteId = null)
    {
        $customer = Mage::getModel('customer/customer');
        if ($websiteId) {
            $customer->setWebsiteId($websiteId);
        }
        $customer->loadByEmail($email);
        if ($customer->getId()) {
            return $customer;
        }
        return false;
    }
}