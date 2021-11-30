<?php

namespace Magento\HelloWorld\Model\Config\Source;

class Language implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [
            [
                'value' => null,
                'label' => __('--Please Select--')
            ],
            [
                'value' => 'vi',
                'label' => __('Việt Nam')
            ],
            [
                'value' => 'en',
                'label' => __('Anh')
            ],
            [
                'value' => 'tq',
                'label' => __('Trung Quốc')
            ],
            [
                'value' => 'my',
                'label' => __('Mỹ')
            ],
        ];
    }
}
