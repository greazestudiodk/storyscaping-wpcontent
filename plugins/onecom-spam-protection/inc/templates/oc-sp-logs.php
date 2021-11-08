<div class="one-sp-wrap wrap" id="onecom-sp-ui">
    <?php echo  OnecomSp::sp_admin_head(__('Spam Logs',OC_SP_TEXTDOMAIN),__('Spam log lists all the submissions/attempts that were identified as spam and were blocked.<br/> Please note that the spam log entries older than 30 days get deleted automatically.',OC_SP_TEXTDOMAIN)) ;
    $spam=oc_get_sp_options('onecom_sp_spam_logs');

    $nonce= '';
    if (array_key_exists('one_sp_nonce', $_POST)) {
        $nonce = $_POST['one_sp_nonce'];
    }


    if (!empty($nonce) && wp_verify_nonce($nonce, 'one_sp_nonce')) {

        $additional_info = array(
            'additional_info' => json_encode(array(
                'logs_cleared_by' => 'manually_cleared',
                'blocked_spams' => $spam['spam_count'] ?? '',

            ))
        );


        (class_exists('OCPushStats') ? \OCPushStats::push_stats_performance_cache('delete', 'setting','logs', ONECOM_SP_PLUGIN_SLUG,$additional_info) : '');

        $spam['records']=array();
        $spam['spam_count'] = 0;

        oc_save_sp_options($spam,'onecom_sp_spam_logs');
        $success_notice = '<div class="notice notice-success is-dismissible"><p>'.__('Spam Logs cleared!',OC_SP_TEXTDOMAIN).'</p></div>';
    }
    $oc_nonce = wp_create_nonce('one_sp_nonce');
    if (!empty($success_notice)) {
        echo "$success_notice";
    }?>
    <div class="one-sp-logs">
    <?php
    if(!isset($spam['records']) || empty($spam['records'])){
        echo "<p>".__('No logs found!',OC_SP_TEXTDOMAIN)."</p></div></div>";
        return false;
    }else{
        $spam_logs = $spam['records'];
    }
    ?>
    <form method="post">
        <input type="hidden" name="one_sp_nonce" value="<?php echo $oc_nonce; ?>"/>

        <p><input type="submit" class="oc-save" name="oc-clear-logs" value="Clear Logs"></p>
    </form>
    <div class="oc_logs">
    <table name="one-sp-log" id="ocSpLog" style="width:100%;" aria-describedby="Spam protection table">
        <thead>
        <tr>
            <th scope="col">
<?php _e('Date & Time',OC_SP_TEXTDOMAIN) ?>
            </th>
            <th scope="col" ><?php _e('IP',OC_SP_TEXTDOMAIN) ?></th>
            <th scope="col" ><?php _e('Email',OC_SP_TEXTDOMAIN) ?></th>
            <th scope="col" ><?php _e('Username',OC_SP_TEXTDOMAIN)?></th>
            <th scope="col" >URL</th>
            <th scope="col" ><?php _e('Reason',OC_SP_TEXTDOMAIN) ?>
            </th>
        </tr>
        </thead><?php


        krsort($spam_logs);
        foreach ($spam_logs as $key => $log) {
            $ip=$log[0];
            $email=$log[1];
            $user_name=$log[2];
            $url=$log[3];
            $detection=$log[4];



        echo "<tr>
            <td>$key</td>
            <td>$ip</td>
            <td>$email</td>
            <td>$user_name</td>
            <td>$url</td>
            <td>$detection</td>
        </tr>";
        }?>
        <tbody>
        </tbody>
    </table>
    </div>
    </div>
</div>