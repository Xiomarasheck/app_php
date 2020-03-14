<?php

class helper
{

    /**
     * @param $controller
     * @param $action
     * @return string
     */
    public function url($controller, $action)
    {
        $urlString = "index.php?controller=" . $controller . "&action=" . $action;
        return $urlString;
    }


}