<?php

class UsersController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if (Input::get())
        {
            $input = array(
                'username' => Input::get('username'),
                'password' => Input::get('password'),
                'email' => Input::get('username'),
            );
            if (!empty($input) && Auth::attempt(array('email' => array_get($input, 'email'), 'password' => array_get($input, 'password'))))
            {
                //var_dump(Auth::user()->confirmed); die();
                if (Auth::user()->confirmed == "1" && Auth::user()->isActv == TRUE)
                {
                    return Redirect::intended(URL::route('dashboard'));
                } else
                {
                    Auth::logout();
                    $errors = array();
                    $title = 'Home';
                    array_push($errors, array('SVP activer votre compte'));
                    return View::make('index')
                                    ->with('title', 'Home')
                                    ->with('errors', $errors);
                }
            } else
            {
                $errors = array();
                $title = 'Home';
                array_push($errors, array('Erreur d\'authentification'));
                return View::make('index')
                                ->with('title', 'Home')
                                ->with('errors', $errors);
            }
        } else
        {
            return Redirect::to(URL::route('/'));
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
        $user_arr = array();
        if (Input::get('create'))
        {
            $form_data = Input::get('create');
            $user_arr = $form_data['user'];
            $rules = array(
                'captcha' => 'Required|captcha',
                'fName' => 'Required',
                'lName' => 'Required',
                'email' => 'Required|Between:3,64|Email',
                'password' => 'Required|Between:8,20',
                'repeat_password' => 'Required|Between:8,20'
            );
            $messages = array(
                'email.unique' => 'L\'adresse courriel à été déjà enregistré dans le système!',
                'email.required' => 'Le champ email est obligatoire!',
                'fName.required' => 'Le champ Prénom est obligatoire!',
                'lName.required' => 'Le champ Nom est obligatoire!',
                'password.required' => 'Le champ Mot de passe est obligatoire!',
                'repeat_password.required' => 'Le champ Re mot de passe est obligatoire!',
                'captcha.required' => 'Le champ Code de sécurité est obligatoire!',
                //'password.confirmed' => 'Le champ Mot de passe doit correspondre avec et le champ Re mot de passe!',
                'captcha.captcha' => 'S\'il vous plaît confirmer le code de sécurité!',
            );
            $validator = Validator::make($user_arr, $rules, $messages);
            if ($validator->passes())
            {
                $form_data = Input::get('create');

                if (array_get($form_data, 'user.password') == array_get($form_data, 'user.repeat_password') && strlen(array_get($form_data, 'user.password')) >= 8)
                {
                    $user_exist = User::where('email', array_get($user_arr, 'email'))->first();
                    if (!$user_exist)
                    {
                        unset($user_arr['repeat_password']);
                        $user_arr['isActv'] = FALSE;
                        $user_arr['confirmed'] = md5(microtime() . rand());
                        $user_arr['role'] = 'user';
                        $user_arr['password'] = Hash::make($user_arr['password']);
                        $user = new User($user_arr);
                        $user->save();

                        $subject = 'Bienvenue dans Sib';

                        $data['text'] = "Bonjour " . $user->getFullNameAttribute() . ", pour activer votre compte consultez le lien suivant: ";
                        $data['url'] = URL::route('confirmation', $user_arr['confirmed']);
                        $data['subject'] = $subject;

                        //$user->email = 'hachrock@gmail.com';

                        Mail::send('emails.register', $data, function($message) use ($user)
                        {

                            $subject = 'Confirmation';
                            $message->from('sib@agriculture.gouv.ht', 'Sib');
                            $message->to('sibhaiti@gmail.com')->subject($subject);
							$message->to('billymanjaro07@gmail.com')->subject($subject);
							$message->to('drmatino@gmail.com')->subject($subject);
							
							
                        });

                        $title = 'Confirmation';
                        $page_id = 'register_user';
                        return View::make('users.confirmation')
                                        ->with('page_id', $page_id)
                                        ->with('url', $data['url'])
                                        ->with('title', $title);
                    } else
                    {
                        array_push($errors, array('Erreur Email!'));
                    }
                } else
                {
                    array_push($errors, array('Erreur Mot-de-passe !'));
                }
            } else
            {
                $errors = array_merge($errors, $validator->messages()->toArray());
            }
        }
        $title = 'Register user';
        $page_id = 'register_user';
        return View::make('users.register')
                        ->with('page_id', $page_id)
                        ->with('errors', $errors)
                        ->with('user_arr', $user_arr)
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

    public function logout()
    {
        Auth::logout();
        return Redirect::to(URL::route('/'));
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

    public function confirmation($id)
    {
        $user = User::where('confirmed', $id)->first();
        if ($user)
        {
            //var_dump($t_user->toArray()); die();
            $user->confirmed = TRUE;
            $user->isActv = TRUE;
            $user->save();
            $msg = "Merci, votre compte à été active avec succès";
        } else
        {
            $msg = "Erreur d'activation de compte";
        }


        $title = 'User activation';
        $page_id = 'activation_user';
        return View::make('users.activation')
                        ->with('page_id', $page_id)
                        ->with('msg', $msg)
                        ->with('title', $title);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit()
    {
        $title = 'Edit User';
        $page_id = 'edit_user';
        $errors = array();

        if (Input::get('edit'))
        {
            $item = Auth::user();
            $form_data = Input::get('edit');

            $user_arr = array_get($form_data, 'user');

            $user_exist = DB::table('users')->where('email', array_get($form_data, 'user.email'))->where('id', '<>', Auth::user()->id)->first();
            //var_dump($user_exist); die();
            if (!$user_exist)
            {
                if (array_get($user_arr, 'password') != "")
                {
                    if (array_get($user_arr, 'password') == array_get($user_arr, 'repeat_password'))
                    {
                        $user_arr['password'] = array_get($user_arr, 'password');
                        array_push($errors, array('Votre mot de passe à été changé avec succes'));
                    } else
                    {
                        array_push($errors, array('Mot de passe incorrect'));
                    }
                } else
                {
                    $user_arr['password'] = $item->password;
                }
                $item->update($user_arr);
                $item->save();
                array_push($errors, array('Votre profil à été miss à jour avec succes'));
            } else
            {
                array_push($errors, array('L\'adresse courriel à été déjà enregistré dans le système'));
            }
        }
        $id = Auth::user()->id;
        $user = User::find($id);
        return View::make('users.edit')
                        ->with('edit_item', $user)
                        ->with('page_id', $page_id)
                        ->with('errors', $errors)
                        ->with('title', $title);
    }

    public function dashboard()
    {
        if (Auth::user()->role != 'user')
        {
            return Redirect::to(URL::route('eleveurs'));
        }
        $page_id = 'dashboard';
        $title = 'Dashboard';
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
                $header = array('Non','telefòn', 'Cheptèl', 'CIN', '#fich', 'Depatman', 'komin', 'seksyon kominal', '', '');

                $query = Eleveur::orderBy('created_at', 'desc');

                if ($obj != "" && $text != "")
                {
                    if ($obj == 'cin')
                    {
                        $query->where('cin', 'LIKE', '%' . $text . '%');
                    }
                }else if ($text != "")
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
            } else if ($type == 'agent')
            {
                $header = array('siyati ak non', 'telefòn', '#so ajan', 'Depatman', 'komin', 'seksyon kominal');

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
                }else if ($text != "")
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
            } else if ($type == 'animal')
            {
                $header = array('#Tag', '#Kanè', 'Elvè', '#So Ajan', 'Depatman', 'komin', 'seksyon kominal', '');

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
            }else if ($type == 'abattoir')
            {
                $header = array('NON', 'TIP', 'DEPATMAN', 'KOMIN', 'SEKSYON', 'TOTAL BÈF', 'KABRIT', 'MOUTON', 'KOCHON', 'BÈF', '');

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

            return View::make('dashboard.search')
                            ->with('page_id', $page_id)
                            ->with('errors', $errors)
                            ->with('title', $title)
                            ->with('departments', $departments)
                            ->with('search', $search)
                            ->with('list', $list)
                            ->with('header', $header)
                            ->with('type', $type);
        } else if (Input::get('filter'))
        {
            $form_data = Input::get('filter');
            //dd($form_data);
            $dept = array_get($form_data, 'department');
            $city = (array_get($form_data, 'city') != "Chwazi komin...") ? array_get($form_data, 'city') : NULL;
            $department = User::getDepartmentOBJ($dept);
            return View::make('dashboard.index')
                            ->with('page_id', $page_id)
                            ->with('errors', $errors)
                            ->with('title', $title)
                            ->with('department', $department)
                            ->with('city', $city)
                            ->with('departments', $departments)
                            ->with('filters', $form_data);
        }

        return View::make('dashboard.index')
                        ->with('page_id', $page_id)
                        ->with('errors', $errors)
                        ->with('title', $title)
                        ->with('departments', $departments)
                        ->with('search', $search);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function forgotpassword()
    {
        $title = 'Forgot password';
        $page_id = 'forgotpassword';
        $errors = array();

        if (Input::get('password'))
        {
            $form_data = Input::get('password');
            $rules = array(
                'captcha' => 'Required|captcha',
                'fName' => 'Required',
                'lName' => 'Required',
                'email' => 'Required|Between:3,64|Email',
                'password' => 'Required|Between:8,20',
                're_password' => 'Required|Between:8,20'
            );
            $messages = array(
                'email.unique' => 'L\'adresse courriel à été déjà enregistré dans le système!',
                'email.required' => 'Le champ email est obligatoire!',
                'fName.required' => 'Le champ Prénom est obligatoire!',
                'lName.required' => 'Le champ Nom est obligatoire!',
                'password.required' => 'Le champ Mot de passe est obligatoire!',
                're_password.required' => 'Le champ Re mot de passe est obligatoire!',
                'captcha.required' => 'Le champ Code de sécurité est obligatoire!',
                //'password.confirmed' => 'Le champ Mot de passe doit correspondre avec et le champ Re mot de passe!',
                'captcha.captcha' => 'S\'il vous plaît confirmer le code de sécurité!',
            );
            $validator = Validator::make($form_data, $rules, $messages);
            if ($validator->passes())
            {
                //var_dump($form_data);
                //die();
                if (array_get($form_data, 'password') == array_get($form_data, 'password'))
                {
                    $user = User::where('email', array_get($form_data, 'email'))->first();
                    if ($user && $user->fName == array_get($form_data, 'fName') && $user->lName == array_get($form_data, 'lName'))
                    {
                        $user->password = Hash::make(array_get($form_data, 'password'));
                        $user->save();
                        array_push($errors, array('Mot de passe changé avec succès'));
                    } else
                    {
                        array_push($errors, array('SVP, verifier votre Prenom, nom et courriel'));
                    }
                } else
                {
                    array_push($errors, array('Mot de passe incorrect'));
                }
            } else
            {
                $errors = array_merge($errors, $validator->messages()->toArray());
            }
        }

        return View::make('users.forgotpassword')
                        ->with('page_id', $page_id)
                        ->with('title', $title)
                        ->with('errors', $errors);
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

}
