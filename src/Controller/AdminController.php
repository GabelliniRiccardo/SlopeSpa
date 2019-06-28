<?php

namespace App\Controller;

use App\Command\Admin\CreateSPA;
use App\Command\Admin\CreateUser;
use App\Command\Admin\DeleteSPA;
use App\Command\Admin\DeleteUser;
use App\Command\Admin\EditSPA;
use App\Command\Admin\EditUser;
use App\Entity\SPA;
use App\Entity\User;
use App\Form\CreateSPAForm;
use App\Form\DeleteSPAForm;
use App\Form\DeleteUserForm;
use App\Form\EditSPAForm;
use App\Form\CreateUserForm;
use App\Form\EditUserForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use SimpleBus\SymfonyBridge\Bus\CommandBus;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    private $commandBus;
    private $entityManager;

    public function __construct(CommandBus $commandBus, EntityManagerInterface $entityManager)
    {
        $this->commandBus = $commandBus;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/dashboard", name="admin_dashboard", methods={"GET"})
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/spa/list/{page}", defaults={"page" : "1"}, name="admin_SPA_list", methods={"GET"})
     */
    public function spaLIst($page)
    {

        $paginatedSpas = $this->entityManager->getRepository(SPA::class)->findAllPaginated($page);
        return $this->render('admin/SPAlist.html.twig',
            [
                'pagination' => $paginatedSpas
            ]);
    }

    /**
     * @Route("/spa/{spa}/staff", defaults={"page" : "1"}, name="admin_spa_info", methods={"GET"})
     */
    public function spaInfo(SPA $spa, $page)
    {
        $paginatedUsers = $this->entityManager->getRepository(User::class)->findAllPaginated($page, $spa->getId());

        return $this->render('admin/SPAInfo.html.twig',
            [
                'pagination' => $paginatedUsers,
                'spa' => $spa
            ]);
    }

    /**
     * @Route("/spa/create", name="admin_create_SPA",  methods={"GET","POST"})
     */
    public function create(Request $request)
    {
        $createSPA = new CreateSPA();
        $form = $this->createForm(CreateSPAForm::class, $createSPA);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($createSPA);
            return $this->redirectToRoute('admin_dashboard');
        }
        return $this->render('admin/createSPA.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/spa/edit/{spa}", name="admin_edit_SPA", methods={"GET","POST"})
     */
    public function edit(SPA $spa, Request $request)
    {
        $editSPA = new EditSPA($spa);

        $form = $this->createForm(EditSPAForm::class, $editSPA);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($editSPA);
            return $this->redirectToRoute('admin_dashboard');
        }
        return $this->render('admin/editSPA.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/spa/delete/{spa}", name="admin_delete_SPA", methods={"GET","DELETE"})
     */
    public function deleteSPA(SPA $spa, Request $request)
    {
        $deleteSPAForm = $this->createForm(DeleteSPAForm::class, $spa,
            [
                'action' => $this->generateUrl('admin_delete_SPA', ['spa' => $spa->getId()])
            ]);
        $deleteSPAForm->handleRequest($request);

        if ($deleteSPAForm->isSubmitted() && $deleteSPAForm->isValid()) {
            $deleteSPA = new DeleteSPA($spa);
            $this->commandBus->handle($deleteSPA);
            return $this->redirectToRoute('admin_SPA_list');
        }

        return $this->render('modal/SpaDeleteConfirmationModal.html.twig', [
            'deleteSPAForm' => $deleteSPAForm->createView(),
            'spa' => $spa
        ]);
    }

    /**
     * @Route("/spa/{spa}/addStaff", name="admin_add_staff", methods={"GET","POST"})
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
     * @Route("/staff/delete/{user}", name="admin_delete_staff", methods={"GET","DELETE"})
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
     * @Route("/staff/edit/{user}", name="admin_edit_staff", methods={"GET","POST"})
     */
    public function editUser(User $user, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $spa = $user->getSpa();
        $spa_id = $spa->getId();

        $editUser = new EditUser($user);
        $form = $this->createForm(EditUserForm::class, $editUser);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle($editUser);
            return $this->redirectToRoute('admin_spa_info',
                [
                    'spa' => $spa_id
                ]);
        }
        return $this->render('admin/editStaffUser.html.twig', [
            'form' => $form->createView(),
            'spa' => $spa
        ]);
    }
}
