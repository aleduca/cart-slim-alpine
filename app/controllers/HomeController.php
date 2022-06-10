<?php
namespace app\controllers;

use app\database\Query;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController
{
    public function index(Request $request, Response $response)
    {
        $query = new Query;
        $products = $query->select('products', 'id,name,price')->get();
        // var_dump($products);
        view('home', ['title' => 'Home','products' => $products]);

        return $response;
    }
}
