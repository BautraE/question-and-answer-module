<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Controller\Adminhtml\Question;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\Model\View\Result\Redirect;
use Magebit\QuestionsAndAnswers\Api\QuestionRepositoryInterface;

class Delete extends Action implements HttpPostActionInterface
{
    /**
     * @var QuestionRepositoryInterface
     */
    private QuestionRepositoryInterface $questionRepository;

    /**
     * @param Context $context
     * @param QuestionRepositoryInterface $questionRepository
     */
    public function __construct(
        Context $context,
        QuestionRepositoryInterface $questionRepository
    ) {
        parent::__construct($context);
        $this->questionRepository = $questionRepository;
    }

    /**
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $questionId = (int) $this->getRequest()->getParam('id');
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($questionId) {
            try {
                $questionModel = $this->questionRepository->get($questionId);
                $this->questionRepository->delete($questionModel);
                $this->messageManager->addSuccessMessage(__('The question has been deleted!'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $questionId]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a question to delete!'));
        return $resultRedirect->setPath('*/*/');
    }
}
