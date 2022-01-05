<?php

namespace Magento\HelloWorld\Model\Config;

use Magento\HelloWorld\Model\PostFactory;
use Magento\HelloWorld\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\Api\Filter;
use Magento\Framework\View\Element\UiComponent\DataProvider\FulltextFilterFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var FulltextFilterFactory
     */
    protected $fulltextFilter;

    /**
     * @var array
     */
    protected $_loadedData = [];

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $employeeCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $employeeCollectionFactory,
        array $meta = [],
        array $data = [],
        FulltextFilterFactory $fulltextFilter
    ) {
        $this->fulltextFilter = $fulltextFilter;
        $this->collection = $employeeCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (!empty($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $this->_loadedData[$item->getId()] = $item->getData();
        }
        return $this->_loadedData;
    }

    /**
     * Add processing fulltext query
     *
     * Some workaround for fulltext search.
     *
     * @param Filter $filter
     * @return void
     */
    public function addFilter(Filter $filter)
    {
        if ('fulltext' == $filter->getField()) {
            $this->fulltextFilter->apply($this->collection, $filter);
        } else {
            parent::addFilter($filter);
        }
    }
}
