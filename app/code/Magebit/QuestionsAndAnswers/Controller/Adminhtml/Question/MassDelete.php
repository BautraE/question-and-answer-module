<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\Model\View\Result\Redirect;
use Magebit\QuestionsAndAnswers\Model\ResourceModel\Question\CollectionFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Exception\LocalizedException;

class MassDelete extends Action implements HttpPostActionInterface
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;
    /**
     * @var Filter
     */
    private FIlter $filter;

    /**
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param Filter $filter
     */
    public function __construct(
        Context $context,
        CollectionFactory $collectionFactory,
        FIlter $filter
    ) {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
        $this->filter = $filter;
    }

    /**
     * @return Redirect
     * @throws LocalizedException
     */
    public function execute(): Redirect
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $error = false;

        foreach ($collection as $question) {
            try {
                $question->delete();
            } catch (\Exception $exception) {
                $this->messageManager->addExceptionMessage($exception);
                $error = true;
            }
        }

        if($error) {
            return $resultRedirect->setPath('*/*/');
        }

        $collectionSize = $collection->getSize();
        $this->messageManager->addSuccessMessage(__('A total of %1 question(s) have been deleted!', $collectionSize));

        return $resultRedirect->setPath('*/*/');
    }
}
