<?php
namespace app\controllers;

use app\classes\Cart;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CartController
{
    public function store(RequestInterface $request, ResponseInterface $response)
    {
        $productId = json_decode(file_get_contents("php://input"));

        if (!$productId) {
            http_response_code(404);
            die();
        }

        // echo json_encode($productId->productId);

        Cart::add($productId->productId);

        echo json_encode(Cart::getCart());

        return $response;
    }


    public function remove(RequestInterface $request, ResponseInterface $response)
    {
        $id = $_GET['productId'] ?? null;

        if (!$id) {
            http_response_code(404);
            die();
        }

        Cart::remove($id);

        echo json_encode(Cart::getCart());

        return $response;
    }

    public function destroy(RequestInterface $request, ResponseInterface $response)
    {
        Cart::clear();

        echo json_encode(Cart::getCart());

        return $response;
    }
}
