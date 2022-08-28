<?php
namespace cavernos\bascode_api\Framework\Twig;

use cavernos\bascode_api\Framework\Session\FlashService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FlashExtension extends AbstractExtension
{

    /**
     * flash
     *
     * @var FlashService
     */
    private $flash;
        
    /**
     * __construct
     *
     * @param  FlashService $flash
     * @return void
     */
    public function __construct(FlashService $flash)
    {
        $this->flash = $flash;
    }
 
    
    /**
     * getFunctions
     *
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('flash', [$this, 'getFlash'])
        ];
    }

    public function getFlash(string $type): ?string
    {
        return $this->flash->get($type);
    }
}
