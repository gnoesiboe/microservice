<?php

namespace Application\Request;

use Utility\Exception\ValidationException;
use Utility\Exception\ValidationExceptionSet;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Utility\ConstraintListSet;
use Utility\ValidatorManager;

/**
 * Class Entity
 */
abstract class RequestEntity
{

    /**
     * @var array
     */
    protected $validatedAndNormalizedInput;

    /**
     * @param array $input
     */
    public function __construct(array $input)
    {
        $this->importInput($input);
    }

    /**
     * @param array $input
     *
     * @throws ValidationException
     */
    private function importInput(array $input)
    {
        $constraintListSet = $this->getContraintListSet();

        $this->validateThatIncomingInputContainsAllKeys($input, $constraintListSet);
        $this->validateThatIncomingInputContainsOnlySupportedKeys($input, $constraintListSet);

        $this->validateInput($input);

        $this->validatedAndNormalizedInput = $input;
    }

    /**
     * @param array $input
     *
     * @throws ValidationExceptionSet
     */
    private function validateInput(array $input)
    {
        (new ValidatorManager())
            ->validateListSet($this->getContraintListSet(), $input);
    }

    /**
     * @return ConstraintListSet
     */
    abstract protected function getContraintListSet();

    /**
     * @param array $input
     * @param ConstraintListSet $constraintListSet
     */
    private function validateThatIncomingInputContainsAllKeys(array $input, ConstraintListSet $constraintListSet)
    {
        $requiredKeys = $constraintListSet->getKeys();

        // find missing keys
        $missingRequiredKeys = array();
        foreach ($requiredKeys as $requiredKey) {
            if (array_key_exists($requiredKey, $input) === false) {
                $missingRequiredKeys[] = $requiredKey;
            }
        }

        if (count($missingRequiredKeys) > 0) {
            throw new BadRequestHttpException('The follow keys are missing: ' . implode(', ', $missingRequiredKeys));
        }
    }

    /**
     * @param array $input
     * @param ConstraintListSet $constraintListSet
     */
    private function validateThatIncomingInputContainsOnlySupportedKeys(array $input, ConstraintListSet $constraintListSet)
    {
        $supportedKeys = $constraintListSet->getKeys();

        $notSupportedKeys = array();
        foreach ($input as $inputKey => $inputValue) {
            if (in_array($inputKey, $supportedKeys) === false) {
                $notSupportedKeys[] = $inputKey;
            }
        }

        if (count($notSupportedKeys) > 0) {
            throw new BadRequestHttpException('The follow keys are not supported: ' . implode(', ', $notSupportedKeys));
        }
    }
}
