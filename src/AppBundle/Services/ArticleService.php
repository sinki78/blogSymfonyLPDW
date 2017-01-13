<?php
namespace AppBundle\Services;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;

class ArticleService
{
    /**
     * @var EntityManager
     */
    private $doctrine;
    public function __construct($doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * Return All Categories and Tags
     * @return array
     */
    public function getCategoriesAndTags()
    {

         $categories = $this
            ->doctrine
            ->getRepository('AppBundle:Category')
            ->getNames();


         $tags = $this
             ->doctrine
             ->getRepository('AppBundle:Tag')
             ->getNames();

        //var which contain all categories and tags names
        $CatAndTag = self::getArrayCatTag($categories,$tags);
        return json_encode($CatAndTag, true);
    }


    /**
     * Return a single array of categories and tags
     *
     * var array
     */
    private function getArrayCatTag($categories,$tags){
        $CatAndTag = array();

        //add all categories names
        foreach ($categories as $category)
            $CatAndTag[] = $category['name'];

        //add all tags names
        foreach ($tags as $tag)
            $CatAndTag[] = $tag['name'];

        return $CatAndTag;
    }

    /**
     * Return nb page
     * var int
     */
     public function getNbPage($search = null){
         if($search = null){
             $articles = $this
                 ->doctrine
                 ->getRepository('AppBundle:Article')
                 ->getNbArticleNoSearch();
         } else {
             $articles = $this
                 ->doctrine
                 ->getRepository('AppBundle:Article')
                 ->getNbArticleWithSearch($search);
         }
         return json_encode($articles,true);
     }


}