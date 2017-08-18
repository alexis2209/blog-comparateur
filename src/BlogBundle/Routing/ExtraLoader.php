<?php
namespace BlogBundle\Routing;

use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class ExtraLoader extends Loader
{
    private $loaded = false;

    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function load($resource, $type = null)
    {
        if (true === $this->loaded) {
            throw new \RuntimeException('Do not add the "extra" loader twice');
        }

        $routes = new RouteCollection();

        $categorys = $this->container->get('blog.wordpress')->getCategs();
        if (!empty($categorys)){
            foreach ($categorys as $category){
                $defaults = array(
                    '_controller' => 'BlogBundle:Default:categorie',
                    'categoryId'=>$category->getId()
                );
                $requirements = [];
                $route = new Route('/' . $category->getTerm()->getSlug(), $defaults, $requirements);

                // add the new route to the route collection
                $routeName = 'category_' . $category->getTerm()->getSlug();
                $routes->add($routeName, $route);


                $articles = $this->container->get('blog.wordpress')->getPostsByCateg($category->getId());
                if (!empty($articles)){
                    foreach ($articles as $article){
                        $defaults = array(
                            '_controller' => 'BlogBundle:Default:index',
                            'postId'=>$article->getId()
                        );
                        $requirements = [];
                        $route = new Route('/' . $category->getTerm()->getSlug() . '/' . $article->getSlug(), $defaults, $requirements);

                        // add the new route to the route collection
                        $routeName = 'article_' . $article->getSlug();
                        $routes->add($routeName, $route);
                    }
                }
            }
        }

        $this->loaded = true;

        return $routes;
    }

    public function supports($resource, $type = null)
    {
        return 'extra' === $type;
    }
}