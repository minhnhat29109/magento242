<?php
namespace Magento\CatalogGraphQl\Model\Resolver\Product\CanonicalUrl;

/**
 * Interceptor class for @see \Magento\CatalogGraphQl\Model\Resolver\Product\CanonicalUrl
 */
class Interceptor extends \Magento\CatalogGraphQl\Model\Resolver\Product\CanonicalUrl implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Catalog\Helper\Product $productHelper)
    {
        $this->___init();
        parent::__construct($productHelper);
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(\Magento\Framework\GraphQl\Config\Element\Field $field, $context, \Magento\Framework\GraphQl\Schema\Type\ResolveInfo $info, ?array $value = null, ?array $args = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'resolve');
        return $pluginInfo ? $this->___callPlugins('resolve', func_get_args(), $pluginInfo) : parent::resolve($field, $context, $info, $value, $args);
    }
}
