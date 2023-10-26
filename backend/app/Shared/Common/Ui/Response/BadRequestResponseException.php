<?php
declare(strict_types=1);

namespace App\Shared\Common\Ui\Response;

class BadRequestResponseException extends AbstractResponseException
{
    public function __construct(string $message = '400 Bad Request', $previous = null) {
        parent::__construct($message, 400, $previous);
    }
}
