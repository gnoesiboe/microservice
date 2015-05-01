<?php

namespace Application\Request\Entity;

use Application\Request\RequestEntity;
use Domain\Request\Entity\ConsumerRequestEntityInterface;
use Utility\ConstraintList;
use Utility\ConstraintListSet;
use Utility\Validator\MinStringLengthValidator;
use Utility\Validator\StringValidator;

/**
 * Class Consumer
 */
final class ConsumerRequestEntity extends RequestEntity implements ConsumerRequestEntityInterface
{

    /**
     * @return ConstraintListSet
     */
    protected function getContraintListSet()
    {
        return new ConstraintListSet(array(
            'username' => new ConstraintList(array(
                new StringValidator(),
                new MinStringLengthValidator(array(MinStringLengthValidator::OPTION_MIN_LENGTH => 4)),
            )),
            'password' => new ConstraintList(array(
                new StringValidator(),
                new MinStringLengthValidator(array(MinStringLengthValidator::OPTION_MIN_LENGTH => 4)),
            )),
        ));
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->validatedAndNormalizedInput['username'];
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->validatedAndNormalizedInput['password'];
    }
}
