<?php
require './mvc/helpers/validation.php';
require './mvc/helpers/helpers.php';
require './mvc/untils/pagination.php';
require './mvc/untils/session.php';


class Order extends Controller
{
    private $orderModel;

    function __construct()
    {
        $this->orderModel = $this->model("OrderModel");
    }

    function index($page = 1)
    {
        $itemOfPage = 5;
        $total_item = count($this->getOrders());
        $pagInfo = Pagination::pagination($page, $total_item, $itemOfPage);
        $orders = $this->orderModel->pagination($pagInfo['idxStart'], $itemOfPage);
        $configPaginate = [
            'countPage' =>  $pagInfo['countPage'],
            'totalRow' => $total_item,
            'numCurrentItem' => count($orders),
            'currentPage' => $page
        ];
        $url = Domain::get().'/order/index';
        $GLOBALS['navigate']['order'] = $url;
        $this->view('master_layout', [
            'Page' => 'order/index',
            'orders' => $orders,
            'configPaginate' => $configPaginate
        ]);
    }

    function getOrders(){
        return $this->orderModel->get();
    }

    function create()
    {
        $msg_types = array('notify_msg', 'error_msg');
        $message = array('msg_type' => $msg_types[0], 'msg' => []);
        $vals = [
            'food_name' => $_POST['food_name'],
            'note' => $_POST['note']
        ];
        $rules = [
            'food_name' => 'required|max:128',
            'note'  => 'max:128',
        ];
        $result = Validation::validator($vals, $rules);
        if (!empty($result)) {
            $message['msg_type'] = $msg_types[1];
            $message['msg'] = $result;    
        } else {
            if (isset($_POST['orderer'])) {
                $vals = ['orderer' => $_POST['orderer']];
                $rules = ['orderer' => 'required|max:55'];
                $result = Validation::validator($vals, $rules);
                if (!empty($result)) {
                    $message['msg_type'] = $msg_types[1];
                    $message['msg'] = $result;
                } else {
                    $result = $this->orderModel->create($_POST['food_name'], $_POST['note'], $_POST['orderer']);
                    $message['msg'] = $result? 'ORDER_SUCCESS' : 'ORDER_FAILED';
                }
            } else {
                $result = $this->orderModel->create($_POST['food_name'], $_POST['note'], $_COOKIE['username']);
                $message['msg'] = $result? 'ORDER_SUCCESS' : 'ORDER_FAILED';
            }
        }
        Helpers::set_session_and_navigate($message['msg_type'], $message['msg'], 'order/index');
    }
}
