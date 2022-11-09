<?php

class RequestType extends Controller
{
    private $requestTypeModel;

    function __construct()
    {
        $this->requestTypeModel = $this->model("RequestTypeModel");
    }
    function request_type()
    {
        echo json_encode($this->requestTypeModel->get());
    }
}
