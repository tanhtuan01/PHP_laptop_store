<?php

require_once (dirname(__DIR__)) . '/db/order.php';

$orderDb = new Order();

$resource = $_GET['resource'];
$action = $_GET['action'];
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($resource) {
    case 'order':
        // require_once 'api/order.php';
        handleOrderRequest($action, 'GET', $id, $orderDb);
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
