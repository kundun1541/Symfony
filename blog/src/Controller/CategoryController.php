<?php
/**
 * Created by PhpStorm.
 * User: Sylvain
 * Date: 2019-05-21
 * Time: 15:55
 */

namespace App\Controller;

// src/Controller/BlogController.php
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Category;
use App\Form\CategoryType;

class CategoryController extends AbstractController
{

    /**
     * Show all row from article's entity
     *
     * @Route("/blog/categoryform", name="categoryform")
     * @return Response A response instance
     */
    public function add(Request $request, ObjectManager $objectManager): Response
    {
        $category = new Category();
        $form = $this->createForm(
            CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $data = $form->getData();
            $objectManager->persist($data);
            $objectManager->flush();
        }

        return $this->render(
            'blog/categoryform.html.twig',
            ['form' => $form->createView()]
        );
    }

    }

