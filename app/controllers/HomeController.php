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
        // select * from products p inner join categories c on p.id = c.product_id inner join categoryName cn on c.category_id = cn.id
        $products = $query->select('products p', 'p.id,cn.name as category, p.name as name, price')
        ->where('p.id', '>', 2)
        ->join('categories as c', 'p.id = c.product_id')
        ->join('categoryName cn', 'c.category_id = cn.id')
        ->group('id,category,name,price')
        ->get();


        $products2 = $query->select('products p')->get();

        view('home', ['title' => 'Home','products' => $products]);

        return $response;
    }
}
