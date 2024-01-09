<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Controller\Adminhtml\Question;

use Magebit\QuestionsAndAnswers\Model\QuestionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Controller\ResultInterface;
use Magebit\QuestionsAndAnswers\Api\QuestionRepositoryInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Backend\Model\View\Result\Redirect;

class Save extends Action implements HttpPostActionInterface
{
    /**
     * @var QuestionFactory
     */
    private QuestionFactory $questionFactory;
    /**
     * @var QuestionRepositoryInterface
     */
    private QuestionRepositoryInterface $questionRepository;

    /**
     * @param Context $context
     * @param QuestionFactory|null $questionFactory
     * @param QuestionRepositoryInterface|null $questionRepository
     */
    public function __construct(
        Context $context,
        QuestionFactory $questionFactory = null,
        QuestionRepositoryInterface $questionRepository = null
    ) {
        parent::__construct($context);
        $this->questionFactory = $questionFactory ?: ObjectManager::getInstance()->get(QuestionFactory::class);
        $this->questionRepository = $questionRepository ?: ObjectManager::getInstance()->get(QuestionRepositoryInterface::class);
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $questionModel = $this->questionFactory->create();
            /** "id" is primary field for product_questions table **/
            if (empty($data['id'])) {
                $data['id'] = null;
            }

            $questionModel->setData($data);

            try {
                $this->questionRepository->save($questionModel);
                $this->messageManager->addSuccessMessage(__('You saved the question!'));
                return $this->processResultRedirect($resultRedirect, $questionModel);
            } catch (\Exception $exception) {
                $this->messageManager->addExceptionMessage($exception);
            }
        }

        return $resultRedirect->setPath('*/*/');
    }

    /**
     * @param $resultRedirect
     * @param $questionModel
     * @return Redirect
     */
    private function processResultRedirect($resultRedirect, $questionModel): Redirect
    {
        if($this->getRequest()->getParam('back') === 'go-back') {
            return $resultRedirect->setPath('*/*/');
        } else {
            return $resultRedirect->setPath('*/*/new', ['id' => $questionModel->getId(), '_current' => true]);
        }
    }
}
