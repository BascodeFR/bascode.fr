<?php

namespace cavernos\bascode_api\API\News\Actions;

use cavernos\bascode_api\API\News\Entity\News;
use cavernos\bascode_api\API\News\NewsUpload;
use cavernos\bascode_api\API\News\Table\NewsTable;
use cavernos\bascode_api\Framework\Actions\CrudAction;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\Router;
use cavernos\bascode_api\Framework\Session\FlashService;
use cavernos\bascode_api\Framework\Validator;
use DateTime;
use Psr\Http\Message\ServerRequestInterface;

class NewsCrudAction extends CrudAction
{

    protected $flashMessages = [
        'create' => "L'actualité a bien été créé",
        'edit' => "L'actualité a bien été modifiée"
    ];
    
    protected $viewPath = "@news/admin/news";

    protected $routePrefix = "admin.news";
    
    /**
     * newsUpload
     *
     * @var NewsUpload
     */
    private $newsUpload;

    public function __construct(
        RendererInterface $renderer,
        NewsTable $table,
        Router $router,
        FlashService $flash,
        NewsUpload $newsUpload
    ) {
        parent::__construct($renderer, $table, $router, $flash);
        $this->newsUpload = $newsUpload;
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
        $params['avatar'] = $this->newsUpload->upload($params['avatar'], $news->avatar);
        $params = array_filter($params, function ($key) {
            return in_array($key, ['name', 'slug', 'created_at', 'content', 'avatar']);
        }, ARRAY_FILTER_USE_KEY);
        return array_merge($params, ['updated_at' =>date('Y-m-d H:i:s')]);
    }

    protected function getValidator(ServerRequestInterface $request): Validator
    {
        $validator =  parent::getValidator($request)
        ->required('name', 'slug', 'created_at', 'content')
        ->length('name', 3, 255)
        ->length('slug', 3, 50)
        ->length('content', 5, 6000)
        ->slug('slug')
        ->extension('image', ['jpg', 'png'])
        ->dateTime('created_at');
        if (is_null($request->getAttribute('id'))) {
            $validator->uploaded('avatar');
        }
        return $validator;
    }

    protected function getNewEntity()
    {
        $news = new News();
        $news->created_at = new DateTime();
        $news->updated_at = new DateTime();
        return $news;
    }
}
