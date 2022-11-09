<?php

class Reason extends Controller
{
    private $reasonModel;

    function __construct()
    {
        $this->reasonModel = $this->model("ReasonModel");
    }
    function reasons_by_id($id)
    {
        echo json_encode($this->reasonModel->getById($id));
    }
}
