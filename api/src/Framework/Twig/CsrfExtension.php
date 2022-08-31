<?php
namespace cavernos\bascode_api\Framework\Twig;

use cavernos\bascode_api\Framework\Middleware\CsrfMiddleware;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CsrfExtension extends AbstractExtension
{
    
    /**
     * csrfMiddleware
     *
     * @var CsrfMiddleware
     */
    private $csrfMiddleware;
    
    public function __construct(CsrfMiddleware $csrfMiddleware)
    {
        $this->csrfMiddleware = $csrfMiddleware;
    }
    
    /**
     * getFunctions
     *
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('csrf_input', [$this, 'csrfInput'], ['is_safe' => ['html']])
        ];
    }

    public function csrfInput()
    {
        return '<input type="hidden" name="'.
        $this->csrfMiddleware->getFormKey()
        .'" value="'.
        $this->csrfMiddleware->generateToken() .'"/>';
    }
}
