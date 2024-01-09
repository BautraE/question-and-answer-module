<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Model;

use Magebit\QuestionsAndAnswers\Model\ResourceModel\Question as ResourceQuestion;
use Magebit\QuestionsAndAnswers\Api\Data\QuestionInterface;
use Magento\Framework\Model\AbstractModel;

class Question extends AbstractModel implements QuestionInterface 
{
    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(ResourceQuestion::class);
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->getData(self::QUESTION_ID);
    }
    
    /**
     * @return string|null
     */
    public function getCustomerId(): ?string
    {
        return $this->getData(self::CUSTOMER_ID);
    }
    
    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->getData(self::PRODUCT_ID);
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
    public function getVisibility(): int
    {
        return (int) $this->getData(self::VISIBILITY);
    }

    /**
     * @param $visibility
     * @return QuestionInterface
     */
    public function setVisibility($visibility): QuestionInterface
    {
        return $this->setData(self::VISIBILITY, $visibility);
    }

    /**
     * @return int
     */
    public function getCreatedByAdmin(): int
    {
        return (int) $this->getData(self::CREATED_BY_ADMIN);
    }

    /**
     * @param $createdByAdmin
     * @return QuestionInterface
     */
    public function setCreatedByAdmin($createdByAdmin): QuestionInterface
    {
        return $this->setData(self::CREATED_BY_ADMIN, $createdByAdmin);
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->getData(self::UPDATED_AT);
    }
}
