<?php

namespace AppBundle\Controller;

use Kayue\WordpressBundle\Entity\Taxonomy;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $repo = $this->get('kayue_wordpress.post.manager');
        //$test = $this->getDoctrine()->getRepository('KayueWordpressBundle:Post')->findAll();
        //var_dump($test);exit;
        $post = $repo->findOnePostBySlug(array(
            'slug'   => 'bonjour-tout-le-monde'
        ));



        /*echo $post->getTitle() , "<br/>";
        echo $post->getUser()->getDisplayName() , "<br/>";
        echo $post->getContent() , "<br/>";

        foreach($post->getComments() as $comment) {
            echo $comment->getContent() . "<br/>";
        }

        foreach($post->getTaxonomies()->filter(function(Taxonomy $tax) {
            // Only return categories, not tags or anything else.
            return 'category' === $tax->getName();
        }) as $tax) {
            echo $tax->getTerm()->getName() . "\n";
        }*/


        // replace this example code with whatever you need
        return $this->render('AppBundle:Index:index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }
}
