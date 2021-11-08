<div class="one-sp-wrap wrap" id="onecom-sp-ui">
    <?php echo OnecomSp::sp_admin_head(__('Spam Protection Diagnostics',OC_SP_TEXTDOMAIN), __('You can use this form to test if a value will be categorised as spam.</br>The input values of diagnostics form passes through different spam checks and</br> based on the result of these checks the final diagnosis report appears.',OC_SP_TEXTDOMAIN));

    $sp_options = oc_get_sp_options('onecom_sp_protect_options');

    $initiate_checks= new OnecomSp();
    $table = '';


    $nonce = '';
    if (array_key_exists('one_sp_nonce', $_POST)) {
        $nonce = $_POST['one_sp_nonce'];
    }


    if (!empty($nonce) && wp_verify_nonce($nonce, 'one_sp_nonce')) {

        $user_ip = isset($_POST['oc_validate_ip'])?$_POST['oc_validate_ip']:'';
        $user_name = isset($_POST['oc_validate_user'])?$_POST['oc_validate_user']:'';
        $user_email = isset($_POST['oc_validate_email'])?$_POST['oc_validate_email']:'';
        $user_agent = isset($_POST['oc_validate_user_agent'])?$_POST['oc_validate_user_agent']:'';
        $user_content = isset($_POST['oc_validate_content'])?$_POST['oc_validate_content']:'';

        if ( strlen( $user_email ) > 80 ) {
            $user_email = substr( $user_email, 0, 77 ) . '...';
        }
        if ( strlen( $user_name ) > 80 ) {
            $user_name = substr( $user_name, 0, 77 ) . '...';
        }

        $api_check = $initiate_checks->sp_api_check($user_ip,$user_email,$user_agent,$user_name);
        $api_check_result= array();


        if(isset($api_check["is_spam"]) && $api_check["is_spam"]){

            $api_check_result['status'] = $api_check["is_spam"];
            $api_check_result['reason'] = $api_check["reason"];

            $table= $initiate_checks->oc_generate_table('api-check',$api_check_result);
        }elseif(isset($api_check["is_spam"]) && !$api_check["is_spam"]){

            $web = new OnecomSpWebsiteCheck();
            $oc_post = array(
                'email' => $user_email,
                'author' => $user_name,
                'comment' => $user_content
            );

            $webiste_check = $web->oc_sp_diagnostics($user_ip,$oc_post);

            $table = $initiate_checks->oc_generate_table('website-check',$webiste_check);


        }


    }

    if(isset($_POST['oc-reset-settings'])){


        $sp_options = oc_get_sp_options('onecom_sp_protect_options');
        if(!empty($sp_options)){
            $default_options= oc_set_default_options();
            $default_options['oc_sp_quickres'] = 'true';

            foreach ($default_options as $key => $value){
                $sp_options['checks'][$key]= $value;

            }

        oc_save_sp_options($sp_options, 'onecom_sp_protect_options');
        }


        $success_notice = '<div class="notice notice-success is-dismissible"><p>'.__('Settings restored.',OC_SP_TEXTDOMAIN).'</p></div>';

    }


    $oc_nonce = wp_create_nonce('one_sp_nonce');

    if(!empty($success_notice)){
        echo $success_notice;
    }

    ?>

    <div class="one-sp-body">
        <div class="ocdg-form-section">
    <form class="sp-diagnostics" method="post">
        <input type="hidden" name="one_sp_nonce" value="<?php echo $oc_nonce; ?>"/>

       <div class="fieldset">

       <label for="ocvalidateip">
            <?php _e('IP',OC_SP_TEXTDOMAIN)?>:
            <input type="text" name="oc_validate_ip" id="ocvalidateip">

        </label>
       </div>

        <div class="fieldset">

        <label for="ocvalidateuser">
            <?php _e('Username',OC_SP_TEXTDOMAIN)?>:
            <input type="text" name="oc_validate_user" id="ocvalidateuser">

        </label>
        </div>

        <div class="fieldset">
        <label for="ocvalidateemail">
            <?php _e('Email',OC_SP_TEXTDOMAIN)?>:

            <input type="email" name="oc_validate_email" id="ocvalidateemail">

        </label>
        </div>

        <div class="fieldset">
        <label for="ocvalidateuseragent">
            <?php _e('User agent',OC_SP_TEXTDOMAIN)?>:

            <input type="text" name="oc_validate_user_agent" id="ocvalidateuseragent">

        </label>
        </div>

        <div class="fieldset">
        <label for="ocvalidatecontent">
            <?php _e('Comment content',OC_SP_TEXTDOMAIN)?>:

            <textarea name="oc_validate_content" rows="5" cols="40" id="ocvalidatecontent"></textarea>

        </label>
        </div>
<p>
        <input type="submit" name="check_spam" class="oc-save" value="<?php _e('Check Spam',OC_SP_TEXTDOMAIN);?>">
</p>
    </form></div><div class="ocdg-results">


    <?php

    if($table && $table!== '' ){

        echo $table;

    }

    ?>

        </div> </div></div>


