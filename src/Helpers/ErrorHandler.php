<?php

namespace Inventory\Helpers;

class ErrorHandler
{
    public static function handleException($exception)
    {
        error_log($exception->getMessage());
        http_response_code(500);
        echo "Ein Fehler ist aufgetreten. Bitte versuchen Sie es später erneut.";
    }
}