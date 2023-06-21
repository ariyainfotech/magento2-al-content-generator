<?php

namespace AriyaInfoTech\Chatgptaicontent\Model\CompletionRequest;

use AriyaInfoTech\Chatgptaicontent\Api\RequestCompletionInterface;

class MetaDescription extends AbstractCompletion implements RequestCompletionInterface
{
    public const TYPE = 'meta_description';
    protected const CUT_RESULT_PREFIX = 'Meta Description: ';

    public function getJsConfig(): ?array
    {
        return [
            'attribute_label' => 'Meta Description',
            'container' => 'product_form.product_form.search-engine-optimization.container_meta_description',
            'prompt_from' => 'product_form.product_form.content.container_description.description',
            'target_field' => 'product_form.product_form.search-engine-optimization.container_meta_description.meta_description',
            'component' => 'AriyaInfoTech_Chatgptaicontent/js/button',
        ];
    }

    public function getPayloadApi(string $text): array
    {
        parent::validateRequest($text);
        return [
            "model" => "text-davinci-003",
            "prompt" => sprintf("Create a HTML meta description (short as possible) from the following product:\n%s", $text),
            "n" => 1,
            "temperature" => 0.5,
            "max_tokens" => 255,
            "frequency_penalty" => 0,
            "presence_penalty" => 0
        ];
    }
}
