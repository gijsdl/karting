<?php

namespace App\Controller;

use App\Entity\Activiteiten;
use App\Entity\AppUsers;
use App\Form\ActiviteitSoortType;
use App\Form\ActiviteitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class MedewerkerController
 * @package App\Controller
 * @IsGranted("ROLE_ADMIN")
 */
class MedewerkerController extends AbstractController
{
    /**
     * @Route("/admin/activiteiten", name="activiteitenoverzicht")
     */
    public function activiteitenOverzichtAction()
    {

        $activiteiten = $this->getDoctrine()
            ->getRepository(Activiteiten::class)
            ->findAll();

        return $this->render('medewerker/activiteiten.html.twig', [
            'activiteiten' => $activiteiten
        ]);
    }

    /**
     * @Route("/admin/details/{id}", name="details")
     */
    public function detailsAction($id)
    {
        $activiteiten = $this->getDoctrine()
            ->getRepository(Activiteiten::class)
            ->findAll();
        $activiteit = $this->getDoctrine()
            ->getRepository(Activiteiten::class)
            ->find($id);

        $deelnemers = $this->getDoctrine()
            ->getRepository(AppUsers::class)
            ->getDeelnemers($id);


        return $this->render('medewerker/details.html.twig', [
            'activiteit' => $activiteit,
            'deelnemers' => $deelnemers,
            'aantal' => count($activiteiten)
        ]);
    }

    /**
     * @Route("/admin/beheer", name="beheer")
     */
    public function beheerAction()
    {
        $activiteiten = $this->getDoctrine()
            ->getRepository(Activiteiten::class)
            ->findAll();

        return $this->render('medewerker/beheer.html.twig', [
            'activiteiten' => $activiteiten
        ]);
    }

    /**
     * @Route("/admin/add", name="add")
     */
    public function addAction(Request $request)
    {

        $form = $this->createForm(ActiviteitType::class);
        //$form->add('reset', ResetType::class, array('label'=>"reset"));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activiteit = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($activiteit);
            $em->flush();

            $this->addFlash(
                'notice',
                'activiteit toegevoegd!'
            );
            return $this->redirectToRoute('beheer');
        }
        $activiteiten = $this->getDoctrine()
            ->getRepository(Activiteiten::class)
            ->findAll();
        return $this->render('medewerker/add.html.twig', [
            'form' => $form->createView(),
            'naam' => 'toevoegen',
            'aantal' => count($activiteiten)]);
    }

    /**
     * @Route("/admin/update/{id}", name="update")
     */
    public function updateAction($id, Request $request)
    {
        $activiteit = $this->getDoctrine()
            ->getRepository(Activiteiten::class)
            ->find($id);

        $form = $this->createForm(ActiviteitType::class, $activiteit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $activiteit = $form->getData();
            $em = $this->getDoctrine()->getManager();

            // tells Doctrine you want to (eventually) save the contact (no queries yet)
            $em->persist($activiteit);


            // actually executes the queries (i.e. the INSERT query)
            $em->flush();
            $this->addFlash(
                'notice',
                'activiteit aangepast!'
            );
            return $this->redirectToRoute('beheer');
        }

        $activiteiten = $this->getDoctrine()
            ->getRepository(Activiteiten::class)
            ->findAll();

        return $this->render('medewerker/add.html.twig', [
            'form' => $form->createView(),
            'naam' => 'aanpassen',
            'aantal' => count($activiteiten)]);
    }

    /**
     * @Route("/admin/delete/{id}", name="delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $activiteit = $this->getDoctrine()
            ->getRepository(Activiteiten::class)->find($id);
        $em->remove($activiteit);
        $em->flush();

        $this->addFlash(
            'notice',
            'activiteit verwijderd!'
        );
        return $this->redirectToRoute('beheer');

    }

    /**
     * @Route("/admin/soort/add", name="add_soort")
     * @param Request $request
     * @return Response
     */
    public function addSoort(Request $request)
    {
        $form = $this->createForm(ActiviteitSoortType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $soortActiviteit = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($soortActiviteit);
            $em->flush();

            $this->addFlash(
                'notice',
                'activiteit toegevoegd!'
            );
            return $this->redirectToRoute('beheer');
        }
        $activiteiten = $this->getDoctrine()
            ->getRepository(Activiteiten::class)
            ->findAll();
        return $this->render('medewerker/add_soort.html.twig', [
            'form' => $form->createView(),
            'naam' => 'toevoegen',
            'aantal' => count($activiteiten)
            ]);
    }
}
