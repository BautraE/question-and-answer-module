<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Model;

use Magebit\QuestionsAndAnswers\Api\Data\QuestionInterface;
use Magebit\QuestionsAndAnswers\Api\Data\QuestionSearchResultsInterface;
use Magebit\QuestionsAndAnswers\Api\QuestionRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magebit\QuestionsAndAnswers\Model\ResourceModel\Question as ResourceQuestion;
use Magebit\QuestionsAndAnswers\Model\ResourceModel\Question\CollectionFactory as QuestionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magebit\QuestionsAndAnswers\Api\Data\QuestionSearchResultsInterfaceFactory;
use Magebit\QuestionsAndAnswers\Model\QuestionFactory as QuestionModelFactory;

class QuestionRepository implements QuestionRepositoryInterface
{
    /**
     * @var ResourceQuestion
     */
    private ResourceQuestion $resourceQuestion;
    /**
     * @var QuestionFactory
     */
    private QuestionFactory $questionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;
    /**
     * @var QuestionSearchResultsInterfaceFactory
     */
    private QuestionSearchResultsInterfaceFactory $searchResultsFactory;
    /**
     * @var QuestionModelFactory
     */
    private QuestionModelFactory $questionModelFactory;

    /**
     * @param ResourceQuestion $resourceQuestion
     * @param QuestionFactory $questionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param QuestionSearchResultsInterfaceFactory $searchResultsFactory
     * @param QuestionModelFactory $questionModelFactory
     */
    public function __construct(
        ResourceQuestion $resourceQuestion,
        QuestionFactory $questionFactory,
        CollectionProcessorInterface $collectionProcessor,
        QuestionSearchResultsInterfaceFactory $searchResultsFactory,
        QuestionModelFactory $questionModelFactory
    ) {
        $this->resourceQuestion = $resourceQuestion;
        $this->questionFactory = $questionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->questionModelFactory = $questionModelFactory;
    }

    /**
     * @param int $questionId
     * @return QuestionInterface
     */
    public function get (int $questionId): QuestionInterface
    {
        $question = $this->questionModelFactory->create();
        $this->resourceQuestion->load($question, $questionId);
        return $question;
    }

    /**
     * @param QuestionInterface $question
     * @return QuestionInterface
     * @throws CouldNotSaveException
     */
    public function save (QuestionInterface $question): QuestionInterface
    {
        try {
            $this->resourceQuestion->save($question);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $question;
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return QuestionSearchResultsInterface
     */
    public function getList (SearchCriteriaInterface $searchCriteria): QuestionSearchResultsInterface
    {
        $collection = $this->questionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @param QuestionInterface $question
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete (QuestionInterface $question): bool
    {
        try {
            $this->resourceQuestion->delete($question);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @param int $questionId
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById (int $questionId): bool
    {
        return $this->delete($this->get($questionId));
    }
}
