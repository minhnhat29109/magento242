<?php

namespace Magento\HelloWorld\Observer;

use Magento\Framework\Event\Observer;

class ChangeName implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(Observer $observer)
    {
        $data = $observer->getData('postData');
        $name = $data['name'];
        $data->setData('name', $name.'-'.rand(000, 9999));
        $observer->setData('postData', $data);
    }
}
