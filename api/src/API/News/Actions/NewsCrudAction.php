<?php

namespace cavernos\bascode_api\API\News\Actions;

use cavernos\bascode_api\API\News\Entity\News;
use cavernos\bascode_api\API\News\Table\NewsTable;
use cavernos\bascode_api\Framework\Actions\CrudAction;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\Router;
use cavernos\bascode_api\Framework\Session\FlashService;
use cavernos\bascode_api\Framework\Validator;
use DateTime;
use LengthException;
use Psr\Http\Message\ServerRequestInterface;

class NewsCrudAction extends CrudAction
{

    protected $flashMessages = [
        'create' => "L'actualité a bien été créé",
        'edit' => "L'actualité a bien été modifiée"
    ];
    
    protected $viewPath = "@news/admin/news";

    protected $routePrefix = "admin.news";

    public function __construct(
        RendererInterface $renderer,
        NewsTable $table,
        Router $router,
        FlashService $flash,
    ) {
        parent::__construct($renderer, $table, $router, $flash);
    }

    protected function getParams(ServerRequestInterface $request): array
    {
        return array_filter($request->getParsedBody(), function ($key) {
            return in_array($key, ['name', 'slug', 'created_at', 'content']);
        }, ARRAY_FILTER_USE_KEY);
    }

    protected function getValidator(ServerRequestInterface $request): Validator
    {
        return parent::getValidator($request)
        ->required('name', 'slug', 'created_at', 'content')
        ->length('name', 3, 255)
        ->length('slug', 3, 50)
        ->length('content', 5, 6000)
        ->slug('slug')
        ->dateTime('created_at');
    }

    protected function getNewEntity()
    {
        $news = new News();
        $news->created_at = new DateTime();
        $news->updated_at = new DateTime();
        return $news;
    }
}
