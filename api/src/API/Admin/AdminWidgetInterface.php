<?php
namespace cavernos\bascode_api\API\Admin;

interface AdminWidgetInterface
{


    public function render(): string;

    public function renderMenu(): string;
}
