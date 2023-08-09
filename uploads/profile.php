<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    set_error_handler(function ($err_severity, $err_msg, $err_file, $err_line, $err_context = null)
    {
        throw new ErrorException('<b>Error</b>'.$err_msg, 0, $err_severity, $err_file, $err_line );
    }, E_WARNING);

    try {
        echo var_export(json_decode(file_get_contents("php://input")), true);
    } catch (ErrorException $e) {
        echo $e->getMessage();
    }
} else {
    echo "SERVER ERROR";
}