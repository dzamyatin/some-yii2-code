<?php
declare(strict_types=1);

namespace App\Shared\Common\Ui\Response;

use Exception;
use JsonSerializable;
use Throwable;

class AbstractResponseException extends Exception implements JsonSerializable
{
    private int $httpCode;

    public function __construct(
        string $message,
        int $httpCode,
        ?Throwable $previous
    ) {
        $this->httpCode = $httpCode;

        parent::__construct($message, 0, $previous);
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function jsonSerialize(): array
    {
        return [
            'message' => $this->getMessage()
        ];
    }
}
