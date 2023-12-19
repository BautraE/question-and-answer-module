<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface QuestionSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return QuestionInterface[]
     */
    public function getItems();

    /**
     * @param QuestionInterface[] $items
     */
    public function setItems(array $items);
}
