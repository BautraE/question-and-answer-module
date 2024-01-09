<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class CustomerName extends Column
{
    /**
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param CustomerRepositoryInterface $customerRepository
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        CustomerRepositoryInterface $customerRepository,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param array $dataSource
     * @return void
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {

                if(!$item['customer_id']) {
                    $item['customer_name'] = NULL;
                }
                else {
                    if (!$customer = $this->customerRepository->getById($item['customer_id'])){
                        $item['customer_name'] = NULL;
                    }
                    else {
                        $item['customer_name'] = $customer->getFirstname() . " " . $customer->getLastname();
                    }
                }
            }
        }

        return $dataSource;
    }
}
