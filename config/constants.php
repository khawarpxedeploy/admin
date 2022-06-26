<?php

if (!app()->runningInConsole()) {

    $server_name = request()->getSchemeAndHttpHost();
    define("BASE_URL", $server_name);
    define("ADMIN_BASE_URL", $server_name.'/admin');

    //Default Images
    define("NO_IMAGE", 'https://www.carsfrombanks.com/frontend/assets/images/placeholder/inventory-full-placeholder.png');

} else {
    $server_name = gethostname();
}






