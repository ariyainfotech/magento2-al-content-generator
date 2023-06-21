<?php

namespace AriyaInfoTech\AIContentGenerator\Controller\Adminhtml\Generate;

use AriyaInfoTech\AIContentGenerator\Model\OpenAI\OpenExceptionAi;
use InvalidArgumentException;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use AriyaInfoTech\AIContentGenerator\Model\ConfigCompletion;
use Magento\Framework\Exception\LocalizedException;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\RequestInterface;


class Index extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'AriyaInfoTech_AIContentGenerator::generate';

    private JsonFactory $jsonFactory;
    private ConfigCompletion $ConfigCompletion;
    protected $productRepository;
    protected $request;

    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        ConfigCompletion $ConfigCompletion,
        ProductRepositoryInterface $productRepository,
       RequestInterface $request
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->ConfigCompletion = $ConfigCompletion;
        $this->productRepository = $productRepository;
        $this->request = $request;
    }

    /**
     * @throws LocalizedException
     */
    public function execute()
    {
       $resultPage = $this->jsonFactory->create();

         $type = $this->ConfigCompletion->getByType(
          $this->getRequest()->getParam('type')
         );

        if ($type === null) {
            throw new LocalizedException(__('Invalid request parameters'));
        }

        try {
            $prompt = $this->getRequest()->getParam('prompt');
            $result = $type->query($prompt);

        } catch (OpenExceptionAi | InvalidArgumentException $e) {
            $resultPage->setData([
                'error' => $e->getMessage()
            ]);
            return $resultPage;
        }

        $resultPage->setData([
            'result' => $result,'type' => $this->getRequest()->getParam('type')
        ]);

        return $resultPage;
     }
    /**
     * @inheritDoc
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('AriyaInfoTech_AIContentGenerator::generate');
    }
}
