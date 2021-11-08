<?php
/**
* Plugin Name: Mit Plugin
* Plugin URI: https://www.storyscraping.dbadesigns.dk/
* Description: This is the very first plugin I ever created.
* Version: 1.0
* Author: Your Name Here
* Author URI: https://www.storyscraping.dbadesigns.dk/
**/

box();

echo "
    <style>
        #popup{
            display: none;
            z-index: 1000;
            padding: 20px 30px;
            width: 540px;
            height: 260px;
            position: fixed;
            bottom: 0;
            right: 0;
            background: url(https://pragueskydiving.com/media/CACHE/images/images/71171d04c87fc522aca407614bc442c7/2dd3842dab7a5dba75b01488e798099c.jpg);
            background-size: cover;
        }
        
        .myInput{
            padding: 2px 3px!important;
            font-size: 14px;
        }
        
        .mySubmit{
            background: #706fd3!important;
            color: white!important;
            border: none!important;
        }.mySubmit:hover{
            background: #474787!important;
            color: white!important;
            border: none!important;
        }

        #dismiss{
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            text-decoration: none;
            font-size: 24px;
            font-family: Arial;
            transform:rotate(45deg);
        }

        #dismiss:hover{
            -webkit-animation:spin 2s linear infinite;
            -moz-animation:spin 2s linear infinite;
            animation:spin 2s linear infinite;
        }

        @keyframes spin { 
            100% { 
                -webkit-transform: rotate(360deg);
                transform:rotate(360deg); 
            } 
        }
    </style>

    

    <script>
        var box = document.getElementById('popup');
        setTimeout(function () {
            box.style.display = 'block';
        }, 2000);

        function dismiss(){
            var box = document.getElementById('popup');
            box.style.display = 'none';
        }
    </script>
";

function box(){
    echo "
    <div id='popup'>
        <form method='POST'>
            <h4 style='color: white'>Tilmeld dig til vores nyhedsbrev!</h4>
            <br/ >
            <input class='myInput' name='email' type='email' placeholder='Enter your e-mail here' />
            <br/ ><br/ >
            <input class='mySubmit' name='submit' type='submit' value='Tilmeld!' />
        </form>
        <a id='dismiss' href='#' onclick='dismiss()'>+</a>
    </div>
    ";
}