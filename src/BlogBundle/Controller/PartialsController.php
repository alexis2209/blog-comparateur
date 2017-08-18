<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PartialsController extends Controller
{
    public function menuAction()
    {
        $categorys = $this->container->get('blog.wordpress')->getCategs();
        return $this->render('BlogBundle:Partials:menu.html.twig', array(
            'categorys' => $categorys
        ));
    }
}
