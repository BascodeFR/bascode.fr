<?php
namespace cavernos\bascode_api\Framework\Twig;

use cavernos\bascode_api\Framework\Database\QueryResult;
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
        } elseif ($type === 'file') {
            $input = $this->file($attributes);
        } elseif ($type === 'checkbox') {
            $input = $this->checkbox($value, $attributes);
        } elseif ($type === 'password') {
            $input = $this->password($value, $attributes);
        } elseif ($type === 'email') {
            $input = $this->email($value, $attributes);
        } elseif (array_key_exists('options', $options)) {
            $input = $this->select($value, $options['options'], $attributes);
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
     * input représente un input
     *
     * @param  ?string $value
     * @param  array $attributes
     * @return string
     */
    private function password(?string $value, array $attributes): string
    {
        return "<input type=\"password\" ".$this->getHtmlFromArray($attributes)." value=\"$value\" />";
    }

        /**
     * input représente un input
     *
     * @param  ?string $value
     * @param  array $attributes
     * @return string
     */
    private function email(?string $value, array $attributes): string
    {
        return "<input type=\"email\" ".$this->getHtmlFromArray($attributes)." value=\"$value\" />";
    }

    private function file(array $attributes): string
    {
        return "<input type=\"file\" ".$this->getHtmlFromArray($attributes)." />";
    }

    private function checkbox(?string $value, array $attributes): string
    {
        $html = "<input type=\"hidden\" name=".$attributes['name']." value=\"0\" />";
        if ($value) {
            $attributes['checked'] = true;
        }
        return $html. "<input type=\"checkbox\" ".$this->getHtmlFromArray($attributes)." value=\"1\" />";
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
     * select représente un select
     *
     * @param  ?string $value
     * @param  array $options
     * @param  array $attributes
     * @return string
     */
    private function select(?string $value, array $options, array $attributes): string
    {
        $htmlOptions = array_reduce(array_keys($options), function (string $html, string $key) use ($options, $value) {
            $params = ['value' => $key, 'selected' => $key === $value];
            return $html . '<option '. $this->getHtmlFromArray($params) .'>'. $options[$key].'</option>';
        }, "");
        return "<select ". $this->getHtmlFromArray($attributes)." />$htmlOptions</select>";
    }
    
    /**
     * getHtmlFromArray Génère du HTMl à partirj d'un tableau
     *
     * @param  array $attributes
     * @return void
     */
    private function getHtmlFromArray(array $attributes)
    {
        $htmlParts = [];
        foreach ($attributes as $key => $value) {
            if ($value === true) {
                $htmlParts[] = (string)$key;
            } elseif ($value !== false) {
                $htmlParts[] = "$key=\"$value\"";
            }
        }
        return implode(' ', $htmlParts);
    }

    private function convertValue($value): string
    {
        if ($value instanceof DateTime) {
            return $value->format('Y-m-d H:i:s');
        }
        return (string)$value;
    }
}
