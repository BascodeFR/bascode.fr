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

class MessagesCrudAction extends CrudAction
{
    
    protected $viewPath = "@forum/admin/messages";

    protected $routePrefix = "admin.forum.messages";

    /**
     * messagesTable
     *
     * @var PostTable
     */
    private $postTable;

    public function __construct(
        RendererInterface $renderer,
        MessagesTable $table,
        Router $router,
        FlashService $flash,
        PostTable $postTable
    ) {
        parent::__construct($renderer, $table, $router, $flash);
        $this->postTable = $postTable;
    }

    protected function getParams(ServerRequestInterface $request): array
    {
        $params = array_filter($request->getParsedBody(), function ($key) {
            return in_array($key, ['created_by', 'created_at', 'content', 'post_id']);
        }, ARRAY_FILTER_USE_KEY);
        return array_merge($params, [
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    protected function formParams(array $params): array
    {
        $params['posts'] = $this->postTable->findList();
        return $params;
    }


    protected function getValidator(ServerRequestInterface $request): Validator
    {
        return parent::getValidator($request)
            ->required('created_by', 'created_at', 'content', 'post_id')
            ->length('created_by', 2, 250)
            ->datetime('created_at')
            ->exists('post_id', $this->postTable->getTable(), $this->postTable->getPdo())
            ->length('content', 5);
    }
}
