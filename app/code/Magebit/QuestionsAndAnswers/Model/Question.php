<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Model;

use Magebit\QuestionsAndAnswers\Model\ResourceModel\Question as ResourceQuestion;
use Magebit\QuestionsAndAnswers\Api\Data\QuestionInterface;
use Magento\Framework\Model\AbstractModel;

class Question extends AbstractModel implements QuestionInterface {
    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(ResourceQuestion::class);
    }

    /**
     * @return ?string
     */
    public function getId(): ?string
    {
        return $this->getData(self::QUESTION_ID);
    }

    /**
     * @return string
     */
    public function getProduct(): string
    {
        return $this->getData(self::PRODUCT);
    }

    /**
     * @return string
     */
    public function getQuestion(): string
    {
        return (string) $this->getData(self::QUESTION);
    }

    /**
     * @param $question
     * @return QuestionInterface
     */
    public function setQuestion($question): QuestionInterface
    {
        return $this->setData(self::QUESTION, $question);
    }

    /**
     * @return string
     */
    public function getAnswer(): string
    {
        return (string) $this->getData(self::ANSWER);
    }

    /**
     * @param $answer
     * @return QuestionInterface
     */
    public function setAnswer($answer): QuestionInterface
    {
        return $this->setData(self::ANSWER, $answer);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return (int) $this->getData(self::STATUS);
    }

    /**
     * @param $status
     * @return QuestionInterface
     */
    public function setStatus($status): QuestionInterface
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return (int) $this->getData(self::POSITION);
    }

    /**
     * @param $position
     * @return QuestionInterface
     */
    public function setPosition($position): QuestionInterface
    {
        return $this->setData(self::POSITION, $position);
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->getData(self::UPDATED_AT);
    }

}
