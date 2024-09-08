<?php

namespace NormanHuth\HelloFreshScraper\Exceptions;

use OutOfBoundsException;

class MissingAttributeException extends OutOfBoundsException
{
    /**
     * Create a new missing attribute exception instance.
     *
     * @note Based on Laravel's MissingAttributeException by Taylor Otwell
     *
     * @param  \NormanHuth\HelloFreshScraper\Models\AbstractModel  $model
     * @param  string  $key
     * @return void
     */
    public function __construct($model, $key)
    {
        parent::__construct(sprintf(
            'The attribute [%s] either does not exist or was not retrieved for model [%s].',
            $key,
            get_class($model)
        ));
    }
}
