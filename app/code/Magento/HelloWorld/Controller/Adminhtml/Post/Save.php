<?php

namespace Magento\HelloWorld\Controller\Adminhtml\Post;

use Magento\HelloWorld\Model\PostFactory;
use Magento\Backend\App\Action;

/**
 * Class Save
 * @package Magento\HelloWorld\Controller\Adminhtml\Post
 */
class Save extends Action
{
    /**
     * @var PostFactory
     */
    private $postFactory;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param PostFactory $postFactory
     */
    public function __construct(
        Action\Context $context,
        PostFactory $postFactory
    ) {
        parent::__construct($context);
        $this->postFactory = $postFactory;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $id = !empty($data['post_id']) ? $data['post_id'] : null;

        $newData = [
            'name' => $data['name'],
            'status' => $data['status'],
            'content' => $data['content'],
        ];
        $post = $this->postFactory->create();

        if ($id) {
            $post->load($id);
        }

        try {
            $post->addData($newData);

            if (!$id)
            {
                $this->_eventManager->dispatch("my_module_event_after", ['postData' => $post]);
            }

            $post->save();
            $this->messageManager->addSuccessMessage(__('You saved the post.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('You can not save the post.'));
        }

        return $this->resultRedirectFactory->create()->setPath('helloworld/post/index');
    }
}
