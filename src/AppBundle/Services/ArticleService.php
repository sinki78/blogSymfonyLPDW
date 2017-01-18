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

    /** get Tags search array */
    public function getTagsSearchArray($reqFields){

        $tags = [];

        $i=0;
        foreach ($reqFields as $key=>$tag){
            if(preg_match('/^tag/',$key)){
                $tags[]= $tag;
            };
            $i++;

        }
        return $tags;
    }

    /** get Nb commentaries */
    public function getNbCommentaries($article){
        $nbArticle = $this->doctrine->getRepository('AppBundle:Commentary')->getNbCom($article);

        return $nbArticle;

    }



}