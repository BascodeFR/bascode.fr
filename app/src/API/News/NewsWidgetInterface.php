<?php
namespace cavernos\bascode_api\API\News;

use Pagerfanta\Pagerfanta;

interface NewsWidgetInterface
{

    public function renderHome(Pagerfanta $news): string;

    public function renderLink(): string;
}
