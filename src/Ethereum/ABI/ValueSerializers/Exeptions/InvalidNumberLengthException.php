<?php

namespace Enjin\BlockchainTools\Ethereum\ABI\ValueSerializers\Exceptions;

use Exception;
use Throwable;

class InvalidNumberLengthException extends Exception
{
    public function __construct(
        $numberType,
        $type,
        $code = 0,
        Throwable $previous = null
    ) {
        $message = 'invalid ' . $numberType . ' length in type: ' . $type;

        parent::__construct($message, $code, $previous);
    }
}
