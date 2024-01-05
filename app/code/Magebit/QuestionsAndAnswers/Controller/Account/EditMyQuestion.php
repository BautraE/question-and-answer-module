<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Controller\Account;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magebit\QuestionsAndAnswers\Api\QuestionRepositoryInterface;

class EditMyQuestion extends Action implements HttpPostActionInterface
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
            $questionModel->setQuestion($data['question']);
            try {
                $this->questionRepository->save($questionModel);
                $this->messageManager->addSuccessMessage(__('Your changes have been saved successfully!'));
                return $resultRedirect;
            } catch (\Exception $error) {
                $this->messageManager->addErrorMessage(__('Something went wrong while trying to save your changes!'));
                return $resultRedirect;
            }
        }

        $this->messageManager->addErrorMessage(__('This question no longer exists!'));
        return $resultRedirect;
    }
}
