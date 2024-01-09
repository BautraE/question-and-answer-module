<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Api;

use Magebit\QuestionsAndAnswers\Api\Data\QuestionInterface;
use Magebit\QuestionsAndAnswers\Api\Data\QuestionSearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Api\SearchCriteriaInterface;

interface QuestionRepositoryInterface
{
    /**
     * @param int $questionId
     * @return QuestionInterface
     * @throws LocalizedException
     */
    public function get (int $questionId): QuestionInterface;

    /**
     * @param QuestionInterface $question
     * @return QuestionInterface
     * @throws LocalizedException
     */
    public function save (QuestionInterface $question): QuestionInterface;

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return QuestionSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList (SearchCriteriaInterface $searchCriteria): QuestionSearchResultsInterface;

    /**
     * @param QuestionInterface $question
     * @return bool true on success
     * @throws LocalizedException
     */
    public function delete (QuestionInterface $question): bool;

    /**
     * @param int $questionId
     * @return bool true on success
     * @throws LocalizedException
     */
    public function deleteById (int $questionId): bool;
}
