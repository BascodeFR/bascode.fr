<?php

namespace cavernos\bascode_api\Framework\Actions;

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
    private $table;
    
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
    protected $viewPath;
    
    /**
     * routePrefix
     *
     * @var string
     */
    protected $routePrefix;
    
    /**
     * flashMessages
     *
     * @var array
     */
    protected $flashMessages = [
        'create' => "L'élément a bien été créé",
        'edit' => "L'élément a bien été modifé"
    ];

    use RouterAwareAction;

    public function __construct(
        RendererInterface $renderer,
        Table $table,
        Router $router,
        FlashService $flash
    ) {
        $this->flash = $flash;
        $this->router = $router;
        $this->renderer = $renderer;
        $this->table = $table;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $this->renderer->addGlobal('viewPath', $this->viewPath);
        $this->renderer->addGlobal('routePrefix', $this->routePrefix);
        if ($request->getMethod() === 'DELETE') {
            return $this->delete($request);
        }
        if (substr((string)$request->getUri(), -3) === 'new') {
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
        $items = $this->table->findPaginated(10, $params['p'] ?? 1);
        return $this->renderer->render("$this->viewPath/index", compact('items'));
    }
    
    /**
     * edite un article
     *
     * @param  ServerRequestInterface $request
     * @return ResponseInterface|string
     */
    public function edit(ServerRequestInterface $request): mixed
    {
        $item = $this->table->find($request->getAttribute('id'));
        $errors = null;
        if ($request->getMethod() === 'POST') {
            $params = $this->getParams($request);
            $params['updated_at'] = date('Y-m-d H:i:s');
           
            $validator = $this->getValidator($request);
            if (!empty($validator->isValid())) {
                $this->table->update($item->id, $params);
                $this->flash->success($this->flashMessages['edit']);
                return $this->redirect($this->routePrefix . '.index');
            }
            $item->slug = $params['slug'];
            $item->name = $params['name'];
            $item->created_by = $params['created_by'];
            $errors = $validator->getErrors();
        }
        $params = $this->formParams(compact('item', 'errors'));

        return $this->renderer->render("$this->viewPath/edit", $params);
    }
    
    /**
     * create Crée un nouvel article
     *
     * @param  ServerRequestInterface $request
     * @return ResponseInterface|string
     */
    public function create(ServerRequestInterface $request): mixed
    {
        $errors = null;
        $item = $this->getNewEntity();
        if ($request->getMethod() === 'POST') {
            $params = $this->getParams($request);
            $validator = $this->getValidator($request);
            if (!empty($validator->isValid())) {
                $this->table->insert($params);
                $this->flash->success($this->flashMessages['create']);
                return $this->redirect($this->routePrefix . '.index');
            }
            $item = $params;
            $errors = $validator->getErrors();
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
        return $this->redirect($this->routePrefix . '.index');
    }
    
    /**
     * getParams
     *
     * @param  mixed $request
     * @return array
     */
    protected function getParams(ServerRequestInterface $request): array
    {
        return array_filter($request->getParsedBody(), function ($key) {
            return in_array($key, []);
        }, ARRAY_FILTER_USE_KEY);
    }

    protected function getValidator(ServerRequestInterface $request): Validator
    {
        return new Validator($request->getParsedBody());
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
