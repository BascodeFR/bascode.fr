<?php
namespace cavernos\bascode_api\API\News;

use Pagerfanta\Pagerfanta;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class NewsTwigExtension extends AbstractExtension
{

    private $widgets;

    public function __construct(array $widgets)
    {
        $this->widgets = $widgets;
    }
    /**
     * getFunctions
     *
     * @return TwigFunction[]
     */
    public function getFunctions():array
    {
        return [
            new TwigFunction('renderHome', [$this, 'renderHome'], ['is_safe' => ['html']]),
            new TwigFunction('renderNewsLink', [$this, 'renderLink'], ['is_safe' => ['html']]),
        ];
    }

    public function renderHome(Pagerfanta $news): string
    {
            return array_reduce($this->widgets, function (string $html, NewsWidgetInterface $widget) use ($news) {
                return $html . $widget->renderHome($news);
            }, '');
    }

    public function renderLink(): string
    {
            return array_reduce($this->widgets, function (string $html, NewsWidgetInterface $widget) {
                return $html . $widget->renderLink();
            }, '');
    }
}
