<?php
require_once (dirname(__DIR__)) . '/db/base.php';
require_once (dirname(__DIR__)) . '/db/order.php';
require_once (dirname(__DIR__)) . '/db/wishlist.php';
$db = new Order();
$orderDb = new Order();
$resource = $_GET['resource'];
$action = $_GET['action'];
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($resource) {
    case 'order':
        // require_once 'api/order.php';
        handleOrderRequest($action, 'GET', $id, $orderDb);
        break;
        
    case 'wishlist':
        handleWishlistRequest($action, $id, $db);
        break;
        
    default:
        header("HTTP/1.1 404 Not Found");
        echo json_encode(["message" => "Resource not found"]);
        break;
}


function handleOrderRequest($action, $method, $id, $orderDb)
{
    switch ($action) {

        case 'findOrderDetailsByOrderId':
            if ($method === 'GET') {
                if ($id) {
                    $order = $orderDb->findOrderDetailsByOrderId($id);
                    echo json_encode($order ?: ["message" => "Order not found"]);
                } else {
                    header("HTTP/1.1 400 Bad Request");
                    echo json_encode(["message" => "Invalid action"]);
                }
            } else {
                header("HTTP/1.1 405 Method Not Allowed");
                echo json_encode(["message" => "Method Not Allowed"]);
            }
            break;

        default:
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["message" => "Invalid action"]);
            break;
    }
}


function handleWishlistRequest($action, $id, $db)
{
    switch ($action) {

        case 'remove':
                if ($id) {
                    $wishlist = $db->delete('t_wishlists',$id);
                    echo json_encode($wishlist ?: ["message" => "Wishlist not found"]);
                } else {
                    header("HTTP/1.1 400 Bad Request");
                    echo json_encode(["message" => "Invalid action"]);
                }
            break;

        default:
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(["message" => "Invalid action"]);
            break;
    }
}