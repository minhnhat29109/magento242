<?php

namespace Magento\HelloWorld\Block\Product;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Helper\Image;
use Magento\Catalog\Block\Product\AbstractProduct;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Message\ManagerInterface as MessageInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 *
 */
class ListProduct extends \Magento\Framework\View\Element\Template
{
    /**
     * @var CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * @var Image
     */
    protected $imageHelper;

    /**
     * @var ProductFactory
     */
    protected $productFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Review\Model\RatingFactory
     */
    protected $ratingFactory;

    /**
     * @var \Magento\Review\Model\ResourceModel\Review\CollectionFactory
     */
    protected $reviewFactory;

    /**
     * @var AbstractProduct
     */
    protected $abstractProduct;

    /**
     * @var ManagerInterface
     */
    protected $eventManager;

    /**
     * @var MessageInterface
     */
    protected $messageInterface;

    /**
     * @var ResultFactory
     */
    protected $resultFactory;

    public function __construct(
        Context $context,
        array $data = [],
        CollectionFactory $productCollectionFactory,
        Image $imageHelper,
        ProductFactory $productFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Review\Model\RatingFactory $ratingFactory,
        \Magento\Review\Model\ResourceModel\Review\CollectionFactory $reviewFactory,
        AbstractProduct $abstractProduct,
        ManagerInterface $eventManager,
        MessageInterface $messageInterface,
        ResultFactory $resultFactory
    ) {
        parent::__construct($context, $data);
        $this->imageHelper = $imageHelper;
        $this->productFactory = $productFactory;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->storeManager = $storeManager;
        $this->ratingFactory = $ratingFactory;
        $this->reviewFactory = $reviewFactory;
        $this->abstractProduct = $abstractProduct;
        $this->eventManager = $eventManager;
        $this->messageInterface = $messageInterface;
        $this->resultFactory = $resultFactory;
    }

    /**
     * @return mixed
     */
    public function getProductCollection()
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->setPageSize(6); // fetching only 3 products

        return $collection;
    }

    public function getReviewCollection($productId){
        $collection = $this->reviewFactory->create()
            ->addStatusFilter(\Magento\Review\Model\Review::STATUS_APPROVED)
            ->addEntityFilter('product', $productId)
            ->setDateOrder();
        return $collection;
    }

    public function getRatingCollection(){
        $ratingCollection = $this->ratingFactory->create()
            ->getResourceCollection()
            ->addEntityFilter('product')
            ->setPositionOrder()
            ->setStoreFilter($this->storeManager->getStore()->getId())
            ->addRatingPerStoreName($this->storeManager->getStore()->getId())
            ->load();

        return $ratingCollection->getData();
    }

    /**
     * @param $id
     * @return string
     */
    public function getProductImageUrl($id): string
    {
        try {
            $product = $this->productFactory->create()->load($id);
        }  catch (NoSuchEntityException $e) {
            return 'Data not found';
        }
        $url = $this->imageHelper->init($product, 'product_base_image')->getUrl();

        return $url;
    }
}
