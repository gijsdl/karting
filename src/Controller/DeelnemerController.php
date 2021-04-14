<?php

namespace App\Controller;

use App\Entity\Activiteiten;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * Class DeelnemerController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class DeelnemerController extends AbstractController
{
    /**
     * @Route("/user/activiteiten", name="activiteiten")
     */
    public function activiteitenAction()
    {
        $usr = $this->getUser();

        $beschikbareActiviteiten = $this->getDoctrine()
            ->getRepository(Activiteiten::class)
            ->getBeschikbareActiviteiten($usr->getId());

        $ingeschrevenActiviteiten = $this->getDoctrine()
            ->getRepository(Activiteiten::class)
            ->getIngeschrevenActiviteiten($usr->getId());

        $totaal = $this->getDoctrine()
            ->getRepository(Activiteiten::class)
            ->getTotaal($ingeschrevenActiviteiten);


        return $this->render('deelnemer/activiteiten.html.twig', [
            'beschikbare_activiteiten' => $beschikbareActiviteiten,
            'ingeschreven_activiteiten' => $ingeschrevenActiviteiten,
            'totaal' => $totaal,
        ]);
    }

    /**
     * @Route("/user/inschrijven/{id}", name="inschrijven")
     */
    public function inschrijvenActiviteitAction($id)
    {

        $activiteit = $this->getDoctrine()
            ->getRepository(Activiteiten::class)
            ->find($id);
        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $usr->addActiviteiten($activiteit);

        $em = $this->getDoctrine()->getManager();
        $em->persist($usr);
        $em->flush();

        return $this->redirectToRoute('activiteiten');
    }

    /**
     * @Route("/user/uitschrijven/{id}", name="uitschrijven")
     */
    public function uitschrijvenActiviteitAction($id)
    {
        $activiteit = $this->getDoctrine()
            ->getRepository(Activiteiten::class)
            ->find($id);
        $usr = $this->get('security.token_storage')->getToken()->getUser();
        $usr->removeActiviteiten($activiteit);
        $em = $this->getDoctrine()->getManager();
        $em->persist($usr);
        $em->flush();
        return $this->redirectToRoute('activiteiten');
    }

    /**
     * @Route("/user/gegevens", name="show_user_gegevens")
     */
    public function showGegevens()
    {
        return $this->render('deelnemer/gegevens.html.twig');
    }

    /**
     * @Route("/user/edit/{password}", name="edit_user")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param EntityManagerInterface $em
     * @param $password
     */
    public function UserEdit(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $em, $password)
    {
        $title = "";
        $user = $this->getUser();
        if ($password === "true") {
            $form = $this->createFormBuilder()
                ->add('currentPassword', PasswordType::class, [
                    'help' => 'vul uw huidig wachtwoord in',
                    'label' => 'huidig wachtwoord'])
                ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'first_options' => ['label' => 'wachtwoord'],
                    'second_options' => ['label' => 'herhaal wachtwoord'],
                ])
                ->getForm();
            $title = "Wachtwoord wijzigen";
        } else {
            $form = $this->createForm(UserType::class, $user);
            $form->remove('password');
            $title = "Gegevens wijzigen";
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($encoder->isPasswordValid($user, $form->get('currentPassword')->getData())) {

                if ($password === "true") {
                    $user->setPassword($encoder->encodePassword($user, $form->get('password')->getData()));
                } else {
                    $user = $form->getData();
                }
                $em->persist($user);
                $em->flush();

                $this->addFlash(
                    'notice',
                    'Uw gegevens zijn gewijzigd!'
                );

                return $this->redirectToRoute("show_user_gegevens");
            } else {
                $this->addFlash('error', 'Wachtwoord incorrect');
            }
        }

        return $this->render('deelnemer/wijzig.html.twig', [
            'title' => $title,
            'form' => $form->createView()
        ]);
    }
}
