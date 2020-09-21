<?php

class Admin_AnimalsController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function __construct()
    {
        parent::__construct();
        $departments = User::departments();
        $this->user = Auth::user();
        View::share('departments', $departments);
    }

    public function index($id = NULL, $city = NULL)
    {
        //dd($this->user->systemlogs->toArray());
        $search = NULL;
        $number = NULL;
        if (Input::get('list'))
        {
            $form_data = Input::get('list');

            if (isset($form_data['delete']) && !empty($form_data['items']['selected']))
            {
                foreach ($form_data['items']['selected'] as &$id)
                {
                    $item = Animal::find($id);
                    $item->delete();
                }
                return Redirect::to(URL::route('adminanimals'));
            }
            else if (isset($form_data['activate']) && !empty($form_data['items']['selected']))
            {
                foreach ($form_data['items']['selected'] as &$id)
                {
                    $item = Animal::find($id);
                    $item->isActv = TRUE;
                    $item->save();
                }
                return Redirect::to(URL::route('adminanimals'));
            }
            else if (isset($form_data['deactivate']) && !empty($form_data['items']['selected']))
            {
                foreach ($form_data['items']['selected'] as &$id)
                {
                    $item = Animal::find($id);
                    $item->isActv = FALSE;
                    $item->save();
                }
                return Redirect::to(URL::route('adminanimals'));
            }
            else
            {
                $this->messages['danger'][] = 'Opps! you forgot to select one or more items';
            }
        }
        else
        {
            if (Input::get('number'))
            {
                $number = Input::get('number');
            }
            else
            {
                $number = 20;
            }
            if ($id != NULL && $city != NULL)
            {
                $animals = Animal::where('department', $id)->where('city', $city)->orderBy('id', 'desc')->paginate($number);
            }
            else if ($id != NULL)
            {
                $animals = Animal::where('department', $id)->orderBy('city', 'asc')->paginate($number);
            }
            else if (Input::get('search'))
            {
                $search = Input::get('search');
                $animals = Animal::where('tag', 'LIKE', '%' . $search . '%')->orWhere('carnet', 'LIKE', '%' . $search . '%')->orWhere('type', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate($number);
            }
            else
            {
                $animals = Animal::orderBy('created_at', 'desc')->paginate($number);
            }
            $title = 'Animals list';
            $active_tab = 'animals_index';
            $page_id = 'animals_index';
            return View::make('admin.animals.tab_list')
                            ->with('title', $title)
                            ->with('active_tab', $active_tab)
                            ->with('page_id', $page_id)
                            ->with('search', $search)
                            ->with('number', $number)
                            ->with('list', $animals);
        }
    }

    public function city($id = NULL)
    {
        $search = NULL;
        if ($id != NULL)
        {
            $animals = Animal::where('city', $id)->orderBy('cSection', 'asc')->paginate(20);
        }
        else if (Input::get('search'))
        {
            $search = Input::get('search');
            $animals = Animal::where('tag', 'LIKE', '%' . $search . '%')->orWhere('carnet', 'LIKE', '%' . $search . '%')->orWhere('type', 'LIKE', '%' . $search . '%')->paginate(20);
        }
        else
        {
            $animals = Animal::paginate(20);
        }
        $title = 'Animals list';
        $active_tab = 'animals_index';
        $page_id = 'animals_index';
        return View::make('admin.animals.tab_list')
                        ->with('title', $title)
                        ->with('active_tab', $active_tab)
                        ->with('page_id', $page_id)
                        ->with('search', $search)
                        ->with('list', $animals);
    }

    public function section($dept = NULL, $cit = NULL, $sec = NULL)
    {
        if ($dept && $cit && $sec)
        {
            $animals = Animal::where('isActv', TRUE)->where('department', $dept)->where('city', $cit)->where('cSection', $sec)->paginate(20);
            $title = 'Animals list';
            $active_tab = 'animals_index';
            $page_id = 'animals_index';
            return View::make('admin.animals.tab_list')
                            ->with('title', $title)
                            ->with('active_tab', $active_tab)
                            ->with('page_id', $page_id)
                            ->with('list', $animals);
        }
        else
        {
            return Redirect::to(URL::route('adminanimals'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($id = NULL)
    {
        $errors = array();
        if (Input::get('create'))
        {
            $form_data = Input::get('create');
            $animal_arr = $form_data['animal'];
            $rules = array(
                'tag' => 'Required|Unique:animals',
                'carnet' => 'Required|Unique:animals',
                // 'type' => 'Required',
                'eleveur' => 'Required',
                    // 'mTag' => 'Required',
                    //'fTag' => 'Required',
            );

            $messages = array(
                'tag.unique' => '#Oup! #Tag sa a anrejistre nan Sib deja!',
                'carnet.unique' => '#Oup! #Kane sa a anrejistre nan Sib deja!',
                'tag.required' => '#Oup! #Tag obligatwa!',
                'carnet.required' => '#Oup! #Kane obligatwa!',
                //'lName.required' => 'Le champ Nom est obligatoire!',
                'eleveur.required' => 'Le champ Éleveur est obligatoire!',
                    //'mTag.required' => 'Le champ Éleveur est obligatoire!',
                    //'fTag.required' => 'Le champ Éleveur est obligatoire!',
            );

            $validator = Validator::make($animal_arr, $rules, $messages);

            if ($validator->passes())
            {
                $animal_exist = Animal::where('tag', array_get($form_data, 'animal.tag'))->orWhere('carnet', array_get($form_data, 'animal.carnet'))->first();
                if ($animal_exist)
                {
                    array_push($errors, array('#Oup! #Tag sa a anrejistre nan Sib deja'));
                }
                else
                {
                    $animal_arr['isActv'] = TRUE;
                    $animal_arr['desc'] = Auth::user()->id;
                    if (array_get($animal_arr, 'datIdant'))
                    {
                        $data = explode("/", $animal_arr['datIdant']);
                        $animal_arr['datIdantFix'] = array_get($data, 2) . "-" . array_get($data, 1) . "-" . array_get($data, 0) . " 00:00:00";
                    }
                    $animal = new Animal($animal_arr);
                    $animal->save();
                    return Redirect::to(URL::route('admineleveurs'));
                }
            }
            else
            {
                $errors = array_merge($errors, $validator->messages()->toArray());
            }
        }
        $title = 'Create Animal';
        $active_tab = 'animals_create';
        $page_id = 'animals_create';
        if ($id != NULL)
        {
            $eleveurs = Eleveur::where('isActv', TRUE)->where('id', $id)->paginate(1000);
        }
        else
        {
            $eleveurs = Eleveur::where('isActv', TRUE)->orderBy('fName', 'asc')->paginate(1000);
        }

        //var_dump($animals->toArray()); die();
        return View::make('admin.animals.tab_create')
                        ->with('active_tab', $active_tab)
                        ->with('page_id', $page_id)
                        ->with('errors', $errors)
                        ->with('eleveurs', $eleveurs)
                        ->with('title', $title);
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
        $edit_item = Animal::find($id);

        if (Input::get('edit'))
        {
            $form_data = Input::get('edit');
            $animal_arr = $form_data['animal'];
            $rules = array(
                'tag' => 'Required',
                'carnet' => 'Required',
                // 'type' => 'Required',
                'eleveur' => 'Required',
                    //'mTag' => 'Required',
                    //'fTag' => 'Required',
            );

            $messages = array(
                //'tag.unique' => 'Le numéro de Tag à été déjà enregistré dans le système!',
                // 'tag.unique' => '#Oup! #Tag sa a anrejistre nan Sib deja!',
                // 'carnet.unique' => '#Oup! #Kane sa a anrejistre nan Sib deja!',	
                //'tag.required' => 'Le champ Tag est obligatoire!',
                // 'carnet.required' => 'Le champ Carnet est obligatoire!',
                'tag.required' => '#Oup! #Tag obligatwa!',
                'carnet.required' => '#Oup! #Kane obligatwa!',
                //'lName.required' => 'Le champ Nom est obligatoire!',
                'eleveur.required' => 'Le champ Éleveur est obligatoire!',
                    //'mTag.required' => 'Le champ Éleveur est obligatoire!',
                    // 'fTag.required' => 'Le champ Éleveur est obligatoire!',
            );

            $validator = Validator::make($animal_arr, $rules, $messages);

            if ($validator->passes())
            {
                if (array_get($animal_arr, 'tag') && array_get($animal_arr, 'carnet'))
                {
                    $animal_tag = Animal::where('tag', array_get($form_data, 'animal.tag'))->where('id', '<>', $edit_item->id)->first();
                    $animal_carnet = Animal::Where('carnet', array_get($form_data, 'animal.carnet'))->where('id', '<>', $edit_item->id)->first();
                    if ($animal_tag || $animal_carnet)
                    {
                        array_push($errors, array('#Oup! #Kane ou #Tag sa a anrejistre nan Sib deja!'));
                    }
                    else
                    {
                        $old = $edit_item->toArray();
                        $new = $animal_arr;
                        $edit_item->update($animal_arr);
                        //dd($new->toArray());
                        $systemlog = Systemlog::create(array());
                        $systemlog->history('Animal', $old, $new);
                        $systemlog->user()->associate($this->user);
                        $systemlog->save();
                        return Redirect::to(URL::route('adminanimals'));
                    }
                }
                else
                {
                    array_push($errors, array('Le numéro de tag et le carnet ne doit pas être vide'));
                }
            }
            else
            {
                $errors = array_merge($errors, $validator->messages()->toArray());
            }
        }
        $title = 'Edit Animal';
        $active_tab = 'animals_edit';
        $page_id = 'animals_edit';
        $edit_item = $edit_item->toArray();
        $eleveurs = Eleveur::where('isActv', TRUE)->orderBy('fName', 'asc')->paginate(1000);
        $notifications = Notification::where('isActv', TRUE)->where('rId', array_get($edit_item, 'id'))->orderBy('created_at', 'desc')->paginate(1000);

        return View::make('admin.animals.tab_edit')
                        ->with('active_tab', $active_tab)
                        ->with('page_id', $page_id)
                        ->with('edit_item', $edit_item)
                        ->with('errors', $errors)
                        ->with('eleveurs', $eleveurs)
                        ->with('notifications', $notifications)
                        ->with('title', $title);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function blacklist($id = NULL)
    {
        if (Input::get('list'))
        {
            $form_data = Input::get('list');
            if (isset($form_data['islive']) && !empty($form_data['items']['selected']))
            {
                foreach ($form_data['items']['selected'] as $id)
                {
                    if ($id != 'on')
                    {
                        $item = Animal::find($id);
                        $item->isDead = FALSE;
                        $item->save();

                        $notification = Notification::where('isActv', TRUE)->where('rId', $item->id)->where('rOb', 'animal')->where('type', 'a')->first();

                        if ($notification)
                        {
                            $notification->delete();
                        }
                    }
                }
            }
        }
        if (Input::get('number'))
        {
            $number = Input::get('number');
        }
        else
        {
            $number = 100;
        }
        if (Input::get('search'))
        {
            $search = Input::get('search');
            $blacklist = Animal::where('isDead', TRUE)->where('tag', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate($number);
        }
        else
        {
            $blacklist = Animal::where('isDead', TRUE)->orderBy('created_at', 'desc')->paginate($number);
        }

        /*
          $notifications = Notification::where('isActv', TRUE)->where('rOb', 'animal')->where('type', 'a')->get();

          foreach ($notifications as $notification) {
          $animal = Animal::find($notification->rId);
          if ($animal) {
          $animal->isDead = TRUE;
          $animal->save();
          }
          }
         */


        $title = 'Animals blacklist';
        $active_tab = 'animals_blacklist';
        $page_id = 'animals_blacklist';
        return View::make('admin.animals.tab_blacklist')
                        ->with('title', $title)
                        ->with('active_tab', $active_tab)
                        ->with('page_id', $page_id)
                        ->with('list', $blacklist);
    }

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

    public function abbatage($id = NULL)
    {
        $notifications = Notification::where('isActv', TRUE)->where('department', $id)->where('type', 'a')->get();
        $title = 'Notification list';
        $active_tab = 'animals_notifications_list';
        $page_id = 'animals_notifications_list';
        return View::make('admin.animals.tab_notifications_list')
                        ->with('title', $title)
                        ->with('active_tab', $active_tab)
                        ->with('page_id', $page_id)
                        ->with('notifications', $notifications);
    }

}
