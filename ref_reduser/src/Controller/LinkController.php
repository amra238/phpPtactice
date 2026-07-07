<?php

namespace App\Controller;

use App\Entity\Link;
use App\Repository\LinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LinkController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET', 'POST'])]
    public function index(Request $request, LinkRepository $linkRepository, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $url = $request->request->get('url');
            if (!empty($url)) {
                $link = new Link();
                $link->setFullUrl($url);
                $link->setShortCode(substr(uniqid(), 0, 6));
                $em->persist($link);
                $em->flush();
            }
            return $this->redirectToRoute('app_home');
        }

        return $this->render('link/index.html.twig', [
            'links' => $linkRepository->findAll(),
        ]);
    }

    #[Route('/short/{code}', name: 'app_redirect')]
    public function redirectToUrl(string $code, LinkRepository $linkRepository, EntityManagerInterface $em): Response
    {
        $link = $linkRepository->findByShortCode($code);
        if (!$link) {
            throw $this->createNotFoundException('Ссылка не найдена');
        }

        $link->incrementVisitCount();
        $link->setLastUsedAt(new \DateTimeImmutable());
        $em->flush();

        return $this->redirect($link->getFullUrl());
    }

    #[Route('/delete/{id}', name: 'app_delete', methods: ['POST'])]
    public function delete(int $id, LinkRepository $linkRepository, EntityManagerInterface $em): Response
    {
        $link = $linkRepository->find($id);
        if ($link) {
            $em->remove($link);
            $em->flush();
        }
        return $this->redirectToRoute('app_home');
    }
}
