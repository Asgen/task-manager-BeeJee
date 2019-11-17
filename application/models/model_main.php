<?php

class Model_Main extends Model
{
    const TASKS_PER_PAGE = 3;

    function __construct()
    {
        $this->api = new Api();
    }

    public function get_tasks()
    {
        return $this->api->get_tasks();
    }

}
