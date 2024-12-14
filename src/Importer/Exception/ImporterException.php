<?php

namespace App\Importer\Exception;

use Port\Exception;

class ImporterException extends \Exception implements Exception
{
    public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
