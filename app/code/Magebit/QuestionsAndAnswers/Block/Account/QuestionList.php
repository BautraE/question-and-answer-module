<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Block\Account;

use Magento\Framework\View\Element\Template;
use Magebit\QuestionsAndAnswers\Api\QuestionRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Message\ManagerInterface;
use Magebit\QuestionsAndAnswers\Api\Data\QuestionInterface;

class QuestionList extends Template
{
    /**
     * @var QuestionRepositoryInterface
     */
    private QuestionRepositoryInterface $questionRepositoryInterface;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;
    /**
     * @var CustomerSession
     */
    private CustomerSession $customerSession;
    /**
     * @var SortOrderBuilder
     */
    private SortOrderBuilder $sortOrderBuilder;
    /**
     * @var ManagerInterface
     */
    private ManagerInterface $messageManager;

    /**
     * @param Template\Context $context
     * @param array $data
     * @param QuestionRepositoryInterface $questionRepositoryInterface
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param ProductRepositoryInterface $productRepository
     * @param CustomerSession $customerSession
     * @param SortOrderBuilder $sortOrderBuilder
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        Template\Context $context,
        array $data,
        QuestionRepositoryInterface $questionRepositoryInterface,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ProductRepositoryInterface $productRepository,
        CustomerSession $customerSession,
        SortOrderBuilder $sortOrderBuilder,
        ManagerInterface $messageManager
    ) {
        parent::__construct($context, $data);
        $this->questionRepositoryInterface = $questionRepositoryInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->productRepository = $productRepository;
        $this->customerSession = $customerSession;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->messageManager = $messageManager;
    }

    /**
     * @return array
     */
    public function getQuestions(): array
    {
        $customerId = $this->customerSession->getCustomer()->getId();
        
        $sortOrder = $this->sortOrderBuilder
            ->setField('updated_at')
            ->setDirection('DESC')
            ->create();
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('user_id', $customerId, 'eq')
            ->setSortOrders([$sortOrder])
            ->create();

        return $this->questionRepositoryInterface->getList($searchCriteria)->getItems();
    }

    /**
     * @param QuestionInterface $question
     * @return string
     */
    public function isAnswered(QuestionInterface $question): string
    {
        if($question->getVisibility()) {
            return "Answered";
        }
        return "Not Answered";
    }

    /**
     * @param QuestionInterface $question
     * @return string
     */
    public function getProductName(QuestionInterface $question): string
    {
        $product = $this->productRepository->getById($question->getProductId());
        return $product->getName();
    }

    /**
     * @return void
     */
    public function getNotice(): void
    {
        $this->messageManager->addNoticeMessage(__("You have no submitted questions."));
    }
}
