<?php
namespace App\Controllers;
class CaludadorController extends BaseController
{
    public function index(): string
    {
        return view('cotizador/index');
    }
}