<?php


class OnecomSpSettings extends OnecomSp
{

    public $is_premium;

    public function __construct()
    {

        add_action('admin_menu', array($this, 'oc_sp_admin_page'));
        $base = new OnecomSp();
        $this->is_premium = onecomsp_is_premium();

    }

    public function oc_sp_admin_page()
    {

        $menu_title = __("Spam Protection", $this->text_domain);
        add_menu_page($menu_title, $menu_title, 'manage_options', 'onecom-wp-spam-protection', array($this, 'sp_settings_page'), 'dashicons-shield' );


        add_submenu_page('onecom-wp-spam-protection',
            __('Spam Summary',$this->text_domain),
            '<span id="onecom_spam_protection">' . __('Spam Summary' , $this->text_domain) . '</span>',
            'manage_options',
            'onecom-wp-spam-protection',
            array($this, 'sp_settings_page'));
        if ($this->is_premium) {

            add_submenu_page(
                'onecom-wp-spam-protection',
                __($this->sub_page_protection, $this->text_domain),
                '<span id="onecom_spam_protection">' . __($this->sub_page_protection, $this->text_domain) . '</span>',
                'manage_options',
                'onecom-wp-protection-settings',
                array($this, 'protection_settings_page')
            );

            add_submenu_page(
                'onecom-wp-spam-protection',
                __($this->sub_page_blocklist, $this->text_domain),
                '<span id="onecom_spam_protection">' . __($this->sub_page_blocklist, $this->text_domain) . '</span>',
                'manage_options',
                'onecom-wp-advanced-settings',
                array($this, 'blocked_lists_page')
            );

            add_submenu_page(
                'onecom-wp-spam-protection',
                __($this->sub_page_logs, $this->text_domain),
                '<span id="onecom_spam_protection">' . __($this->sub_page_logs, $this->text_domain) . '</span>',
                'manage_options',
                'onecom-wp-spam-logs',
                array($this, 'spam_logs_page')
            );

            add_submenu_page(
                'onecom-wp-spam-protection',
                __($this->sub_page_diagnostics, $this->text_domain),
                '<span id="onecom_spam_protection">' . __($this->sub_page_diagnostics, $this->text_domain) . '</span>',
                'manage_options',
                'onecom-wp-spam-diagnostics',
                array($this, 'diagnostics_page')
            );
        }


    }


    public function sp_settings_page()
    {

        $spamlogs = oc_get_sp_options('onecom_sp_spam_logs');
        $total_count = isset($spamlogs['spam_count']) ? $spamlogs['spam_count'] : 0;
        $comments = [];
        $registration = [];
        $failed_login = [];
        $other = [];

        if (isset($spamlogs['records']) && is_array($spamlogs['records'])) {

            foreach ($spamlogs['records'] as $record) {


                if (strpos($record[3], 'wp-comments-post.php') !== false) {

                    $comments[] = $record[3];
                    unset($record[3]);

                } elseif (strpos($record[3], 'action=register') !== false) {
                    $registration[] = $record[3];
                    unset($record[3]);

                } elseif (strcmp('/wp-login.php', $record[3]) == 0) {

                    $failed_login[] = $record[3];
                    unset($record[3]);


                } else {
                    $other[] = $record[3];
                }

            }

        }

        $disabled = (!$this->is_premium) ? 'oc-show-modal' : '';
        $disabled_class = (!$this->is_premium) ? 'disabled-section' : '';
        ?>
        <div class="one-sp-wrap wrap" id="onecom-sp-ui">

            <?php if (!$this->is_premium && function_exists('onecom_premium_theme_admin_notice')){
                onecom_premium_theme_admin_notice();
            }?>

            <?php echo OnecomSp::sp_admin_head(__('Spam Protection', OC_SP_TEXTDOMAIN).'<span>Pro</span>', __('Protect your website from spambots commenting or registering on it.', OC_SP_TEXTDOMAIN)); ?>

            <div class="one-sp-body">
                <div class="left-section">
                    <div class="card onecom-sp-card">
                        <h3><?php _e('Protection options', OC_SP_TEXTDOMAIN) ?></h3>
                        <p><?php _e('Adjust the security levels as per your requirement.', OC_SP_TEXTDOMAIN) ?></p>
                        <p>
                            <a href="<?php if ($this->is_premium) {
                                menu_page_url('onecom-wp-protection-settings');
                            } else { ?>javascript:void(0)<?php } ?>"
                               class="oc-save <?php echo $disabled; ?>" <?php echo $disabled; ?>><?php _e('Configure protection settings', OC_SP_TEXTDOMAIN) ?></a>
                        </p>
                    </div>
                    <div class="card onecom-sp-card">
                        <h3><?php _e('Spam Logs', OC_SP_TEXTDOMAIN) ?></h3>
                        <p><?php _e('View the requests blocked by spam protection plugin.', OC_SP_TEXTDOMAIN) ?></p>
                        <p><a class="oc-save <?php echo $disabled; ?>" href="<?php if ($this->is_premium) {
                                menu_page_url('onecom-wp-spam-logs');
                            } else { ?>javascript:void(0)<?php } ?>"><?php _e('View logs', OC_SP_TEXTDOMAIN) ?></a></p>
                    </div>
                </div>
                <div class="right-section <?php echo $disabled_class ?>">
                    <h3><?php _e('Spam summary', OC_SP_TEXTDOMAIN) ?></h3>
                    <p><?php _e('View the counts of spam events.', OC_SP_TEXTDOMAIN) ?></p>
                    <div class="filter-summary">
                        <ul>
                            <li><a href="javascript:void(0)" data-duration="24hours"
                                   class="oc-duration-filter"> <?php _e('Last 24 hours', OC_SP_TEXTDOMAIN) ?></a></li>
                            <li><a href="javascript:void(0)" data-duration="7days"
                                   class="oc-duration-filter"><?php _e('Last week', OC_SP_TEXTDOMAIN) ?></a></li>
                            <li><a href="javascript:void(0)" data-duration="30days"
                                   class="oc-duration-filter"><?php _e('Last month', OC_SP_TEXTDOMAIN) ?></a></li>
                        </ul>

                    </div>
                    <div class="oc-summary-body"><span id="oc_switch_spinner" class="oc_cb_spinner spinner"></span>
                        <ul>
                            <li><span class="sp-success"></span><span
                                        class="oc_total_count"><?php echo $total_count . '</span> ' . __('total spams blocked', OC_SP_TEXTDOMAIN) ?>
                            </li>
                            <li><span class="sp-success"></span><span
                                        class="oc_comment_count"><?php echo count($comments) . '</span> ' . __('spam comments blocked', OC_SP_TEXTDOMAIN) ?>  <a
                                            href="<?php echo admin_url('edit-comments.php?comment_status=spam') ?>">Review</a>
                            </li>
                            <li><span class="sp-success"></span><span
                                        class="oc_registration_count"><?php echo count($registration) . '</span> ' . __('spam registrations blocked', OC_SP_TEXTDOMAIN) ?>
                            </li>
                            <li><span class="sp-success"></span><span
                                        class="oc_failed_login_count"><?php echo count($failed_login) . '</span> ' . __('failed logins blocked', OC_SP_TEXTDOMAIN) ?>
                            </li>
                            <li><span class="sp-success"></span><span
                                        class="oc_other_count"><?php echo count($other) . '</span> ' . __('other spams blocked', OC_SP_TEXTDOMAIN) ?>
                            </li>
                        </ul>
                        <a href="<?php if ($this->is_premium) {
                            menu_page_url('onecom-wp-spam-logs');
                        } else { ?>javascript:void(0)<?php } ?>"
                           class="sp-log-link"><?php _e('View logs', OC_SP_TEXTDOMAIN) ?></a>
                    </div>
                </div>
            </div>


        </div>


        <?php
    }


    public function protection_settings_page()
    {
        include_once ONECOM_PLUGIN_PATH . 'inc/templates/oc-sp-protect-options.php';
    }

    public function blocked_lists_page()
    {

        include_once ONECOM_PLUGIN_PATH . 'inc/templates/oc-sp-blocked-lists.php';

    }

    public function spam_logs_page()
    {

        include_once ONECOM_PLUGIN_PATH . 'inc/templates/oc-sp-logs.php';

    }

    public function diagnostics_page()
    {

        include_once ONECOM_PLUGIN_PATH . 'inc/templates/oc-diagnostics.php';

    }
}
