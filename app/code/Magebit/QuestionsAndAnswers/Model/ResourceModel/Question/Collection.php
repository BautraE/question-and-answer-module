<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Model\ResourceModel\Question;

use Magebit\QuestionsAndAnswers\Model\Question;
use Magebit\QuestionsAndAnswers\Model\ResourceModel\Question as ResourceQuestion;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(Question::class, ResourceQuestion::class);
    }
}
