<?php


namespace App\Command\Admin;


use App\Entity\SPA;
use App\Model\DTO\SPADTO;
use Symfony\Component\Validator\Constraints as Assert;

class EditSPA
{
    /**
     * @var SPADTO
     * @Assert\Valid
     */
    public $spaDTO;

    public function __construct(SPA $spa)
    {
        $this->spaDTO = new SPADTO();
        $this->assignDATAToSpaDTO($spa);
    }

    private function assignDATAToSpaDTO(SPA $spa): void
    {
        $id = $spa->getId();
        $name = $spa->getName();
        $email = $spa->getEmail();
        $address = $spa->getAddress();
        $phoneNumber = $spa->getPhoneNumber();

        $this->spaDTO->id = $id;
        $this->spaDTO->name = $name;
        $this->spaDTO->email = $email;
        $this->spaDTO->address = $address;
        $this->spaDTO->phoneNumber = $phoneNumber;
    }
}
