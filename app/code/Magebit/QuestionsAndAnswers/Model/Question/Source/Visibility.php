<?php

namespace Magebit\QuestionsAndAnswers\Model\Question\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Visibility implements OptionSourceInterface
{
    public function toOptionArray(): array
    {
        return [
            [
                'label' => 'Hidden',
                'value' => 0,
            ],
            [
                'label' => 'Visible',
                'value' => 1,
            ],
        ];
    }
}
