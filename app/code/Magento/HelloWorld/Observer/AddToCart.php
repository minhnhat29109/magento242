<?php

namespace Magento\HelloWorld\Observer;

use Magento\Catalog\Model\Product;
use Magento\Framework\Event\Observer;
use Magento\Framework\Exception\LocalizedException;

class AddToCart implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param Observer $observer
     * @return void
     * @throws LocalizedException
     */
    public function execute(Observer $observer)
    {
        /* @var $product Product */
        $product = $observer->getEvent()->getProduct();


        if (!isset($product['add_attribute_test'])) {
            throw new LocalizedException(
                __('Can not add to cart!')
            );
        }
    }
}
