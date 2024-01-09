<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Api;

use Magebit\QuestionsAndAnswers\Api\Data\QuestionInterface;

interface QuestionManagementInterface 
{
    /**
     * @param QuestionInterface $question
     * @return QuestionInterface
     */
    public function showQuestion(QuestionInterface $question): QuestionInterface;

    /**
     * @param QuestionInterface $question
     * @return QuestionInterface
     */
    public function hideQuestion(QuestionInterface $question): QuestionInterface;
}
