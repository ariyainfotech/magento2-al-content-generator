<?php

namespace AriyaInfoTech\AIContentGenerator\Model;

use AriyaInfoTech\AIContentGenerator\Api\RequestCompletionInterface;
use Magento\Framework\App\RequestInterface;

class ConfigCompletion
{
    /**
     * @var RequestCompletionInterface[]
     */
    private array $pool;
    private Config $config;
    private RequestInterface $request;

    public function __construct(
        array $pool,
        Config $config,
        RequestInterface $request
    ) {
        $this->pool = $pool;
        $this->config = $config;
        $this->request = $request;
    }

    public function getConfig(): array
    {
        if (!$this->config->getValue(Config::XML_PATH_ENABLED)) {
            return [
                'targets' => []
            ];
        }

        $allowedStores = $this->config->getEnabledStoreIds();
        $storeId = (int) $this->request->getParam('store', '0');
        if (!in_array($storeId, $allowedStores)) {
            return [
                'targets' => []
            ];
        }

        $targets = [];

        foreach ($this->pool as $config) {
            $targets[$config->getType()] = $config->getJsConfig();
        }

        $targets = array_filter($targets);

        return [
            'targets' => $targets
        ];
    }

    public function getByType(string $type): ?RequestCompletionInterface
    {
        foreach ($this->pool as $config) {
            
            if ($config->getType() === $type) {
                return $config;
            }
        }
        return null;
    }
}
