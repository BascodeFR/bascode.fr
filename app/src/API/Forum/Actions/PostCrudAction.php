<?php

namespace cavernos\bascode_api\API\Forum\Actions;

use cavernos\bascode_api\API\Forum\Entity\Post;
use cavernos\bascode_api\API\Forum\Table\MessagesTable;
use cavernos\bascode_api\API\Forum\Table\PostTable;
use cavernos\bascode_api\Framework\Actions\CrudAction;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\Router;
use cavernos\bascode_api\Framework\Session\FlashService;
use cavernos\bascode_api\Framework\Validator;
use DateTime;
use Psr\Http\Message\ServerRequestInterface;

class PostCrudAction extends CrudAction
{
    
    protected string $viewPath = "@forum/admin/posts";

    protected string $routePrefix = "admin.forum";
    
    /**
     * messagesTable
     *
     * @var MessagesTable
     */
    private $messagesTable;

    public function __construct(
        RendererInterface $renderer,
        PostTable $table,
        Router $router,
        FlashService $flash,
    ) {
        parent::__construct($renderer, $table, $router, $flash);
    }

    protected function getParams(ServerRequestInterface $request, $item): array
    {
        $params = array_filter($request->getParsedBody(), function ($key) {
            return in_array($key, ['name', 'slug', 'created_by', 'created_at']);
        }, ARRAY_FILTER_USE_KEY);
        return array_merge($params, [
            'updated_at' => date('Y-m-d H:i:s'),
            'slug' => str_replace(
                [' ' ,  'á' ,  'à', 'é', 'í', 'ó', 'ú'],
                ['-', 'a', 'a', 'e', 'i', 'o', 'u'],
                strtolower($params['name'])
            )
        ]);
    }

    protected function getValidator(ServerRequestInterface $request): Validator
    {
        return parent::getValidator($request)
            ->required('name', 'created_by', 'created_at')
            ->length('name', 2, 250)
            ->length('created_by', 2, 250)
            ->datetime('created_at');
    }

    protected function getNewEntity()
    {
        $post = new Post();
        $post->created_at = new DateTime();
        return $post;
    }
}
