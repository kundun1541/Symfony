<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends AbstractController
{
    /**
     * @Route("/blog/list/{page<\d+>}", name="blog_list")
     */
    public function list($page)
    {
        return $this->render('blog/list.html.twig', ['page' => $page]);
    }

    /**
     * @Route(
     *     "blog/show/{slug}",
     *     name="blog_list",
     *     )
     */

    public function show($slug)
    {
        $slugspace = str_replace("-", " ", $slug);
        $slugspacemaj = ucwords($slugspace);
        return $this->render('blog/show.html.twig', ['slugspacemaj' => $slugspacemaj]);
    }
}
