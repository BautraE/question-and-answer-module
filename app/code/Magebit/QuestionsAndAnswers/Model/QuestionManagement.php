<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Model;

use Magento\Framework\Model\AbstractModel;
use Magebit\QuestionsAndAnswers\Model\ResourceModel\Question as ResourceQuestion;
use Magebit\QuestionsAndAnswers\Api\Data\QuestionInterface;
use Magebit\QuestionsAndAnswers\Api\QuestionManagementInterface;

class QuestionManagement extends AbstractModel implements QuestionManagementInterface
{
    const VISIBILITY = 'visibility';

    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(ResourceQuestion::class);
    }

    /**
     * @param $question
     * @return QuestionInterface
     */
    public function showQuestion($question): QuestionInterface
    {
        return $question->setData(self::VISIBILITY, 1);
    }

    /**
     * @param $question
     * @return QuestionInterface
     */
    public function hideQuestion($question): QuestionInterface
    {
        return $question->setData(self::VISIBILITY, 0);
    }
}
