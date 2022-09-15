<?php
namespace cavernos\bascode_api\API\Auth;

use cavernos\bascode_api\Framework\Upload;

class AuthUpload extends Upload
{

    protected $path = 'public/upload/avatar';

    protected $formats = [
        'thumb' => [40, 40]
    ];
}
