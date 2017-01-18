<?php
namespace AppBundle\Twig;

use AppBundle\Services\ArticleService;

class ArticleExtension extends \Twig_Extension
{
    /**
     * @var ArticleService
     */
    private $articleService;
    /**
     * @param ArticleService $articleService
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction(
                'get_nb_commentaries',
                array($this, 'getNbCommentaries')
            ),
        );
    }

    public function getNbCommentaries($article)
    {
        return $this->articleService->getNbCommentaries($article);
    }

}