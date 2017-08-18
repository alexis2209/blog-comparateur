<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     *
     */
    public function indexAction($postId)
    {
        $post = $this->container->get('blog.wordpress')->getArticle($postId);
        $thumbnail = $this->container->get('blog.wordpress')->getThumbnailByPost($post);

        // replace this example code with whatever you need
        return $this->render('BlogBundle:Default:post.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'post' => $post,
            'thumbnail' => $thumbnail
        ));
    }


    /**
     *
     */
    public function categorieAction($categoryId)
    {
        $category = $this->container->get('blog.wordpress')->getCateg($categoryId);
        // replace this example code with whatever you need
        return $this->render('BlogBundle:Default:category.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
            'category' => $category,
            'posts' => $category->getPosts()
        ));
    }
}
