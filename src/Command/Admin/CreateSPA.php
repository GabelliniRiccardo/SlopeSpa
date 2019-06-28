<?php


namespace App\Command\Admin;


use App\Model\DTO\SPADTO;
use Symfony\Component\Validator\Constraints as Assert;

class CreateSPA
{
    /**
     * @var SPADTO
     * @Assert\Valid
     */
    public $spaDTO;

    public function __construct()
    {
        $this->spaDTO = new SPADTO();
    }
}
