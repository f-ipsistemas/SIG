<?php
class ErrorController
{
    public function index()
    {
        $response = array();
        $response[] = ['status' => "error", 'description' => "General Fail"];
        echo json_encode($response);
    }

    public function e401()
    {
        require_once 'views/layouts/error/vi_401.php';
    }



}
