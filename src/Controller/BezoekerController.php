<?php

namespace App\Controller;

use App\Entity\AppUsers;
use App\Entity\SoortActiviteiten;
use App\Form\UserType;
use AppBundle\Entity\Soortactiviteit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BezoekerController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        return $this->render('bezoeker/index.html.twig', [
            'boodschap' => 'welkom',
        ]);
    }

    /**
     * @Route("/kartactiviteiten", name="kartactiviteiten")
     */
    public function kartactiviteitenAction()
    {
        $repository = $this->getDoctrine()->getRepository(Soortactiviteiten::class);
        $soortactiviteiten = $repository->findAll();
        return $this->render('bezoeker/kartactiviteiten.html.twig', [
            'boodschap' => 'Welkom', 'soortactiviteiten' => $soortactiviteiten]);
    }

    /**
     * @Route("/kartactiviteiten/{activiteitNaam}", name="acitiviteit_detail")
     * @param $activiteitenNaam
     * @param EntityManagerInterface $entityManager
     */
    public function kartactiviteitDetails($activiteitNaam, EntityManagerInterface $em)
    {
        $activiteit = $em->getRepository(SoortActiviteiten::class)->findBy(["naam" => $activiteitNaam])[0];
        if ($activiteit){
            return $this->render('bezoeker/detail.html.twig', ['activiteit' => $activiteit]);
        }
        $this->addFlash('error', 'deze activiteit bestaad niet');
        return $this->redirectToRoute('kartactiviteiten');
    }

    /**
     * @Route("registreren", name="registreren")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function registreren(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $form = $this->createForm(UserType::class);
        $form->remove('huidigWachtwoord');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
            $user->setRoles(['ROLE_USER']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash(
                'notice',
                $user->getNaam() . ' is geregistreerd!'
            );

            return $this->redirectToRoute('homepage');

        }

        return $this->render('bezoeker/registreren.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
