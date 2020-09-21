<?php

class EleveursController extends \BaseController {

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

    public function index($id = NULL, $city = NULL){
        $search = NULL;
        if (Input::get('list')){
            $form_data = Input::get('list');
            if (isset($form_data['delete']) && !empty($form_data['items']['selected'])){
                foreach ($form_data['items']['selected'] as &$id){
                    $item = Eleveur::find($id);
                    if ($item->cin != '00-00-00-0000-00-00000'){
                        $item->delete();
                    }
                }
                return Redirect::to(URL::route('eleveurs'));
            }elseif(isset($form_data['activate']) && !empty($form_data['items']['selected'])){
                foreach ($form_data['items']['selected'] as &$id){
                    $item = Eleveur::find($id);
                    $item->isActv = TRUE;
                    $item->save();
                }
                return Redirect::to(URL::route('eleveurs'));
            }elseif(isset($form_data['deactivate']) && !empty($form_data['items']['selected'])){
                foreach ($form_data['items']['selected'] as &$id){
                    $item = Eleveur::find($id);
                    $item->isActv = FALSE;
                    $item->save();
                }
                return Redirect::to(URL::route('eleveurs'));
            }else{
                $this->messages['block'][] = 'Opps! you forgot to select one or more items';
            }
        }else{
            if ($id != NULL && $city != NULL){
                $eleveurs = Eleveur::where('department', $id)->where('city', $city)->orderBy('id', 'desc')->paginate(10);
            }elseif($id != NULL){
                $eleveurs = Eleveur::where('department', $id)->orderBy('city', 'asc')->paginate(10);
            }elseif(Input::get('search')){
                $search = Input::get('search');
                $eleveurs = Eleveur::where('isActv', '<>', FALSE)
                                //->where('desc', Auth::user()->id)
                                ->where(function($query){
                                    $query->where('fName', 'LIKE', '%' . Input::get('search') . '%')
                                    // ->orWhere('nif', 'LIKE', '%' . Input::get('search') . '%')
                                    ->orWhere('cin', 'LIKE', '%' . Input::get('search') . '%')
                                    ->orWhere('idEleveur', 'LIKE', '%' . Input::get('search') . '%');
                                })->orderBy('cin', 'asc')->paginate(10);
            }else{
                if (Auth::user()->role == 'user'){
                    $eleveurs = NULL;
                }else{
                    //$eleveurs = Eleveur::where('isActv', '<>', FALSE)->where('desc', Auth::user()->id)->orWhere('cin', '00-00-00-0000-00-00000')->orderBy('nif', 'desc')->orderBy('created_at', 'desc')->paginate(10);
                    $eleveurs = Eleveur::where('desc', Auth::user()->id)->orWhere('cin', '00-00-00-0000-00-00000')->orderBy('nif', 'desc')->orderBy('created_at', 'desc')->paginate(5);
                }
            }
            $title = 'Elvè Yo';
            $active_tab = 'eleveurs_index';
            $page_id = 'eleveurs_index';
            return View::make('eleveurs.tab_list')
                            ->with('title', $title)
                            ->with('active_tab', $active_tab)
                            ->with('page_id', $page_id)
                            ->with('search', $search)
                            ->with('list', $eleveurs);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $errors = array();
        $eleveur_arr = array();
        if (Input::get('create'))
        {
            $form_data = Input::get('create');
            $eleveur_arr = $form_data['eleveur'];
            $rules = array(
                'fName' => 'Required',
                'lName' => 'Required',
                'cin' => 'Required|Unique:eleveurs',
                'sex' => 'Required',
                'fiche' => 'Required',
                'department' => 'Required',
                'city' => 'Required',
            );

            $messages = array(
                'fName.required' => 'Siyati obligatwa',
                'lName.required' => 'Non obligatwa',
                'sex.required' => 'Sèks obligatwa',
                'cin.required' => 'CIN obligatwa',
                'cin.unique' => '#CIN sa a anrejistre nan Sib deja!',
                'fiche.required' => 'Fich obligatwa',
                'department.required' => 'Depatman obligatwa',
                'city.required' => 'Komin obligatwa',
            );

            $validator = Validator::make($eleveur_arr, $rules, $messages);

            if ($validator->passes())
            {
                if (array_get($eleveur_arr, 'cin') && strlen(array_get($eleveur_arr, 'cin')) >= 14)
                {
                    $year = substr(array_get($eleveur_arr, 'cin'), 11, 2);
                }
                else if (array_get($eleveur_arr, 'nif') && strlen(array_get($eleveur_arr, 'nif')) >= 14)
                {
                    $year = substr(array_get($eleveur_arr, 'nif'), 10, 2);
                }
                else
                {
                    $year = rand(10, 99);
                }
                $ideleveur = strtoupper(substr(array_get($eleveur_arr, 'lName'), 0, 3) . substr(array_get($eleveur_arr, 'fName'), 0, 1) . array_get($eleveur_arr, 'department') . $year . rand(1000, 9999));
                $eleveur_exist = Eleveur::where('idEleveur', $ideleveur)->first();
                while ($eleveur_exist)
                {
                    $ideleveur = strtoupper(substr(array_get($eleveur_arr, 'lName'), 0, 2) . substr(array_get($eleveur_arr, 'fName'), 0, 1) . array_get($eleveur_arr, 'department') . $year . rand(1000, 9999));
                    $eleveur_exist = Eleveur::where('idEleveur', $ideleveur)->first();
                }
                $eleveur_arr['idEleveur'] = $ideleveur;
                $eleveur_arr['isActv'] = TRUE;
                $eleveur_arr['desc'] = Auth::user()->id;
                //$eleveur_arr['email'] = (Array_get($eleveur_arr, 'email')) ? $eleveur_arr['email'] : $eleveur_arr['fName'] . $eleveur_arr['lName'] . '@gmail.com';
                $eleveur = new Eleveur($eleveur_arr);
                $eleveur->save();
                return Redirect::to(URL::route('createanimal', $eleveur->id));
                //return Redirect::to(URL::route('eleveurs'));
            }
            else
            {
                $errors = array_merge($errors, $validator->messages()->toArray());
            }
        }
        $title = 'Create Eleveur';
        $active_tab = 'eleveurs_create';
        $page_id = 'eleveurs_create';
        return View::make('eleveurs.tab_create')
                        ->with('active_tab', $active_tab)
                        ->with('page_id', $page_id)
                        ->with('errors', $errors)
                        ->with('item_arr', $eleveur_arr)
                        ->with('title', $title);
    }

    public function city($id = NULL)
    {
        $search = NULL;

        if ($id != NULL)
        {
            $eleveurs = Eleveur::where('city', $id)->orderBy('cSection', 'asc')->paginate(20);
        }
        elseif (Input::get('search'))
        {
            $search = Input::get('search');
            $eleveurs = Eleveur::where('email', 'LIKE', '%' . $search . '%')->orWhere('fName', 'LIKE', '%' . $search . '%')->orWhere('lName', 'LIKE', '%' . $search . '%')->orWhere('idEleveur', 'LIKE', '%' . $search . '%')->paginate(20);
        }
        else
        {
            $eleveurs = Eleveur::paginate(20);
        }
        $title = 'Eleveurs list';
        $active_tab = 'eleveurs_index';
        $page_id = 'eleveurs_index';
        return View::make('eleveurs.tab_list')
                        ->with('title', $title)
                        ->with('active_tab', $active_tab)
                        ->with('page_id', $page_id)
                        ->with('search', $search)
                        ->with('list', $eleveurs);
    }

    public function section($dept = NULL, $cit = NULL, $sec = NULL)
    {
        if ($dept && $cit && $sec)
        {
            $eleveurs = Eleveur::where('isActv', TRUE)->where('department', $dept)->where('city', $cit)->where('cSection', $sec)->paginate(20);
            $title = 'Eleveurs list';
            $active_tab = 'eleveurs_index';
            $page_id = 'eleveurs_index';
            return View::make('eleveurs.tab_list')
                            ->with('title', $title)
                            ->with('active_tab', $active_tab)
                            ->with('page_id', $page_id)
                            ->with('list', $eleveurs);
        }
        else
        {
            return Redirect::to(URL::route('eleveurs'));
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
        $edit_item = Eleveur::find($id);
        //var_dump($edit_item->toArray()); die();
        if (Input::get('edit') && $edit_item->id != 60)
        {
            $form_data = Input::get('edit');
            $eleveur_arr = $form_data['eleveur'];
            $rules = array(
                'fName' => 'Required',
                'lName' => 'Required',
                'cin' => 'Required',
                'sex' => 'Required',
                'fiche' => 'Required',
                'department' => 'Required',
                'city' => 'Required',
            );

            $messages = array(
                'fName.required' => 'Siyati obligatwa',
                'lName.required' => 'Non obligatwa',
                'sex.required' => 'Sèks obligatwa',
                'cin.required' => 'CIN obligatwa',
                'cin.unique' => '#CIN sa a anrejistre nan Sib deja!',
                'fiche.required' => 'Fich obligatwa',
                'department.required' => 'Depatman obligatwa',
                'city.required' => 'Komin obligatwa',
            );

            $validator = Validator::make($eleveur_arr, $rules, $messages);

            if ($validator->passes())
            {
                $old = $edit_item->toArray();
                $new = $eleveur_arr;
                $edit_item->update($eleveur_arr);
                $systemlog = Systemlog::create(array());
                $systemlog->history('Eleveur', $old, $new);
                $systemlog->user()->associate($this->user);
                $systemlog->save();

                return Redirect::to(URL::route('eleveurs'));
            }
            else
            {
                $errors = array_merge($errors, $validator->messages()->toArray());
            }
        }
        $title = 'Edit Eleveur';
        $active_tab = 'eleveurs_edit';
        $page_id = 'eleveurs_edit';
        $edit_item = $edit_item->toArray();
        return View::make('eleveurs.tab_edit')
                        ->with('active_tab', $active_tab)
                        ->with('page_id', $page_id)
                        ->with('edit_item', $edit_item)
                        ->with('errors', $errors)
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
