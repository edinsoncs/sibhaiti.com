<?php

class Admin_UsersController extends Admin_BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $search = NULL;
        if (Input::get('list'))
        {
            $form_data = Input::get('list');

            if (isset($form_data['delete']) && !empty($form_data['items']['selected']))
            {
                foreach ($form_data['items']['selected'] as &$id)
                {
                    $item = User::find($id);
                    $item->delete();
                }
                return Redirect::to(URL::route('adminusers'));
            }
            else if (isset($form_data['activate']) && !empty($form_data['items']['selected']))
            {
                foreach ($form_data['items']['selected'] as &$id)
                {
                    $item = User::find($id);
                    $item->isActv = TRUE;
                    $item->confirmed = TRUE;
                    $item->save();
                }
                return Redirect::to(URL::route('adminusers'));
            }
            else if (isset($form_data['deactivate']) && !empty($form_data['items']['selected']))
            {
                foreach ($form_data['items']['selected'] as &$id)
                {
                    $item = User::find($id);
                    $item->isActv = FALSE;
                    $item->save();
                }
                return Redirect::to(URL::route('adminusers'));
            }
            else
            {
                $this->messages['block'][] = 'Opps! you forgot to select one or more items';
            }
        }
        else
        {
            if (Input::get('search'))
            {
                $search = Input::get('search');
                $users = User::where('email', 'LIKE', '%' . $search . '%')->orWhere('fName', 'LIKE', '%' . $search . '%')->orWhere('lName', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'desc')->paginate(20);
            }
            else
            {
                $users = User::where('isActv','=',1)				->orderBy('role','desc')				->paginate(10);				
            }
            $title = 'Admin users list';
            $active_tab = 'admin_users_index';
            $page_id = 'admin_users_index';
            return View::make('admin.users.tab_list')
                            ->with('title', $title)
                            ->with('active_tab', $active_tab)
                            ->with('page_id', $page_id)
                            ->with('search', $search)
                            ->with('list', $users);
        }
    }

    public function login()
    {
        $input = array(
            'username' => Input::get('username'),
            'password' => Input::get('password'),
            'email' => Input::get('username'),
        );
        if (!empty($input) && Auth::attempt(array('email' => array_get($input, 'email'), 'password' => array_get($input, 'password'))) && Auth::user()->role == 'admin')
        {
            return Redirect::intended(URL::route('admindashboard'));
        }
        else
        {
            //die('autentication fail');
            //return Redirect::to(URL::route('/'));
            $errors = array();
            $title = 'Home admin';
            array_push($errors, array('Erreur d\'authentification'));
            return View::make('admin.home.index')
                            ->with('title', 'Admin')
                            ->with('errors', $errors);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function logout()
    {
        Auth::logout();
        return Redirect::to(URL::route('/'));
    }

    public function create()
    {
        $errors = array();
        if (Input::get('create'))
        {

            $form_data = Input::get('create');
            $user_arr = $form_data['user'];
            $rules = array(
                'fName' => 'Required',
                'lName' => 'Required',
                'email' => 'Required|Between:3,64|Email|Unique:users',
                'password' => 'Required|AlphaNum',
                'repeat_password' => 'Required|AlphaNum'
            );

            $messages = array(
                'email.required' => 'Le champ email est obligatoire!',
                'fName.required' => 'Le champ Prénom est obligatoire!',
                'lName.required' => 'Le champ Nom est obligatoire!',
                'password.required' => 'Le champ Mot de passe est obligatoire!',
                'repeat_password.required' => 'Le champ Re Mot de passe est obligatoire!',
            );

            $validator = Validator::make($user_arr, $rules, $messages);

            if ($validator->passes())
            {
                if (array_get($form_data, 'user.password') == array_get($form_data, 'user.repeat_password'))
                {
                    $user_exist = DB::table('users')->where('email', array_get($form_data, 'user.email'))->first();
                    if (!$user_exist)
                    {
                        unset($user_arr['repeat_password']);
                        $user_arr['isActv'] = TRUE;
                        $user_arr['confirmed'] = TRUE;
                        $user_arr['password'] = Hash::make($user_arr['password']);
                        //strlen($user_arr['password']) >= 8;
                        $user = new User($user_arr);
                        $user->save();
                        return Redirect::to(URL::route('adminusers'));
                    }
                    else
                    {
                        array_push($errors, array('L\'adresse courriel à été déjà enregistré dans le système'));
                    }
                }
                else
                {
                    array_push($errors, array('Erreur dans le mot de passe'));
                }
            }
            else
            {
                $errors = array_merge($errors, $validator->messages()->toArray());
            }
        }
        $title = 'Create user';
        $active_tab = 'admin_users_create';
        $page_id = 'admin_users_create';
        return View::make('admin.users.tab_create')
                        ->with('active_tab', $active_tab)
                        ->with('page_id', $page_id)
                        ->with('errors', $errors)
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
        $item = User::find($id);
        if (Input::get('edit'))
        {
            $form_data = Input::get('edit');
            $user_arr = array_get($form_data, 'user');
            $rules = array(
                'fName' => 'Required',
                'lName' => 'Required',
                'email' => 'Required|Between:3,64|Email',
            );

            $messages = array(
                'email.required' => 'Le champ email est obligatoire!',
                'fName.required' => 'Le champ Prénom est obligatoire!',
                'lName.required' => 'Le champ Nom est obligatoire!',
            );

            $validator = Validator::make($user_arr, $rules, $messages);

            if ($validator->passes())
            {
                $user_exist = User::where('email', array_get($form_data, 'user.email'))->where('id', '<>', $item->id)->first();
                if (!$user_exist)
                {
                    if (array_get($user_arr, 'password') != "" && array_get($user_arr, 'password') == array_get($user_arr, 'repeat_password'))
                    {
                        $user_arr['password'] = Hash::make($user_arr['password']);
                        array_push($errors, array('Votre mot de passe à été changé avec succes'));
                    }
                    else
                    {
                        $user_arr['password'] = $item->password;
                    }
                    $item->update($user_arr);
                    $item->save();
                    return Redirect::to(URL::route('adminusers'));
                }
                else
                {
                    array_push($errors, array('L\'adresse courriel à été déjà enregistré dans le système'));
                }
            }
            else
            {
                $errors = array_merge($errors, $validator->messages()->toArray());
            }
        }
        $title = 'Edit user';
        $active_tab = 'admin_users_edit';
        $page_id = 'admin_users_edit';

        $user = $item->toArray();

        if ($item && !empty($user))
        {
            return View::make('admin.users.tab_edit')
                            ->with('edit_item', $user)
                            ->with('active_tab', $active_tab)
                            ->with('page_id', $page_id)
                            ->with('errors', $errors)
                            ->with('title', $title);
        }
        else
        {
            return Redirect::to(URL::route('adminusers'));
        }
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

    public function resetpass($id)
    {

        $user = User::find($id);
        if ($user)
        {
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++)
            {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            $newpass = implode($pass);
            //dd($newpass);

            $user->password = Hash::make($newpass);
            $user->save();


            $subject = 'Changement de mot-de-passe';

            $data['text'] = "Bonjour " . $user->getFullNameAttribute() . " <" . $user->email . "> le nouveau mot-de-passe est: " . $newpass;
            $data['url'] = "http://sib.agriculture.gouv.ht/";
            $data['subject'] = $subject;

            //$user->email = 'hachrock@gmail.com';

            Mail::send('emails.register', $data, function($message) use ($user)
            {
                $email = $user->email;
                $cc = 'sibhaiti@gmail.com';
                $subject = 'Changement de mot-de-passe';
                $message->from('sib@agriculture.gouv.ht', 'Sib');
                $message->to($email)->cc($cc)->subject($subject);
            });
            return Redirect::to(URL::route('adminusers'));
        }
        return Redirect::to(URL::route('adminedituser', $id));
    }

}
