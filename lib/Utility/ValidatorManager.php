<?php

namespace Utility;

use Utility\Exception\ValidationException;
use Utility\Exception\ValidationExceptionSet;

/**
 * Class ValidatorManager
 */
final class ValidatorManager
{

    /**
     * @param ConstraintListSet $constraintListSet
     * @param array $input
     *
     * @throws ValidationExceptionSet
     */
    public function validateListSet(ConstraintListSet $constraintListSet, array $input)
    {
        $validationExceptionSet = new ValidationExceptionSet();

        foreach ($input as $key => $value) {
            $constraintList = $constraintListSet->get($key);

            try {
                $this->validateList($constraintList, $value);
            } catch (ValidationException $validationException) {
                $validationExceptionSet->addException($key, $validationException);
            }
        }

        if ($validationExceptionSet->hasExceptions() === true) {
            throw $validationExceptionSet;
        }
    }

    /**
     * @param ConstraintList $constraintList
     * @param mixed $value
     *
     * @throws ValidationException
     */
    public function validateList(ConstraintList $constraintList, $value)
    {
        foreach ($constraintList as $validator) {
            /** @var Validator $validator */

            $validator->validate($value);
        }
    }
}
