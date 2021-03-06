<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PaginatorInterface $paginator, Request $request){
        $page = $request->query->getInt('page', 1);

        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();

        $posts = $paginator->paginate($posts, $page, 6);

        return $this->render('index.html.twig', [
            'title' => 'Postagem Teste',
            'posts' => $posts,
            'categories' => $this->getCategories()
        ]);
    }

    #[Route('/post/{slug}', name: 'single_post')]
    public function single($slug)
    {

        $post = $this->getDoctrine()->getRepository(Post::class)->findOneBySlug($slug);

        //Criando Form do Comentário
        $form = $this->createForm(CommentType::class, new Comment());
        return $this->render('single.html.twig',
            [
                'post' => $post,
                'categories' => $this->getCategories(),
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/category/{slug}", name="single_category")
     */
    public function category($slug, PaginatorInterface $paginator, Request $request)
    {
        $page = $request->query->getInt('page', 1);
        $category = $this->getDoctrine()
            ->getRepository(Category::class)->findOneBySlug($slug);

        $posts = $paginator->paginate($category->getPosts(), $page, 5);

        return $this->render('category.html.twig',
            [
                'category' => $category,
                'posts'    => $posts,
                'categories' => $this->getCategories()
            ]);
    }

    private function getCategories()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $categories;
    }
}