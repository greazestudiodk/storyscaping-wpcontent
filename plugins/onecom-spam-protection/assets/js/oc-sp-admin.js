jQuery(document).ready(function ($) {

    $('.oc-duration-filter').click(function (e) {
        e.preventDefault();
        var $this = $(this);
        if ($this.parents().hasClass('disabled-section')) {
            return false;
        }
        $('.filter-summary ul li').removeClass('active');
        if (!$this.parent().hasClass('active')) {
            $this.parent().addClass('active');
        }
        // console.log($(this).data('duration'))
        var data = {
            action: 'oc_get_summary',
            duration: $this.data('duration')
        };
        $('span#oc_switch_spinner').css('visibility', 'visible');
        var total_count = $('.oc-summary-body').find('.oc_total_count'),
            comment_count = $('.oc-summary-body').find('.oc_comment_count'),
            registration_count = $('.oc-summary-body').find('.oc_registration_count'),
            failed_login_count = $('.oc-summary-body').find('.oc_failed_login_count'),
            other_count = $('.oc-summary-body').find('.oc_other_count');

        $.post(ajaxurl, data, function (response) {
            total_count.html(response.total_count);
            comment_count.html(response.comments_count);
            registration_count.html(response.registration_count);
            failed_login_count.html(response.failed_login);
            other_count.html(response.other_count);
            $('#oc_switch_spinner').css('visibility', 'hidden');

        });
    });


    var blocked_lists = $('.sp-blocked-lists'),
        whitelist = blocked_lists.find('#spbadusragent'),
        urlshortener = blocked_lists.find('#spurlshort'),
        proburl = blocked_lists.find('#spprobchk'),
        whitelist_users = blocked_lists.find('#spwhitelistusername'),
        username_textarea = blocked_lists.find('.oc_whitelist_usernames'),
        useragent_textarea = blocked_lists.find('.oc-whitelist-useragent'),
        urlshorteners_textarea = blocked_lists.find('.oc-url-shorters'),
        exploit_url_textarea = blocked_lists.find('.oc-exploit-urls'),
        limitlogin = $('#spquickres'),
        max_login_val = $('.oc_max_login_val'),
        block_time = $('.oc_block_time');


    // events trigger on page load
    if (whitelist_users && whitelist_users.prop('checked') === true) {
        username_textarea.prop('disabled', false).css('background', '#ffffff');
    } else if (whitelist_users && whitelist_users.prop('checked') !== true) {
        username_textarea.prop('disabled', true).css('background', '#f0f0f1');
    }

    if (whitelist && whitelist.prop('checked') === true) {
        useragent_textarea.prop('disabled', false).css('background', '#ffffff');
    } else if (whitelist && whitelist.prop('checked') !== true) {
        useragent_textarea.prop('disabled', true).css('background', '#f0f0f1');
    }

    if (urlshortener && urlshortener.prop('checked') === true) {
        urlshorteners_textarea.prop('disabled', false).css('background', '#ffffff');
    } else if (urlshortener && urlshortener.prop('checked') !== true) {
        urlshorteners_textarea.prop('disabled', true).css('background', '#f0f0f1');
    }

    if (proburl && proburl.prop('checked') === true) {
        exploit_url_textarea.prop('disabled', false).css('background', '#ffffff');
    } else if (proburl && proburl.prop('checked') !== true) {
        exploit_url_textarea.prop('disabled', true).css('background', '#f0f0f1');
    }

    if (limitlogin && limitlogin.prop('checked') === true) {
        max_login_val.prop('disabled', false).css('background', '#ffffff');
        block_time.prop('disabled', false).css('background', '#ffffff');
    } else if (limitlogin && limitlogin.prop('checked') !== true) {
        max_login_val.prop('disabled', true).css('background', '#f0f0f1');
        block_time.prop('disabled', true).css('background', '#f0f0f1');
    }

    // page load events end //

// events which triggers on change of the toggle switches

    whitelist_users.on('change', function () {
        var checked = $(this).prop('checked');
        username_textarea.prop('disabled', !checked);
        if (!checked) {
            username_textarea.css('background', '#f0f0f1');
        } else {
            username_textarea.css('background', '#ffffff');
        }
    });


    whitelist.on('change', function () {
        var checked = $(this).prop('checked');
        useragent_textarea.prop('disabled', !checked);
        if (!checked) {
            useragent_textarea.css('background', '#f0f0f1');
        } else {
            useragent_textarea.css('background', '#ffffff');
        }
    });
    urlshortener.on('change', function () {
        var checked = $(this).prop('checked');
        urlshorteners_textarea.prop('disabled', !checked);
        if (!checked) {
            urlshorteners_textarea.css('background', '#f0f0f1');
        } else {
            urlshorteners_textarea.css('background', '#ffffff');
        }
    });
    proburl.on('change', function () {
        var checked = $(this).prop('checked');
        exploit_url_textarea.prop('disabled', !checked).css('background', '#f0f0f1');
        if (!checked) {
            exploit_url_textarea.css('background', '#f0f0f1');
        } else {
            exploit_url_textarea.css('background', '#ffffff');
        }
    });

    $('#spquickres').on('change', function () {
        var checked = $(this).prop('checked');
        max_login_val.prop('disabled', !checked).css('background', '#f0f0f1');
        block_time.prop('disabled', !checked).css('background', '#f0f0f1');
        if (!checked) {
            max_login_val.css('background', '#f0f0f1');
            block_time.css('background', '#f0f0f1');
        } else {
            max_login_val.css('background', '#ffffff');
            block_time.css('background', '#ffffff');
        }
    });

    // on change events end

    $('.sp-diagnostics').on('submit', function (e) {


        e.preventDefault();
        var $this = $(this);
        var ip = $this.find('#ocvalidateip').val(),
            user = $this.find('#ocvalidateuser').val(),
            email = $this.find('#ocvalidateemail').val(),
            useragent = $this.find('#ocvalidateuseragent').val(),
            content = $this.find('#ocvalidatecontent').val(),
            validation_err = $this.parent().find('.oc-dg-err');


        if (ip == '' && email == '' && user == '' && useragent == '' && content == '' && (validation_err.length) == 0) {

            $this.parent().prepend('<div class="notice notice-error oc-dg-err"><p class="error">' + onespnotice.oc_notice + '</p></div>');

        } else if (ip == '' && email == '' && user == '' && useragent == '' && content == '' && (validation_err.length) > 0) {

            return false;

        } else {
            $this.unbind('submit').submit();
        }


    })

    $('.oc-show-modal').on('click', function (e) {

        e.preventDefault();

        $('#oc_um_overlay').show();
        ocSetModalData({
            isPremium: 'true',
            feature: '',
            featureAction: ''
        });


    })

// Show floating save button if regular button is not in viewport (via JS Observer API)
    var observer = new IntersectionObserver(function (entries) {
        // isIntersecting is true when element and viewport are overlapping else false
        if (entries[0].isIntersecting === true) {
            $('.oc-sp-float-btn').hide();
        } else {
            $('.oc-sp-float-btn').show();
        }
    }, {threshold: [0]});

    observer.observe(document.querySelector("#onecom-sp-ui .oc-save"));

    // disable submit button if no change in settings form

    let settingsForm = $('#onecom-sp-ui').find('form');
    let parentClass = settingsForm.parent().get( 0 ).className;

    if(parentClass === 'one-sp-logs' || parentClass === 'ocdg-form-section' ){
        return false;
    }

    settingsForm.on('click','.oc-save',function(e){

        e.preventDefault();
        $(this).val('Saving');
        settingsForm.submit();



    })

    settingsForm.each(function () {
        $(this).data('serialized', $(this).serialize())
    })
        .on('change input', function () {
            $(this)
                .find('input:submit')
                .attr('disabled', $(this).serialize() == $(this).data('serialized'))
            ;
        })
        .find('input:submit, button:submit')
        .attr('disabled', true);

})


