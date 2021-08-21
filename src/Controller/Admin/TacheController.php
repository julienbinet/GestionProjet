<?php

namespace App\Controller\Admin;

use App\Entity\Tache;
use App\Form\TacheType;
use App\Repository\TacheRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/tache")
 */
class TacheController extends AbstractController
{
    /**
     * @Route("/", name="admin_tache_index", methods="GET")
     */
    public function index(TacheRepository $tacheRepository): Response
    {
        return $this->render('admin/tache/index.html.twig', ['taches' => $tacheRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_tache_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $tache = new Tache();
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tache);
            $em->flush();

            $this->addFlash('success', 'tache.created_successfully');

            return $this->redirectToRoute('admin_tache_index');
        }

        return $this->render('admin/tache/new.html.twig', [
            'tache' => $tache,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_tache_show", methods="GET")
     */
    public function show(Tache $tache): Response
    {
        return $this->render('admin/tache/show.html.twig', ['tache' => $tache]);
    }

    /**
     * @Route("/{id}/edit", name="admin_tache_edit", methods="GET|POST")
     */
    public function edit(Request $request, Tache $tache): Response
    {
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'tache.updated_successfully');

            return $this->redirectToRoute('admin_tache_edit', ['id' => $tache->getId()]);
        }

        return $this->render('admin/tache/edit.html.twig', [
            'tache' => $tache,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_tache_delete", methods="DELETE")
     */
    public function delete(Request $request, Tache $tache): Response
    {
        if ($this->isCsrfTokenValid('delete' . $tache->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tache);
            $em->flush();

            $this->addFlash('success', 'tache.deleted_successfully');
        }

        return $this->redirectToRoute('admin_tache_index');
    }
}
