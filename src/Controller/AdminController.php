<?php

namespace App\Controller;

use App\Entity\SPA;
use App\Entity\User;
use App\Form\SPACreateForm;
use App\Form\StaffUserCreateForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/dashboard", name="admin_dashboard")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/spa_list/{page}", defaults={"page" : "1"}, name="admin_SPA_list")
     */
    public function spaLIst($page)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $paginatedSpas = $entityManager->getRepository(SPA::class)->findAllPaginated($page);

        return $this->render('admin/SPAlist.html.twig',
            [
                'pagination' => $paginatedSpas
            ]);
    }

    /**
     * @Route("/create", name="admin_create_SPA")
     */
    public function create(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $spa = new SPA('');
        $form = $this->createForm(SPACreateForm::class, $spa);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($spa);
            $entityManager->flush();
            return $this->redirectToRoute('admin_dashboard');
        }
        return $this->render('admin/createSPA.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/spa/{spa}", name="admin_edit_SPA")
     */
    public function edit(SPA $spa, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(SPACreateForm::class, $spa);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($spa);
            $entityManager->flush();
            return $this->redirectToRoute('admin_dashboard');
        }
        return $this->render('admin/editSPA.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/spa/{spa}", name="admin_delete_SPA", methods={"DELETE"})
     */
    public function deleteSPA(SPA $spa)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($spa);
        $entityManager->flush();
        return $this->redirectToRoute('admin_SPA_list');
    }

    /**
     * @Route("/spa/{spa}/addStaff", name="admin_add_staff")
     */
    public function addStaff(SPA $spa, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User('', '', '', '', ['ROLE_STAFF']);
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(StaffUserCreateForm::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setspa($spa);
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('admin_dashboard');
        }
        return $this->render('admin/addStaffUser.html.twig', [
            'form' => $form->createView(),
            'spa' => $spa
        ]);
    }

    /**
     * @Route("/spa/{spa}", defaults={"page" : "1"}, name="admin_spa_info")
     */
    public function spaInfo(SPA $spa, $page)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $paginatedUsers = $entityManager->getRepository(User::class)->findAllPaginated($page, $spa->getId());

        return $this->render('admin/SPAInfo.html.twig',
            [
                'pagination' => $paginatedUsers,
                'spa' => $spa
            ]);
    }

    /**
     * @Route("/delete/staff/{user}", name="admin_delete_staff", methods={"DELETE"})
     */
    public function deleteUser(User $user)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();
        $spa_id = $user->getSpa()->getId();
        return $this->redirectToRoute('admin_spa_info',
            [
                'spa' => $spa_id
            ]);
    }

    /**
     * @Route("/edit/staff/{user}", name="admin_edit_staff")
     */
    public function editStaff(User $user, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $spa = $user->getSpa();
        $spa_id = $spa->getId();

        $form = $this->createForm(StaffUserCreateForm::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            $entityManager->persist($user);
            $entityManager->flush();
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
