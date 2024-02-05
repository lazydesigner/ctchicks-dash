
<?php   
$pro_cdn = 'https://localhost/dashboard.ctchicks.com/';
function isLocalhost() {
    // Define an array of common localhost hostnames or IP addresses
    $localhosts = array('localhost', '127.0.0.1');

    // Get the server's hostname
    $serverHostname = $_SERVER['SERVER_NAME'];

    // Check if the server's hostname is in the array of localhost values
    return in_array($serverHostname, $localhosts);
}

// Example of how to use the function
if (isLocalhost()) {
    function get_url(){

        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    
        $domain = $_SERVER['HTTP_HOST'];
    
        $subdirectory = dirname($_SERVER['PHP_SELF']);
        if($subdirectory){
            $baseUrl = $protocol . $domain. $subdirectory;

            $a = explode('/', $baseUrl);
            $url = $a[0].'/'.$a[1].'/'.$a[2].'/'.$a[3];
            // echo $url;
            // $baseUrl = $protocol . $domain . $subdirectory;
            return $url.'/';
        }else{
            $baseUrl = $protocol . $domain;
            
            $a = explode('/', $baseUrl);
            $url = $a[0].'/'.$a[1].'/'.$a[2].'/'.$a[3];
            // $baseUrl = $protocol . $domain . $subdirectory;
            return $url.'/';
        }
    
    }
} else {
    function get_url() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
    
        // Remove subdirectories from the base path
        $basePath = '/';
        $requestUri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $basePathPosition = strpos($requestUri, $basePath);
        if ($basePathPosition !== false) {
            $basePath = substr($requestUri, 0, $basePathPosition + strlen($basePath));
        }
    
        $url = $protocol . $host . $basePath;
    
        return $url;
    }
}


?>