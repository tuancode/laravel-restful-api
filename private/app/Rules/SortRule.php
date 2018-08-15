<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SortRule implements Rule
{
    /**
     * @var string
     */
    private $message = 'The sort field is invalid';

    /**
     * @var array
     */
    private $allowedFields;

    /**
     * Sort constructor.
     *
     * @param $allowedFields
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
        $sorts = explode(',', $value);

        foreach ($sorts as $sortCol) {
            $sortCol = ltrim($sortCol, '-');

            if (!\in_array($sortCol, $this->allowedFields, true)) {
                $this->message = "The '{$sortCol}' field is not allowed";

                return false;
            }
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function message()
    {
        return $this->message;
    }
}