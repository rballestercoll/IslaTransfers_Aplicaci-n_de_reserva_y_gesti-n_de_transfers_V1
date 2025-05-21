<?php
function enviarConfirmacion($to, $asunto, $mensajeHtml)
{
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: Isla Transfers <no-reply@fp064.techlab.uoc.edu>\r\n";

    return mail($to, $asunto, $mensajeHtml, $headers);
}
