<?php
namespace cavernos\bascode_api\API\Auth\Action;

use cavernos\bascode_api\API\Auth\DatabaseAuth;
use cavernos\bascode_api\Framework\Actions\RouterAwareAction;
use cavernos\bascode_api\Framework\Database\NoRecordException;
use cavernos\bascode_api\Framework\Renderer\RendererInterface;
use cavernos\bascode_api\Framework\Response\RedirectResponse;
use cavernos\bascode_api\Framework\Router;
use cavernos\bascode_api\Framework\Session\FlashService;
use cavernos\bascode_api\Framework\Session\SessionInterface;
use cavernos\bascode_api\Framework\Validator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginAttemptAction
{

    public $renderer;

    private $auth;

    private $session;

    private $router;

    use RouterAwareAction;


    public function __construct(
        RendererInterface$renderer,
        DatabaseAuth $auth,
        SessionInterface $session,
        Router $router
    ) {
        $this->session = $session;
        $this->renderer = $renderer;
        $this->auth = $auth;
        $this->router = $router;
    }

    /**
     * @param ServerRequestInterface $request
     * @return string|ResponseInterface|RedirectResponse
     */
    public function __invoke(ServerRequestInterface $request): string|ResponseInterface|RedirectResponse
    {
        $errors = null;
        $params = $request->getParsedBody();
        $params = array_filter($params, function ($key) {
            return in_array($key, ['username', 'password']);
        }, ARRAY_FILTER_USE_KEY);
        $validator = (new Validator($params))
            ->required('username', 'password')
            ->length('username', 3, 255)
            ->length('password', 3, 2000);
        try {
            $user = $this->auth->login($params['username'], $params['password']);
        } catch (NoRecordException $e) {
            (new FlashService($this->session))->error('Identifiants Invalides');
            return $this->redirect('@auth/login');
        }
        if (!$user) {
            (new FlashService($this->session))->error('Identifiants Invalides');
            $errors = $validator->getErrors();
            return $this->renderer->render('@auth/login', compact('errors'));
        } else {
            (new FlashService($this->session))->success('Connection Réussie');
            $path = $this->session->get('auth.redirect') ?:
                $this->router->generateUri('auth.index', ['id' => $user->id]);
            $this->session->delete('auth.redirect');
            return new RedirectResponse($path);
        }
    }
}
