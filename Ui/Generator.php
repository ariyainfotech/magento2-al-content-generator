<?php
namespace AriyaInfoTech\AIContentGenerator\Ui;

use AriyaInfoTech\AIContentGenerator\Model\ConfigCompletion;
use Magento\Ui\Component\Container;

class Generator extends Container
{
    public function getConfiguration(): array
    {
        $config = parent::getConfiguration();

        /** @var ConfigCompletion $ConfigCompletion */
        $ConfigCompletion = $this->getData('completion_config');

        return array_merge(
            $config,
            $ConfigCompletion->getConfig(),
            [
                'settings' => [
                    'serviceUrl' => $this->context->getUrl('ariyainfotech_aicontentgenerator/generate'),
                    'validationUrl' => $this->context->getUrl('ariyainfotech_aicontentgenerator/validate'),
                ]
            ]
        );
    }
}
