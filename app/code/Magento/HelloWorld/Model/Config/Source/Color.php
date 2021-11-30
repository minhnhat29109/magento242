<?php

namespace Magento\HelloWorld\Model\Config\Source;

class Color implements \Magento\Framework\Option\ArrayInterface
{

    public function toOptionArray()
    {
        return [
            [
                'value' => null,
                'label' => __('--Please Select--')
            ],
            [
                'value' => 'yellow',
                'label' => __('Yellow')
            ],
            [
                'value' => 'red',
                'label' => __('Red')
            ],
            [
                'value' => 'gold',
                'label' => __('Gold')
            ],
        ];
    }
}
