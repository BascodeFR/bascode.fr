<?php
namespace cavernos\bascode_api\Framework\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

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
            new TwigFilter('excerpt', [$this, 'excerpt'])
        ];
    }
    
    /**
     * excerpt renvoie un extrait du contenu
     *
     * @param  string $content
     * @param  int $maxLength
     * @return string
     */
    public function excerpt(string $content, int $maxLength = 100): string
    {
        if (mb_strlen($content) > $maxLength) {
            $excerpt = mb_substr($content, 0, $maxLength);
            $lastSpace = mb_strrpos($excerpt, ' ');
            return mb_substr($excerpt, 0, $lastSpace) . '...';
        }
        return $content;
    }
}
