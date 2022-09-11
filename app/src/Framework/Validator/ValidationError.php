<?php
namespace cavernos\bascode_api\Framework\Validator;

class ValidationError
{

    private $key;

    private $rule;

    private $attributes;

    private $messages = [
        'required' => "Le champ %s est requis",
        'empty' => "Le champ %s ne peut être vide",
        'slug' => "Le champ %s n'est pas un slug valide",
        'minLength' => "Le champ %s doit contenir plus de %d caracères",
        'maxLength' => "Le champ %s doit contenir moins de %d caracères",
        'betweenLength' => "Le champ %s doit contenir entre %d et %d caracères",
        'datetime' => 'Le champ %s doit être une date valide (%s)',
        'exist' => 'Le champ %s  n\'existe pas dans la table %s',
        'filetype' => 'Le champ %s  n\'est pas au bon format (formats valides: %s)',
        'uploaded' => 'Vous devez Uploader un fichier',
    ];

    public function __construct(string $key, string $rule, array $attributes = [])
    {
        $this->key = $key;
        $this->rule = $rule;
        $this->attributes = $attributes;
    }

    public function __toString()
    {
        $params = array_merge([$this->messages[$this->rule], $this->key], $this->attributes);
        return (string)call_user_func_array('sprintf', $params);
    }
}
