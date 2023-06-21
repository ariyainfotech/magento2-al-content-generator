define([
    'Magento_Ui/js/form/components/button',
    'uiRegistry',
    'mage/url'
], function (Button, registry, urlBuilder) {
    'use strict';

    return Button.extend({
        defaults: {
            title: 'Content AI',
            error: '',
            displayArea: '',
            template: 'AriyaInfoTech_Chatgptaicontent/button',
            elementTmpl: 'AriyaInfoTech_Chatgptaicontent/button',
            modalName: null,
            actions: [{
                targetName: '${ $.name }',
                actionName: 'action'
            }],
        },
          /**
         * @abstract
         */
        onRender: function () {
        },
        /**
         * @abstract
         */
        hasAddons: function () {
            return false;
        },
        /**
         * @abstract
         */
        hasService: function () {
            return false;
        },
        action: function () {
            var data = new FormData();
            var payload ={
                  'form_key': FORM_KEY,
                  'prompt': jQuery("input[name='product[name]']").val(),
                  'type': this.settings.type
                };
            var result = true;

            jQuery.ajax({ url: jQuery('#openai_url').val(),data: payload,showLoader: true,type: 'POST',}).done(
                function (response) {
                    if(response.type == 'meta_keywords'){
                      jQuery("textarea[name='product[meta_keyword]']").val(response.result).trigger('change');
                    }else if(response.type == 'meta_description'){
                      jQuery("textarea[name='product[meta_description]']").val(response.result).trigger('change');
                    }else if(response.type == 'meta_title'){
                       jQuery("input[name='product[meta_title]']").val(response.result).trigger('change');
                    }
                    return true;
                }
            ).fail(
                function (response) {
                    errorProcessor.process(response);
                }
            );          
        }
    });
});
