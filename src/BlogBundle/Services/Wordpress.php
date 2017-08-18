<?php
namespace BlogBundle\Services;

use JMS\DiExtraBundle\Annotation\Inject;
use JMS\DiExtraBundle\Annotation\InjectParams;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation\Tag;
use Psr\Log\LoggerInterface;

/**
 * Class Wordpress
 * @package BlogBundle\Services
 * @Service("blog.wordpress")
 * @Tag("monolog.logger", attributes = {"name": "monolog.logger", "channel":"worker"})
 */
class Wordpress
{

    /**
     * @InjectParams({
     *     "container"       = @Inject("service_container")
     * })
     */
    public function __construct($container) {
        $this->container = $container;
    }

    public function getCateg($id){
        $category = $this->container->get('doctrine')->getRepository('KayueWordpressBundle:Taxonomy')->findOneById($id);
        if (!is_null($category)) {
            return $category;
        }
        return false;
    }

    public function getArticle($id){
        $article = $this->container->get('doctrine')->getRepository('KayueWordpressBundle:Post')->findOneById($id);
        if (!is_null($article)) {
            return $article;
        }
        return false;
    }


    public function getThumbnailByPost($post){
        $thumbnailId = $this->container->get('doctrine')->getRepository('KayueWordpressBundle:PostMeta')->findOneBy(['post'=>$post, 'key'=>'_thumbnail_id']);
        if ($thumbnailId){
            $thumbnail = $this->container->get('doctrine')->getRepository('KayueWordpressBundle:Post')->findOneById($thumbnailId->getValue());
            return $thumbnail;
        }
        return false;
    }


    public function getCategs(){
        $returnCateg = [];
        $categorys = $this->container->get('doctrine')->getRepository('KayueWordpressBundle:Taxonomy')->findAll();
        if (!is_null($categorys)) {
            foreach ($categorys as $category) {
                if ($category->getName() == 'category' && $category->getTerm()->getSlug() != 'non-classe') {
                    $returnCateg[] = $category;
                }
            }
        }
        return $returnCateg;
    }


    public function getPostsByCateg($id){
        $returnPosts = [];
        $category = $this->container->get('doctrine')->getRepository('KayueWordpressBundle:Taxonomy')->findOneById($id);
        $posts = $category->getPosts();
        foreach ($posts as $post) {
            if ($post->getStatus() == 'publish')
                $returnPosts[] = $post;
        }
        return $returnPosts;
    }


}