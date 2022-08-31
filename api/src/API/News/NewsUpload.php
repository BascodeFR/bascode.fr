<?php
namespace cavernos\bascode_api\API\News;

use cavernos\bascode_api\Framework\Upload;

class NewsUpload extends Upload
{

    protected $path = 'public/upload/news';

    protected $formats = [
        'thumb' => [106, 106]
    ];
}
