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
                'get_categories_and_tags',
                array($this, 'getCategoriesAndTags')
            ),
            new \Twig_SimpleFunction(
                'get_nb_page',
                array($this, 'getNbPage')
            ),
        );
    }
    public function getCategoriesAndTags()
    {
        return $this->articleService->getCategoriesAndTags();
    }

    public function getNbPage($search = null)
    {
        return $this->articleService->getNbPage($search);
    }

}