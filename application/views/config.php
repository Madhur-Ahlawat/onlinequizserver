<!DOCTYPE html>
<html>
<head>
    <title>Quiz - Server Requirements</title>
    <style>
        body {
            padding-top: 18px;
            font-family: sans-serif;
            background: #f9fafb;
            font-size: 14px;
        }

        #container {
            width: 600px;
            margin: 0 auto;
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            border: 2px solid #f0f0f0;
            -webkit-box-shadow: 0px 1px 15px 1px rgba(90, 90, 90, 0.08);
            box-shadow: 0px 1px 15px 1px rgba(90, 90, 90, 0.08);
        }

        a {
            text-decoration: none;
            color: red;
        }

        h1 {
            text-align: center;
            color: #424242;
            border-bottom: 1px solid #e4e4e4;
            padding-bottom: 25px;
            font-size: 22px;
            font-weight: normal;
        }

        table {
            width: 100%;
            padding: 10px;
            border-radius: 3px;
        }

        table thead th {
            text-align: left;
            padding: 5px 0px 5px 0px;
        }

        table tbody td {
            padding: 5px 0px;
        }

        table tbody td:last-child, table thead th:last-child {
            text-align: right;
        }

        .label {
            padding: 3px 10px;
            border-radius: 4px;
            color: #fff;

        }

        .label.label-success {
            background: #4ac700;
        }

        .label.label-warning {
            background: #dc2020;
        }


        .logo {
            margin-bottom: 30px;
            margin-top: 20px;
            display: block;
        }

        .logo img {
            margin: 0 auto;
            display: block;
            border-radius: 50%;
        }

        .scene {
            width: 100%;
            height: 100%;
            perspective: 600px;
            display: -webkit-box;
            display: -moz-box;
            display: -ms-flexbox;
            display: -webkit-flex;
            display: flex;
            align-items: center;
            justify-content: center;

        svg {
            width: 240px;
            height: 240px;
        }

        }

        @keyframes arrow-spin {
            50% {
                transform: rotateY(360deg);
            }
        }
    </style>
</head>
<body>
<?php


$memory_limit = ini_get('memory_limit');
if (preg_match('/^(d+)(.)$/', $memory_limit, $matches)) {
    if ($matches[2] == 'M') {
        $memory_limit = $matches[1] * 1024 * 1024; // nnnM -> nnn MB
    } else if ($matches[2] == 'K') {
        $memory_limit = $matches[1] * 1024; // nnnK -> nnn KB
    }
}



$res = preg_replace("/[^0-9]/", "", $memory_limit );


$error = false;


    $filePresent = null;
   

    if ($is_database_connect == 1){
        $database_connection = "<span class='label label-success'>Success</span>";
    }
    else{
        $database_connection = "<span class='label label-warning'>Failed</span>";
    }
?>
</p>
<?php

$PHP_VERSION = PHP_VERSION;
if ($PHP_VERSION >= 7.2 && $PHP_VERSION < 7.3 ) {
    $requirement1 = "<span class='label label-success'>v." . PHP_VERSION . '</span>';
} else {
    $error = true;
    $requirement1 = "<span class='label label-warning'>Your PHP version is " . $PHP_VERSION . '</span>';
}


if (!extension_loaded('curl')) {
    $error = true;
    $requirement4 = "<span class='label label-warning'>Not enabled</span>";
} else {
    $requirement4 = "<span class='label label-success'>Enabled</span>";
}

if (!extension_loaded('openssl')) {
    $error = true;
    $requirement5 = "<span class='label label-warning'>Not enabled</span>";
} else {
    $requirement5 = "<span class='label label-success'>Enabled</span>";
}

if (!extension_loaded('mbstring')) {
    $error = true;
    $requirement6 = "<span class='label label-warning'>Not enabled</span>";
} else {
    $requirement6 = "<span class='label label-success'>Enabled</span>";
}

if (!extension_loaded('ctype') && !function_exists('ctype')) {
    $error = true;
    $requirement7 = "<span class='label label-warning'>Not enabled</span>";
} else {
    $requirement7 = "<span class='label label-success'>Enabled</span>";
}


if (!extension_loaded('gd')) {
    $error = true;
    $requirement9 = "<span class='label label-warning'>Not enabled</span>";
} else {
    $requirement9 = "<span class='label label-success'>Enabled</span>";
}

if (!extension_loaded('zip')) {
    $error = true;
    $requirement10 = "<span class='label label-warning'>Zip Extension is not enabled</span>";
} else {
    $requirement10 = "<span class='label label-success'>Enabled</span>";
}

$url_f_open = ini_get('allow_url_fopen');
if ($url_f_open != "1" && $url_f_open != 'On') {
    $error = true;
    $requirement11 = "<span class='label label-warning'>Allow_url_fopen is not enabled!</span>";
} else {
    $requirement11 = "<span class='label label-success'>Enabled</span>";
}
$requirement12 = "<span class='label label-success'>  $memory_limit</span>";
$test_cmd = "ls";

$exec_test_output = array();
$shell_exec_test_output = "";

if(function_exists('exec')) {
    exec($test_cmd,$exec_test_output);
    if(count($exec_test_output)!=""){
        $exec = "<span class='label label-success'>Enabled</span>";
    }else{


        $exec = "<span class='label label-warning'>You have to enable exec from your server</span>";
    }

}else{

    $exec = "<span class='label label-warning'>You have to enable exec from your server.</span>";
}

if(function_exists('shell_exec')) {
    $shell_exec_test_output = shell_exec($test_cmd);

    if(strlen($shell_exec_test_output) > 2){
        $shell_exec = "<span class='label label-success'>Enabled</span>";
    }else{


        $shell_exec = "<span class='label label-warning'>You have to enable shell_exec from your server</span>";
    }

}else{

    $shell_exec = "<span class='label label-warning'>You have to enable shell_exec from your server.</span>";
}


if(function_exists('shell_exec')) {
    $ffmpeg = trim(shell_exec('ffmpeg -version'));

    $ffmpeg = explode(" ",$ffmpeg);

    if(count($ffmpeg) < 2){
        $ffmpeg = "<span class='label label-warning'>You have to enable shell_exec() from your server</span>";


    }else{

        $ffmpeg="<span class='label label-success'>".$ffmpeg[2]."</span>";
    }

}else{

    $ffmpeg = "<span class='label label-warning'>You have to enable shell_exec() from your server</span>";

}
$upload_max_size = ini_get('upload_max_filesize');
$size =  str_replace("M","","$upload_max_size");
if($size >= 100)
{
    $upload_max_filesize = "<span class='label label-success'>upload_max_filesize is Ok</span>";
}
else
{
    $upload_max_filesize = "<span class='label label-warning'>upload_max_filesize must a more then 100M</span>";
}


$upload_max_size = ini_get('post_max_size');
$size =  str_replace("M","","$upload_max_size");
if($size >= 100)
{
    $post_max_size = "<span class='label label-success'>post_max_size is Ok</span>";
}
else
{
    $post_max_size = "<span class='label label-warning'>post_max_size must a more then 100M</span>";
}


?>
<div id="container">
    <div class="logo">
        <a href="#">
           </a>
    </div>
    <h1>Server Requirements</h1>


    <table class="table table-hover" id="requirements">
        <thead>
        <tr>
            <th>Requirements</th>
            <th>Result</th>
        </tr>
        </thead>
        <tbody>
       
        <tr>
            <td>Database Connection</td>
            <td><?php echo $database_connection; ?></td>
        </tr>


        <tr>
            <td>PHP 7.2.0+</td>
            <td><?php echo $requirement1; ?></td>
        </tr>

       
        <tr>
            <td>cURL PHP Extension</td>
            <td><?php echo $requirement4; ?></td>
        </tr>
        <tr>
            <td>OpenSSL PHP Extension</td>
            <td><?php echo $requirement5; ?></td>
        </tr>
        <tr>
            <td>MBString PHP Extension</td>
            <td><?php echo $requirement6; ?></td>
        </tr>


        <tr>
            <td>GD PHP Extension</td>
            <td><?php echo $requirement9; ?></td>
        </tr>
        <tr>
            <td>Zip PHP Extension</td>
            <td><?php echo $requirement10; ?></td>
        </tr>
        <tr>
            <td>exec</td>
            <td><?php echo $exec; ?></td>
        </tr>

        <tr>
            <td>shell_exec</td>
            <td><?php echo $shell_exec; ?></td>
        </tr>

        <tr>
            <td>allow_url_fopen</td>
            <td><?php echo $requirement11; ?></td>
        </tr>

        <tr>
            <td>ffmpeg</td>
            <td><?php echo $ffmpeg; ?></td>
        </tr>


        <tr>
            <td>File Upload Max Size</td>
            <td><?php echo $upload_max_filesize; ?></td>
        </tr>


        <tr>
            <td>Post Max Size</td>
            <td><?php echo $post_max_size; ?></td>
        </tr>



        <tr>
            <td>Memory Limit</td>
            <td><?php echo $requirement12 ?></td>
        </tr>
        </tbody>

    </table>
    <br/>
   
    <div style="line-height: 24px;">
        <h1>Admin Portal Config</h1>

        <?php 

        $base_url = base_url().'admin';
        echo 'Admin URL "' . $base_url . '";<br>';
        echo 'Email : admin@gmail.com<br>';
        echo 'Password: 12345 <br>';
        ?>

        <br>
        <h1>Android App Config</h1>

      
        <?php 
         $base_url = base_url().'api';
       

        echo 'API URL = "' . $base_url . '";<br>';

        ?>

        <br>
        <h1>IOS App Config</h1>
    <?php
            $base_url = base_url().'api';
            echo 'API URL = "' . $base_url . '"<br>';
        ?>

</div>

</body>
</html>
