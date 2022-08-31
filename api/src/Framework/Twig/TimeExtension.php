<?php
namespace cavernos\bascode_api\Framework\Twig;

use DateTime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 *
 *  Extensions concernant les DateTime dans Twig
 *
 * @package cavernos\bascode_api\Framework\Twig
 */
class TimeExtension extends AbstractExtension
{
    
    /**
     * getFilters
     *
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('ago', [$this, 'ago'], ['is_safe'  => ['html']])
        ];
    }
    
    
    /**
     * ago
     *
     * @param   $DateTime
     * @param  string $format
     * @return string
     */
    public function ago($date, string $format = 'd/m/Y H:i'): string
    {
        if (is_string($date)) {
            return $date;
        }

        return '<span class="timeago" datetime="'. $date->format(DateTime::ISO8601). '">'
                    . $date->format($format) .
                '</span>';
    }
}
