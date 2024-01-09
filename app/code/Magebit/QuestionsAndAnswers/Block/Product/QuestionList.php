<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Block\Product;

use Magento\Framework\View\Element\Template;
use Magebit\QuestionsAndAnswers\Api\QuestionRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Registry;
use Magebit\QuestionsAndAnswers\Api\Data\QuestionInterface;
use Magento\Catalog\Api\Data\ProductInterface;

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
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;
    /**
     * @var SortOrderBuilder
     */
    private SortOrderBuilder $sortOrderBuilder;
    protected $_coreRegistry = null;
    protected $_product = null;

    /**
     * @param Template\Context $context
     * @param array $data
     * @param QuestionRepositoryInterface $questionRepositoryInterface
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param Registry $registry
     * @param CustomerRepositoryInterface $customerRepository
     * @param SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        Template\Context $context,
        array $data,
        QuestionRepositoryInterface $questionRepositoryInterface,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        Registry $registry,
        CustomerRepositoryInterface $customerRepository,
        SortOrderBuilder $sortOrderBuilder
    ) {
        parent::__construct($context, $data);
        $this->questionRepositoryInterface = $questionRepositoryInterface;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_coreRegistry = $registry;
        $this->customerRepository = $customerRepository;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @return array
     * @throws LocalizedException
     */
    public function getQuestions(): array
    {
        $productId = $this->getProduct()->getId();

        $sortOrder = $this->sortOrderBuilder
            ->setField('updated_at')
            ->setDirection('DESC')
            ->create();
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('product_id', $productId, 'eq')
            ->addFilter('visibility', '1', 'eq')
            ->create();
        
        return $this->questionRepositoryInterface->getList($searchCriteria)->getItems();
    }

    /**
     * @return void
     */
    public function getProduct(): ProductInterface
    {
        if (!$this->_product) {
            $this->_product = $this->_coreRegistry->registry('product');
        }
        return $this->_product;
    }

    /**
     * @param QuestionInterface $question
     * @return string
     */
    public function getAuthorName(QuestionInterface $question): string
    {
        if($question->getCreatedByAdmin()) {
            return "(admin)";
        }
        $customerId = $question->getCustomerId();
        $customer = $this->customerRepository->getById($customerId);
        if (!$customer->getId()) {
            return '(deleted user)';
        }
        return $customer->getFirstname();
    }
}
