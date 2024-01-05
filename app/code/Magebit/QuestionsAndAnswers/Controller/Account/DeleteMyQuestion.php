<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Controller\Account;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magebit\QuestionsAndAnswers\Api\QuestionRepositoryInterface;
use Magento\Framework\Controller\Result\Redirect;

class DeleteMyQuestion extends Action implements HttpPostActionInterface
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
        $data = $this->getRequest()->getPostValue();

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('qnacus/account/myquestions');

        $questionModel = $this->questionRepository->get((int) $data['question_id']);

        if($questionModel->getId()) {
            try {
                $this->questionRepository->delete($questionModel);
                $this->messageManager->addSuccessMessage(__('Your question has been deleted successfully!'));
                return $resultRedirect;
            } catch (\Exception $error) {
                $this->messageManager->addErrorMessage(__('Something went wrong while trying delete your question!'));
                return $resultRedirect;
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a question to delete!'));
        return $resultRedirect;
    }
}
