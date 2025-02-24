<?php

namespace LandingPage\Form\Block;

use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Model\Url as CustomerUrl;
use LandingPage\Form\Helper\Data as FormHelper;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\SessionFactory;

class Index extends Template
{
    const ENGLISH_STORE = 'en_gb';

    protected $customerSession;
    protected $customerUrl;
    protected $storeManager;
    protected $formHelper;
    protected $sessionFactory;

    /**
     * Construct
     *
     * @param Context $context
     * @param CustomerSession $customerSession
     * @param CustomerUrl $customerUrl
     * @param StoreManagerInterface $storeManager
     * @param FormHelper $formHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        CustomerSession $customerSession,
        CustomerUrl $customerUrl,
        StoreManagerInterface $storeManager,
        FormHelper $formHelper,
        SessionFactory $sessionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->customerSession = $customerSession;
        $this->customerUrl = $customerUrl;
        $this->storeManager = $storeManager;
        $this->formHelper = $formHelper;
        $this->sessionFactory = $sessionFactory;
    }

    protected function getCustomer()
    {
        $customerSession = $this->sessionFactory->create();
        return $customerSession->getCustomer();
    }

    public function isCustomerLoggerIn()
    {

        $customerSession = $this->sessionFactory->create();
        return $customerSession->getCustomer()->getId() ? true : false;
    }

    public function getCustomerName()
    {
        $customer = $this->getCustomer();

        $name = $customer->getName();

        return $name;
    }

    public function getCustomerEmail()
    {
        $customer = $this->getCustomer();
        $email = $customer->getEmail();

        return $email;
    }

    public function getLoginUrl()
    {
        return $this->getUrl('customer/account/login');
    }

    /**
     * Check if the module is enabled
     *
     * @return bool
     */
    public function isModuleEnabled()
    {
        return $this->formHelper->isModuleEnabled();
    }

    public function isEnglishStore()
    {
        return $this->storeManager->getStore()->getCode() === self::ENGLISH_STORE;
    }
}
