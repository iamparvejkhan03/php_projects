<?php
    if(isset($_GET['file'])){
        header("Content-Type: application/octet-stream"); 
  
        $file = $_GET["file"]  . ".pdf"; 
        
        header("Content-Disposition: attachment; filename=" . urlencode($file));    
        header("Content-Type: application/download"); 
        header("Content-Description: File Transfer");             
        header("Content-Length: " . filesize($file)); 
        
        flush(); // This doesn't really matter. 
        
        $fp = fopen($file, "r"); 
        while (!feof($fp)) { 
            echo fread($fp, 65536); 
            flush(); // This is essential for large downloads 
        }  
        
        fclose($fp); 
    }

    $image = "upload/unnamed.png";

    header("Content-Type: image/jpeg");  
    header("Cache-Control: no-store, no-cache");  
    header('Content-Disposition: attachment; filename="unnamed.png"');

    // Read and output the binary content of the image
    readfile($image);

?>