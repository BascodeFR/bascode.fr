<?php

namespace cavernos\bascode_api\API\Forum\Actions;

use cavernos\bascode_api\API\Forum\Table\PostTable;
use cavernos\bascode_api\Framework\Actions\RouterAwareAction;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\Router;
use cavernos\bascode_api\Framework\Session\FlashService;
use cavernos\bascode_api\Framework\Session\SessionInterface;
use cavernos\bascode_api\Framework\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AdminForumAction
{
    
    /**
     * renderer
     *
     * @var RendererInterface
     */
    private $renderer;

    /**
     * postTable
     *
     * @var PostTable
     */
    private $postTable;
    
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

    use RouterAwareAction;

    public function __construct(
        RendererInterface $renderer,
        PostTable $postTable,
        Router $router,
        FlashService $flash
    ) {
        $this->flash = $flash;
        $this->router = $router;
        $this->renderer = $renderer;
        $this->postTable = $postTable;
    }

    public function __invoke(ServerRequestInterface $request)
    {
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
        $items = $this->postTable->findPaginated(10, $params['p'] ?? 1);
        return $this->renderer->render('@forum/admin/index', compact('items'));
    }
    
    /**
     * edite un article
     *
     * @param  ServerRequestInterface $request
     * @return ResponseInterface|string
     */
    public function edit(ServerRequestInterface $request): mixed
    {
        $item = $this->postTable->find($request->getAttribute('id'));

        if ($request->getMethod() === 'POST') {
            $params = $this->getParams($request);
            $params['updated_at'] = date('Y-m-d H:i:s');
           
            $validator = $this->getValidator($request);
            if (!empty($validator->isValid())) {
                $this->postTable->update($item->id, $params);
                $this->flash->success('Le topic a bien été modifié');
                return $this->redirect('admin.forum.index');
            }
            $item->slug = $params['slug'];
            $item->name = $params['name'];
            $item->created_by = $params['created_by'];
            $errors = $validator->getErrors();
        }
        return $this->renderer->render('@forum/admin/edit', compact('item', 'errors'));
    }
    
    /**
     * create Crée un nouvel article
     *
     * @param  ServerRequestInterface $request
     * @return ResponseInterface|string
     */
    public function create(ServerRequestInterface $request): mixed
    {
        if ($request->getMethod() === 'POST') {
            $params = $this->getParams($request);
            $params = array_merge($params, [
                'updated_at' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
                'total_messages' => 1,
            ]);
            
            $validator = $this->getValidator($request);
            if (!empty($validator->isValid())) {
                $this->postTable->insert($params);
                $this->flash->success('Le Topic a bien été créé');
                return $this->redirect('admin.forum.index');
            }
            $item = $params;
            $errors = $validator->getErrors();
        }

        return $this->renderer->render('@forum/admin/create', compact('item', 'errors'));
    }
    
    /**
     * delete
     *
     * @param  ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function delete(ServerRequestInterface $request): ResponseInterface
    {
        $this->postTable->delete($request->getAttribute('id'));
        return $this->redirect('admin.forum.index');
    }
    
    /**
     * getParams
     *
     * @param  mixed $request
     * @return array
     */
    private function getParams(ServerRequestInterface $request): array
    {
        return array_filter($request->getParsedBody(), function ($key) {
            return in_array($key, ['name', 'slug', 'created_by']);
        }, ARRAY_FILTER_USE_KEY);
    }

    private function getValidator(ServerRequestInterface $request)
    {
        return (new Validator($request->getParsedBody()))
            ->required('name', 'slug')
            ->length('name', 2, 250)
            ->length('name', 2, 50)
            ->slug('slug');
    }
}
