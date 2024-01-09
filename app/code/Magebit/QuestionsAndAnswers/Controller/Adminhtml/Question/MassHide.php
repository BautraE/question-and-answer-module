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
     */
    public function execute(): Redirect
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $error = false;

        foreach ($collection as $question) {
            try {
                $this->questionManagementInterface->hideQuestion($question);
                $question->save();
            } catch (\Exception $exception) {
                $this->messageManager->addExceptionMessage($exception);
                $error = true;
            }
        }

        if($error) {
            return $resultRedirect->setPath('*/*/');
        }

        $this->messageManager->addSuccessMessage(
            __('A total of %1 question(s) have been hidden!', $collection->getSize())
        );

        return $resultRedirect->setPath('*/*/');
    }
}
