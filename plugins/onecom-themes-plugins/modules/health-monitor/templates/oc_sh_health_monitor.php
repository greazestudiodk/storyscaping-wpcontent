<?php
$template = new OnecomTemplate();
?>
<div class="wrap ocsh-wrap">
    <div class="inner one_wrap">
        <div class="wrap_inner">
            <div class="onecom_critical__wrap critical" id="critical">
                <ul class="critical"></ul>
            </div>
            <div class="onecom_head">
                <div class="onecom_head__inner onecom_head_left">
                    <h2 class="onecom_heading"><?php echo $template->get_title(); ?></h2>
                    <p class="onecom_description"><?php echo $template->get_description(); ?></p>
                </div>
                <div class="onecom_head__inner onecom_head_right">
                    <div class="onecom_card">
                        <span class="onecom_card_title"><?php echo __( 'Score', OC_PLUGIN_DOMAIN ) ?>

                            <div class="tooltip">
                            <img
                                    class="onecom_info_icon"
                                    src="<?php echo $template->get_info_icon(); ?>"
                                    alt="info">
                                <img
                                        class="onecom_up-arrow"
                                        src="<?php echo ONECOM_WP_URL ?>modules/health-monitor/assets/images/arrow-up.svg"
                                        alt="info">
                            <span class="tooltiptext"><?php echo __( "Recommendations are common security and performance improvements you can do to enhance your site's defense against hackers and bots.", $this->text_domain ) ?></span>
                        </div>
                        </span>
                        <span id="onecom_card_result" class="onecom_card_value"><span class="poor">0%</span></span>

                    </div>
                    <div class="onecom_card">
                        <span class="onecom_card_title"><?php echo __( 'To do', OC_PLUGIN_DOMAIN ); ?>
                            <div class="tooltip">
                            <img
                                    class="onecom_info_icon"
                                    src="<?php echo $template->get_info_icon(); ?>"
                                    alt="info">
                            <img
                                    class="onecom_up-arrow"
                                    src="<?php echo ONECOM_WP_URL ?>modules/health-monitor/assets/images/arrow-up.svg"
                                    alt="info">
                            <span class="tooltiptext"><?php echo __( "Recommendations are common security and performance improvements you can do to enhance your site's defense against hackers and bots.", $this->text_domain ) ?></span>
                        </div>
                        </span>
                        <span id="onecom_card_todo_score" class="onecom_card_value">0</span>
                    </div>
                </div>

            </div>
        </div>
        <div class="onecom_body">
        <div class="h-parent-wrap">
            <div class="h-parent">
			    <div class="h-child">
                    <div class="onecom_tabs_container" data-error="<?php echo ini_get( 'display_errors' ); ?>">
                    <div class="onecom_tab active" data-tab="todo"><?php echo __( 'To do', OC_PLUGIN_DOMAIN ) ?>
                        <span
                                class="count" id="todo_count">0</span></div>
                    <div class="onecom_tab" data-tab="done"><?php echo __( 'Done', OC_PLUGIN_DOMAIN ) ?><span
                                class="count" id="done_count">0</span></div>
                    <div class="onecom_tab" data-tab="ignored"><?php echo __( 'Ignored', OC_PLUGIN_DOMAIN ) ?><span
                                class="count" id="ignored_count">0</span></div>
                    </div>
                </div>
            </div>
            </div>
            <div class="onecom_tabs_panels">
                <div class="onecom_tabs_panel todo" id="todo">
                    <ul id="plugin-filter" class="todo"></ul>
                </div>
                <div class="onecom_tabs_panel done oc_hidden" id="done">
                    <ul class="done"></ul>
                </div>
                <div class="onecom_tabs_panel ignored oc_hidden" id="ignored">
					<?php echo $template->get_ignored_ul() ?>
                </div>
            </div>
        </div>
    </div>
</div>