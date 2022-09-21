<?php

namespace cavernos\bascode_api\Framework\Actions;

use cavernos\bascode_api\API\Auth\Table\UserTable;
use cavernos\bascode_api\Framework\Database\Hydrator;
use cavernos\bascode_api\Framework\Database\Table;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\Router;
use cavernos\bascode_api\Framework\Session\FlashService;
use cavernos\bascode_api\Framework\Validator;
use DateTime;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CrudAction
{
    
    /**
     * renderer
     *
     * @var RendererInterface
     */
    private $renderer;

    /**
     * table
     *
     * @var Table
     */
    protected $table;
    
    /**
     * router
     *
     * @var Router
     */
    private $router;
    
    /**
     * session
     *
     * @var FlashService
     */
    private $flash;
    
    /**
     * viewPath
     *
     * @var string
     */
    protected string $viewPath;
    
    /**
     * routePrefix
     *
     * @var string
     */
    protected string $routePrefix;
    
    /**
     * flashMessages
     *
     * @var array
     */
    protected array $flashMessages = [
        'create' => "L'élément a bien été créé",
        'edit' => "L'élément a bien été modifé",
        'delete' => "L'élément a bien été supprimé"
    ];

    use RouterAwareAction;

    public function __construct(
        RendererInterface $renderer,
        Table $table,
        Router $router,
        FlashService $flash,
    ) {
        $this->flash = $flash;
        $this->router = $router;
        $this->renderer = $renderer;
        $this->table = $table;
    }

    /**
     * @param ServerRequestInterface $request
     * @return string|ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request): string|ResponseInterface
    {
        $this->renderer->addGlobal('viewPath', $this->viewPath);
        $this->renderer->addGlobal('routePrefix', $this->routePrefix);
        if ($request->getMethod() === 'DELETE') {
            return $this->delete($request);
        }
        if (str_ends_with((string)$request->getUri(), 'new')) {
            return $this->create($request);
        }
        if ($request->getAttribute('id')) {
            return $this->edit($request);
        }
        return $this->index($request);
    }

    /**
     * posts
     *
     * @return string
     */
    public function index(ServerRequestInterface $request): string
    {
        $params = $request->getQueryParams();
        $table = $this->table->getTable();
        $items = $this->table->makeQuery()
            ->select("$table.*, u.username")
            ->from($table)
            ->order('created_at DESC')
            ->join('users as u', "user_id = u.id")
            ->paginate(10, $params['p'] ?? 1);
        return $this->renderer->render("$this->viewPath/index", compact('items'));
    }
    
    /**
     * edite un article
     *
     * @param  ServerRequestInterface $request
     * @return string|ResponseInterface
     */
    public function edit(ServerRequestInterface $request): string|ResponseInterface
    {
        $item = $this->table->find($request->getAttribute('id'));
        $errors = null;
        if ($request->getMethod() === 'POST') {
            $validator = $this->getValidator($request);
            if (!empty($validator->isValid())) {
                $this->table->update($item->id, $this->getParams($request, $item));
                $this->flash->success($this->flashMessages['edit']);
                return $this->redirect($this->routePrefix . '.index');
            }
            $errors = $validator->getErrors();
            Hydrator::hydrate($request->getParsedBody(), $item);
        }
        $params = $this->formParams(compact('item', 'errors'));

        return $this->renderer->render("$this->viewPath/edit", $params);
    }
    
    /**
     * create Crée un nouvel article
     *
     * @param  ServerRequestInterface $request
     * @return string|ResponseInterface
     */
    public function create(ServerRequestInterface $request): string|ResponseInterface
    {
        $errors = null;
        $item = $this->getNewEntity();
        if ($request->getMethod() === 'POST') {
            $validator = $this->getValidator($request);
            if (!empty($validator->isValid())) {
                $this->table->insert($this->getParams($request, $item));
                $this->flash->success($this->flashMessages['create']);
                return $this->redirect($this->routePrefix . '.index');
            }
            $errors = $validator->getErrors();
            Hydrator::hydrate($request->getParsedBody(), $item);
        }
        $params = $this->formParams(compact('item', 'errors'));

        return $this->renderer->render("$this->viewPath/create", $params);
    }
    
    /**
     * delete
     *
     * @param  ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request): ResponseInterface
    {
        $this->table->delete($request->getAttribute('id'));
        $this->flash->error($this->flashMessages['delete']);
        return $this->redirect($this->routePrefix . '.index');
    }
    
    /**
     * getParams
     *
     * @param  ServerRequestInterface $request
     * @param  mixed $item
     * @return array
     */
    protected function getParams(ServerRequestInterface $request, $item): array
    {
        return array_filter($request->getParsedBody(), function ($key) {
            return in_array($key, []);
        }, ARRAY_FILTER_USE_KEY);
    }

    protected function getValidator(ServerRequestInterface $request): Validator
    {
        return new Validator(array_merge($request->getParsedBody(), $request->getUploadedFiles()));
    }

    protected function getNewEntity()
    {
        return [];
    }
    
    /**
     * formParams
     *
     * @param  array $params
     * @return array
     */
    protected function formParams(array $params): array
    {
        return $params;
    }
}
