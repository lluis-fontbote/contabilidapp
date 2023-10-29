<?php

namespace App\Controller;

use App\Entity\Provider;
use App\Form\ProviderFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProviderController extends AbstractController
{
    /**
     * Creates a new Provider.
     *
     * @Route("/proveedores/nuevo", methods={"GET", "POST"}, name="provider.new")
     *
     */
    public function new(Request $request): Response
    {
        $provider = new Provider();

        $form = $this->createForm(ProviderFormType::class, $provider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // refresh CSRF token to prevent duplicates on users submitting the form twice
            $this->get("security.csrf.token_manager")->refreshToken("form_intention");

            $em = $this->getDoctrine()->getManager();
            $em->persist($provider);
            $em->flush();

            $this->addFlash('success', 'Proveedor creado correctamente');

            return $this->redirectToRoute('provider.edit', ['id' => $provider->getId()]);
        }

        return $this->render('provider/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Edits an existing Provider.
     *
     * @Route("/proveedores/{id<\d+>}", methods={"GET", "POST"}, name="provider.edit")
     */
    public function edit(Request $request, Provider $provider): Response
    {
        $form = $this->createForm(ProviderFormType::class, $provider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($provider);
            $em->flush();

            $this->addFlash('success', 'Proveedor editado correctamente');

            return $this->redirectToRoute('provider.edit', ['id' => $provider->getId()]);
        }

        return $this->render('provider/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
