<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Model;

use Magento\Framework\Model\AbstractModel;
use Magebit\QuestionsAndAnswers\Model\ResourceModel\Question as ResourceQuestion;
use Magebit\QuestionsAndAnswers\Api\Data\QuestionInterface;
use Magebit\QuestionsAndAnswers\Api\QuestionManagementInterface;

class QuestionManagement extends AbstractModel implements QuestionManagementInterface
{
    const STATUS = 'status';

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
    public function enableQuestion($question): QuestionInterface
    {
        return $question->setData(self::STATUS, 1);
    }

    /**
     * @param $question
     * @return QuestionInterface
     */
    public function disableQuestion($question): QuestionInterface
    {
        return $question->setData(self::STATUS, 0);
    }
}
