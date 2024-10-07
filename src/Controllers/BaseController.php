<?php

namespace Inventory\Controllers;

use Inventory\Helpers\Auth;
use Inventory\Helpers\Authorization;

class BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Inventory\Helpers\Database::getInstance()->getConnection();
    }

    protected function render($view, $data = [])
    {
        extract($data);
        ob_start();
        include __DIR__ . "/../Views/{$view}.php";
        $content = ob_get_clean();
        include __DIR__ . "/../Views/layout.php";
    }

    protected function requirePermission($permission)
    {
        Authorization::requirePermission($permission);
    }
}