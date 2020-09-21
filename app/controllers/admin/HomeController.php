<?php

class Admin_HomeController extends Admin_BaseController {

    public function __construct()
    {
        parent::__construct();

        $this->js_files = array_merge($this->js_files, array('../frontapp/bootstrap/js/jquery.js'));
        $this->js_files = array_merge($this->js_files, array('../frontapp/bootstrap/js/bootstrap.min.js'));
        $this->css_files = array_merge($this->css_files, array('../frontapp/bootstrap/css/bootstrap.min.css'));
    }

    public function index()
    {
        $title = 'Pòtay Admin';
        return View::make('admin/home/index')
                        ->with('title', $title)
                        ->with('lang', 'en')
                        ->with('html_body', '<b>Welcome!</b>')
                        ->with('js_files', $this->js_files)
                        ->with('css_files', $this->css_files);
    }

    public function dashboard()
    {
        $page_id = 'admin_dashboard';
        $title = 'Admin Dashboard';
        $errors = array();
        $departments = User::departments();
        $search = array();

        if (Input::get('search'))
        {
            $header = array();
            $search = Input::get('search');
            $type = array_get($search, 'type');
            $text = array_get($search, 'text');
            $department = array_get($search, 'department');
            $city = array_get($search, 'city');
            $city = ($city != "Chwazi komin...") ? $city : "";
            $obj = array_get($search, 'obj');
            $list = NULL;

            if ($type == 'eleveur')
            {
                $header = array('siyati ak non', 'Telefòn', 'Cheptèl', 'CIN', '#fich', 'Depatman', 'komin', 'seksyon', '');

                $query = Eleveur::orderBy('created_at', 'desc');

                if ($obj != "" && $text != "")
                {
                    if ($obj == 'cin')
                    {
                        $query->where('cin', 'LIKE', '%' . $text . '%');
                    }
                }
                else if ($text != "")
                {
                    $query->where(function ($q)
                    {
                        $search = Input::get('search');
                        $text = array_get($search, 'text');
                        $q->where('fName', 'LIKE', '%' . $text . '%')
                                ->orWhere('lName', 'LIKE', '%' . $text . '%');
                    });
                }

                if ($department != "")
                {
                    $query->where('department', $department);
                }

                if ($city != "")
                {
                    $query->where('city', $city);
                }

                $list = $query->paginate(20);
            }
            else if ($type == 'agent')
            {
                $header = array('siyati ak non', 'Telefòn', '#so', 'Depatman', 'komin', 'seksyon', 'Tip Ajan');

                $query = Agent::where('isActv', TRUE)->orderBy('created_at', 'desc');

                if ($obj != "" && $text != "")
                {
                    if ($obj == 'cin')
                    {
                        $query->where('cin', 'LIKE', '%' . $text . '%');
                    }
                    if ($obj == 'so')
                    {
                        $query->where('so', 'LIKE', '%' . $text . '%');
                    }
                }
                else if ($text != "")
                {
                    $query->where(function ($q)
                    {
                        $search = Input::get('search');
                        $text = array_get($search, 'text');
                        $q->where('fName', 'LIKE', '%' . $text . '%')
                                ->orWhere('lName', 'LIKE', '%' . $text . '%');
                    });
                }

                if ($department != "")
                {
                    $query->where('department', $department);
                }

                if ($city != "")
                {
                    $query->where('city', $city);
                }

                $list = $query->paginate(20);
            }
            else if ($type == 'animal')
            {
                $header = array('#Tag', '#Kanè', 'Elvè', '#So', 'Depatman', 'komin', 'seksyon');

                $query = Animal::orderBy('created_at', 'desc');

                if ($obj != "" && $text != "")
                {
                    if ($obj == 'tag')
                    {
                        $query->where('tag', 'LIKE', '%' . $text . '%');
                    }
                    if ($obj == 'so')
                    {
                        $query->where('so', 'LIKE', '%' . $text . '%');
                    }
                    if ($obj == 'kane')
                    {
                        $query->where('carnet', 'LIKE', '%' . $text . '%');
                    }
                }

                if ($department != "")
                {
                    $query->where('department', $department);
                }

                if ($city != "")
                {
                    $query->where('city', $city);
                }

                $list = $query->paginate(20);
            }
            else if ($type == 'abattoir')
            {
                $header = array('NON', 'TIP', 'TOTAL BÈF', 'KABRIT', 'MOUTON', 'KOCHON', 'BÈF', 'DEPATMAN', 'KOMIN', 'SEKSYON');

                $query = Abattoir::orderBy('created_at', 'desc');

                if ($text != "")
                {
                    $query->where(function ($q)
                    {
                        $search = Input::get('search');
                        $text = array_get($search, 'text');
                        $q->where('name', 'LIKE', '%' . $text . '%')
                                ->orWhere('phone', 'LIKE', '%' . $text . '%');
                    });
                }

                if ($department != "")
                {
                    $query->where('dept', $department);
                }

                if ($city != "")
                {
                    $query->where('city', $city);
                }

                $list = $query->paginate(20);
            }

            return View::make('admin.home.search')
                            ->with('page_id', $page_id)
                            ->with('errors', $errors)
                            ->with('title', $title)
                            ->with('departments', $departments)
                            ->with('search', $search)
                            ->with('list', $list)
                            ->with('header', $header)
                            ->with('type', $type);
        }
        else if (Input::get('filter'))
        {
            $form_data = Input::get('filter');
            //dd($form_data);
            $dept = array_get($form_data, 'department');
            $city = (array_get($form_data, 'city') != "Chwazi komin...") ? array_get($form_data, 'city') : NULL;
            $department = User::getDepartmentOBJ($dept);
            return View::make('admin.home.dashboard')
                            ->with('page_id', $page_id)
                            ->with('errors', $errors)
                            ->with('title', $title)
                            ->with('department', $department)
                            ->with('city', $city)
                            ->with('departments', $departments)
                            ->with('filters', $form_data);
        }

        return View::make('admin.home.dashboard')
                        ->with('page_id', $page_id)
                        ->with('errors', $errors)
                        ->with('title', $title)
                        ->with('departments', $departments)
                        ->with('search', $search);
    }

    public function stats()
    {
        $page_id = 'admin_stats';
        $title = 'Admin - Remak';
        $errors = array();
        $departments = User::departments();
        $search = array();

        if (Input::get('search'))
        {
            $header = array();
            $search = Input::get('search');
            $type = array_get($search, 'type');
            $text = array_get($search, 'text');
            $department = array_get($search, 'department');
            $city = array_get($search, 'city');
            $city = ($city != "Chwazi komin...") ? $city : "";
            $obj = array_get($search, 'obj');
            $list = NULL;

            if ($type == 'eleveur')
            {
                $header = array('Non', '#Elvè', 'CIN', '#fich', 'Depatman', 'komin', 'seksyon');

                $query = Eleveur::orderBy('created_at', 'desc');

                if ($obj != "" && $text != "")
                {
                    if ($obj == 'cin')
                    {
                        $query->where('cin', 'LIKE', '%' . $text . '%');
                    }
                }
                else if ($text != "")
                {
                    $query->where(function ($q)
                    {
                        $search = Input::get('search');
                        $text = array_get($search, 'text');
                        $q->where('fName', 'LIKE', '%' . $text . '%')
                                ->orWhere('lName', 'LIKE', '%' . $text . '%');
                    });
                }

                if ($department != "")
                {
                    $query->where('department', $department);
                }

                if ($city != "")
                {
                    $query->where('city', $city);
                }

                $list = $query->paginate(20);
            }
            else if ($type == 'agent')
            {
                $header = array('siyati ak non', 'telefòn', '#so', 'Depatman', 'komin', 'seksyon');

                $query = Agent::where('isActv', TRUE)->orderBy('created_at', 'desc');

                if ($obj != "" && $text != "")
                {
                    if ($obj == 'cin')
                    {
                        $query->where('cin', 'LIKE', '%' . $text . '%');
                    }
                    if ($obj == 'so')
                    {
                        $query->where('so', 'LIKE', '%' . $text . '%');
                    }
                }
                else if ($text != "")
                {
                    $query->where(function ($q)
                    {
                        $search = Input::get('search');
                        $text = array_get($search, 'text');
                        $q->where('fName', 'LIKE', '%' . $text . '%')
                                ->orWhere('lName', 'LIKE', '%' . $text . '%');
                    });
                }

                if ($department != "")
                {
                    $query->where('department', $department);
                }

                if ($city != "")
                {
                    $query->where('city', $city);
                }

                $list = $query->paginate(20);
            }
            else if ($type == 'animal')
            {
                $header = array('#Tag', '#Kanè', 'Elvè', '#So', 'Depatman', 'komin', 'seksyon');

                $query = Animal::orderBy('created_at', 'desc');

                if ($obj != "" && $text != "")
                {
                    if ($obj == 'tag')
                    {
                        $query->where('tag', 'LIKE', '%' . $text . '%');
                    }
                    if ($obj == 'so')
                    {
                        $query->where('so', 'LIKE', '%' . $text . '%');
                    }
                    if ($obj == 'kane')
                    {
                        $query->where('carnet', 'LIKE', '%' . $text . '%');
                    }
                }

                if ($department != "")
                {
                    $query->where('department', $department);
                }

                if ($city != "")
                {
                    $query->where('city', $city);
                }

                $list = $query->paginate(20);
            }
            else if ($type == 'abattoir')
            {
                $header = array('NON', 'TIP', 'TOTAL BÈF', 'KABRIT', 'MOUTON', 'KOCHON', 'BÈF', 'DEPATMAN', 'KOMIN', 'SEKSYON');

                $query = Abattoir::orderBy('created_at', 'desc');

                if ($text != "")
                {
                    $query->where(function ($q)
                    {
                        $search = Input::get('search');
                        $text = array_get($search, 'text');
                        $q->where('name', 'LIKE', '%' . $text . '%')
                                ->orWhere('phone', 'LIKE', '%' . $text . '%');
                    });
                }

                if ($department != "")
                {
                    $query->where('dept', $department);
                }

                if ($city != "")
                {
                    $query->where('city', $city);
                }

                $list = $query->paginate(20);
            }

            return View::make('admin.home.search')
                            ->with('page_id', $page_id)
                            ->with('errors', $errors)
                            ->with('title', $title)
                            ->with('departments', $departments)
                            ->with('search', $search)
                            ->with('list', $list)
                            ->with('header', $header)
                            ->with('type', $type);
        }
        else if (Input::get('filter'))
        {
            $form_data = Input::get('filter');
            //dd($form_data);
            $dept = array_get($form_data, 'department');
            $city = (array_get($form_data, 'city') != "Chwazi komin...") ? array_get($form_data, 'city') : NULL;
            $department = User::getDepartmentOBJ($dept);
            return View::make('admin.home.dashboard')
                            ->with('page_id', $page_id)
                            ->with('errors', $errors)
                            ->with('title', $title)
                            ->with('department', $department)
                            ->with('city', $city)
                            ->with('departments', $departments)
                            ->with('filters', $form_data);
        }

        return View::make('admin.home.stats')
                        ->with('page_id', $page_id)
                        ->with('errors', $errors)
                        ->with('title', $title)
                        ->with('departments', $departments)
                        ->with('search', $search);
    }

    public function oldstats()
    {
        $page_id = 'admin_stats';
        $title = 'Admin - Remak';
        $errors = array();
        $departments = User::departments();
        $search = array();

        if (Input::get('search'))
        {
            $header = array();
            $search = Input::get('search');
            $type = array_get($search, 'type');
            $text = array_get($search, 'text');
            $department = array_get($search, 'department');
            $city = array_get($search, 'city');
            $city = ($city != "Chwazi komin...") ? $city : "";
            $obj = array_get($search, 'obj');
            $list = NULL;

            if ($type == 'eleveur')
            {
                $header = array('Non', '#Elvè', 'CIN', '#fich', 'Depatman', 'komin', 'seksyon');

                $query = Eleveur::orderBy('created_at', 'desc');

                if ($obj != "" && $text != "")
                {
                    if ($obj == 'cin')
                    {
                        $query->where('cin', 'LIKE', '%' . $text . '%');
                    }
                }
                else if ($text != "")
                {
                    $query->where(function ($q)
                    {
                        $search = Input::get('search');
                        $text = array_get($search, 'text');
                        $q->where('fName', 'LIKE', '%' . $text . '%')
                                ->orWhere('lName', 'LIKE', '%' . $text . '%');
                    });
                }

                if ($department != "")
                {
                    $query->where('department', $department);
                }

                if ($city != "")
                {
                    $query->where('city', $city);
                }

                $list = $query->paginate(20);
            }
            else if ($type == 'agent')
            {
                $header = array('siyati ak non', 'telefòn', '#so', 'Depatman', 'komin', 'seksyon');

                $query = Agent::where('isActv', TRUE)->orderBy('created_at', 'desc');

                if ($obj != "" && $text != "")
                {
                    if ($obj == 'cin')
                    {
                        $query->where('cin', 'LIKE', '%' . $text . '%');
                    }
                    if ($obj == 'so')
                    {
                        $query->where('so', 'LIKE', '%' . $text . '%');
                    }
                }
                else if ($text != "")
                {
                    $query->where(function ($q)
                    {
                        $search = Input::get('search');
                        $text = array_get($search, 'text');
                        $q->where('fName', 'LIKE', '%' . $text . '%')
                                ->orWhere('lName', 'LIKE', '%' . $text . '%');
                    });
                }

                if ($department != "")
                {
                    $query->where('department', $department);
                }

                if ($city != "")
                {
                    $query->where('city', $city);
                }

                $list = $query->paginate(20);
            }
            else if ($type == 'animal')
            {
                $header = array('#Tag', '#Kanè', 'Elvè', '#So', 'Depatman', 'komin', 'seksyon');

                $query = Animal::orderBy('created_at', 'desc');

                if ($obj != "" && $text != "")
                {
                    if ($obj == 'tag')
                    {
                        $query->where('tag', 'LIKE', '%' . $text . '%');
                    }
                    if ($obj == 'so')
                    {
                        $query->where('so', 'LIKE', '%' . $text . '%');
                    }
                    if ($obj == 'kane')
                    {
                        $query->where('carnet', 'LIKE', '%' . $text . '%');
                    }
                }

                if ($department != "")
                {
                    $query->where('department', $department);
                }

                if ($city != "")
                {
                    $query->where('city', $city);
                }

                $list = $query->paginate(20);
            }
            else if ($type == 'abattoir')
            {
                $header = array('NON', 'TIP', 'TOTAL BÈF', 'KABRIT', 'MOUTON', 'KOCHON', 'BÈF', 'DEPATMAN', 'KOMIN', 'SEKSYON');

                $query = Abattoir::orderBy('created_at', 'desc');

                if ($text != "")
                {
                    $query->where(function ($q)
                    {
                        $search = Input::get('search');
                        $text = array_get($search, 'text');
                        $q->where('name', 'LIKE', '%' . $text . '%')
                                ->orWhere('phone', 'LIKE', '%' . $text . '%');
                    });
                }

                if ($department != "")
                {
                    $query->where('dept', $department);
                }

                if ($city != "")
                {
                    $query->where('city', $city);
                }

                $list = $query->paginate(20);
            }

            return View::make('admin.home.search')
                            ->with('page_id', $page_id)
                            ->with('errors', $errors)
                            ->with('title', $title)
                            ->with('departments', $departments)
                            ->with('search', $search)
                            ->with('list', $list)
                            ->with('header', $header)
                            ->with('type', $type);
        }
        else if (Input::get('filter'))
        {
            $form_data = Input::get('filter');
            //dd($form_data);
            $dept = array_get($form_data, 'department');
            $city = (array_get($form_data, 'city') != "Chwazi komin...") ? array_get($form_data, 'city') : NULL;
            $department = User::getDepartmentOBJ($dept);
            return View::make('admin.home.dashboard')
                            ->with('page_id', $page_id)
                            ->with('errors', $errors)
                            ->with('title', $title)
                            ->with('department', $department)
                            ->with('city', $city)
                            ->with('departments', $departments)
                            ->with('filters', $form_data);
        }

        return View::make('admin.home.stats')
                        ->with('page_id', $page_id)
                        ->with('errors', $errors)
                        ->with('title', $title)
                        ->with('departments', $departments)
                        ->with('search', $search);
    }

    public function olddashboard()
    {
        $page_id = 'admin_dashboard';
        $title = 'Admin Dashboard';
        $errors = array();
        $departments = User::departments();
        $search = array();

        if (Input::get('search'))
        {
            $header = array();
            $search = Input::get('search');
            $type = array_get($search, 'type');
            $text = array_get($search, 'text');
            $department = array_get($search, 'department');
            $city = array_get($search, 'city');
            $city = ($city != "Chwazi komin...") ? $city : "";
            $obj = array_get($search, 'obj');
            $list = NULL;

            if ($type == 'eleveur')
            {
                $header = array('Non', '#Elvè', 'CIN', '#fich', 'Depatman', 'komin', 'seksyon kominal', '');

                $query = Eleveur::orderBy('created_at', 'desc');

                if ($obj != "" && $text != "")
                {
                    if ($obj == 'cin')
                    {
                        $query->where('cin', 'LIKE', '%' . $text . '%');
                    }
                }

                if ($department != "")
                {
                    $query->where('department', $department);
                }

                if ($city != "")
                {
                    $query->where('city', $city);
                }
                /*
                  if ($text != "")
                  {
                  $query->where('fName', 'LIKE', '%' . $text . '%')
                  ->orWhere('lName', 'LIKE', '%' . $text . '%')
                  ->orWhere('idEleveur', 'LIKE', '%' . $text . '%');
                  }
                 */
                $list = $query->paginate(20);
            }
            else if ($type == 'agent')
            {
                $header = array('siyati ak non', 'Telefòn', '#so', 'Depatman', 'komin', 'seksyon', '');

                $query = Agent::where('isActv', TRUE)->orderBy('created_at', 'desc');

                if ($obj != "" && $text != "")
                {
                    if ($obj == 'cin')
                    {
                        $query->where('cin', 'LIKE', '%' . $text . '%');
                    }
                    if ($obj == 'so')
                    {
                        $query->where('so', 'LIKE', '%' . $text . '%');
                    }
                }

                if ($department != "")
                {
                    $query->where('department', $department);
                }

                if ($city != "")
                {
                    $query->where('city', $city);
                }
                /*
                  if ($text != "")
                  {
                  $query->where('fName', 'LIKE', '%' . $text . '%')
                  ->orWhere('lName', 'LIKE', '%' . $text . '%');
                  }
                 */
                $list = $query->paginate(20);
            }
            else if ($type == 'animal')
            {
                $header = array('#Tag', '#Kanè', 'Elvè', '#So', 'Depatman', 'komin', 'seksyon', '');

                $query = Animal::orderBy('created_at', 'desc');

                if ($obj != "" && $text != "")
                {
                    if ($obj == 'tag')
                    {
                        $query->where('tag', 'LIKE', '%' . $text . '%');
                    }
                    if ($obj == 'so')
                    {
                        $query->where('so', 'LIKE', '%' . $text . '%');
                    }
                    if ($obj == 'kane')
                    {
                        $query->where('carnet', 'LIKE', '%' . $text . '%');
                    }
                }

                if ($department != "")
                {
                    $query->where('department', $department);
                }

                if ($city != "")
                {
                    $query->where('city', $city);
                }

                $list = $query->paginate(20);
            }

            return View::make('admin.home.search')
                            ->with('page_id', $page_id)
                            ->with('errors', $errors)
                            ->with('title', $title)
                            ->with('departments', $departments)
                            ->with('search', $search)
                            ->with('list', $list)
                            ->with('header', $header)
                            ->with('type', $type);
        }

        return View::make('admin.home.dashboard')
                        ->with('page_id', $page_id)
                        ->with('errors', $errors)
                        ->with('title', $title)
                        ->with('departments', $departments)
                        ->with('search', $search);
    }

    public function department($id)
    {
        $page_id = 'admin_dashboard';
        $title = 'Admin Dashboard';
        $errors = array();

        $department = NULL;
        if ($id != NULL)
        {
            $deparments = User::departments();
            foreach ($deparments as $item)
            {
                if (array_get($item, 'id') == $id)
                {
                    $department = $item;
                }
            }
        }
        return View::make('admin.home.department')
                        ->with('page_id', $page_id)
                        ->with('errors', $errors)
                        ->with('title', $title)
                        ->with('deparment', $department);
    }

    public function city($dept, $cit)
    {
        $page_id = 'admin_dashboard';
        $title = 'Admin Dashboard';
        $errors = array();

        $department = NULL;
        $city = NULL;
        if ($dept != NULL)
        {
            $deparments = User::departments();
            foreach ($deparments as $item)
            {
                if (array_get($item, 'id') == $dept)
                {
                    $department = $item;
                    $cities = array_get($department, 'cities');
                    foreach ($cities as $c)
                    {
                        if (array_get($c, 'id') == $cit)
                        {
                            $city = $c;
                            break;
                        }
                    }
                }
            }
        }

        return View::make('admin.home.city')
                        ->with('page_id', $page_id)
                        ->with('errors', $errors)
                        ->with('title', $title)
                        ->with('department', $department)
                        ->with('city', $city);
    }

    public function statinfo()
    {
        if (!$this->user)
        {
            Auth::logout();
            return Redirect::to(URL::route('/'));
        }

        $errors = array();
        $search = array();
        $page_id = 'statinfo';
        $title = 'Bèf Ki Idantifye Pa Dat';
        $months = array('janvye', 'fevrye', 'mas', 'avril', 'me', 'jwen', 'Jiyè', 'daout', 'septanm', 'oktòb', 'novanm', 'desanm');
        $years = array();
        $departments = User::departments();
        $init = 2013;
        $currentY = date('Y');
        for ($i = $init; $i <= $currentY; $i++)
        {
            array_push($years, $i);
        }

        $filterYears = array();
        $animals = array();
        $agents = array();
        $abattoirs = array();
        $eleveurs = array();

        if (Input::get('search'))
        {
            $search = Input::get('search');
            $start = (array_get($search, 'start_year')) ? array_get($search, 'start_year') : date('Y');
            $start .= "-";
            $start .= (array_get($search, 'start_month') != "") ? array_get($search, 'start_month') : '00';
            $start .= "-00 00:00:00";

            $end = (array_get($search, 'end_year')) ? array_get($search, 'end_year') : date('Y');
            $end .= "-";
            $end .= (array_get($search, 'end_month') != "") ? array_get($search, 'end_month') : '12';
            $end .= "-31 00:00:00";

            $search['start'] = $start;
            $search['end'] = $end;

            if (array_get($search, 'start_year') && array_get($search, 'end_year'))
            {
                for ($y = array_get($search, 'start_year'); $y <= array_get($search, 'end_year'); $y++)
                {
                    array_push($filterYears, $y);
                }
            }

            if (array_get($search, 'type'))
            {
                if (array_get($search, 'type') == 'animal')
                {
                    $animal_titles = array('Bèf Idantifye', 'Bèf ki mouri', 'Bèf ki pran vaksen', 'Bèf dominiken', 'Bèf Lòt Peyi');

                    //--------datIdant-------------------------------------------------------------------------
                    $animals_datIdant_total = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', FALSE)->where('datIdant', '<>', '');
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    $animals_datIdant_male = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', FALSE)->where('datIdant', '<>', '')->where('type', 'm');
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    $animals_datIdant_female = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', FALSE)->where('datIdant', '<>', '')->where('type', 'f');
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    $animals_datIdant_unknow = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', FALSE)->where('datIdant', '<>', '')->where('type', 's');
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    //---------isDead------------------------------------------------------------------------

                    $animals_isDead_total = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', TRUE);
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    $animals_isDead_male = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', TRUE)->where('type', 'm');
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    $animals_isDead_female = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', TRUE)->where('type', 'f');
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    $animals_isDead_unknow = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', TRUE)->where('type', 's');
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    //----------isVaccinated-----------------------------------------------------------------------

                    $animals_isVaccinated_total = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', FALSE)->where('isVaccinated', 'o');
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    $animals_isVaccinated_male = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', FALSE)->where('isVaccinated', 'o')->where('type', 'm');
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    $animals_isVaccinated_female = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', FALSE)->where('isVaccinated', 'o')->where('type', 'f');
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    $animals_isVaccinated_unknow = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', FALSE)->where('isVaccinated', 'o')->where('type', 's');
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    //----------dominicaines-----------------------------------------------------------------------

                    $animals_country_domi_total = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', FALSE)->where('country', TRUE);
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    $animals_country_domi_male = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', FALSE)->where('country', TRUE)->where('type', 'm');
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    $animals_country_domi_female = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', FALSE)->where('country', TRUE)->where('type', 'f');
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    $animals_country_domi_unknow = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', FALSE)->where('country', TRUE)->where('type', 's');
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    //----------ayisyèn-----------------------------------------------------------------------

                    $animals_country_hait_total = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', FALSE)->where('country', FALSE);
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    $animals_country_hait_male = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', FALSE)->where('country', FALSE)->where('type', 'm');
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    $animals_country_hait_female = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', FALSE)->where('country', FALSE)->where('type', 'f');
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    $animals_country_hait_unknow = Animal::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE)->where('isDead', FALSE)->where('country', FALSE)->where('type', 's');
                                if (array_get($search, 'start'))
                                {
                                    $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    //----------isVaccinated-----------------------------------------------------------------------

                    foreach ($animal_titles as $k => $title)
                    {
                        if ($k == 0)
                        {
                            $row = array(
                                'title' => $title,
                                'total' => $animals_datIdant_total,
                                'male' => $animals_datIdant_male,
                                'female' => $animals_datIdant_female,
                                'unknow' => $animals_datIdant_unknow,
                            );
                            foreach ($filterYears as $i => $y)
                            {
                                if ($i == 0)
                                {
                                    $s = (string) array_get($search, 'start');
                                }
                                else
                                {
                                    $s = (string) $y;
                                }

                                if (array_get($search, 'end') < (string) $y + 1)
                                {
                                    $e = (string) array_get($search, 'end');
                                }
                                else
                                {
                                    $e = (string) $y + 1;
                                }

                                $search['tempStartDate'] = $s;
                                $search['tempEndYear'] = $e;
                                $row[$y] = Animal::where(function($query) use ($search)
                                        {
                                            $query->where('created_at', '>=', array_get($search, 'tempStartDate'))->where('created_at', '<=', array_get($search, 'tempEndYear'));
                                            $query->where('isActv', TRUE)->where('isDead', FALSE)->where('datIdant', '<>', '');
                                            if (array_get($search, 'start'))
                                            {
                                                $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                            }
                                            if (array_get($search, 'end'))
                                            {
                                                $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                            }
                                            if (array_get($search, 'department') != '')
                                            {
                                                $query->where('department', array_get($search, 'department'));
                                            }
                                            if (array_get($search, 'city') != '')
                                            {
                                                $query->where('city', array_get($search, 'city'));
                                            }
                                            if (array_get($search, 'cSection') != '')
                                            {
                                                $query->where('cSection', array_get($search, 'cSection'));
                                            }
                                        })->count();
                            }
                        }
                        else if ($k == 1)
                        {
                            $row = array(
                                'title' => $title,
                                'total' => $animals_isDead_total,
                                'male' => $animals_isDead_male,
                                'female' => $animals_isDead_female,
                                'unknow' => $animals_isDead_unknow,
                            );
                            foreach ($filterYears as $i => $y)
                            {
                                if ($i == 0)
                                {
                                    $s = (string) array_get($search, 'start');
                                }
                                else
                                {
                                    $s = (string) $y;
                                }

                                if (array_get($search, 'end') < (string) $y + 1)
                                {
                                    $e = (string) array_get($search, 'end');
                                }
                                else
                                {
                                    $e = (string) $y + 1;
                                }

                                $search['tempStartDate'] = $s;
                                $search['tempEndYear'] = $e;
                                $row[$y] = Animal::where(function($query) use ($search)
                                        {
                                            $query->where('created_at', '>=', array_get($search, 'tempStartDate'))->where('created_at', '<=', array_get($search, 'tempEndYear'));
                                            $query->where('isActv', TRUE)->where('isDead', TRUE);
                                            if (array_get($search, 'start'))
                                            {
                                                $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                            }
                                            if (array_get($search, 'end'))
                                            {
                                                $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                            }
                                            if (array_get($search, 'department') != '')
                                            {
                                                $query->where('department', array_get($search, 'department'));
                                            }
                                            if (array_get($search, 'city') != '')
                                            {
                                                $query->where('city', array_get($search, 'city'));
                                            }
                                            if (array_get($search, 'cSection') != '')
                                            {
                                                $query->where('cSection', array_get($search, 'cSection'));
                                            }
                                        })->count();
                            }
                        }
                        else if ($k == 2)
                        {
                            $row = array(
                                'title' => $title,
                                'total' => $animals_isVaccinated_total,
                                'male' => $animals_isVaccinated_male,
                                'female' => $animals_isVaccinated_female,
                                'unknow' => $animals_isVaccinated_unknow,
                            );
                            foreach ($filterYears as $i => $y)
                            {
                                if ($i == 0)
                                {
                                    $s = (string) array_get($search, 'start');
                                }
                                else
                                {
                                    $s = (string) $y;
                                }

                                if (array_get($search, 'end') < (string) $y + 1)
                                {
                                    $e = (string) array_get($search, 'end');
                                }
                                else
                                {
                                    $e = (string) $y + 1;
                                }

                                $search['tempStartDate'] = $s;
                                $search['tempEndYear'] = $e;
                                $row[$y] = Animal::where(function($query) use ($search)
                                        {
                                            $query->where('created_at', '>=', array_get($search, 'tempStartDate'))->where('created_at', '<=', array_get($search, 'tempEndYear'));
                                            $query->where('isActv', TRUE)->where('isDead', FALSE)->where('isVaccinated', 'o');
                                            if (array_get($search, 'start'))
                                            {
                                                $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                            }
                                            if (array_get($search, 'end'))
                                            {
                                                $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                            }
                                            if (array_get($search, 'department') != '')
                                            {
                                                $query->where('department', array_get($search, 'department'));
                                            }
                                            if (array_get($search, 'city') != '')
                                            {
                                                $query->where('city', array_get($search, 'city'));
                                            }
                                            if (array_get($search, 'cSection') != '')
                                            {
                                                $query->where('cSection', array_get($search, 'cSection'));
                                            }
                                        })->count();
                            }
                        }
                        else if ($k == 3)
                        {
                            $row = array(
                                'title' => $title,
                                'total' => $animals_country_domi_total,
                                'male' => $animals_country_domi_male,
                                'female' => $animals_country_domi_female,
                                'unknow' => $animals_country_domi_unknow,
                            );
                            foreach ($filterYears as $i => $y)
                            {
                                if ($i == 0)
                                {
                                    $s = (string) array_get($search, 'start');
                                }
                                else
                                {
                                    $s = (string) $y;
                                }

                                if (array_get($search, 'end') < (string) $y + 1)
                                {
                                    $e = (string) array_get($search, 'end');
                                }
                                else
                                {
                                    $e = (string) $y + 1;
                                }

                                $search['tempStartDate'] = $s;
                                $search['tempEndYear'] = $e;
                                $row[$y] = Animal::where(function($query) use ($search)
                                        {
                                            $query->where('created_at', '>=', array_get($search, 'tempStartDate'))->where('created_at', '<=', array_get($search, 'tempEndYear'));
                                            $query->where('isActv', TRUE)->where('isDead', FALSE)->where('country', TRUE);
                                            if (array_get($search, 'start'))
                                            {
                                                $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                            }
                                            if (array_get($search, 'end'))
                                            {
                                                $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                            }
                                            if (array_get($search, 'department') != '')
                                            {
                                                $query->where('department', array_get($search, 'department'));
                                            }
                                            if (array_get($search, 'city') != '')
                                            {
                                                $query->where('city', array_get($search, 'city'));
                                            }
                                            if (array_get($search, 'cSection') != '')
                                            {
                                                $query->where('cSection', array_get($search, 'cSection'));
                                            }
                                        })->count();
                            }
                        }
                        else if ($k == 4)
                        {
                            $row = array(
                                'title' => $title,
                                'total' => $animals_country_hait_total,
                                'male' => $animals_country_hait_male,
                                'female' => $animals_country_hait_female,
                                'unknow' => $animals_country_hait_unknow,
                            );
                            foreach ($filterYears as $i => $y)
                            {
                                if ($i == 0)
                                {
                                    $s = (string) array_get($search, 'start');
                                }
                                else
                                {
                                    $s = (string) $y;
                                }

                                if (array_get($search, 'end') < (string) $y + 1)
                                {
                                    $e = (string) array_get($search, 'end');
                                }
                                else
                                {
                                    $e = (string) $y + 1;
                                }

                                $search['tempStartDate'] = $s;
                                $search['tempEndYear'] = $e;
                                $row[$y] = Animal::where(function($query) use ($search)
                                        {
                                            $query->where('created_at', '>=', array_get($search, 'tempStartDate'))->where('created_at', '<=', array_get($search, 'tempEndYear'));
                                            $query->where('isActv', TRUE)->where('isDead', FALSE)->where('country', FALSE);
                                            if (array_get($search, 'start'))
                                            {
                                                $query->where('datIdantFix', '>=', array_get($search, 'start'));
                                            }
                                            if (array_get($search, 'end'))
                                            {
                                                $query->where('datIdantFix', '<=', array_get($search, 'end'));
                                            }
                                            if (array_get($search, 'department') != '')
                                            {
                                                $query->where('department', array_get($search, 'department'));
                                            }
                                            if (array_get($search, 'city') != '')
                                            {
                                                $query->where('city', array_get($search, 'city'));
                                            }
                                            if (array_get($search, 'cSection') != '')
                                            {
                                                $query->where('cSection', array_get($search, 'cSection'));
                                            }
                                        })->count();
                            }
                        }
                        array_push($animals, $row);
                    }
                }
                else if (array_get($search, 'type') == 'agent')
                {
                    $agents_title = array('Total Ajan yo', 'Ajan Idantifikatè (AIB)', 'Ajan Kontwòl Abataj (AKA)', 'Ajan Toulède');

                    $agents_list = Agent::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE);
                                if (array_get($search, 'start'))
                                {
                                    $query->where('created_at', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('created_at', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->get();

                    $agents_total = count($agents_list);

                    $agents_male = 0;
                    $agents_female = 0;
                    $agents_male_ai = 0;
                    $agents_male_ev = 0;
                    $agents_male_aiev = 0;
                    $agents_female_ai = 0;
                    $agents_female_ev = 0;
                    $agents_female_aiev = 0;
                    $agents_ai = 0;
                    $agents_ev = 0;
                    $agents_aiev = 0;

                    foreach ($agents_list as $item)
                    {
                        if ($item->sex == 'm')
                        {
                            $agents_male++;
                            if ($item->type == 'ai')
                            {
                                $agents_male_ai++;
                            }
                            else if ($item->type == 'ev')
                            {
                                $agents_male_ev++;
                            }
                            else if ($item->type == 'aiev')
                            {
                                $agents_male_aiev++;
                            }
                        }
                        else if ($item->sex == 'f')
                        {
                            $agents_female++;
                            if ($item->type == 'ai')
                            {
                                $agents_female_ai++;
                            }
                            else if ($item->type == 'ev')
                            {
                                $agents_female_ev++;
                            }
                            else if ($item->type == 'aiev')
                            {
                                $agents_female_aiev++;
                            }
                        }
                        $agents_ai = $agents_male_ai + $agents_female_ai;
                        $agents_ev = $agents_male_ev + $agents_female_ev;
                        $agents_aiev = $agents_male_aiev + $agents_female_aiev;
                    }

                    foreach ($agents_title as $k => $title)
                    {
                        if ($k == 0)
                        {
                            $row = array(
                                'title' => $title,
                                'total' => $agents_total,
                                'male' => $agents_male,
                                'female' => $agents_female,
                            );
                            foreach ($filterYears as $i => $y)
                            {
                                if ($i == 0)
                                {
                                    $s = (string) array_get($search, 'start');
                                }
                                else
                                {
                                    $s = (string) $y;
                                }

                                if (array_get($search, 'end') < (string) $y + 1)
                                {
                                    $e = (string) array_get($search, 'end');
                                }
                                else
                                {
                                    $e = (string) $y + 1;
                                }

                                $search['tempStartDate'] = $s;
                                $search['tempEndYear'] = $e;
                                $row[$y] = Agent::where(function($query) use ($search)
                                        {
                                            $query->where('isActv', TRUE)->where('created_at', '>=', array_get($search, 'tempStartDate'))->where('created_at', '<=', array_get($search, 'tempEndYear'));
                                            if (array_get($search, 'department') != '')
                                            {
                                                $query->where('department', array_get($search, 'department'));
                                            }
                                            if (array_get($search, 'city') != '')
                                            {
                                                $query->where('city', array_get($search, 'city'));
                                            }
                                            if (array_get($search, 'cSection') != '')
                                            {
                                                $query->where('cSection', array_get($search, 'cSection'));
                                            }
                                        })->count();
                            }
                        }
                        else if ($k == 1)
                        {
                            $row = array(
                                'title' => $title,
                                'total' => $agents_ai,
                                'male' => $agents_male_ai,
                                'female' => $agents_female_ai,
                            );
                            foreach ($filterYears as $k => $y)
                            {
                                if ($i == 0)
                                {
                                    $s = (string) array_get($search, 'start');
                                }
                                else
                                {
                                    $s = (string) $y;
                                }

                                if (array_get($search, 'end') < (string) $y + 1)
                                {
                                    $e = (string) array_get($search, 'end');
                                }
                                else
                                {
                                    $e = (string) $y + 1;
                                }

                                $search['tempStartDate'] = $s;
                                $search['tempEndYear'] = $e;
                                $row[$y] = Agent::where(function($query) use ($search)
                                        {
                                            $query->where('isActv', TRUE)->where('created_at', '>=', array_get($search, 'tempStartDate'))->where('created_at', '<=', array_get($search, 'tempEndYear'));
                                            $query->where('type', 'ai');
                                            if (array_get($search, 'department') != '')
                                            {
                                                $query->where('department', array_get($search, 'department'));
                                            }
                                            if (array_get($search, 'city') != '')
                                            {
                                                $query->where('city', array_get($search, 'city'));
                                            }
                                            if (array_get($search, 'cSection') != '')
                                            {
                                                $query->where('cSection', array_get($search, 'cSection'));
                                            }
                                        })->count();
                            }
                        }
                        else if ($k == 2)
                        {
                            $row = array(
                                'title' => $title,
                                'total' => $agents_ev,
                                'male' => $agents_male_ev,
                                'female' => $agents_female_ev,
                            );
                            foreach ($filterYears as $k => $y)
                            {
                                if ($i == 0)
                                {
                                    $s = (string) array_get($search, 'start');
                                }
                                else
                                {
                                    $s = (string) $y;
                                }

                                if (array_get($search, 'end') < (string) $y + 1)
                                {
                                    $e = (string) array_get($search, 'end');
                                }
                                else
                                {
                                    $e = (string) $y + 1;
                                }

                                $search['tempStartDate'] = $s;
                                $search['tempEndYear'] = $e;
                                $row[$y] = Agent::where(function($query) use ($search)
                                        {
                                            $query->where('isActv', TRUE)->where('created_at', '>=', array_get($search, 'tempStartDate'))->where('created_at', '<=', array_get($search, 'tempEndYear'));
                                            $query->where('type', 'ev');
                                            if (array_get($search, 'department') != '')
                                            {
                                                $query->where('department', array_get($search, 'department'));
                                            }
                                            if (array_get($search, 'city') != '')
                                            {
                                                $query->where('city', array_get($search, 'city'));
                                            }
                                            if (array_get($search, 'cSection') != '')
                                            {
                                                $query->where('cSection', array_get($search, 'cSection'));
                                            }
                                        })->count();
                            }
                        }
                        else if ($k == 3)
                        {
                            $row = array(
                                'title' => $title,
                                'total' => $agents_aiev,
                                'male' => $agents_male_aiev,
                                'female' => $agents_female_aiev,
                            );
                            foreach ($filterYears as $k => $y)
                            {
                                if ($i == 0)
                                {
                                    $s = (string) array_get($search, 'start');
                                }
                                else
                                {
                                    $s = (string) $y;
                                }

                                if (array_get($search, 'end') < (string) $y + 1)
                                {
                                    $e = (string) array_get($search, 'end');
                                }
                                else
                                {
                                    $e = (string) $y + 1;
                                }

                                $search['tempStartDate'] = $s;
                                $search['tempEndYear'] = $e;
                                $row[$y] = Agent::where(function($query) use ($search)
                                        {
                                            $query->where('isActv', TRUE)->where('created_at', '>=', array_get($search, 'tempStartDate'))->where('created_at', '<=', array_get($search, 'tempEndYear'));
                                            $query->where('type', 'aiev');
                                            if (array_get($search, 'department') != '')
                                            {
                                                $query->where('department', array_get($search, 'department'));
                                            }
                                            if (array_get($search, 'city') != '')
                                            {
                                                $query->where('city', array_get($search, 'city'));
                                            }
                                            if (array_get($search, 'cSection') != '')
                                            {
                                                $query->where('cSection', array_get($search, 'cSection'));
                                            }
                                        })->count();
                            }
                        }
                        array_push($agents, $row);
                    }
                }
                else if (array_get($search, 'type') == 'eleveur')
                {
                    $eleveurs_title = array('Total Elvè');

                    $eleveurs_list = Eleveur::where(function($query) use ($search)
                            {
                                $query->where('isActv', TRUE);
                                if (array_get($search, 'start'))
                                {
                                    $query->where('created_at', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('created_at', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();
                    $eleveurs_male = Eleveur::where(function($query) use ($search)
                            {
                                $query->where('sex', 'm')->where('isActv', TRUE);
                                if (array_get($search, 'start'))
                                {
                                    $query->where('created_at', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('created_at', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    $eleveurs_female = Eleveur::where(function($query) use ($search)
                            {
                                $query->where('sex', 'f')->where('isActv', TRUE);
                                if (array_get($search, 'start'))
                                {
                                    $query->where('created_at', '>=', array_get($search, 'start'));
                                }
                                if (array_get($search, 'end'))
                                {
                                    $query->where('created_at', '<=', array_get($search, 'end'));
                                }
                                if (array_get($search, 'department') != '')
                                {
                                    $query->where('department', array_get($search, 'department'));
                                }
                                if (array_get($search, 'city') != '')
                                {
                                    $query->where('city', array_get($search, 'city'));
                                }
                                if (array_get($search, 'cSection') != '')
                                {
                                    $query->where('cSection', array_get($search, 'cSection'));
                                }
                            })->count();

                    //$eleveurs_total = count($eleveurs_list);

                    foreach ($eleveurs_title as $k => $title)
                    {
                        $row = array(
                            'title' => $title,
                            'total' => $eleveurs_list,
                            'male' => $eleveurs_male,
                            'female' => $eleveurs_female,
                        );

                        foreach ($filterYears as $i => $y)
                        {
                            if ($i == 0)
                            {
                                $s = (string) array_get($search, 'start');
                            }
                            else
                            {
                                $s = (string) $y;
                            }

                            if (array_get($search, 'end') < (string) $y + 1)
                            {
                                $e = (string) array_get($search, 'end');
                            }
                            else
                            {
                                $e = (string) $y + 1;
                            }

                            $search['tempStartDate'] = $s;
                            $search['tempEndYear'] = $e;
                            $row[$y] = Eleveur::where(function($query) use ($search)
                                    {
                                        $query->where('isActv', TRUE)->where('created_at', '>=', array_get($search, 'tempStartDate'))->where('created_at', '<=', array_get($search, 'tempEndYear'));
                                        if (array_get($search, 'department') != '')
                                        {
                                            $query->where('department', array_get($search, 'department'));
                                        }
                                        if (array_get($search, 'city') != '')
                                        {
                                            $query->where('city', array_get($search, 'city'));
                                        }
                                        if (array_get($search, 'cSection') != '')
                                        {
                                            $query->where('cSection', array_get($search, 'cSection'));
                                        }
                                    })->count();
                        }
                        array_push($eleveurs, $row);
                    }
                }
                else if (array_get($search, 'type') == 'abattoir')
                {
                    $abbatoir_title = array('Total Pwen Abataj yo', 'Labatwa Piblik Nan Mache', 'Labatwa Piblik Izole', 'Labatwa Prive', 'Labatwa Ong', 'Estimasyon BÈF', 'Estimasyon semèn : KABRIT', 'Estimasyon semèn : MOUTON', 'Estimasyon semèn : KOCHON');
                    $public = 0;
                    $public_isole = 0;
                    $prive = 0;
                    $ong = 0;
                    $est_animals = 0;
                    $est_kabrit = 0;
                    $est_mouton = 0;
                    $est_kochon = 0;

                    $query = Abattoir::orderBy('created_at', 'desc');
                    if ($start != "")
                    {
                        $query->where('created_at', '>=', $start);
                    }
                    if ($end != "")
                    {
                        $query->where('created_at', '<=', $end);
                    }
                    if (array_get($search, 'department') != '')
                    {
                        $query->where('dept', array_get($search, 'department'));
                    }
                    if (array_get($search, 'city') != '')
                    {
                        $query->where('city', array_get($search, 'city'));
                    }
                    if (array_get($search, 'cSection') != '')
                    {
                        $query->where('cSection', array_get($search, 'cSection'));
                    }

                    $list = $query->get();

                    $total = count($list);
                    foreach ($list as $item)
                    {
                        if ($item->type == 'public')
                        {
                            $public++;
                        }
                        else if ($item->type == 'public-isole')
                        {
                            $public_isole++;
                        }
                        else if ($item->type == 'prive')
                        {
                            $prive++;
                        }
                        else if ($item->type == 'ong')
                        {
                            $ong++;
                        }

                        $est_animals+= $item->bef;
                        $est_kabrit+= $item->kabri;
                        $est_mouton+= $item->mouton;
                        $est_kochon+= $item->kochon;
                    }

                    foreach ($abbatoir_title as $k => $title)
                    {
                        if ($k == 0)
                        {
                            $value = $total;
                        }
                        else if ($k == 1)
                        {
                            $value = $public;
                        }
                        else if ($k == 2)
                        {
                            $value = $public_isole;
                        }
                        else if ($k == 3)
                        {
                            $value = $prive;
                        }
                        else if ($k == 4)
                        {
                            $value = $ong;
                        }
                        else if ($k == 5)
                        {
                            $value = $est_animals;
                        }
                        else if ($k == 6)
                        {
                            $value = $est_kabrit;
                        }
                        else if ($k == 7)
                        {
                            $value = $est_mouton;
                        }
                        else if ($k == 8)
                        {
                            $value = $est_kochon;
                        }

                        $row = array(
                            'title' => $title,
                            'value' => $value,
                        );
                        array_push($abattoirs, $row);
                    }
                }
            }
        }

        $dept = (array_get($search, 'department')) ? array_get($search, 'department') : array_get($departments[0], 'id');
        $cities = User::getCities($dept);
        $sections = User::getSections($dept, array_get($cities[0], 'id'));

        return View::make('admin.home.statinfo')
                        ->with('page_id', $page_id)
                        ->with('months', $months)
                        ->with('years', $years)
                        ->with('filterYears', $filterYears)
                        ->with('departments', $departments)
                        ->with('cities', $cities)
                        ->with('sections', $sections)
                        ->with('animals', $animals)
                        ->with('agents', $agents)
                        ->with('abattoirs', $abattoirs)
                        ->with('eleveurs', $eleveurs)
                        ->with('errors', $errors)
                        ->with('search', $search)
                        ->with('title', $title);
    }

    public function statabattoir()
    {
        if (!$this->user)
        {
            Auth::logout();
            return Redirect::to(URL::route('/'));
        }

        $errors = array();
        $search = array();
        $page_id = 'statabattoir';
        $title = 'Stats Abattoir';
        $months = array('janvye', 'fevrye', 'mas', 'avril', 'me', 'jwen', 'Jiyè', 'daout', 'septanm', 'oktòb', 'novanm', 'desanm');
        //$months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
        $years = array();
        $departments = User::departments();
        $init = 2013;
        $currentY = date('Y');
        for ($i = $init; $i <= $currentY; $i++)
        {
            array_push($years, $i);
        }

        $filterYears = array();
        $data = array();

        if (Input::get('search'))
        {
            $search = Input::get('search');
            $start = (array_get($search, 'start_year')) ? array_get($search, 'start_year') : date('Y');
            $start .= "-";
            $start .= (array_get($search, 'start_month') != "") ? array_get($search, 'start_month') : '00';
            $start .= "-00 00:00:00";

            $end = (array_get($search, 'end_year')) ? array_get($search, 'end_year') : date('Y');
            $end .= "-";
            $end .= (array_get($search, 'end_month') != "") ? array_get($search, 'end_month') : '12';
            $end .= "-31 00:00:00";

            $search['start'] = $start;
            $search['end'] = $end;

            foreach ($departments as $department)
            {
                $row = array();
                $notifications = Notification::where('department', array_get($department, 'id'))->where('rOb', 'animal')->where('type', 'a')->where('created_at', '>=', array_get($search, 'start'))->where('created_at', '<=', array_get($search, 'end'))->get();
                $total = count($notifications);
                array_push($row, array_get($department, 'name'));
                array_push($row, $total);
                foreach ($departments as $department)
                {
                    $value = Notification::departments($notifications, array_get($department, 'id'));
                    array_push($row, $value);
                }
                array_push($data, $row);
            }
        }
        return View::make('admin.home.statabattoir')
                        ->with('page_id', $page_id)
                        ->with('data', $data)
                        ->with('months', $months)
                        ->with('years', $years)
                        ->with('departments', $departments)
                        ->with('search', $search)
                        ->with('errors', $errors)
                        ->with('title', $title);
    }

    public function statabattoir2()
    {
        if (!$this->user)
        {
            Auth::logout();
            return Redirect::to(URL::route('/'));
        }

        $fixes = Notification::where('rOb', 'animal')->where('department', '<>', '')->where('city', NULL)->get();
        if (!empty($fixes))
        {
            foreach ($fixes as $fix)
            {
                $fix->city = User::getFirstCity($fix->department);
                $fix->save();
            }
        }

        $errors = array();
        $search = array();
        $page_id = 'statabattoir2';
        $title = 'Stats Abattoir';
        $months = array('janvye', 'fevrye', 'mas', 'avril', 'me', 'jwen', 'Jiyè', 'daout', 'septanm', 'oktòb', 'novanm', 'desanm');
        //$months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
        $years = array();
        $departments = User::departments();
        $init = 2012;
        $currentY = date('Y');
        for ($i = $init; $i <= $currentY; $i++)
        {
            array_push($years, $i);
        }

        $filterYears = array();
        $data = array();

        if (Input::get('search'))
        {
            $search = Input::get('search');
            if (array_get($search, 'department'))
            {
                $start = (array_get($search, 'start_year')) ? array_get($search, 'start_year') : date('Y');
                $start .= "-";
                $start .= (array_get($search, 'start_month') != "") ? array_get($search, 'start_month') : '00';
                $start .= "-00 00:00:00";

                $end = (array_get($search, 'end_year')) ? array_get($search, 'end_year') : date('Y');
                $end .= "-";
                $end .= (array_get($search, 'end_month') != "") ? array_get($search, 'end_month') : '12';
                $end .= "-31 00:00:00";

                $search['start'] = $start;
                $search['end'] = $end;

                $department = array_get($search, 'department');
                //dd($department);
                $cities = User::getCities($department);

                foreach ($cities as $city)
                {
                    $row = array();
                    //var_dump($city);
                    $notifications = Notification::where('department', $department)->where('city', array_get($city, 'id'))->where('rOb', 'animal')->where('type', 'a')->where('created_at', '>=', array_get($search, 'start'))->where('created_at', '<=', array_get($search, 'end'))->get();
                    $total = count($notifications);
                    array_push($row, array_get($city, 'name'));
                    array_push($row, $total);
                    foreach ($departments as $dept)
                    {
                        $value = Notification::departments($notifications, array_get($dept, 'id'));
                        array_push($row, $value);
                    }
                    array_push($data, $row);
                }
            }
        }
        return View::make('admin.home.statabattoir2')
                        ->with('page_id', $page_id)
                        ->with('data', $data)
                        ->with('months', $months)
                        ->with('years', $years)
                        ->with('departments', $departments)
                        ->with('search', $search)
                        ->with('errors', $errors)
                        ->with('title', $title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function systemlogs()
    {
        if (!$this->user)
        {
            Auth::logout();
            return Redirect::to(URL::route('/'));
        }
        //$months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
        $months = array('janvye', 'fevrye', 'mas', 'avril', 'me', 'jwen', 'Jiyè', 'daout', 'septanm', 'oktòb', 'novanm', 'desanm');
        $errors = array();
        $search = array();
        $page_id = 'system_logs';
        $title = 'System logs';
        $years = array();
        $init = 2012;
        $currentY = date('Y');
        for ($i = $init; $i <= $currentY; $i++)
        {
            array_push($years, $i);
        }

        $list = Systemlog::where('isActv', TRUE)->orderBy('created_at', 'desc')->paginate(20);

        set_time_limit(0);
        if (Input::get('list'))
        {
            $search = Input::get('search');
            if (!empty($search))
            {
                $type = array_get($search, 'type');
                $month = array_get($search, 'month');
                $year = array_get($search, 'year');
               

                $query = Systemlog::orderBy('created_at', 'desc');
                if ($type != "")
                {
                    $query->where('rOb', $type);
                }
                if ($month && $year)
                {
                    if ($month < 9)
                    {
                        $month = "0" . (string) $month;
                    }
                    $month = $year . "-" . $month;
                    $query->where('created_at', 'LIKE', $month . '%');
                }
                if($year)
                {
                    $query->where('created_at', 'LIKE', $year . '%');
                }

                $list = $query->get();
            }
            $data = array();
            $header = array(
                utf8_decode('Date'),
                utf8_decode('User'),
                utf8_decode('Type'),
                utf8_decode('Text'),
            );

            array_push($data, $header);

            foreach ($list as $item)
            {
                $row = array(
                    'date' => $item->created_at,
                    'user' => $item->user->getFullNameAttribute(),
                    'type' => $item->rOb,
                    'text' => utf8_decode(str_replace("<br>", " | ", $item->text)),
                );
                array_push($data, $row);
            }

            function cleanData(&$str)
            {
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
            }

            // filename for download
            $filename = "Sib-Syslog-CSV-" . date('Y-m-d') . ".xls";

            header("Content-Disposition: attachment; filename=\"$filename\"");
            header("Content-Type: application/vnd.ms-excel");

            foreach ($data as $row)
            {
                array_walk($row, 'cleanData');
                echo implode("\t", array_values($row)) . "\r\n";
            }
            exit;
        }

        return View::make('admin.home.systemlogs')
                        ->with('page_id', $page_id)
                        ->with('list', $list)
                        ->with('search', $search)
                        ->with('errors', $errors)
                        ->with('months', $months)
                        ->with('years', $years)
                        ->with('title', $title);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function fixdata()
    {
        $animals = Animal::where('datIdantFix', NULL)->limit(50000)->get();
        echo count($animals);

        foreach ($animals as $item)
        {
            if ($item->datIdant)
            {
                $data = explode("/", $item->datIdant);
                if (array_get($data, 2))
                {
                    $item->datIdantFix = array_get($data, 2) . "-" . array_get($data, 1) . "-" . array_get($data, 0) . " 00:00:00";
                    $item->save();
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
