<?php



class UAgentsController extends \BaseController {



    /**

     * Display a listing of the resource.

     *

     * @return Response

     */

    public function __construct()

    {

        parent::__construct();

        $this->user = Auth::user();

        $departments = User::departments();

        View::share('departments', $departments);

    }



    public function index($id = NULL, $city = NULL)

    {

        //return Redirect::to(URL::route('animals'));

        $search = NULL;

        if (Input::get('list'))

        {

            $form_data = Input::get('list');



            if (isset($form_data['delete']) && !empty($form_data['items']['selected']))

            {

                foreach ($form_data['items']['selected'] as &$id)

                {

                    $item = Agent::find($id);

                    $item->delete();

                }

                return Redirect::to(URL::route('agents'));

            }

            else if (isset($form_data['activate']) && !empty($form_data['items']['selected']))

            {

                foreach ($form_data['items']['selected'] as &$id)

                {

                    $item = Agent::find($id);

                    $item->isActv = TRUE;

                    $item->save();

                }

                return Redirect::to(URL::route('agents'));

            }

            else if (isset($form_data['deactivate']) && !empty($form_data['items']['selected']))

            {

                foreach ($form_data['items']['selected'] as &$id)

                {

                    $item = Agent::find($id);

                    $item->isActv = FALSE;

                    $item->save();

                }

                return Redirect::to(URL::route('agents'));

            }

            else

            {

                $this->messages['danger'][] = 'Opps! you forgot to select one or more items';

            }

        }

        else

        {



            if ($id != NULL && $city != NULL)

            {

                $agents = Agent::where('isActv', TRUE)->where('department', $id)->where('city', $city)->orderBy('id', 'desc')->paginate(20);

            }

            else if ($id != NULL)

            {

                $agents = Agent::where('isActv', TRUE)->where('department', $id)->orderBy('city', 'asc')->paginate(20);

            }

            else if (Input::get('search'))

            {

                $search = Input::get('search');

                $agents = Agent::where('isActv', TRUE)

                                ->where(function ($query)

                                {

                                    $query->where('so', 'LIKE', '%' . Input::get('search') . '%')

                                    ->orWhere('cin', 'LIKE', '%' . Input::get('search') . '%')

                                    ->orWhere('fName', 'LIKE', '%' . Input::get('search') . '%')

                                    ->orWhere('lName', 'LIKE', '%' . Input::get('search') . '%');

                                })->orderBy('created_at', 'desc')->paginate(20);

            }

            else

            {

                $agents = Agent:://where('isActv', '<>', FALSE)
                where('desc', Auth::user()->id)
                //->orderBy('created_at', 'desc')
                ->paginate(5);

            }

            $title = 'Agents list';

            $active_tab = 'agents_index';

            $page_id = 'agents_index';

            return View::make('agents.tab_list')

                            ->with('title', $title)

                            ->with('active_tab', $active_tab)

                            ->with('page_id', $page_id)

                            ->with('search', $search)

                            ->with('list', $agents);

        }

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return Response

     */

    public function create()

    {

        $agent_arr = array();

        $errors = array();

        if (Input::get('create'))

        {

            $form_data = Input::get('create');

            $agent_arr = $form_data['agent'];



            $rules = array(

                'fName' => 'Required',

                'lName' => 'Required',

                'sex' => 'Required',

                'type' => 'Required',

                'cin' => 'Required',

                'so' => 'Required',

                'department' => 'Required',

                'city' => 'Required',

            );



            $messages = array(

                'fName.required' => 'Oups! siyati obligatwa!',

                'lName.required' => 'Oups! non obligatwa!',

                'sex.required' => 'Oups! #Sèks obligatwa!',

                'cin.required' => 'Oups! #CIN obligatwa!',

                'so.required' => 'Oups! #SO obligatwa!',

                'department.required' => 'Oups! Depatman obligatwa!',

                'city.required' => 'Oups! Komin obligatwa!',

                    //'cin.unique' => '#Oup! #CIN sa a anrejistre nan Sib deja!',

                    //'so.unique' => '#Oup! #SO sa a anrejistre nan Sib deja!',

                    // 'so.Unique' => 'Oups! #So anrejistre nan Sib deja!',

            );



            $validator = Validator::make($agent_arr, $rules, $messages);



            if ($validator->passes())

            {

                $agent_so = Agent::where('isActv', TRUE)->where('so', array_get($form_data, 'agent.so'))->first();

                $agent_cin = Agent::where('isActv', TRUE)->where('cin', array_get($form_data, 'agent.cin'))->first();



                if ($agent_so || $agent_cin)

                {

                    array_push($errors, array('Oups! #So ou #CIN anrejistre nan Sib deja!'));

                }

                else

                {

                    $obj_agent = new Agent();



                    $agent_arr['isActv'] = TRUE;

                    $agent_arr['desc'] = Auth::user()->id;

                    $agent = new Agent($agent_arr);

                    //die('created');

                    $agent->save();

                    return Redirect::to(URL::route('agents'));

                }

            }

            else

            {

                $errors = array_merge($errors, $validator->messages()->toArray());

            }

        }



        $title = 'Create Agent';

        $active_tab = 'agents_create';

        $page_id = 'agents_create';

        return View::make('agents.tab_create')

                        ->with('active_tab', $active_tab)

                        ->with('page_id', $page_id)

                        ->with('errors', $errors)

                        ->with('item_arr', $agent_arr)

                        ->with('title', $title);

    }



    public function city($id = NULL)

    {

        $search = NULL;

        if ($id != NULL)

        {

            $agents = Agent::where('isActv', TRUE)->where('city', $id)->orderBy('cSection', 'asc')->paginate(20);

        }

        else if (Input::get('search'))

        {

            $search = Input::get('search');

            $agents = Agent::where('isActv', TRUE)->where('email', 'LIKE', '%' . $search . '%')->orWhere('fName', 'LIKE', '%' . $search . '%')->orWhere('lName', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate(20);

        }

        else

        {

            $agents = Agent::where('isActv', TRUE)->orderBy('created_at', 'desc')->paginate(20);

        }

        $title = 'Agents list';

        $active_tab = 'agents_index';

        $page_id = 'agents_index';

        return View::make('agents.tab_list')

                        ->with('title', $title)

                        ->with('active_tab', $active_tab)

                        ->with('page_id', $page_id)

                        ->with('search', $search)

                        ->with('list', $agents);

    }



    public function section($dept = NULL, $cit = NULL, $sec = NULL)

    {

        if ($dept && $cit && $sec)

        {

            $agents = Agent::where('isActv', TRUE)->where('department', $dept)->where('city', $cit)->where('cSection', $sec)->paginate(20);

            $title = 'Agents list';

            $active_tab = 'agents_index';

            $page_id = 'agents_index';

            return View::make('agents.tab_list')

                            ->with('title', $title)

                            ->with('active_tab', $active_tab)

                            ->with('page_id', $page_id)

                            ->with('list', $agents);

        }

        else

        {

            return Redirect::to(URL::route('agents'));

        }

    }



    /**

     * Store a newly created resource in storage.

     *

     * @return Response

     */

    public function store()

    {

        //

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

        $errors = array();

        $edit_item = Agent::find($id);

        //var_dump($edit_item->toArray()); die();

        if (Input::get('edit'))

        {

            $form_data = Input::get('edit');

            $agent_arr = $form_data['agent'];

            $rules = array(

                'fName' => 'Required',

                'lName' => 'Required',

                'sex' => 'Required',

                'type' => 'Required',

                'cin' => 'Required',

                'so' => 'Required',

                'department' => 'Required',

                'city' => 'Required',

            );



            $messages = array(

                'fName.required' => 'Oups! siyati obligatwa!',

                'lName.required' => 'Oups! non obligatwa!',

                'sex.required' => 'Oups! #Sèks obligatwa!',

                //'cin.required' => 'Oups! #CIN obligatwa!',

                //'so.required' => 'Oups! #SO obligatwa!',

                'department.required' => 'Oups! Depatman obligatwa!',

                'city.required' => 'Oups! Komin obligatwa!',

                    // 'so.Unique' => 'Oups! #So anrejistre nan Sib deja!',

            );



            $validator = Validator::make($agent_arr, $rules, $messages);



            if ($validator->passes())

            {

                $agent_so = Agent::where('isActv', TRUE)->where('so', array_get($form_data, 'agent.so'))->where('id', '<>', $edit_item->id)->first();

                $agent_cin = Agent::where('isActv', TRUE)->where('cin', array_get($form_data, 'agent.cin'))->where('id', '<>', $edit_item->id)->first();

                if ($agent_so || $agent_cin)

                {

                    array_push($errors, array('Oups! #So ou #CIN anrejistre nan Sib deja!'));

                }

                else

                {

                    $old = $edit_item->toArray();

                    $new = $agent_arr;

                    $edit_item->update($agent_arr);

                    $systemlog = Systemlog::create(array());

                    $systemlog->history('Agent', $old, $new);

                    $systemlog->user()->associate($this->user);

                    $systemlog->save();



                    return Redirect::to(URL::route('agents'));

                }

            }

            else

            {

                $errors = array_merge($errors, $validator->messages()->toArray());

            }

        }

        $title = 'Edit Agent';

        $active_tab = 'agents_edit';

        $page_id = 'agents_edit';

        $notifications = Notification::where('rId', $edit_item->id)->where('rOb', 'agent')->orderBy('created_at', 'desc')->get();

        $edit_item = $edit_item->toArray();

        return View::make('agents.tab_edit')

                        ->with('active_tab', $active_tab)

                        ->with('page_id', $page_id)

                        ->with('edit_item', $edit_item)

                        ->with('errors', $errors)

                        ->with('notifications', $notifications)

                        ->with('title', $title);

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



    public function department()

    {

        if (Request::ajax())

        {

            if (Input::get('department'))

            {

                $department = Input::get('department');

                $agents = Agent::where('isActv', TRUE)->where('department', $department)->orderBy('created_at', 'desc')->paginate(10000);

            }



            return Response::json($agents);

        }

    }



}

