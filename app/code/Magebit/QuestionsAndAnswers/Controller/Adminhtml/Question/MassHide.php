<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Ui\Component\MassAction\Filter;
use Magebit\QuestionsAndAnswers\Model\ResourceModel\Question\CollectionFactory;
use Magebit\QuestionsAndAnswers\Api\QuestionManagementInterface;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;

class MassHide extends Action implements HttpPostActionInterface
{
    /**
     * @var Filter
     */
    private Filter $filter;
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;
    /**
     * @var QuestionManagementInterface
     */
    private QuestionManagementInterface $questionManagementInterface;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param QuestionManagementInterface $questionManagementInterface
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        QuestionManagementInterface $questionManagementInterface
    ) {
        parent::__construct($context);
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->questionManagementInterface = $questionManagementInterface;
    }

    /**
     * @return Redirect
     * @throws LocalizedException
     */
    public function execute(): Redirect
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        foreach ($collection as $item) {
            $this->questionManagementInterface->hideQuestion($item);
            $item->save();
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 question(s) have been hidden.', $collection->getSize())
        );

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
