<?php
namespace cavernos\bascode_api\Framework\Twig;

use DateTime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FormExtension extends AbstractExtension
{

    public function getFunctions()
    {
        return[
            new TwigFunction('field', [$this, 'field'], [
                'is_safe' => ['html'],
                'needs_context' => true
            ]),
        ];
    }
    
    /**
     * field per met de représeter un champ
     *
     * @param  array $context
     * @param  string $key
     * @param  mixed $value
     * @param  ?string $label
     * @param  array $options
     * @return string
     */
    public function field(array $context, string $key, $value, ?string $label = null, array $options = []):string
    {
        $type = $options['type'] ?? 'text';
        $error = $this->getHTMlError($context, $key);
        $class = 'fields admin';
        $value = $this->convertValue($value);
        $attributes = [
            'class' => $options['class'] ??'',
            "name"=> $key,
            "id" => $key,
        ];

        if ($error) {
            $class .= ' has-danger';
        }
        if ($type === 'textarea') {
            $input = $this->textarea($value, $attributes);
        } else {
            $input = $this->input($value, $attributes);
        }
        return "<div class=\"". $class."\">
            <label for=\"$key\">{$label}</label>
            {$input}
            {$error}
        </div>";
    }
    
    /**
     * getHTMlError Récupère les erreur HTML
     *
     * @param  array $context
     * @param  string $key
     * @return string
     */
    private function getHTMlError(array $context, string $key): string
    {
        $error = $context['errors'][$key] ?? false;
        if ($error) {
            return "<small>{$error}</small>";
        }
        return '';
    }
    
    /**
     * input représente un input
     *
     * @param  ?string $value
     * @param  array $attributes
     * @return string
     */
    private function input(?string $value, array $attributes): string
    {
        return "<input type=\"text\" ".$this->getHtmlFromArray($attributes)." value=\"$value\" />";
    }
    /**
     * input représente un textarea
     *
     * @param  ?string $value
     * @param  array $attributes
     * @return string
     */
    private function textarea(?string $value, array $attributes): string
    {
        return "<textarea ".$this->getHtmlFromArray($attributes).">{$value}</textarea>";
    }
    
    /**
     * getHtmlFromArray Génère du HTMl à partirj d'un tableau
     *
     * @param  array $attributes
     * @return void
     */
    private function getHtmlFromArray(array $attributes)
    {
        return implode(' ', array_map(function ($key, $value) {
            return "$key=\"$value\"";
        }, array_keys($attributes), $attributes));
    }

    private function convertValue($value): string
    {
        if ($value instanceof DateTime) {
            return $value->format('Y-m-d H:i:s');
        }
        return (string)$value;
    }
}
