<?php
session_start(); // Ensure session is started
require_once 'Product_Database.php';

class Cart {
    private $items = [];

    public function __construct() {
        $this->loadFromSession(); // Load cart from session on initialization
    }

    // Add a product to the shopping cart
    public function addProduct(Product_Database $product, $quantity = 1) {
        $key = $product->getProductId();
        if (isset($this->items[$key])) {
            $this->items[$key]['quantity'] += $quantity;
        } else {
            $this->items[$key] = [
                'product' => $product,
                'quantity' => $quantity
            ];
        }
        $this->saveToSession();
    }

    // Remove a product from the shopping cart
    public function removeProduct(Product_Database $product, $quantity = 1) {
        $key = $product->getProductId();
        if (isset($this->items[$key])) {
            $this->items[$key]['quantity'] -= $quantity;
            if ($this->items[$key]['quantity'] <= 0) {
                unset($this->items[$key]);
            }
            $this->saveToSession();
        }
    }

    // Get the total price of all items
    public function calculateTotalPrice() {
        $totalPrice = 0;
        foreach ($this->items as $item) {
            $totalPrice += $item['product']->getPrice() * $item['quantity'];
        }
        return $totalPrice;
    }

    // Get all items in the cart
    public function getItems() {
        return $this->items;
    }

    // Clear the shopping cart
    public function clearCart() {
        $this->items = [];
        $this->saveToSession();
    }

    // Save the cart to session
    private function saveToSession() {
        $_SESSION['cart'] = $this->items;
    }

    // Load the cart from session
    public function loadFromSession() {
        if (isset($_SESSION['cart'])) {
            $this->items = $_SESSION['cart'];
        }
    }
}
?>