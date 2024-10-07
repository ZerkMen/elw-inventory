<?php

namespace Inventory\Controllers;

class HomeController extends BaseController
{
    public function index()
    {
        $this->render('home/index', ['title' => 'Home']);
    }
}