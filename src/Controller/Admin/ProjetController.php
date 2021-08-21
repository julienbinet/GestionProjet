<?php

namespace App\Controller\Admin;

use App\Entity\Projet;
use App\Entity\Tache;
use App\Form\ProjetType;
use App\Form\TacheProjetType;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/projet")
 */
class ProjetController extends AbstractController
{
    /**
     * @Route("/", name="admin_projet_index", methods="GET")
     */
    public function index(ProjetRepository $projetRepository): Response
    {

        return $this->render('admin/projet/index.html.twig', [
            'projets' => $projetRepository->findAll(),

        ]);
    }

    /**
     * @Route("/new", name="admin_projet_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($projet);
            $em->flush();

            $this->addFlash('success', 'projet.created_successfully');
            return $this->redirectToRoute('admin_projet_index');
        }

        return $this->render('admin/projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_projet_show", methods="GET|POST")
     *
     * Ajout de la méthode POST pour l'ajout d'une tache concernant le projet
     */
    public function show(Request $request, Projet $projet): Response
    {

        $tache_form = new Tache();
        $tache_form->setProjet($projet);
        $tache_form->setUser($this->getUser());
        $form = $this->createForm(TacheProjetType::class, $tache_form);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tache_form);
            $em->flush();

            $this->addFlash('success', 'tache.created_successfully');
            return $this->redirectToRoute('admin_projet_show', ['id' => $projet->getId()]);
        }

        /*
         *  On calcul la somme des durées pour connaitre le temps total du projet
         * On transforme la durée en interval pour l'additionner à la date initiale
         * on soustrait la date initiale à celle finale pour avoir le temps passé
         */

        $date = \DateTime::createFromFormat('h:s', '11:00');
        $date_init = clone $date;

        $taches = $projet->getTaches();
        foreach ($taches as $tache) {

            $time_string = 'PT' . $tache->getDuree()->format('H') . 'H' . $tache->getDuree()->format('i') . 'M';
            $date->add(new \DateInterval($time_string));
        }

        $interval = $date->diff($date_init);
        $total_duree = $interval->format('%d jour(s) %h heures %i minutes');

        return $this->render('admin/projet/show.html.twig', [
            'projet' => $projet,
            'total_duree' => $total_duree,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_projet_edit", methods="GET|POST")
     */
    public function edit(Request $request, Projet $projet): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'projet.updated_successfully');

            return $this->redirectToRoute('admin_projet_edit', ['id' => $projet->getId()]);
        }

        return $this->render('admin/projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_projet_delete", methods="DELETE")
     */
    public function delete(Request $request, Projet $projet): Response
    {
        if ($this->isCsrfTokenValid('delete' . $projet->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($projet);
            $em->flush();
        }

        $this->addFlash('success', 'projet.deleted_successfully');

        return $this->redirectToRoute('admin_projet_index');
    }
}
