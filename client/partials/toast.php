<?php

function toast(string $message, string $type){
    echo '<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>';
    echo '<script>Toastify({
        text: ' . "'$message'" . ',
        offset: {
            x: 8,
            y: 50 
          },
        duration: 3000,
        close: true,
        stopOnFocus: true,
        className: "rounded shadow",
        style: {
            background: "';
    
    switch($type){
        case 'ok': echo '#27A544'; break;
        case 'error': echo '#DE3343'; break;
        default : echo '#0079F8';
    }
        echo '",}
    ,}).showToast();
          </script>' ;
    }

?>