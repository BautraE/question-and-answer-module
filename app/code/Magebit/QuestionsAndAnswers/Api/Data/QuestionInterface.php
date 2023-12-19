<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Api\Data;
interface QuestionInterface {
    const QUESTION_ID = 'id';
    const PRODUCT = 'product';
    const QUESTION = 'question';
    const ANSWER = 'answer';
    const STATUS = 'status';
    const POSITION = 'position';
    const UPDATED_AT = 'updated_at';

    /**
     * @return string|null
     */
    public function getId(): ?string;

    /**
     * @return string
     */
    public function getProduct(): string;

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
    public function getStatus(): int;


    /**
     * @param $status
     * @return QuestionInterface
     */
    public function setStatus($status): QuestionInterface;

    /**
     * @return int
     */
    public function getPosition(): int;


    /**
     * @param $position
     * @return QuestionInterface
     */
    public function setPosition($position): QuestionInterface;

    /**
     * @return string
     */
    public function getUpdatedAt(): string;

}
