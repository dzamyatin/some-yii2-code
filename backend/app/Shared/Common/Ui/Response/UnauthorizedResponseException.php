<?php
declare(strict_types=1);

namespace App\Shared\Common\Ui\Response;

class UnauthorizedResponseException extends AbstractResponseException
{
    public function __construct(string $message = '401 Unauthorized', $previous = null) {
        parent::__construct($message, 401, $previous);
    }
}
