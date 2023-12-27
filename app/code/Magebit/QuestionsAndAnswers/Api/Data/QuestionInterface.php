<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Api\Data;

interface QuestionInterface 
{
    const QUESTION_ID = 'id';
    const PRODUCT_ID = 'product_id';
    const USER_ID = 'user_id';
    const QUESTION = 'question';
    const ANSWER = 'answer';
    const VISIBILITY = 'visibility';
    const CREATED_BY_ADMIN = 'created_by_admin';
    const UPDATED_AT = 'updated_at';

    /**
     * @return string|null
     */
    public function getId(): ?string;

    /**
     * @return string
     */
    public function getProductId(): string;

    /**
     * @return string|null
     */
    public function getUserId(): ?string;

    /**
     * @return string
     */
    public function getQuestion(): string;

    /**
     * @param $question
     * @return QuestionInterface
     */
    public function setQuestion($question): QuestionInterface;

    /**
     * @return string
     */
    public function getAnswer(): string;

    /**
     * @param $answer
     * @return QuestionInterface
     */
    public function setAnswer($answer): QuestionInterface;

    /**
     * @return int
     */
    public function getVisibility(): int;


    /**
     * @param $visibility
     * @return QuestionInterface
     */
    public function setVisibility($visibility): QuestionInterface;

    /**
     * @return int
     */
    public function getCreatedByAdmin(): int;


    /**
     * @param $createdByAdmin
     * @return QuestionInterface
     */
    public function setCreatedByAdmin($createdByAdmin): QuestionInterface;

    /**
     * @return string
     */
    public function getUpdatedAt(): string;
}
