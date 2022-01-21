<?php
namespace Magento\HelloWorld\Controller\Cart;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Add extends Action
{
    /**
     * @var \Magento\Framework\Data\Form\FormKey
     */
    private \Magento\Framework\Data\Form\FormKey $formKey;

    /**
     * @var \Magento\Catalog\Model\Product
     */
    private \Magento\Catalog\Model\Product $product;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    private \Magento\Checkout\Model\Session $checkoutSession;

    /**
     * @var \Magento\Quote\Api\CartRepositoryInterface
     */
    private \Magento\Quote\Api\CartRepositoryInterface $cartRepository;

    /**
     * @param Context $context
     * @param \Magento\Framework\Data\Form\FormKey $formKey
     * @param \Magento\Catalog\Model\Product $product
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Quote\Api\CartRepositoryInterface $cartRepository
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Catalog\Model\Product $product,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Quote\Api\CartRepositoryInterface $cartRepository
    ) {
        parent::__construct($context);
        $this->formKey = $formKey;
        $this->product = $product;
        $this->checkoutSession = $checkoutSession;
        $this->cartRepository = $cartRepository;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $productId = $this->getRequest()->getParam('product_id');
        //Load the product based on productID
        $product = $this->product->load($productId);
        $quote = $this->checkoutSession->getQuote();
        $quote->addProduct($product);
        $this->cartRepository->save($quote);
        $this->checkoutSession->replaceQuote($quote)->unsLastRealOrderId();
        $pageResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        return $pageResult->setData([
            'message' => 'success',
            'product' => $product->getData(),
        ]);
    }
}
