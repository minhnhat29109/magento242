<?php

namespace Magento\HelloWorld\Model;

class Post extends \Magento\Framework\Model\AbstractModel
{
    public function __construct()
    {
        $this->_init('Magento\HelloWorld\Model\ResourceModel\Post');
    }
}
