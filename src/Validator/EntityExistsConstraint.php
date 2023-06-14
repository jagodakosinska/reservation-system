<?php

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute]
class EntityExistsConstraint extends Constraint
{
    public function getTargets(): string|array
    {
        return self::PROPERTY_CONSTRAINT;
    }
}