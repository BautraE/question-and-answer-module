<?php

namespace Magebit\QuestionsAndAnswers\Controller\Account;

use Magento\Customer\Controller\AbstractAccount;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\Page\Interceptor;
use Magento\Customer\Model\Session as CustomerSession;

class MyQuestions extends AbstractAccount implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected PageFactory $resultPageFactory;
    /**
     * @var CustomerSession
     */
    protected CustomerSession $customerSession;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param CustomerSession $customerSession
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        CustomerSession $customerSession
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->customerSession = $customerSession;
    }

    /**
     * @return Interceptor
     */
    public function execute(): Interceptor
    {
        if (!$this->customerSession->isLoggedIn()) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('customer/account/login');
            return $resultRedirect;
        }
        return $this->resultPageFactory->create();
    }
}

