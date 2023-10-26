<?php
declare(strict_types=1);

namespace App\Shared\Common\Ui\Response;

class NotFoundResponseException extends AbstractResponseException
{
    public function __construct(string $message = '404 Not Found', $previous = null) {
        parent::__construct($message, 404, $previous);
    }
}
