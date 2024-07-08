<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$hook['post_controller_constructor'] = array(
    'class'    => 'SessionChecker',
    'function' => 'checkSession',
    'filename' => 'SessionChecker.php',
    'filepath' => 'hooks',
);