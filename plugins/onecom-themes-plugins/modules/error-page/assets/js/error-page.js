(function ($) {

    $("#onecom_ep_enable").click(function () {

        if(parseInt(LocalizeObj.isPremium)){
            $(this).find('.oc-failed')
            {
                $('.oc-failed').removeClass("oc-failed");
            }
            var data = {
                action: 'onecom-error-pages',
                type: $(this).prop("checked") ? 'enable' : 'disable'
            };
            $('.components-spinner').css("display", "inline-block");
            ajaxUpdate(data);
        }else{
            //show modal for premium
            checkPremium($(this));
        }
    });

    function failButton() {
        if ($("#onecom_ep_enable").prop("checked")) {
            $('.oc_cb_slider').addClass("oc-failed");
            $("#onecom_ep_enable").prop("checked", false);
        } else {
            $('.oc_cb_slider').addClass("oc-success");
            $("#onecom_ep_enable").prop("checked", true);
        }
    }

    function checkPremiumSwitch(){

        if(!parseInt(LocalizeObj.isPremium)){

            var data = {
                action: 'onecom-error-pages',
                type: 'disable'
            };

            ajaxUpdate(data);
        }

    }

    function ajaxUpdate(data){
        $.post(ajaxurl, data, function (res) {
            $('.components-spinner').css("display", "none");
            if (res.status === 'success') {
                $('#onecom-error-preview').toggleClass("onecom-error-extended");
                $('#onecom-status-message').slideUp();
            } else {
                $('#onecom-status-message').text(res.message);
                $('#onecom-status-message').slideDown();
                failButton();
            }
        });
    }

    function checkPremium(thisObj){
        if(!parseInt(LocalizeObj.isPremium)){
            var referrer = location.search;
            $('#oc_um_overlay').show();
            ocSetModalData({
                isPremium: LocalizeObj.isPremium,
                feature: 'advanced_error_page',
                featureAction: 'settings',
                referrer: referrer
            });
            //check status
            if (thisObj.is(':checked')) {
                thisObj.prop('checked', false);
            } else {
                checkPremiumSwitch();
                thisObj.prop('checked', false);
            }
            return false;
        }
    }
})(jQuery);