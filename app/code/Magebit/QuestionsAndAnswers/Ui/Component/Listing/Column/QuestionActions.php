<?php

declare(strict_types=1);

namespace Magebit\QuestionsAndAnswers\Ui\Component\Listing\Column;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Escaper;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

class QuestionActions extends Column
{
    private UrlInterface $urlBuilder;
    private Escaper $escaper;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        Escaper $escaper,
        array $components = [],
        array $data = []
    ) {
        $this->escaper = $escaper;
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['id'])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl('qna/question/new', ['id' => $item['id']]),
                        'label' => __('Edit'),
                    ];
                    $question = $this->getEscaper()->escapeHtml($item['question']);
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl('qna/question/delete', ['id' => $item['id']]),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete %1', $question),
                            'message' => __('Are you sure you want to delete the question: "%1"?', $question),
                        ],
                        'post' => true,
                    ];
                }
            }
        }
        return $dataSource;
    }

    private function getEscaper()
    {
        if (!$this->escaper) {
            $this->escaper = ObjectManager::getInstance()->get(Escaper::class);
        }
        return $this->escaper;
    }
}
