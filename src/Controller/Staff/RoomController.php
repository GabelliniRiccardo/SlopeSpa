<?php

namespace App\Controller\Staff;

use App\Command\Staff\Room\CreateRoom;
use App\Command\Staff\Room\DeleteRoom;
use App\Command\Staff\Room\EditRoom;
use App\Entity\Room;
use App\Entity\SPA;
use App\Form\CreateRoomForm;
use App\Form\DeleteRoomForm;
use App\Form\EditRoomForm;
use Doctrine\ORM\EntityManagerInterface;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/staff/room")
 * @IsGranted("ROLE_STAFF")
 */
class RoomController extends AbstractController
{
    private $commandBus;
    private $entityManager;

    public function __construct(CommandBus $commandBus, EntityManagerInterface $entityManager)
    {
        $this->commandBus = $commandBus;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/list/{page}", defaults={"page" : "1"}, name="staff_room_list", methods={"GET"})
     */
    public function operatorList($page)
    {
        $user = $this->getUser();
        $spa_id = $user->getSpa()->getId();

        $paginatedRooms = $this->entityManager->getRepository(Room::class)->findAllPaginated($page, $spa_id);

        return $this->render('staff/room/roomList.html.twig',
            [
                'pagination' => $paginatedRooms,
            ]);
    }

    /**
     * @Route("/create", name="staff_create_room",  methods={"GET","POST"})
     */
    public function create(Request $request)
    {
        $user = $this->getUser();
        $spa_id = $user->getSpa()->getId();

        $spa = $this->entityManager->getRepository(SPA::class)->find($spa_id);

        $createRoom = new CreateRoom($spa);
        $form = $this->createForm(CreateRoomForm::class, $createRoom);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($createRoom);
            return $this->redirectToRoute('staff_dashboard');
        }

        return $this->render('staff/room/createRoom.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{room}", name="staff_edit_room", methods={"GET","POST"})
     */
    public function edit(Room $room, Request $request)
    {
        $editRoom = new EditRoom($room);

        $form = $this->createForm(EditRoomForm::class, $editRoom);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($editRoom);
            return $this->redirectToRoute('staff_dashboard');
        }
        return $this->render('staff/room/editRoom.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{room}", name="staff_delete_room", methods={"GET","DELETE"})
     */
    public function deleteSPA(Room $room, Request $request)
    {
        $deleteRoomForm = $this->createForm(DeleteRoomForm::class, $room,
            [
                'action' => $this->generateUrl('staff_delete_room', ['room' => $room->getId()])
            ]);
        $deleteRoomForm->handleRequest($request);

        if ($deleteRoomForm->isSubmitted() && $deleteRoomForm->isValid()) {
            $deleteSPA = new DeleteRoom($room);
            $this->commandBus->handle($deleteSPA);
            return $this->redirectToRoute('staff_dashboard');
        }

        return $this->render('modal/RoomDeleteConfirmationModal.html.twig', [
            'deleteRoomForm' => $deleteRoomForm->createView(),
            'room' => $room
        ]);
    }
}
