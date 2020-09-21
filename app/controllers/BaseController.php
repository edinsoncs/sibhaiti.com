<?php

class BaseController extends Controller
{

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    public function __construct()
    {
        if (Auth::user())
        {
            View::share('role', Auth::user()->role);
            View::share('user', Auth::user());
        }
    }

    protected function setupLayout()
    {
        if (!is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }
    }

}