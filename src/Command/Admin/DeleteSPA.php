<?php


namespace App\Command\Admin;


use App\Entity\SPA;

class DeleteSPA
{
    /**
     * @var SPA
     * @Assert\Valid
     */
    public $spa;

    public function __construct(SPA $spa)
    {
        $this->spa = $spa;
    }
}
