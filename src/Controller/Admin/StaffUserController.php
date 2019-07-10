<?php

namespace App\Controller\Admin;

use App\Command\Admin\CreateUser;
use App\Command\Admin\DeleteUser;
use App\Command\Admin\EditUser;
use App\Entity\SPA;
use App\Entity\User;
use App\Form\CreateUserForm;
use App\Form\DeleteUserForm;
use App\Form\EditUserForm;
use Doctrine\ORM\EntityManagerInterface;
use SimpleBus\SymfonyBridge\Bus\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/staff")
 * @IsGranted("ROLE_ADMIN")
 */
class StaffUserController extends AbstractController
{
    private $commandBus;
    private $entityManager;

    public function __construct(CommandBus $commandBus, EntityManagerInterface $entityManager)
    {
        $this->commandBus = $commandBus;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("addStaff/spa/{spa}", name="admin_add_staff", methods={"GET","POST"})
     */
    public function addStaff(SPA $spa, Request $request)
    {
        $createUser = new CreateUser($spa);
        $form = $this->createForm(CreateUserForm::class, $createUser);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($createUser);
            return $this->redirectToRoute('admin_dashboard');
        }
        return $this->render('admin/addStaffUser.html.twig', [
            'form' => $form->createView(),
            'spa' => $spa
        ]);
    }

    /**
     * @Route("/delete/{user}", name="admin_delete_staff", methods={"GET","DELETE"})
     */
    public function deleteUser(User $user, Request $request)
    {
        $deleteUserForm = $this->createForm(DeleteUserForm::class, $user,
            [
                'action' => $this->generateUrl('admin_delete_staff', ['user' => $user->getId()])
            ]);

        $deleteUserForm->handleRequest($request);

        if ($deleteUserForm->isSubmitted() && $deleteUserForm->isValid()) {
            $deleteUser = new DeleteUser($user);
            $this->commandBus->handle($deleteUser);
            $spa_id = $user->getSpa()->getId();
            return $this->redirectToRoute('admin_spa_info',
                [
                    'spa' => $spa_id
                ]);
        }

        return $this->render('modal/UserDeleteConfirmationModal.html.twig', [
            'deleteUserForm' => $deleteUserForm->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/edit/{user}", name="admin_edit_staff", methods={"GET","POST"})
     */
    public function editUser(User $user, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $spa = $user->getSpa();
        if (!$spa) {
            throw new AccessDeniedException('Could not change Admin user ' . $user->getName() . ' ' . $user->getLastName());
        }

        $editUser = new EditUser($user);
        $form = $this->createForm(EditUserForm::class, $editUser);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($editUser);
            return $this->redirectToRoute('admin_spa_info',
                [
                    'spa' => $spa->getId()
                ]);
        }
        return $this->render('admin/editStaffUser.html.twig', [
            'form' => $form->createView(),
            'spa' => $spa
        ]);
    }
}
