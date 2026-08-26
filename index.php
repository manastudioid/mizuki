<?php
date_default_timezone_set('Asia/Jakarta');

define('colors',array(
    'primary' => array('hex' => '#0d6efd'),
    'secondary' => array('hex' => '#6c757d'),
    'success' => array('hex' => '#198754'),
    'danger' => array('hex' => '#dc3545'),
    'warning' => array('hex' => '#ffc107'),
    'info' => array('hex' => '#0dcaf0'),
    'light' => array('hex' => '#f8f9fa'),
    'dark' => array('hex' => '#212529'),
));

define('scale',array(
    0 => array('rem' => '0'),
    1 => array('rem' => '0.25rem'),
    2 => array('rem' => '0.5rem'),
    3 => array('rem' => '1rem'),
    4 => array('rem' => '1.5rem'),
    5 => array('rem' => '3rem'),
));

define('breakpoint',array(
    'xs' => array('min-width' => null),
    'sm' => array('min-width' => '576px'),
    'md' => array('min-width' => '768px'),
    'lg' => array('min-width' => '992px'),
    'xl' => array('min-width' => '1200px'),
    'xxl' => array('min-width' => '1400px'),
));

$files = glob('modules/css/*');
$data = array();

foreach($files as $file)
{
    if(is_file($file))
    {
        $final_file = str_replace('modules/css/','',$file);
        $exp = explode('-',$final_file);
        
        if($final_file != 'index.php')
        {
            //echo $final_file.'<br>'; 
            ob_start();
            include $file;
            $data_get = ob_get_clean();
            //$data_get = preg_replace('!//.*$!m', '', $data_get);
            //$data_get = preg_replace('!/\*.*?\*/!s', '', $data_get);
            //$data_get = preg_replace('!/\*(?!\!).*?\*/!s', '', $data_get);
            $data_get = preg_replace('/\/\*(?!\!).*?\*\//s', '', $data_get);
            $data_get = preg_replace('/\s+/', ' ', $data_get);
            $data_get = preg_replace('/\s*([{}:;,>])\s*/', '$1', $data_get);
            
            $data[$exp[0]] = $data_get;   
        }     
    }
}



ksort($data);

//print_r($data);
file_put_contents('mizuki.min.css', $data);

echo 'Generated at '.date('r');