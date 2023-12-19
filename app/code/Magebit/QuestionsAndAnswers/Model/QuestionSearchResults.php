<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Model;

use Magebit\QuestionsAndAnswers\Api\Data\QuestionSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Service Data Object with Questions search results.
 */
class QuestionSearchResults extends SearchResults implements QuestionSearchResultsInterface
{
}
