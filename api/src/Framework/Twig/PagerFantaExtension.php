<?php
namespace cavernos\bascode_api\Framework\Twig;

use cavernos\bascode_api\Framework\PagerFanta\PaginateTemplate;
use cavernos\bascode_api\Framework\Router;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Twig\View\TwigView;
use Pagerfanta\View\DefaultView;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class PagerFantaExtension extends AbstractExtension
{
    
    /**
     * router
     *
     * @var Router
     */
    private $router;
        
    /**
     * __construct
     *
     * @param  Router $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }
    
    public function getFunctions()
    {
        return [
            new TwigFunction('paginate', [$this, 'paginate'], ['is_safe' => ['html']])
        ];
    }
    
        
    /**
     * paginate
     *
     * @param  Pagerfanta $paginatedResults
     * @param  string $route
     * @param  array $queryArgs
     * @return string
     */
    public function paginate(
        Pagerfanta $paginatedResults,
        string $route,
        array $routerOptions = [],
        array $queryArgs = []
    ): string {
        $view = new DefaultView();
        $options = array('css_disabled_class' => 'disabled',
        'container_template' => '<div class="%s">%%pages%%</div>',
        'page_template' => '<a class="%class%" href="%href%"%rel%>%text%</a>',
        'css_item_class' => 'pages',
        'span_template' => '<span class="%class%">%text%</span>',
        'css_prev_class' => 'prev',
        'css_next_class' => 'next',
        'prev_message' => '',
        'next_message' => '',
        'css_dots_class' => 'pages',
        'dots_message' => '...',
        'css_active_class' => 'active');
        return $view->render($paginatedResults, function (int $page) use ($route, $queryArgs, $routerOptions) {
            if ($page > 1) {
                $queryArgs['p'] = $page;
            }
            return $this->router->generateUri($route, $routerOptions, $queryArgs);
        }, $options);
    }
}
