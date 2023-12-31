<?php

namespace AriyaInfoTech\AIContentGenerator\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    public const XML_PATH_ENABLED = 'ariyainfotech_aicontentgenerator/general/enabled';
    public const XML_PATH_BASE_URL = 'ariyainfotech_aicontentgenerator/api/base_url';
    public const XML_PATH_TOKEN = 'ariyainfotech_aicontentgenerator/api/token';
    public const XML_PATH_STORES = 'ariyainfotech_aicontentgenerator/general/stores';
    private ScopeConfigInterface $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return mixed
     */
    public function getValue(string $path, $scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        return $this->scopeConfig->getValue($path, $scopeType, $scopeCode);
    }

    /**
     * @return int[]
     */
    public function getEnabledStoreIds(): array
    {
        $stores = $this->scopeConfig->getValue(self::XML_PATH_STORES);

        if ($stores === null || $stores === '') {
            $storeList = [0];
        } else {
            $storeList = $stores === '0' ? [0] : array_map('intval', explode(',', $stores));
        }
        sort($storeList, SORT_NUMERIC);

        return $storeList;
    }
}
