<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Photos;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PhotoProcessor implements ProcessorInterface
{
public function __construct(
private EntityManagerInterface $entityManager,
) {}

public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
{
$request = $context['request'] ?? null;

if (!$request instanceof Request) {
throw new BadRequestHttpException('Invalid request');
}

$uploadedFile = $request->files->get('file');

if (!$uploadedFile) {
throw new BadRequestHttpException('No file uploaded');
}

$photo = new Photos();
$photo->setFile($uploadedFile);

$this->entityManager->persist($photo);
$this->entityManager->flush();

return $photo;
}
}