<?php


namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class MontantGarantieValide extends Constraint
{
    public string $message = 'The value of the guarantee must be greater than or equal to the amount of the credit';

    public ?float $montantCredit;

    public function __construct($options = null)
    {
        parent::__construct($options);

        $this->montantCredit = $options['montantCredit'];
    }
}


