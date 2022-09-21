<?php

namespace cavernos\bascode_api\API\News\Actions;

use cavernos\bascode_api\API\Auth\Table\UserTable;
use cavernos\bascode_api\API\News\Entity\News;
use cavernos\bascode_api\API\News\NewsUpload;
use cavernos\bascode_api\API\News\Table\NewsTable;
use cavernos\bascode_api\Framework\Actions\CrudAction;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\Router;
use cavernos\bascode_api\Framework\Session\FlashService;
use cavernos\bascode_api\Framework\Validator;
use DateTime;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NewsCrudAction extends CrudAction
{

    protected array $flashMessages = [
        'create' => "L'actualité a bien été créé",
        'edit' => "L'actualité a bien été modifiée",
        'delete' => "L'actualité a bien été suprimée"
    ];
    
    protected string $viewPath = "@news/admin/news";

    protected string $routePrefix = "admin.news";
    
    /**
     * newsUpload
     *
     * @var NewsUpload
     */
    private NewsUpload $newsUpload;
    
    /**
     * userTable
     *
     * @var UserTable
     */
    private UserTable $userTable;

    public function __construct(
        RendererInterface $renderer,
        NewsTable $table,
        Router $router,
        FlashService $flash,
        NewsUpload $newsUpload,
        UserTable $userTable
    ) {
        parent::__construct($renderer, $table, $router, $flash);
        $this->newsUpload = $newsUpload;
        $this->userTable= $userTable;
    }
    public function delete(ServerRequestInterface $request): ResponseInterface
    {
        $new = $this->table->find($request->getAttribute('id'));
        $this->newsUpload->delete($new->avatar);
        return parent::delete($request);
    }
    /**
     * getParams
     *
     * @param  ServerRequestInterface $request
     * @param  News $news
     * @return array
     */
    protected function getParams(ServerRequestInterface $request, $news): array
    {
        $params = array_merge($request->getParsedBody(), $request->getUploadedFiles());
        // Uploader le Fichier
        $image = $this->newsUpload->upload($params['avatar'], $news->avatar);
        if ($image !== null) {
            $params['avatar'] = $image;
        } else {
            unset($params['avatar']);
        }
       
        $params = array_filter($params, function ($key) {
            return in_array($key, ['name', 'slug', 'created_at', 'content', 'avatar', 'public', 'user_id']);
        }, ARRAY_FILTER_USE_KEY);
        return array_merge($params, ['updated_at' =>date('Y-m-d H:i:s')]);
    }

    protected function getValidator(ServerRequestInterface $request): Validator
    {
        $validator =  parent::getValidator($request)
        ->required('name', 'slug', 'created_at', 'content', 'user_id')
        ->length('name', 3, 255)
        ->length('slug', 3, 50)
        ->length('content', 5, 6000)
        ->exists('user_id', $this->userTable->getTable(), $this->userTable->getPdo())
        ->slug('slug')
        ->extension('image', ['jpg', 'png'])
        ->dateTime('created_at');
        if (is_null($request->getAttribute('id'))) {
            $validator->uploaded('avatar');
        }
        return $validator;
    }

    protected function getNewEntity(): News
    {
        $news = new News();
        $news->createdAt = new DateTime();
        $news->updatedAt = new DateTime();
        return $news;
    }

    protected function formParams(array $params): array
    {
        $params['users'] = $this->userTable->findList();
        return $params;
    }
}
