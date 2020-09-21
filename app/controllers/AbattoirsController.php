<?php



class AbattoirsController extends \BaseController {



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

        $search = NULL;

        if (Input::get('list'))

        {

            $form_data = Input::get('list');



            if (isset($form_data['delete']) && !empty($form_data['items']['selected']))

            {

                foreach ($form_data['items']['selected'] as &$id)

                {

                    $item = Abattoir::find($id);

                    $item->delete();

                }

                return Redirect::to(URL::route('abbatages'));

            }

            else if (isset($form_data['activate']) && !empty($form_data['items']['selected']))

            {

                foreach ($form_data['items']['selected'] as &$id)

                {

                    $item = Abattoir::find($id);

                    $item->isActv = TRUE;

                    $item->save();

                }

                return Redirect::to(URL::route('abbatages'));

            }

            else if (isset($form_data['deactivate']) && !empty($form_data['items']['selected']))

            {

                foreach ($form_data['items']['selected'] as &$id)

                {

                    $item = Abattoir::find($id);

                    $item->isActv = FALSE;

                    $item->save();

                }

                return Redirect::to(URL::route('abbatages'));

            }

            else

            {

                $this->messages['block'][] = 'Opps! you forgot to select one or more items';

            }

        }

        else

        {

            if ($id != NULL && $city != NULL)

            {

                $abattoirs = Abattoir::where('dept', $id)->where('city', $city)->orderBy('id', 'desc')->paginate(20);

            }

            else if ($id != NULL)

            {

                $abattoirs = Abattoir::where('dept', $id)->orderBy('id', 'desc')->paginate(20);

            }

            else if (Input::get('search'))

            {

                $search = Input::get('search');

                $abattoirs = Abattoir::where('name', 'LIKE', '%' . $search . '%')->orWhere('type', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate(20);

            }

            else

            {

                $abattoirs = Abattoir::orderBy('created_at', 'desc')
                ->where('desc', Auth::user()->id)->paginate(5);

            }

            $title = 'Abattoirs list';

            $active_tab = 'abattoirs_index';

            $page_id = 'abattoirs_index';

            return View::make('abattoirs.tab_list')

                            ->with('title', $title)

                            ->with('active_tab', $active_tab)

                            ->with('page_id', $page_id)

                            ->with('search', $search)

                            ->with('list', $abattoirs);

        }

    }



    public function create()

    {

        $errors = array();

        if (Input::get('create'))

        {

            $form_data = Input::get('create');

            //dd($form_data);

            $abattoir_arr = $form_data['abattoir'];

            $rules = array(

                'name' => 'Required',

                //'owner' => 'Required',

                'cSection' => 'Required',

                'type' => 'Required',

                'department' => 'Required',

                'city' => 'Required',

            );



            $messages = array(

                'name.required' => 'Oups! non obligatwa!',

                //'owner.required' => 'Oups! Nom du Responsable obligatwa!',

                'department.required' => 'Oups! Depatman obligatwa!',

                'city.required' => 'Oups! Komin obligatwa!',

                'cSection.required' => 'Oups! Seksyon obligatwa!',

            );





            $validator = Validator::make($abattoir_arr, $rules, $messages);



            if ($validator->passes())

            {

                $abattoir_arr['isActv'] = TRUE;

                $abattoir_arr['dept'] = array_get($abattoir_arr, 'department');

                $abattoir_arr['city'] = array_get($abattoir_arr, 'city');

                $abattoir_arr['cSection'] = array_get($abattoir_arr, 'cSection');

                $abattoir_arr['desc'] = Auth::user()->id;

                $abattoir = new Abattoir($abattoir_arr);

                $abattoir->save();

                $address_arr = array(

                    'rId' => $abattoir->id,

                    'rOb' => 'abattoir',

                    'department' => array_get($abattoir_arr, 'department'),

                    'city' => array_get($abattoir_arr, 'city'),

                    'cSection' => array_get($abattoir_arr, 'cSection'),

                    'isActv' => TRUE,

                );

                $address = new Address($address_arr);

                $address->save();

                return Redirect::to(URL::route('abbatages'));

            }

            else

            {

                $errors = array_merge($errors, $validator->messages()->toArray());

            }

        }

        $title = 'Create Abattoir';

        $active_tab = 'abattoirs_create';

        $page_id = 'abattoirs_create';

        return View::make('abattoirs.tab_create')

                        ->with('active_tab', $active_tab)

                        ->with('page_id', $page_id)

                        ->with('errors', $errors)

                        ->with('title', $title);

    }



    public function city($id = NULL)

    {

        if ($id != NULL)

        {

            $abattoirs = Abattoir::where('city', $id)->orderBy('cSection', 'asc')->paginate(20);

        }

        else

        {

            $abattoirs = Abattoir::paginate(20);

        }

        $title = 'Abbatoires list';

        $active_tab = 'abbatoires_index';

        $page_id = 'abbatoires_index';

        return View::make('abattoirs.tab_list')

                        ->with('title', $title)

                        ->with('active_tab', $active_tab)

                        ->with('page_id', $page_id)

                        ->with('list', $abattoirs);

    }



    public function section($dept = NULL, $cit = NULL, $sec = NULL)

    {

        if ($dept && $cit && $sec)

        {

            $abattoirs = Abattoir::where('isActv', TRUE)->where('dept', $dept)->where('city', $cit)->where('cSection', $sec)->paginate(20);

            $title = 'Abattoirs list';

            $active_tab = 'abattoirs_index';

            $page_id = 'abattoirs_index';

            return View::make('abattoirs.tab_list')

                            ->with('title', $title)

                            ->with('active_tab', $active_tab)

                            ->with('page_id', $page_id)

                            ->with('list', $abattoirs);

        }

        else

        {

            return Redirect::to(URL::route('abattoirs'));

        }

    }



    public function abbatoirdepartment()

    {



        if (Request::ajax())

        {

            $result = array();

            if (Input::get('department'))

            {

                $department = Input::get('department');

                //dd($department);

                $abattoirs = Abattoir::where('isActv', TRUE)->orderBy('created_at', 'desc')->get();



                if ($abattoirs)

                {

                    foreach ($abattoirs as &$item)

                    {

                        if ($item->department() == $department)

                        {

                            $item->desc = $department;

                        }

                    }

                }

                return Response::json($abattoirs);

            }

        }

    }



    public function edit($id)

    {

        $errors = array();

        $edit_item = Abattoir::find($id);



        if (Input::get('edit'))

        {

            $form_data = Input::get('edit');

            $abattoir_arr = $form_data['abattoir'];

            $rules = array(

                'name' => 'Required',

                'owner' => 'Required',

                'type' => 'Required',

                'department' => 'Required',

                'city' => 'Required',

            );



            $messages = array(

                'name.required' => 'Oups! non obligatwa!',

                'owner.required' => 'Oups! Nom du Responsable obligatwa!',

                'department.required' => 'Oups! Depatman obligatwa!',

                'city.required' => 'Oups! Komin obligatwa!',

            );



            $validator = Validator::make($abattoir_arr, $rules, $messages);



            if ($validator->passes())

            {

                $abattoir_arr['dept'] = array_get($abattoir_arr, 'department');

                $abattoir_arr['city'] = array_get($abattoir_arr, 'city');

                $abattoir_arr['cSection'] = array_get($abattoir_arr, 'cSection');

                

                $old = $edit_item->toArray();

                $new = $abattoir_arr;

                $edit_item->update($abattoir_arr);

                $systemlog = Systemlog::create(array());

                $systemlog->history('Abattoir', $old, $new);

                $systemlog->user()->associate($this->user);

                $systemlog->save();



                $address_arr = array(

                    'rId' => $edit_item->id,

                    'rOb' => 'abattoir',

                    'department' => array_get($abattoir_arr, 'department'),

                    'city' => array_get($abattoir_arr, 'city'),

                    'cSection' => array_get($abattoir_arr, 'cSection'),

                    'isActv' => TRUE,

                );

                $address = Address::where('rId', $edit_item->id)->where('rOb', 'abattoir')->first();

                //dd($address);

                if ($address)

                {

                    $address->update($address_arr);

                }

                else

                {

                    $address = new Address($address_arr);

                }

                $address->save();

                return Redirect::to(URL::route('abbatages'));

            }

            else

            {

                $errors = array_merge($errors, $validator->messages()->toArray());

            }

        }

        $title = 'Edit Abattoir';

        $active_tab = 'abattoirs_edit';

        $page_id = 'abattoirs_edit';

        $edit_item = $edit_item->toArray();

        return View::make('abattoirs.tab_edit')

                        ->with('active_tab', $active_tab)

                        ->with('page_id', $page_id)

                        ->with('edit_item', $edit_item)

                        ->with('errors', $errors)

                        ->with('title', $title);

    }



}

