<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PaginationRule implements Rule
{
    /**
     * @var string
     */
    private $message = 'The page field is invalid';

    /**
     * @var array
     */
    private $allowedFields = ['number', 'size'];

    /**
     * @param array $allowedFields
     */
    public function __construct(array $allowedFields = [])
    {
        if ($allowedFields) {
            $this->allowedFields = $allowedFields;
        }
    }

    /**
     * @inheritDoc
     */
    public function passes($attribute, $value): bool
    {
        $pages = array_keys($value);

        foreach ($pages as $page) {
            if (!\in_array($page, $this->allowedFields, true)) {
                $this->message = "The '{$page}' field is not allowed";

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