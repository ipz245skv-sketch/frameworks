<?php

namespace App\Controller;

use App\Entity\Playlist;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/playlists')]
class PlaylistController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $playlists = $em->getRepository(Playlist::class)->findAll();
        $data = [];
        foreach ($playlists as $p) {
            $data[] = ['id' => $p->getId(), 'name' => $p->getName(), 'description' => $p->getDescription()];
        }
        return new JsonResponse($data, 200);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function show(int $id, EntityManagerInterface $em): JsonResponse
    {
        $playlist = $em->getRepository(Playlist::class)->find($id);
        if (!$playlist) {
            return new JsonResponse(['message' => 'Not found'], 404);
        }
        return new JsonResponse(['id' => $playlist->getId(), 'name' => $playlist->getName(), 'description' => $playlist->getDescription()], 200);
    }

    #[Route('', methods: ['POST'])]
    public function store(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $content = json_decode($request->getContent(), true);
        if (empty($content['name'])) {
            return new JsonResponse(['message' => 'Name is required'], 400);
        }
        $playlist = new Playlist();
        $playlist->setName($content['name']);
        $playlist->setDescription($content['description'] ?? null);
        $em->persist($playlist);
        $em->flush();
        return new JsonResponse(['id' => $playlist->getId(), 'name' => $playlist->getName(), 'description' => $playlist->getDescription()], 201);
    }

    #[Route('/{id}', methods: ['PATCH'])]
    public function update(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $playlist = $em->getRepository(Playlist::class)->find($id);
        if (!$playlist) {
            return new JsonResponse(['message' => 'Not found'], 404);
        }
        $content = json_decode($request->getContent(), true);
        if (isset($content['name'])) {
            $playlist->setName($content['name']);
        }
        if (isset($content['description'])) {
            $playlist->setDescription($content['description']);
        }
        $em->flush();
        return new JsonResponse(['id' => $playlist->getId(), 'name' => $playlist->getName(), 'description' => $playlist->getDescription()], 200);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function destroy(int $id, EntityManagerInterface $em): JsonResponse
    {
        $playlist = $em->getRepository(Playlist::class)->find($id);
        if (!$playlist) {
            return new JsonResponse(['message' => 'Not found'], 404);
        }
        $em->remove($playlist);
        $em->flush();
        return new JsonResponse(['message' => 'Deleted successfully'], 200);
    }
}