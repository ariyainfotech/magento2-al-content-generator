<?php


namespace AriyaInfoTech\AIContentGenerator\Model\CompletionRequest;

use AriyaInfoTech\AIContentGenerator\Api\RequestCompletionInterface;

class MetaKeywords extends AbstractCompletion implements RequestCompletionInterface
{
    public const TYPE = 'meta_keywords';
    protected const CUT_RESULT_PREFIX = 'Meta Keywords: ';

    public function getJsConfig(): ?array
    {
        return [
            'attribute_label' => 'Meta Keywords',
            'container' => 'product_form.product_form.search-engine-optimization.container_meta_keyword',
            'prompt_from' => 'product_form.product_form.content.container_description.description',
            'target_field' => 'product_form.product_form.search-engine-optimization.container_meta_keyword.meta_keyword',
            'component' => 'AriyaInfoTech_AIContentGenerator/js/button',
        ];
    }

    public function getPayloadApi(string $text): array
    {
        parent::validateRequest($text);
        return [
            "model" => "text-davinci-003",
            "prompt" => sprintf("Create HTML meta keywords (only content) of the following product:\n%s", $text),
            "n" => 1,
            "temperature" => 0.5,
            "max_tokens" => 100,
            "frequency_penalty" => 0,
            "presence_penalty" => 0
        ];
    }
}
