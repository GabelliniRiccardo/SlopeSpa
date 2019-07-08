<?php


namespace App\Service\DomainManager;


use App\Entity\Room;
use App\Model\DTO\RoomDTO;
use Doctrine\ORM\EntityManagerInterface;

class RoomManager
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param RoomDTO $roomDTO
     * @return Room
     */
    public function create(RoomDTO $roomDTO): Room
    {
        $name = $roomDTO->name;
        $spa = $roomDTO->spa;
        $room = new Room($name, $spa);

        $this->entityManager->persist($room);
        $this->entityManager->flush();

        return $room;
    }

    /**
     * @param RoomDTO $roomDTO
     * @return Room
     */
    public function update(RoomDTO $roomDTO): Room
    {
        $id = $roomDTO->id;
        $name = $roomDTO->name;

        $room = $this->entityManager->getRepository(Room::class)->find($id);

        $room->setName($name);

        $this->entityManager->persist($room);
        $this->entityManager->flush();

        return $room;
    }

    /**
     * @param Room $room
     * @return void
     */
    public function delete(Room $room): void
    {
        $this->entityManager->remove($room);
        $this->entityManager->flush();
    }
}
