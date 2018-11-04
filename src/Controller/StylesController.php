<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Controller;


use App\Entity\Style;
use App\Repository\StyleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;;

class StylesController extends AbstractController
{
    /**
     * @Route("/styles", methods={"GET"})
     */
    public function index(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        /** @var StyleRepository $repo */
        $repo = $em->getRepository(Style::class);

        $search = $request->query->get('search');
        $tag = $request->query->get('tag');

        if($search) {
            $styles = $repo->findByWord($search);
        }
        elseif ($tag) {
            $styles = $repo->findByTag($tag);
        }
        else {
            $styles = $repo->findBy(['deleted' => false]);
        }

       return $this->json($styles);
    }
}