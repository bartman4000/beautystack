<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Controller;

use App\Entity\Style;
use App\Repository\StyleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class StylesController extends AbstractController
{
    /**
     * @Route("/styles", methods={"GET"})
     */
    public function index(Request $request, ObjectManager $em): JsonResponse
    {
        /** @var StyleRepository $repo */
        $repo = $em->getRepository(Style::class);

        $search = $request->query->get('search');
        $tag = $request->query->get('tag');

        if ($search) {
            $styles = $repo->findByWord($search);
        } elseif ($tag) {
            $styles = $repo->findByTag($tag);
        } else {
            $styles = $repo->findBy(['deleted' => false]);
        }

        return $this->json($styles);
    }
}
