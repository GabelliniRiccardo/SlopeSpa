<?php


namespace App\Service\DomainManager;


use App\Entity\SPA;
use App\Model\DTO\SPADTO;
use Doctrine\ORM\EntityManagerInterface;


class SpaManager
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param SPADTO $spaDTO
     * @return SPA
     */
    public function create(SPADTO $spaDTO): SPA
    {
        $name = $spaDTO->name;
        $email = $spaDTO->email;
        $address = $spaDTO->address;
        $phoneNumber = $spaDTO->phoneNumber;

        $spa = new SPA($name, $email);

        if (!!$address) {
            $spa->setAddress($address);
        }

        if (!!$phoneNumber) {
            $spa->setPhoneNumber($phoneNumber);
        }

        $this->entityManager->persist($spa);
        $this->entityManager->flush();

        return $spa;
    }

    /**
     * @param SPADTO $spaDTO
     * @return SPA
     */
    public function update(SPADTO $spaDTO): SPA
    {
        $id = $spaDTO->id;
        $name = $spaDTO->name;
        $email = $spaDTO->email;
        $address = $spaDTO->address;
        $phoneNumber = $spaDTO->phoneNumber;

        $spa = $this->entityManager->getRepository(SPA::class)->find($id);

        $spa->setName($name);
        $spa->setEmail($email);

        if (!!$address) {
            $spa->setAddress($address);
        }

        if (!!$phoneNumber) {
            $spa->setPhoneNumber($phoneNumber);
        }

        $this->entityManager->persist($spa);
        $this->entityManager->flush();

        return $spa;
    }

    /**
     * @param SPA $spa
     * @return void
     */
    public function delete(SPA $spa): void
    {
        $this->entityManager->remove($spa);
        $this->entityManager->flush();
    }
}
