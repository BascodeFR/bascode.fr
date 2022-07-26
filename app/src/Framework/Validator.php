<?php

namespace cavernos\bascode_api\Framework;

use cavernos\bascode_api\Framework\Database\Table;
use cavernos\bascode_api\Framework\Validator\ValidationError;
use DateTime;
use PDO;
use Psr\Http\Message\UploadedFileInterface;

class Validator
{

    private const MIME_TYPES = [
        'jpg' => 'image/jpeg',
        'png' => 'image/png'
    ];
    
    /**
     * params
     *
     * @var array
     */
    private $params;

    
    /**
     * errors
     *
     * @var string[]
     */
    private $errors = [];

    public function __construct(array $params)
    {
        $this->params = $params;
    }
    
    /**
     * required Vérifie que les champs sont dans le tableau
     *
     * @param  string $keys
     * @return self
     */
    public function required(string ...$keys): self
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value)) {
                $this->addError($key, 'required');
            }
        }
        return $this;
    }

    public function notEmpty(string ...$keys): self
    {
        foreach ($keys as $key) {
            $value = $this->getValue($key);
            if (is_null($value) || empty($value)) {
                $this->addError($key, 'empty');
            }
        }
        return $this;
    }
    
    /**
     * length Vérifie que l'élément respècte la taille limite
     *
     * @param  string $key
     * @param  ?int $min
     * @param  ?int $max
     * @return self
     */
    public function length(string $key, ?int $min, ?int $max = null): self
    {
        $value = $this->getValue($key);
        $length = mb_strlen($value);
        if (!is_null($min) && !is_null($max) && ($length < $min || $length > $max)) {
            $this->addError($key, 'betweenLength', [$min, $max]);
            return $this;
        }
        if (!is_null($min) &&
        $length < $min) {
            $this->addError($key, 'minLength', [$min]);
            return $this;
        }
        if (!is_null($max) &&
        $length > $max) {
            $this->addError($key, 'maxLength', [$max]);
            return $this;
        }
        return $this;
    }
    
    /**
     * slug Vérifie que l'élément est un slug
     *
     * @param  string $keys
     * @return self
     */
    public function slug(string $key): self
    {
        $value = $this->getValue($key);
        $pattern = '/^[a-z0-9]+(-[a-z0-9]+)*$/';
        if (!is_null($value) && !preg_match($pattern, $value)) {
            $this->addError($key, 'slug');
        }
        return $this;
    }

        /**
     * dateTime Vérifie que l'élément est une date valide
     *
     * @param  string $keys
     * @param  string $format
     * @return self
     */
    public function dateTime(string $key, string $format = "Y-m-d H:i:s"): self
    {
        $value = $this->getValue($key);
        $date = DateTime::createFromFormat($format, $value);
        $error = DateTime::getLastErrors();
        if ($error['error_count'] > 0 || $error['warning_count'] > 0 || $date === false) {
            $this->addError($key, 'datetime', [$format]);
            return $this;
        };
        
        
        return $this;
    }

      /**
     * exists
     *
     * @param string $key
     * @param  int $id
     * @param  Table $table
     * @return self
     */
    public function exists(string $key, string $table, PDO $pdo): self
    {
        $value = $this->getValue($key);
        $statement = $pdo->prepare("SELECT id FROM $table WHERE id = ?");
        $statement->execute([$value]);
        if ($statement->fetchColumn() === false) {
            $this->addError($key, 'exists', [$table]);
            return $this;
        };
        return $this;
    }

    public function isValid(): bool
    {
        return empty($this->errors);
    }

    public function uploaded(string $key): self
    {
        $file = $this->getValue($key);
        if ($file === null || $file->getError() !== UPLOAD_ERR_OK) {
            $this->addError($key, 'uploaded');
        }
        return $this;
    }
    
    
    /**
     * extension
     *
     * @param  string $key
     * @param  array $extensions
     * @return self
     */
    public function extension(string $key, array $extensions): self
    {
        
        /** @var UploadedFileInterface $file */
        $file = $this->getValue($key);
        if ($file !== null && $file->getError() === UPLOAD_ERR_OK) {
            $type = $file->getClientMediaType();
            $extension = mb_strtolower(pathinfo($file->getClientFilename(), PATHINFO_EXTENSION));
            $expectedType = self::MIME_TYPES[$extension] ?? null;
            if (!in_array($extension, $extensions) || $expectedType !== $type) {
                $this->addError($key, 'filetype', [join(',', $extensions)]);
            }
        }

        return $this;
    }
    
    /**
     * getErrors
     *
     * @return ValidationError
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
    
    /**
     * addError
     *
     * @param  string $key
     * @param  string $rule
     * @return void
     */
    private function addError(string $key, string $rule, array $attributes = [])
    {
        $this->errors[$key] = new ValidationError($key, $rule, $attributes);
    }

    private function getValue(string $key): mixed
    {
        if (array_key_exists($key, $this->params)) {
            return $this->params[$key];
        }
        return null;
    }
}
