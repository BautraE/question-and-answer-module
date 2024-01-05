<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Model\Question;

use Magebit\QuestionsAndAnswers\Model\ResourceModel\Question\CollectionFactory;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\ReportingInterface;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider;
use Magebit\QuestionsAndAnswers\Model\ResourceModel\Question\Collection;
use Magebit\QuestionsAndAnswers\Api\QuestionRepositoryInterface;
use Magebit\QuestionsAndAnswers\Model\QuestionFactory;
use Magento\Framework\Exception\LocalizedException;
use Magebit\QuestionsAndAnswers\Model\Question;

class QuestionDataProvider extends DataProvider
{
    /**
     * @var Collection
     */
    private Collection $collection;
    /**
     * @var QuestionRepositoryInterface
     */
    private QuestionRepositoryInterface $questionRepository;
    /**
     * @var QuestionFactory
     */
    private QuestionFactory $questionFactory;
    /**
     * @var array
     */
    private array $loadedData;

    /**
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param ReportingInterface $reporting
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param RequestInterface $request
     * @param FilterBuilder $filterBuilder
     * @param CollectionFactory $collectionFactory
     * @param QuestionRepositoryInterface $questionRepository
     * @param QuestionFactory $questionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        ReportingInterface $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        CollectionFactory $collectionFactory,
        QuestionRepositoryInterface $questionRepository,
        QuestionFactory $questionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $reporting,
            $searchCriteriaBuilder,
            $request,
            $filterBuilder,
            $meta,
            $data);
        $this->collection = $collectionFactory->create();
        $this->questionRepository = $questionRepository;
        $this->questionFactory = $questionFactory;
    }

    /**
     * @return array
     * @throws LocalizedException
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $question = $this->getCurrentQuestion();
        $this->loadedData[$question->getId()] = $question->getData();

        return $this->loadedData;
    }

    /**
     * @return Question
     * @throws LocalizedException
     */
    private function getCurrentQuestion(): Question
    {
        $questionId = $this->getQuestionId();
        if (!$questionId) {
            return $this->questionFactory->create();
        }
        return $this->questionRepository->get((int)$questionId);
    }

    /**
     * @return string|null
     */
    private function getQuestionId(): ?string
    {
        return $this->request->getParam($this->getRequestFieldName());
    }
}
