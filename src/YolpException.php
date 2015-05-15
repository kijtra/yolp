<?php

namespace Kijtra;

/**
 * This class represents a generic error.
 */
class YolpException extends \Exception
{
    public function __construct($message, $code = 0)
    {
        parent::__construct('YOLP Error: '.$message);
    }
}
