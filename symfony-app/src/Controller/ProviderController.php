<?php

namespace App\Controller;

use App\Entity\Provider;
use App\Entity\ProviderType;
use App\Form\ProviderFormType;
use App\Repository\ProviderRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProviderController extends AbstractController
{
    /**
     * Returns the view of 
     * 
     * @Route("/", methods={"GET"}, name="home")
     * @Route("/proveedores", methods={"GET"}, name="provider.index")
     *
     */
    public function index(ProviderRepository $providerRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $nameFilter = $request->query->get('name');
        $activeFilter = $request->query->get('active');
        $providerTypeFilter = $request->query->get('providerType');

        $queryBuilder = $providerRepository->createQueryBuilder('p')
            ->leftJoin('p.providerType', 'pt');

        if ($nameFilter) {
            $queryBuilder->andWhere('p.name LIKE :name')
                ->setParameter('name', '%' . $nameFilter . '%');
        }
    
        if ($activeFilter !== '') {
            $queryBuilder->andWhere('p.active = :active')
                ->setParameter('active', $activeFilter);
        }
    
        if ($providerTypeFilter) {
            $queryBuilder->andWhere('pt.id = :providerType')
                ->setParameter('providerType', $providerTypeFilter);
        }

        $providers = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            10
        );

        $providerTypes = $this->getDoctrine()->getRepository(ProviderType::class)->findAll();

        return $this->render('provider/index.html.twig', [
            'providers' => $providers,
            'providerTypes' => $providerTypes,
        ]);
    }

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

        if ($form->isSubmitted()) {
            if (!$form->isValid()) {
                $this->addFlash('error', 'Revisa los campos del formulario.');

            } else {
                // refresh CSRF token to prevent duplicates on users submitting the form twice
                $this->get("security.csrf.token_manager")->refreshToken("form_intention");
    
                $em = $this->getDoctrine()->getManager();
                $em->persist($provider);
                $em->flush();
    
                $this->addFlash('success', 'Proveedor creado correctamente');
    
                return $this->redirectToRoute('provider.edit', ['id' => $provider->getId()]);
            }
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

    /**
     * Toggle the active state of a Provider.
     *
     * @Route("/proveedores/{id<\d+>}", methods={"PATCH"}, name="provider.toggle_status")
     */
    public function toggleActive(Provider $provider)
    {
        $provider->setActive(!$provider->isActive());
        $em = $this->getDoctrine()->getManager();
        $em->persist($provider);
        $em->flush();

        return new JsonResponse(['active' => $provider->isActive()]);
    }

    /**
     * Deletes a Provider
     *
     * @Route("/proveedores/{id}/eliminar", methods={"POST"}, name="provider.delete")
     */
    public function delete(Request $request, Provider $provider): Response
    {
        if (!$this->isCsrfTokenValid('delete-provider', $request->request->get('token'))) {
            $this->addFlash('error', 'No se pudo eliminar el proveedor');

            return $this->redirectToRoute('provider.index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($provider);
        $em->flush();

        $this->addFlash('success', 'Proveedor eliminado correctamente');

        return $this->redirectToRoute('provider.index');
    }
}
