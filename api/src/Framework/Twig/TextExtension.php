<?php
namespace cavernos\bascode_api\Framework\Twig;

use Michelf\Markdown;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 *
 *  Extensions concernant les textes dans Twig
 *
 * @package cavernos\bascode_api\Framework\Twig
 */
class TextExtension extends AbstractExtension
{
    
    /**
     * getFilters
     *
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('excerpt', [$this, 'excerpt']),
        ];
    }
    
    /**
     * getIFunctions
     *
     * @return TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('markdown', [$this, 'markdown'], ['is_safe' => ['html']])
        ];
    }
    
    /**
     * excerpt renvoie un extrait du contenu
     *
     * @param  string $content
     * @param  int $maxLength
     * @return string
     */
    public function excerpt(?string $content, int $maxLength = 100): string
    {
        if (is_null($content)) {
            return '';
        }
        if (mb_strlen($content) > $maxLength) {
            $excerpt = mb_substr($content, 0, $maxLength);
            $lastSpace = mb_strrpos($excerpt, ' ');
            return mb_substr($excerpt, 0, $lastSpace) . '...';
        }
        return $content;
    }

    public function markdown(?string $content): string
    {
        if (is_null($content)) {
            return '';
        }
        $content = Markdown::defaultTransform($content);
        return $content;
    }
}
