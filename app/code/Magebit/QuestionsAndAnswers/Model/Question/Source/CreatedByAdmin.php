<?php

namespace Magebit\QuestionsAndAnswers\Model\Question\Source;

use Magento\Framework\Data\OptionSourceInterface;

class CreatedByAdmin implements OptionSourceInterface
{
    public function toOptionArray(): array
    {
        return [
            [
                'label' => 'No',
                'value' => 0,
            ],
            [
                'label' => 'Yes',
                'value' => 1,
            ],
        ];
    }
}
