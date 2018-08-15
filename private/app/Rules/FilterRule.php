<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FilterRule implements Rule
{
    /**
     * @var string
     */
    private $message = 'The filter field is invalid';

    /**
     * @var array
     */
    private $allowedFields;

    /**
     * Filter constructor.
     *
     * @param array $allowedFields
     */
    public function __construct(array $allowedFields = [])
    {
        $this->allowedFields = $allowedFields;
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value): bool
    {
        $filters = array_keys($value);

        foreach ($filters as $filter) {
            if (!\in_array($filter, $this->allowedFields, true)) {
                $this->message = "The '{$filter}' field is not allowed";

                return false;
            }
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function message(): string
    {
        return $this->message;
    }
}