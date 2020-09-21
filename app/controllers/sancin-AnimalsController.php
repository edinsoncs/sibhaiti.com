<?php

class AnimalsController extends \BaseController {

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
                    $item = Animal::find($id);
                    $item->delete();
                }
                return Redirect::to(URL::route('animals'));
            }
            else if (isset($form_data['activate']) && !empty($form_data['items']['selected']))
            {
                foreach ($form_data['items']['selected'] as &$id)
                {
                    $item = Animal::find($id);
                    $item->isActv = TRUE;
                    $item->save();
                }
                return Redirect::to(URL::route('animals'));
            }
            else if (isset($form_data['deactivate']) && !empty($form_data['items']['selected']))
            {
                foreach ($form_data['items']['selected'] as &$id)
                {
                    $item = Animal::find($id);
                    $item->isActv = FALSE;
                    $item->save();
                }
                return Redirect::to(URL::route('animals'));
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
                $animals = Animal::where('isActv', '<>', FALSE)->where('isDead', '<>', 1)->where('department', $id)->where('city', $city)->orderBy('id', 'desc')->paginate(20);
            }
            else if ($id != NULL)
            {
                $animals = Animal::where('isActv', '<>', FALSE)->where('isDead', '<>', 1)->where('department', $id)->orderBy('city', 'asc')->paginate(20);
            }
            else if (Input::get('search'))
            {
                $search = Input::get('search');
                $animals = Animal::where('isActv', '<>', FALSE)->where('isDead', '<>', 1)
                                //->where('desc', Auth::user()->id)
                                ->where(function ($query)
                                {
                                    $query->where('tag', 'LIKE', '%' . Input::get('search') . '%')
                                    ->orWhere('carnet', 'LIKE', '%' . Input::get('search') . '%')
                                    ->orWhere('so', 'LIKE', '%' . Input::get('search') . '%')
                                    ->orWhere('type', 'LIKE', '%' . Input::get('search') . '%');
                                })->orderBy('created_at', 'desc')->paginate(20);
            }
            else
            {
                if (Auth::user()->role == 'user')
                {
                    $animals = NULL;
                }
                else
                {
                    //$animals = Animal::where('isActv', '<>', TRUE)
                    $animals = Animal::where('isDead', '<>', 1)
                    //->where('isDead', '<>', 1)
                    ->where('desc', Auth::user()->id)
                    //->orderBy('created_at', 'desc')
                    ->paginate(5);
                }
            }
            $title = 'Animals list';
            $active_tab = 'animals_index';
            $page_id = 'animals_index';
            return View::make('animals.tab_list')
                            ->with('title', $title)
                            ->with('active_tab', $active_tab)
                            ->with('page_id', $page_id)
                            ->with('search', $search)
                            ->with('list', $animals);
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
        $animal_arr = array();
        if (Input::get('create'))
        {
            $form_data = Input::get('create');
            $animal_arr = $form_data['animal'];
            $rules = array(
                'fiche' => 'Required',
                'carnet' => 'Required|Unique:animals',
                'tag' => 'Required|Unique:animals',
                'type' => 'Required',
                'so' => 'Required',
                'eleveur' => 'Required',
                'datIdant' => 'Required',
                'department' => 'Required',
                'city' => 'Required',
            );

            $messages = array(
                'tag.unique' => '#Oup! #Tag sa a anrejistre nan Sib deja!',
                'carnet.unique' => '#Oup! #Kane sa a anrejistre nan Sib deja!',
                'tag.required' => '#Oup! #Zanno obligatwa!',
                'carnet.required' => '#Oup! #Kane obligatwa!',
                'fiche.required' => '#Oup! Fich obligatwa!',
                'type.required' => '#Oup! Sèks obligatwa!',
                'so.required' => '#Oup! #SO obligatwa!',
                'datIdant.required' => '#Oup! Dat idantifikasyon obligatwa!',
                'department.required' => '#Oup! Depatman obligatwa!',
                'city.required' => '#Oup! Komin obligatwa!',
                'eleveur.required' => 'Le champ Éleveur est obligatoire!',
            );

            $validator = Validator::make($animal_arr, $rules, $messages);

            if ($validator->passes())
            {
                if (array_get($animal_arr, 'tag') && array_get($animal_arr, 'carnet'))
                {
                    //$animal_exist = Animal::where('tag', array_get($form_data, 'animal.tag'))->first();
                    $animal_exist = Animal::where('tag', array_get($form_data, 'animal.tag'))->orWhere('carnet', array_get($form_data, 'animal.carnet'))->first();
                    if ($animal_exist)
                    {
                        array_push($errors, array('#Oup! #Zanno sa a anrejistre nan Sib deja'));
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
                        Session::put('animaladded', TRUE);
                        return Redirect::to(URL::route('editanimal', $animal->id));
                        //return Redirect::to(URL::route('eleveurs'));
                    }
                }
                else
                {
                    array_push($errors, array('#Oup! #Zanno ak #Kane paka vid'));
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
            $eleveurs = Eleveur::where('isActv', '<>', FALSE)->where('id', $id)->get();
        }
        else
        {
            $eleveurs = Eleveur::where('isActv', '<>', FALSE)->where('desc', Auth::user()->id)->orWhere('cin', '00-00-00-0000-00-00000')->orderBy('created_at', 'desc')->paginate(1);
        }

        //$agents = Agent::where('isActv', TRUE)->where('department',)->orderBy('created_at', 'desc')->paginate(10000);
        //var_dump($animal_arr); die();
        return View::make('animals.tab_create')
                        ->with('active_tab', $active_tab)
                        ->with('page_id', $page_id)
                        ->with('errors', $errors)
                        ->with('eleveurs', $eleveurs)
                        ->with('item_arr', $animal_arr)
                        ->with('title', $title);
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
        return View::make('animals.tab_list')
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
            return View::make('animals.tab_list')
                            ->with('title', $title)
                            ->with('active_tab', $active_tab)
                            ->with('page_id', $page_id)
                            ->with('list', $animals);
        }
        else
        {
            return Redirect::to(URL::route('animals'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function remarke($id = NULL)
    {
        $animal = Animal::find($id);
        if ($animal)
        {
            $agents = Agent::where('isActv', TRUE)->where('department', $animal->department)->orderBy('created_at', 'desc')->paginate(10000);
            $abattoirs = Abattoir::indepartment($animal->department);
        }
        else
        {
            $agents = array();
            $abattoirs = array();
        }
        $form_data = array();
        $errors = array();
        $success = array();
        if (Input::get('notification'))
        {
            $form_data = Input::get('notification');

            if (array_get($form_data, 'tag'))
            {
                $animal = Animal::where('isActv', TRUE)->where('tag', array_get($form_data, 'tag'))->first();
                if ($animal)
                {
                    if (array_get($form_data, 'abbatoire'))
                    {
                        $abbatoire = Abattoir::find(array_get($form_data, 'abbatoire'));
                        //dd($abbatoire->toArray());
                        if ($abbatoire)
                        {
                            $form_data['department'] = $abbatoire->department();
                            $form_data['city'] = $abbatoire->city();
                            $form_data['cSection'] = $abbatoire->cSection();
                        }
                    }
                    else
                    {
                        $form_data['department'] = $animal->department;
                        $form_data['city'] = $animal->city;
                        $form_data['cSection'] = $animal->cSection;
                    }

                    $notification_arr = array();
                    $notification_arr['type'] = array_get($form_data, 'type');
                    if ($notification_arr['type'] == 'c')
                    {
                        $notification_arr['chabon'] = 'Oui';
                        $notification_arr['day'] = array_get($form_data, 'dayc');
                        //$notification_arr['nday'] = array_get($form_data, 'ndayc');
                        //$notification_arr['month'] = array_get($form_data, 'monthc');
                        //$notification_arr['year'] = array_get($form_data, 'yearc');
                        $notification_arr['department'] = array_get($form_data, 'departmentc');
                        $notification_arr['city'] = array_get($form_data, 'cityc');
                        $notification_arr['so'] = array_get($form_data, 'soc');
                    }
                    else if ($notification_arr['type'] == 'a')
                    {
                        $exist = Notification::where('isActv', TRUE)->where('rOb', 'animal')->where('rId', $animal->id)->where('type', 'a')->first();
                        if (!$exist)
                        {
                            $notification_arr['department'] = array_get($form_data, 'department');
                            $notification_arr['city'] = array_get($form_data, 'city');
                            $notification_arr['day'] = array_get($form_data, 'day');
                            //$notification_arr['nday'] = array_get($form_data, 'nday');
                            //$notification_arr['month'] = array_get($form_data, 'month');
                            //$notification_arr['year'] = array_get($form_data, 'year');
                            $notification_arr['abbatoire'] = array_get($form_data, 'abbatoire');
                            $notification_arr['so'] = array_get($form_data, 'so');

                            //isDead
                            $animal->isDead = TRUE;
                            $animal->save();
                        }
                        else
                        {
                            array_push($errors, "Animal déjà notifié abattu");
                        }
                    }
                    else if ($notification_arr['type'] == 't')
                    {
                        $existing_old = Eleveur::where('isActv', TRUE)->where('cin', array_get($form_data, 'old_cin'))->first();
                        $existing_new = Eleveur::where('isActv', TRUE)->where('cin', array_get($form_data, 'old_cin'))->first();
                        $existing_carnet = Animal::where('isActv', TRUE)->where('carnet', array_get($form_data, 'kane'))->first();
                        if ($existing_old && $existing_new && $existing_carnet)
                        {
                            $notification_arr['old_cin'] = array_get($form_data, 'old_cin');
                            $notification_arr['new_cin'] = array_get($form_data, 'new_cin');
                            $notification_arr['tag'] = array_get($form_data, 'tag');
                            $notification_arr['kane'] = array_get($form_data, 'kane');
                        }
                        else if (!$existing_old)
                        {
                            array_push($errors, "Cin Ansyen elvè inconnu");
                        }
                        else if (!$existing_new)
                        {
                            array_push($errors, "Cin nouvo elvè inconnu");
                        }
                        else if (!$existing_carnet)
                        {
                            array_push($errors, "Karnet agent inconnu");
                        }
                    }
                    else if ($notification_arr['type'] == 'k')
                    {
                        $existing_eleveur = Eleveur::where('isActv', TRUE)->where('cin', array_get($form_data, 'cin_eleveur'))->first();
                        $existing_carnet = Animal::where('isActv', TRUE)->where('carnet', array_get($form_data, 'old_kane'))->first();

                        if ($existing_eleveur && $existing_carnet)
                        {
                            $notification_arr['cin_eleveur'] = array_get($form_data, 'cin_eleveur');
                            $notification_arr['old_tag'] = array_get($form_data, 'old_tag');
                            $notification_arr['new_tag'] = array_get($form_data, 'new_tag');
                            $notification_arr['old_kane'] = array_get($form_data, 'old_kane');
                            $notification_arr['new_kane'] = array_get($form_data, 'new_kane');
                        }
                        else if (!$existing_eleveur)
                        {
                            array_push($errors, "Cin elvè inconnu");
                        }
                        else if (!$existing_carnet)
                        {
                            array_push($errors, "Karnet agent inconnu");
                        }
                    }
                    else if ($notification_arr['type'] == 'ks')
                    {
                        $existing_eleveur = Eleveur::where('isActv', TRUE)->where('cin', array_get($form_data, 'cin_eleveur_ks'))->first();
                        $existing_carnet = Animal::where('isActv', TRUE)->where('carnet', array_get($form_data, 'old_kane_ks'))->first();

                        if ($existing_eleveur && $existing_carnet)
                        {
                            $notification_arr['cin_eleveur'] = array_get($form_data, 'cin_eleveur_ks');
                            //$notification_arr['old_tag'] = array_get($form_data, 'old_tag_ks');
                            //$notification_arr['new_tag'] = array_get($form_data, 'new_tag_ks');
                            $notification_arr['old_kane'] = array_get($form_data, 'old_kane_ks');
                            $notification_arr['new_kane'] = array_get($form_data, 'new_kane_ks');
                        }
                        else if (!$existing_eleveur)
                        {
                            array_push($errors, "Cin elvè inconnu");
                        }
                        else if (!$existing_carnet)
                        {
                            array_push($errors, "Karnet agent inconnu");
                        }
                    }

                    if (empty($errors))
                    {
                        $notification_arr['rId'] = $animal->id;
                        $notification_arr['rOb'] = 'animal';
                        $notification_arr['isActv'] = TRUE;
                        $notification_arr['desc'] = Auth::user()->id;
                        $notification = new Notification($notification_arr);
                        $notification->save();
                        array_push($success, "Remake enregistré avec succès.");
                        $form_data = array();
                        // return Redirect::to(URL::route('animals'));
                    }
                }
                else
                {
                    array_push($errors, "Le numéro du tag n'existe pas.");
                }
            }
            else
            {
                array_push($errors, 'Aucune Tag trouve');
            }
        }

        $title = 'Notifications';
        $page_id = "notification";
        return View::make('animals.notification')
                        ->with('page_id', $page_id)
                        ->with('errors', $errors)
                        ->with('success', $success)
                        ->with('abattoirs', $abattoirs)
                        ->with('animal', $animal)
                        ->with('form_data', $form_data)
                        ->with('agents', $agents)
                        ->with('title', $title);
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

    public function validatetag()
    {
        if (Request::ajax())
        {
            if (Input::get('tag'))
            {
                $tag = Input::get('tag');
                $animal = Animal::where('isActv', TRUE)->where('tag', $tag)->first();
                if ($animal)
                {
                    $agents = Agent::where('isActv', TRUE)->where('department', $animal->department)->orderBy('so', 'asc')->paginate(10000);

                    $msg = "Numéro du tag valide avec succès.";
                    $response = array(
                        'status' => 'success',
                        'msg' => $msg,
                        'agents' => $agents,
                    );
                }
                else
                {
                    $msg = "Le numéro du tag n'existe pas.";
                    $response = array(
                        'status' => 'error',
                        'msg' => $msg,
                    );
                }
                return Response::json($response);
            }
        }
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
                'fiche' => 'Required',
                'carnet' => 'Required',
                'tag' => 'Required',
                'type' => 'Required',
                'so' => 'Required',
                'eleveur' => 'Required',
                'datIdant' => 'Required',
                'department' => 'Required',
                'city' => 'Required',
            );

            $messages = array(
                'tag.unique' => '#Oup! #Tag sa a anrejistre nan Sib deja!',
                'carnet.unique' => '#Oup! #Kane sa a anrejistre nan Sib deja!',
                'tag.required' => '#Oup! #Zanno obligatwa!',
                'carnet.required' => '#Oup! #Kane obligatwa!',
                'fiche.required' => '#Oup! Fich obligatwa!',
                'type.required' => '#Oup! Sèks obligatwa!',
                'so.required' => '#Oup! #SO obligatwa!',
                'datIdant.required' => '#Oup! Dat idantifikasyon obligatwa!',
                'department.required' => '#Oup! Depatman obligatwa!',
                'city.required' => '#Oup! Komin obligatwa!',
                'eleveur.required' => 'Le champ Éleveur est obligatoire!',
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
                        array_push($errors, array('#Oup! #Kane ou #Zanno sa a anrejistre nan Sib deja!'));
                    }
                    else
                    {
                        $old = $edit_item->toArray();
                        $new = $animal_arr;
                        $edit_item->update($animal_arr);
                        $systemlog = Systemlog::create(array());
                        $systemlog->history('Animal', $old, $new);
                        $systemlog->user()->associate($this->user);
                        $systemlog->save();

                        return Redirect::to(URL::route('animals'));
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
        $eleveurs = Eleveur::where('isActv', '<>', FALSE)->where('desc', Auth::user()->id)->orWhere('cin', '00-00-00-0000-00-00000')->orderBy('fName', 'asc')->paginate(10000);
        $notifications = Notification::where('isActv', '<>', FALSE)->where('rOb', 'animal')->where('rId', $edit_item->id)->orderBy('created_at', 'desc')->paginate(100);

        $edit_item = $edit_item->toArray();
        $added = Session::get('animaladded');
        Session::forget('animaladded');

        return View::make('animals.tab_edit')
                        ->with('active_tab', $active_tab)
                        ->with('page_id', $page_id)
                        ->with('edit_item', $edit_item)
                        ->with('errors', $errors)
                        ->with('eleveurs', $eleveurs)
                        ->with('added', $added)
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

}
