<?php
declare(strict_types=1);

namespace App\Shared\Common\Ui\Response;

class ForbiddenResponseException extends AbstractResponseException
{
    public function __construct(string $message = '403 Forbidden', $previous = null) {
        parent::__construct($message, 403, $previous);
    }
}
