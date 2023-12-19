<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Question extends AbstractDb
{
    /**
     * @return void
     */
    public function _construct(): void
    {
        $this->_init('product_questions', 'id');
    }

}
