<?php
namespace app\classes;

class Cart
{
    public static function add(int $productId)
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        (!isset($_SESSION['cart'][$productId])) ?
            $_SESSION['cart'][$productId] = 1:
            $_SESSION['cart'][$productId] += 1;
    }

    public static function remove(int $productId)
    {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    }

    public static function clear()
    {
        if (isset($_SESSION['cart'])) {
            unset($_SESSION['cart']);
        }
    }

    public static function getCart()
    {
        return $_SESSION['cart'] ?? [];
    }
}
