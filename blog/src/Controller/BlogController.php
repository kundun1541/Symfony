<?php
// src/Controller/BlogController.php
namespace App\Controller;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleSearchType;
use App\Form\CategoryType2;

class BlogController extends AbstractController
{

    /**
     * Show all row from article's entity
     *
     * @Route("/", name="blog_index")
     * @return Response A response instance
     */
    public function index(Request $request): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        $category = new Category();
        $form = $this->createForm(
            CategoryType2::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
        }

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        return $this->render(
            'blog/index.html.twig',
            ['articles' => $articles, 'form' => $form->createView()]
        );
    }

    /**
     * @Route("/list/{page}", requirements={"page"="\d+"}, name="blog_list")
     */
    public function list($page)
    {
        return $this->render('blog/list.html.twig', ['page' => $page]);
    }


    /**
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="blog_show")
     * @return Response A response instance
     */
    public function show(?string $slug): Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with ' . $slug . ' title, found in article\'s table.'
            );
        }

        return $this->render(
            'blog/show.html.twig',
            [
                'article' => $article,
                'slug' => $slug,
            ]
        );

    }


    /**
     * @Route("/blog/category/{id}", name="show_category")
     */
    public function showByCategory(Category $categoryName)
    {


        $articles = $categoryName->getArticles();


        return $this->render(
            'blog/category.html.twig',
            [
                'articles' => $articles,
                'categoryName' => $categoryName,
            ]);
    }

    /**
     * @Route("blog/tag/{name}", name="show_name")
     *
     *
     */
    public function Showtag(Tag $tag): Response
    {

        return $this->render('blog/tag.html.twig', ['tag' => $tag]);
    }
}



