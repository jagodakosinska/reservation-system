<?php

namespace App\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;

class EntityExistsConstraintValidator extends \Symfony\Component\Validator\ConstraintValidator
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    /**
     * @inheritDoc
     */
    public function validate(mixed $value, Constraint $constraint)
    {
        $class = is_array($constraint->payload) ? $constraint->payload[0] : $constraint->payload;
        $field = is_array($constraint->payload) ? $constraint->payload[1] : 'id';

        $object = $this->em->getRepository($class)->findBy([$field => $value]);

        if(!$object){
            $this->context->buildViolation('Object %value% could not be found')
                ->setParameter('%value%', $value)
                ->addViolation();
        }

    }
}