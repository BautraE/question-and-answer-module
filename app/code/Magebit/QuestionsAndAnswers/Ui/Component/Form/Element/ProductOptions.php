<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Ui\Component\Form\Element;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;

class ProductOptions implements OptionSourceInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    /**
     * @var SortOrderBuilder
     */
    private SortOrderBuilder $sortOrderBuilder;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder
    ) {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @return array
     */
    public function toOptionArray(): array
    {
        $sortOrder = $this->sortOrderBuilder
            ->setField('name')
            ->setDirection('ASC')
            ->create();
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('type_id', 'configurable', 'eq')
            ->setSortOrders([$sortOrder])
            ->create();
        $productList = $this->productRepository->getList($searchCriteria)->getItems();
        $options = [];

        foreach ($productList as $product) {
            $options[] = [
                'value' => $product->getId(),
                'label' => $product->getName()
            ];
        }

        return $options;
    }
}
