<?php
    $pc_checked = '';
    $dev_mode_checked = '';
    $exclude_cdn_checked = '';
    $performance_icon = $this->OCVCURI.'/assets/images/performance@2x.svg';
    $performance_icon_2x = $this->OCVCURI.'/assets/images/performance-active@2x.svg 2x';
    $performance_icon_active = $this->OCVCURI.'/assets/images/performance-active@2x.svg';
    $performance_icon_2x_active = $this->OCVCURI.'/assets/images/performance-active@2x.svg 2x';
    $varnish_caching = get_site_option(self::defaultPrefix . 'enable');    
    $varnish_caching_ttl = get_site_option('varnish_caching_ttl');
    $varnish_caching_ttl_unit = get_site_option('varnish_caching_ttl_unit');
    $dev_mode_duration = $this->oc_json_get_option('onecom_vcache_info','dev_mode_duration');
    $oc_dev_mode_status = $this->oc_json_get_option('onecom_vcache_info','oc_dev_mode_enabled');
    $oc_exclude_cdn_data = $this->oc_json_get_option('onecom_vcache_info','oc_exclude_cdn_data');
    $oc_exclude_cdn_status = $this->oc_json_get_option('onecom_vcache_info','oc_exclude_cdn_enabled');

    if ($this->oc_premium() === true){
        $wrap_premium_class = 'oc-premium';
    } else {
        $wrap_premium_class = 'oc-non-premium';
    }

    if ($varnish_caching == "true"){
        $pc_checked = 'checked';
    }

    if ($oc_dev_mode_status == "true"){
        $dev_mode_checked = 'checked';
    } else {
        $dev_mode_checked = '';
    }
    
    if ($oc_exclude_cdn_status == "true"){
        $exclude_cdn_checked = 'checked';
    } else {
        $exclude_cdn_checked = '';
    }
    
    $cdn_enabled = get_site_option('oc_cdn_enabled');

    $cdn_icon = $this->OCVCURI.'/assets/images/cdn.png';
    $cdn_icon_2x = $this->OCVCURI.'/assets/images/cdn@2x.png 2x';    
    $cdn_icon_active = $this->OCVCURI.'/assets/images/cdn-active@1x.png';
    $cdn_icon_2x_active = $this->OCVCURI.'/assets/images/cdn-active@2x.png 2x';
    
?>
<div id="onestaging-clonepage-wrapper">
    <!-- Page Header -->
    <div class="wrap onecom-staging-wrap <?php echo $wrap_premium_class; ?>" id="onecom-ui">
        <div class="onecom-notifier"></div>
        <?php
            if ($this->oc_premium() != true && function_exists('onecom_premium_theme_admin_notice')){
                onecom_premium_theme_admin_notice();
                //(function_exists( 'onecom_generic_log')? onecom_generic_log( "wp_premium_click", "pcache"):'');
            }
        ?>

        <h1 class="one-title"> <?php _e('Performance Tools', self::textDomain);
            if ($this->oc_premium() === true){ 
                echo "<span>Pro</span>";
			} /* else {
				echo "<span>Lite</span>";
			} */ ?>
        </h1>
        <div class="page-subtitle">
            <?php
            if (true === $this->oc_premium()){
                _e('Make your website faster with Performance Cache Pro by saving a cached copy of it. With the Pro version, you get more optimization.', self::textDomain);
            }
            else{
                _e('Make your website faster with Performance Cache by saving a cached copy of it.', self::textDomain);
            }
            ?>
        </div>
        <!-- <h2 class="one-logo">
            <div class="textleft">
                <span><?php _e('Get better performance with Performance Cache and CDN', self::textDomain)?></span>
            </div>
            <div class="textright">
                <img src="<?php echo $this->OCVCURI.'/assets/images/one.com-logo@2x.svg' ?>" alt="one.com"
                    srcset="<?php echo $this->OCVCURI.'/assets/images/one.com-logo@2x.svg 2x' ?>" />
            </div> 
        </h2> -->
        <div class="wrap_inner inner one_wrap">
            <div class="one-card one-card-performance">
                <div class="one-card-inline-block one-card-align-left onecom-staging-logo">
                    <img id="oc-performance-icon" width="160" height="160" src="<?php echo $performance_icon ?>" alt="one.com"
                        srcset="<?php echo $performance_icon_2x;?>" style="display: <?php echo $pc_checked === ''? 'inline':'none'?>;"/>
                        <img id="oc-performance-icon-active" width="160" height="160" src="<?php echo $performance_icon_active ?>" alt="one.com"
                        srcset="<?php echo $performance_icon_2x_active;?>" style="display: <?php echo $pc_checked === 'checked'? 'inline':'none'?>;"/>
                </div>
                <div class="one-card-inline-block one-card-align-left one-card-staging-content">
                    <div id="staging-create" class="one-card-staging-create card-1">
                        <div class="one-card-staging-create-info">
                            <h2 class="no-top-margin">
                                <?php _e('Performance Cache', self::textDomain)?>
                            </h2>
                            <div class="oc-block">
                                <?php _e('With One.com Performance Cache enabled your website loads a lot faster. We save a cached copy of your website on a Varnish server, that will then be served to your next visitors. <br/>This is especially useful if you have a lot of visitors. It may also help to improve your SEO ranking. If you would like to learn more, please read our help article: <a href="https://help.one.com/hc/en-us/articles/360000080458" target="_blank">How to use the One.com Performance Cache for WordPress</a>.', self::textDomain );?><br>
                                <?php _e('Performance cache is purged automatically when a post or page is published or modified.', self::textDomain ); ?> <a href="<?php echo wp_nonce_url(add_query_arg($this->purgeCache, 1), $this->plugin); ?>" title="Purge Performance Cache">
                                <?php echo __('Purge Performance Cache', $this->plugin); ?></a>
                            </div>
                            <div class="oc-block">
                                <label for="pc_enable" class="oc-label">
                                <span class="oc_cb_switch">
                                    <input type="checkbox" id="pc_enable" data-target="pc_enable_settings" name="show"
                                        value=1 <?php echo $pc_checked; ?> />
                                    <span class="oc_cb_slider" data-target="oc-performance-icon"
                                        data-target-input="pc_enable"></span>
                                </span>
                                <?php echo __("Enable Performance Cache", self::textDomain); ?>
                            </label><span id="oc_pc_switch_spinner" class="oc_cb_spinner spinner"></span> 
                            </div>
                            
                            <div id="pc_enable_settings" style="display:<?php echo $pc_checked === 'checked'? 'block' : 'none'?>;">
                                <?php

                                    // show if any of mwp/PC feature available
                                    if($this->OCVer->isVer() 
                                    && ($this->oc_premium() === true || $this->oc_pcache() === true)) { 
                                        if ($varnish_caching_ttl_unit == 'minutes') {
                                            $vc_ttl_as_unit = $varnish_caching_ttl / 60;
                                        } else if ($varnish_caching_ttl_unit == 'hours') {
                                            $vc_ttl_as_unit = $varnish_caching_ttl / 3600;
                                        } else if ($varnish_caching_ttl_unit == 'days') {
                                            $vc_ttl_as_unit = $varnish_caching_ttl / 86400;
                                        } else {
                                            $vc_ttl_as_unit = $varnish_caching_ttl;
                                        }
                                    ?>
                                       <form method="post" action="options.php">
                                            <label class="oc_vcache_ttl_label"><?php _e('Cache TTL', self::textDomain)?></label><span class="tooltip"><span class="dashicons dashicons-editor-help"></span><span><?php echo __( 'The time that website data is stored in the Varnish cache. After the TTL expires the data will be updated, 0 means no caching.', self::textDomain )?></span></span>
                                            <div class="oc-input-wrap">
                                            <input type="text" name="oc_vcache_ttl" class="oc_vcache_ttl" id="oc_vcache_ttl" value="<?php echo $vc_ttl_as_unit; ?>"/>
                                            <select class="oc-vcache-ttl-select" name="oc_vcache_ttl_unit" id="oc_vcache_ttl_unit">
                                        <option value="seconds" 
                                            <?php if($varnish_caching_ttl_unit =="seconds") { echo "selected"; } ?> 
                                            ><?php _e('Seconds', self::textDomain)?></option>
                                        <option value="minutes"
                                            <?php if($varnish_caching_ttl_unit =="minutes") { echo "selected"; } ?> 
                                           ><?php _e('Minutes', self::textDomain)?></option>
                                        <option value="hours"
                                            <?php if($varnish_caching_ttl_unit =="hours") { echo "selected"; } ?> 
                                           ><?php _e('Hours', self::textDomain)?></option>
                                        <option value="days"
                                            <?php if($varnish_caching_ttl_unit =="days") { echo "selected"; } ?> 
                                          ><?php _e('Days', self::textDomain)?></option>
                                        </select>
                                            <button type="button" id="oc_ttl_save" class="one-button btn button_1 oc_vcache_btn no-right-margin"><?php _e('Save', self::textDomain)?></button>
                                            <span id="oc_ttl_spinner" class="oc_cb_spinner spinner"></span>
                                            <p class="oc_vcache_decription"><?php _e('Time to live in Varnish cache', self::textDomain)?></p>
                                            </div>
                                            </form>

                                        <?php } 
                                        else {
                                            // upgrade modal moved to top of the page
                                        } ?>
                            </div>
                            <?php /* ?><a href="https://help.one.com/hc/en-us/articles/360000020617" class="help_link pc_block"
                                target="_blank"><?php _e('Need help?',self::textDomain );?></a>
                            <br><?php */ ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="one-card one-card-cdn">
                <div class="one-card-inline-block one-card-align-left onecom-staging-logo">
                    <img id="oc-cdn-icon" width="160" height="160" src="<?php echo $cdn_icon ?>" alt="one.com"
                        srcset="<?php echo $cdn_icon_2x;?>" style="display: <?php echo $cdn_enabled != 'true' ? 'inline' : 'none'?>" />
                        <img id="oc-cdn-icon-active" width="160" height="160" src="<?php echo $cdn_icon_active?>" alt="one.com"
                        srcset="<?php echo $cdn_icon_2x_active;?>" style="display: <?php echo $cdn_enabled == 'true' ? 'inline' : 'none'?>"/>

                </div>
                <div class="one-card-inline-block one-card-align-left one-card-staging-content">
                    <div id="staging-create" class="one-card-staging-create card-1">
                        <div class="one-card-staging-create-info">
                            <h2 class="no-top-margin">
                                <?php _e('Content Delivery Network', self::textDomain);?>
                            </h2>
                            <div class="oc-block">
                                <?php _e('A content delivery network is a system of distributed servers that deliver pages and other web content to a user, <br/>based on the geographic locations of the user, the origin of the webpage and the content delivery server. <br>This is especially useful if you have a lot of visitors spread across the globe.', self::textDomain );?> <a href="<?php echo wp_nonce_url(add_query_arg($this->purgeCache, 'cdn'), $this->plugin); ?>" title="Purge CDN">
                            <?php echo __('Purge CDN', $this->plugin); ?></a>
                            </div>

                            <div class="oc-block">
                                <label for="cdn_enable" class="oc-label">
                                    <span class="oc_cb_switch">
                                        <input type="checkbox" class="" id="cdn_enable" name="show" value=1
                                            <?php echo $cdn_enabled == 'true' ? 'checked' : ''?> />
                                        <span class="oc_cb_slider" data-target="oc-cdn-icon"></span>
                                    </span>
                                    <?php echo __("Enable CDN", self::textDomain); ?>
                                </label><span id="oc_cdn_switch_spinner" class="oc_cb_spinner spinner"></span>
                            </div>
                            <?php /* ?><br><br>
                            <a href="https://help.one.com/hc/en-us/articles/360000020617" class="help_link"
                                target="_blank"><?php _e('Need help?',self::textDomain );?></a>
                            <br><?php */ ?>

                            <div class="oc-cdn-feature-box oc-block" style="display:<?php echo $cdn_enabled === 'true'? 'block' : 'none'?>;">

                            <div class="oc-block">
                                <label for="dev_mode_enable" class="oc-label">
                                    <span class="oc_cb_switch">
                                        <input type="checkbox" class="" id="dev_mode_enable" name="show" value=1 <?php echo $dev_mode_checked; ?> />
                                        <span class="oc_cb_slider oc_warn" data-target="oc-cdn-icon"></span>
                                    </span>
                                    <?php echo __("Development mode", self::textDomain); ?>
                                </label><span id="oc_dev_mode_switch_spinner" class="oc_cb_spinner spinner"></span>

                                <div id="dev_mode_enable_settings" style="display:<?php echo $dev_mode_checked === 'checked'? 'block' : 'none'?>;" >

                                    <form method="post" action="options.php">
                                        <label class="oc_vcache_ttl_label"><?php _e('End development mode (hours)', self::textDomain)?></label><span class="tooltip"><span class="dashicons dashicons-editor-help"></span><span><?php echo __( 'CDN will not work for logged-in users until development mode is active.', self::textDomain )?></span></span>
                                        <div class="oc-input-wrap">
                                        <input type="text" min="0" max="720" class="" id="dev_mode_duration" value="<?php echo $dev_mode_duration ?>">
                                        <button type="button" id="oc_dev_duration_save" class="one-button btn button_1 oc_dev_mode_btn no-right-margin"><?php _e('Save', self::textDomain) ?></button>
                                        <span id="oc_dev_duration_spinner" class="oc_cb_spinner spinner"></span>
                                        
                                        <p class="oc_vcache_decription"><?php echo __("Development mode will get disabled after entered duration", self::textDomain); ?></p>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="">
                            <label for="exclude_cdn_enable" class="oc-label">
                                <span class="oc_cb_switch">
                                    <input type="checkbox" class="" id="exclude_cdn_enable" name="show" value=1 <?php echo $exclude_cdn_checked; ?> />
                                    <span class="oc_cb_slider oc_warn" data-target="oc-cdn-icon"></span>
                                </span>
                                <?php echo __("Exclude from CDN", self::textDomain); ?>
                            </label><span id="oc_exclude_cdn_switch_spinner" class="oc_cb_spinner spinner"></span>

                            <div id="exclude_cdn_enable_settings" style="display:<?php echo $exclude_cdn_checked === 'checked'? 'block' : 'none'?>;" >

                                <form method="post" action="options.php">
                                    <label class="oc_vcache_ttl_label">
                                    <?php _e('Specify files and folders to be excluded (one per line)', self::textDomain)?></label>
                                    <span class="tooltip"><span class="dashicons dashicons-editor-help"></span><span><?php
                                    echo __( 'Specify files and folders you wish to exclude from CDN. For example:', self::textDomain ).
                                    "<br />". __( '.css', self::textDomain ). 
                                    "<br />". __( 'uploads', self::textDomain ).
                                    "<br />". __( 'uploads/2021/02/sample.png', self::textDomain ).
                                    "<br />". __( 'themes/assets/js/', self::textDomain );
                                    
                                    ?></span></span>
                                    <div class="oc-input-wrap">
                                    <textarea id="exclude_cdn_data"
                                    placeholder=".css
uploads
uploads/2021/02/sample.png
themes/assets/js/
"><?php echo $oc_exclude_cdn_data ?></textarea>
                                    </div>
                                    <div>
                                    <button type="button" id="oc_exclude_cdn_data_save" class="one-button btn button_1 oc_cdn_exclude_btn no-right-margin"><?php _e('Save', self::textDomain) ?></button>
                                    <span id="oc_exclude_cdn_data_spinner" class="oc_cb_spinner spinner"></span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- wp rocket link -->
            <div class="one-card one-card-cdn" style="padding-bottom: 18px;">
                <div class="one-card-inline-block one-card-align-left onecom-staging-logo">
                    <img id="oc-cdn-icon" width="160" height="160" src="<?php echo $this->OCVCURI.'/assets/images/wp-rocket-dark.svg';?>" alt="one.com"  style="display: inline">
                </div>
                <div class="one-card-inline-block one-card-align-left one-card-staging-content">
                    <div id="wp-rocket-link" class="one-card-staging-create card-3">
                        <div class="one-card-staging-create-info">
                            <h2 class="no-top-margin"><?php _e('WP Rocket', self::textDomain)?></h2>
                            <div class="oc-block"><?php _e('WP Rocket is the most powerful caching plugin in the world. Use it to improve
                                the speed of your WordPress site. SEO ranking and conversions. No coding required.', self::textDomain)?>
                            </div>
                            <div class="oc-block">
                                <a href="https://wp-rocket.me/one-and-wp-rocket/?utm_campaign=one-benefits&utm_source=one&utm_medium=partners" title="<?php _e('Get WP Rocket with -20% discount', self::textDomain)?>" target="_blank" id="wprocketLink"
                                   style="background: #f56f46;color: #ffffff;overflow-wrap: break-word;padding: 5px 15px;text-decoration: none;border-bottom: none !important;font-weight: 600;"><?php _e('Get WP Rocket with -20% discount', self::textDomain)?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- wp rocket link end -->
        </div>
        <div id="onecom-staging-error-wrapper">
            <div id="onecom-staging-error-details"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>