<?php
// src/Controller/BlogController.php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog_index")
     */
    public function index()
    {
        return $this->render('blog/index.html.twig', ['owner' => 'Dimitri',]);
    }
    /**
     * @Route("/list/{page}", requirements={"page"="\d+"}, name="blog_list")
     */
    public function list($page)
    {
        return $this->render('blog/list.html.twig', ['page' => $page]);
    }
    /**
     * @Route("/show/{slug}", defaults={"slug"="Article Sans Titre"}, requirements={"slug"="[a-z0-9-]+"},
     *     name="blog_show")
     */
    public function show($slug)
    {
        $slug = str_replace("-", " ", $slug);
        $slug = ucwords($slug);
        return $this->render('blog/show.html.twig', ['slug' => $slug]);
    }
}