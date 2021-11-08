<div class="one-sp-wrap wrap" id="onecom-sp-ui">
    <?php echo OnecomSp::sp_admin_head(__(' Protection Settings',OC_SP_TEXTDOMAIN), __('Configure your spam protection settings.',OC_SP_TEXTDOMAIN));

    $sp_options = oc_get_sp_options('onecom_sp_protect_options');

    $onecom_sp = new OnecomSp();


    $nonce = '';
    if (array_key_exists('one_sp_nonce', $_POST)) {
        $nonce = $_POST['one_sp_nonce'];
    }


    if (!empty($nonce) && wp_verify_nonce($nonce, 'one_sp_nonce')) {

        $protect_options = OnecomSp::sp_protect_options();
        $protect_options[]='oc_sp_quickres';

        foreach ($protect_options as $option) {

            $option_val = 'false';
            if (array_key_exists($option, $_POST)) {
                $option_val = $_POST[$option];
                if ($option_val != 'true') {
                    $option_val = 'false';
                }
            }
            $sp_options['checks'][$option] = $option_val;
        }
        $sp_options['checks']['oc_max_login_val'] = isset($_POST['oc_max_login_val']) ? (int)$_POST['oc_max_login_val'] : 5;
        $sp_options['checks']['oc_block_time'] = isset($_POST['oc_block_time']) ? (int)$_POST['oc_block_time'] : 30;

        $setting_status = array('settings_status'=>json_encode(array_map('strval', $sp_options['checks'])));
        (class_exists('OCPushStats') ? OCPushStats::push_stats_performance_cache('save', 'setting','setting', ONECOM_SP_PLUGIN_SLUG,$setting_status) : '');

        oc_save_sp_options($sp_options, 'onecom_sp_protect_options');
        $success_notice = '<div class="notice notice-success is-dismissible"><p>'.__('Protection settings updated!',OC_SP_TEXTDOMAIN).'</p></div>';


    }
    $spoption_checks = $sp_options['checks'];
    $oc_sp_accept= isset($spoption_checks['oc_sp_accept'])?$spoption_checks['oc_sp_accept']:'';
    $oc_sp_referrer= isset($spoption_checks['oc_sp_referrer'])?$spoption_checks['oc_sp_referrer']:'';
    $oc_sp_long= isset($spoption_checks['oc_sp_long'])?$spoption_checks['oc_sp_long']:'';
    $oc_sp_short= isset($spoption_checks['oc_sp_short'])?$spoption_checks['oc_sp_short']:'';
    $oc_sp_bbcode= isset($spoption_checks['oc_sp_bbcode'])?$spoption_checks['oc_sp_bbcode']:'';
    $oc_sp_exploit= isset($spoption_checks['oc_sp_exploit'])?$spoption_checks['oc_sp_exploit']:'';
    $oc_sp_quickres= isset($spoption_checks['oc_sp_quickres'])?$spoption_checks['oc_sp_quickres']:'';
    $oc_max_login_val= isset($spoption_checks['oc_max_login_val'])?$spoption_checks['oc_max_login_val']:'';
    $oc_block_time= isset($spoption_checks['oc_block_time'])?$spoption_checks['oc_block_time']:'';


    ?>


    <?php
    $oc_nonce = wp_create_nonce('one_sp_nonce');
    if (!empty($success_notice)) {
        echo "$success_notice";
    } ?>

    <form class="sp-protect-options" method="post">
        <input type="hidden" name="one_sp_nonce" value="<?php echo $oc_nonce; ?>"/>

        <label for="spaccept">
                        <span class="oc_sp_switch">
            <input class="oc_sp_check" type="checkbox" id="spaccept" name="oc_sp_accept"
                   value="true" <?php if ($oc_sp_accept == 'true') {
                echo "checked=\"checked\"";
            } ?>>
             <span class="oc_sp_slider"></span>
                        </span>
            <span><?php _e('Block requests without HTTP_ACCEPT header', OC_SP_TEXTDOMAIN) ?></span>
        </label>
            <p class="description"><span class="dashicons dashicons-info oc-info"></span>
                <span class="prt-desc"><?php _e('Blocks users who have a missing or incomplete HTTP_ACCEPT header. All browsers provide this header.If a request is missing the HTTP_ACCEPT header it is because a poorly written bot is trying access your site.', OC_SP_TEXTDOMAIN); ?></span>
            </p>



        <label for="spreferrer">
            <span class="oc_sp_switch">
            <input class="oc_sp_check" type="checkbox" id="spreferrer" name="oc_sp_referrer"
                   value="true" <?php if ($oc_sp_referrer == 'true') {
                echo "checked=\"checked\"";
            } ?>>
                 <span class="oc_sp_slider"></span>
                        </span>
            <span><?php _e('Block requests coming from invalid HTTP_REFERER', OC_SP_TEXTDOMAIN) ?></span>
        </label>
        <p class="description"><span class="dashicons dashicons-info oc-info"></span>
        <span class="prt-desc"><?php _e('When a form is submitted, all browsers generally provide origin of that submission i.e., HTTP_REFERER header. 
                If the HTTP_REFERER header is missing or does not match your website then that submission is probably not made by a human. 
                Note: In some cases, you may want to disable this check if you are noticing incorrect spam detections from visitors who are accessing your site via mobile/tablet devices.', OC_SP_TEXTDOMAIN) ?></span>
        </p>


        <label for="splongchk">
            <span class="oc_sp_switch">
            <input class="oc_sp_check" type="checkbox" id="splongchk" name="oc_sp_long"
                   value="true" <?php if ($oc_sp_long == 'true') {
                echo "checked=\"checked\"";
            } ?>>
            <span class="oc_sp_slider"></span>
            </span>
            <span><?php _e('Disable lengthy emails and author names', OC_SP_TEXTDOMAIN) ?></span>
        </label>
            <p class="description"><span class="dashicons dashicons-info oc-info"></span>
                <span class="prt-desc"><?php _e('Spammers mostly use unusually long names and emails. This check rejects the submissions having names and emails over 64 characters.', OC_SP_TEXTDOMAIN) ?></span>
            </p>


        <label for="spshrtchk">
            <span class="oc_sp_switch">
            <input class="oc_sp_check" type="checkbox" id="spshrtchk" name="oc_sp_short"
                   value="true" <?php if ($oc_sp_short == 'true') {
                echo "checked=\"checked\"";
            } ?>>
                <span class="oc_sp_slider"></span>
            </span>
            <span><?php _e('Disable too short emails and author names', OC_SP_TEXTDOMAIN) ?></span>
        </label>
            <p class="description"><span class="dashicons dashicons-info oc-info"></span>
                <span class="prt-desc"><?php _e('Spammers often  use short usernames or emails. This blocks requests with emails less than 5 characters & usernames less than 3 characters.', OC_SP_TEXTDOMAIN) ?></span>
            </p>



        <label for="spbbcode">
            <span class="oc_sp_switch">
            <input class="oc_sp_check" type="checkbox" id="spbbcode" name="oc_sp_bbcode"
                   value="true" <?php if ($oc_sp_bbcode == 'true') {
                echo "checked=\"checked\"";
            } ?>>
            <span class="oc_sp_slider"></span>
            </span>
            <span><?php _e('Mark comments having BBCodes as spam', OC_SP_TEXTDOMAIN) ?></span>
        </label>
            <p class="description"><span class="dashicons dashicons-info oc-info"></span>
                <span class="prt-desc"><?php _e('BBCodes are codes like [url] that spammers like to place in comments. WordPress does not support BBCodes without a plugin.  If you have a BBCode plugin then uncheck this. This check will mark any comment that has BBCodes as spam.', OC_SP_TEXTDOMAIN) ?></span>
            </p>


        <label for="spexploit">
            <span class="oc_sp_switch">
            <input class="oc_sp_check" type="checkbox" id="spexploit" name="oc_sp_exploit"
                   value="true" <?php if ($oc_sp_exploit == 'true') {
                echo "checked=\"checked\"";
            } ?>>
                <span class="oc_sp_slider"></span>
            </span>
            <span><?php _e('Analyse input fields text for exploits', OC_SP_TEXTDOMAIN) ?></span>
        </label>
            <p class="description"><span class="dashicons dashicons-info oc-info"></span>
                <span class="prt-desc"><?php _e('This checks for the PHP `eval` function and typical SQL injection strings in comments text and login attempts. It also checks for JavaScript that may potentially be used for cross domain exploits.', OC_SP_TEXTDOMAIN) ?></span>
            </p>


        <label for="spquickres">
            <span class="oc_sp_switch">
            <input class="oc_sp_check" type="checkbox" id="spquickres" name="oc_sp_quickres"
                   value="true" <?php if ($oc_sp_quickres == 'true') {
                echo "checked=\"checked\"";
            } ?>>
            <span class="oc_sp_slider"></span>
            </span>
            <span><?php _e('Block users with consecutive failed login attempts', OC_SP_TEXTDOMAIN) ?></span></label>
            <p class="description"><span class="dashicons dashicons-info oc-info"></span>
                <span class="prt-desc"> <?php _e('On finding maximum number of failed login attempts in a fixed time duration from an IP address, the login form is temporarily blocked for that IP for duration as specified below.', OC_SP_TEXTDOMAIN) ?></span></p>


            <label class="sp-sub-points"><?php _e('Maximum no of failed login attempts',OC_SP_TEXTDOMAIN)?>: <input type="number" required class="oc_max_login_val" name="oc_max_login_val" value="<?php echo $oc_max_login_val ?>" min="1" max="10"></label>
            <label class="sp-sub-points"><?php _e('Time for which user will be temporarily blocked(in seconds)',OC_SP_TEXTDOMAIN)?>: <input
                        type="number" required name="oc_block_time" class="oc_block_time" value="<?php echo $oc_block_time ?>" min="10" max="900"></label>




        <p>
            <?php echo $onecom_sp->oc_generate_submit_button('regular') ?>
            <a class="oc-advance-link" href="<?php menu_page_url('onecom-wp-advanced-settings') ?>"><?php echo __('Advanced settings',OC_SP_TEXTDOMAIN)?></a>
        </p>

        <div class="oc_sticky_footer">
            <p><?php echo $onecom_sp->oc_generate_submit_button('sticky') ?></p>
        </div>

        <p><?php echo $onecom_sp->oc_generate_submit_button('float') ?></p>

    </form>


</div>