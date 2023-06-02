<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserController extends AbstractController
{
#[Route('/api/user', name: 'api_user')]
#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
    public function apiUser()
    {
        return $this->json($this->getUser(), 200,[], ['groups' => ['user:read']]);
    }
}