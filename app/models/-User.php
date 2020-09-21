<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');
    protected $guarded = array('id');
    protected $fillable = array(
        'email',
        'fName',
        'lName',
        'phone',
        'role',
        'password',
        'confirmed',
        'isActv',
        'lrank',
        'hrank',
        'desc'
    );

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function notifications($type = NULL)
    {
        $notifications = 0;
        if ($type)
        {
            $notifications = Notification::where('type', 'a')->where('desc', $this->id)->remember(10)->count();
        }
        return $notifications;
    }

    public function finduser($id)
    {
        $user = User::find($id);
        if ($user)
        {
            return $user->getFullNameAttribute();
        }
        return NULL;
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function animals()
    {
        $animals = Animal::where('isActv', TRUE)->where('desc', $this->id)->remember(10)->count();
        return $animals;
    }

    public function eleveurs()
    {
        $eleveurs = Eleveur::where('isActv', TRUE)->where('desc', $this->id)->remember(10)->count();
        return $eleveurs;
    }

    public function agents()
    {
        $agents = Agent::where('isActv', TRUE)->where('desc', $this->id)->remember(10)->count();
        return $agents;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the e-mail address where password reminders are sent.
     *
     * @return string
     */
    public function getReminderEmail()
    {
        return $this->email;
    }

    public static function checkIfExists($attributes)
    {
        $existing_user = FALSE;

        if (isset($attributes['email']))
        {
            $existing_user = static::where('email', $attributes['email'])->first();
        }

        return $existing_user;
    }

    public function getFullNameAttribute()
    {
        return $this->fName . ' ' . $this->lName;
    }

    static function getFirstCity($dept)
    {
        $cities = User::getCities($dept);
        if (array_get($cities, 0))
        {
            return(array_get($cities[0], 'id'));
        }
        return NULL;
    }

    static function deptCounter($type = NULL, $dept = NULL, $city = NULL)
    {
        if ($type != NULL && $dept != NULL)
        {
            $result = 0;
            if ($city != NULL)
            {
                if ($type == 'animal')
                {
                    $result = Animal::where('isActv', TRUE)->where('department', $dept)->where('city', $city)->count();
                }
                else if ($type == 'agent')
                {
                    $result = Agent::where('isActv', TRUE)->where('department', $dept)->where('city', $city)->count();
                }
                else if ($type == 'eleveur')
                {
                    $result = Eleveur::where('isActv', TRUE)->where('department', $dept)->where('city', $city)->count();
                }
                else if ($type == 'abbatage')
                {
                    $result = Abattoir::where('isActv', TRUE)->where('dept', $dept)->where('city', $city)->count();
                }
            }
            else
            {
                if ($type == 'animal')
                {
                    $result = Animal::where('isActv', TRUE)->where('department', $dept)->count();
                }
                else if ($type == 'agent')
                {
                    $result = Agent::where('isActv', TRUE)->where('department', $dept)->count();
                }
                else if ($type == 'eleveur')
                {
                    $result = Eleveur::where('isActv', TRUE)->where('department', $dept)->count();
                }
                else if ($type == 'abbatage')
                {
                    $result = Abattoir::where('isActv', TRUE)->where('dept', $dept)->count();
                    //$result = Address::where('isActv', TRUE)->where('department', $dept)->where('rOb', 'abattoir')->count();
                    // $result = Notification::where('isActv', TRUE)->where('department', $dept)->where('type', 'a')->count();
                }
            }
            return $result;
        }
        return NULL;
    }

    static function cityCounter($type = NULL, $dept = NULL, $city = NULL)
    {
        if ($type != NULL && $dept != NULL && $city != NULL)
        {
            $result = 0;
            if ($type == 'animal')
            {
                $result = Animal::where('isActv', TRUE)->where('department', $dept)->where('city', $city)->remember(10)->get();
            }
            else if ($type == 'agent')
            {
                $result = Agent::where('isActv', TRUE)->where('department', $dept)->where('city', $city)->remember(10)->get();
            }
            else if ($type == 'eleveur')
            {
                $result = Eleveur::where('isActv', TRUE)->where('department', $dept)->where('city', $city)->remember(10)->get();
            }
            else if ($type == 'abattoir')
            {
                $result = Abattoir::where('isActv', TRUE)->where('dept', $dept)->where('city', $city)->remember(10)->get();
            }
            return count($result);
        }
        return NULL;
    }

    static function sectionCounter($type = NULL, $dept = NULL, $city = NULL, $section = NULL)
    {
        if ($type != NULL && $dept != NULL && $city != NULL && $section != NULL)
        {
            $result = 0;
            if ($type == 'animal')
            {
                $result = Animal::where('isActv', TRUE)->where('department', $dept)->where('city', $city)->where('cSection', $section)->remember(10)->get();
            }
            else if ($type == 'agent')
            {
                $result = Agent::where('isActv', TRUE)->where('department', $dept)->where('city', $city)->where('cSection', $section)->remember(10)->get();
            }
            else if ($type == 'eleveur')
            {
                $result = Eleveur::where('isActv', TRUE)->where('department', $dept)->where('city', $city)->where('cSection', $section)->remember(10)->get();
            }
            else if ($type == 'abattoir')
            {
                $result = Abattoir::where('isActv', TRUE)->where('dept', $dept)->where('city', $city)->where('cSection', $section)->remember(10)->get();
            }
            return count($result);
        }
        return NULL;
    }

    static function getDepartment($dept = NULL)
    {
        if ($dept != NULL)
        {
            $departments = User::departments();
            foreach ($departments as $deparment)
            {
                if (array_get($deparment, 'id') == $dept)
                {
                    return array_get($deparment, 'name');
                }
            }
        }
        return NULL;
    }

    static function getDepartmentOBJ($dept = NULL)
    {
        if ($dept != NULL)
        {
            $departments = User::departments();
            foreach ($departments as $deparment)
            {
                if (array_get($deparment, 'id') == $dept)
                {
                    return $deparment;
                }
            }
        }
        return NULL;
    }

    static function getCity($dept = NULL, $city = NULL)
    {
        if ($dept != NULL && $city != NULL)
        {
            $departments = User::departments();
            foreach ($departments as $deparment)
            {
                if (array_get($deparment, 'id') == $dept)
                {
                    $cities = array_get($deparment, 'cities');
                    if (!empty($cities))
                    {
                        foreach ($cities as $cityitem)
                        {
                            if (array_get($cityitem, 'id') == $city)
                            {
                                return array_get($cityitem, 'name');
                            }
                        }
                    }
                }
            }
        }
        return NULL;
    }

    static function getSection($dept = NULL, $city = NULL, $section = NULL)
    {
        if ($dept != NULL && $city != NULL && $section != NULL)
        {
            $departments = User::departments();
            foreach ($departments as $deparment)
            {
                if (array_get($deparment, 'id') == $dept)
                {
                    $cities = array_get($deparment, 'cities');
                    if (!empty($cities))
                    {
                        foreach ($cities as $cityitem)
                        {
                            if (array_get($cityitem, 'id') == $city)
                            {
                                $sections = array_get($cityitem, 'sections');
                                if (!empty($sections))
                                {
                                    foreach ($sections as $sec)
                                    {
                                        if (array_get($sec, 'id') == $section)
                                        {
                                            return array_get($sec, 'name');
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return NULL;
    }

    static function getCities($dept = NULL)
    {
        if ($dept != NULL)
        {
            $departments = User::departments();
            foreach ($departments as $department)
            {
                if (array_get($department, 'id') == $dept)
                {
                    return array_get($department, 'cities');
                }
            }
        }
        return NULL;
    }

    static function getSections($dept = NULL, $city = NULL)
    {
        if ($dept != NULL && $city != NULL)
        {
            $departments = User::departments();
            foreach ($departments as $department)
            {
                if (array_get($department, 'id') == $dept)
                {
                    $cities = array_get($department, 'cities');
                    if (!empty($cities))
                    {
                        foreach ($cities as $cityitem)
                        {
                            if (array_get($cityitem, 'id') == $city)
                            {
                                return array_get($cityitem, 'sections');
                            }
                        }
                    }
                }
            }
        }
        return NULL;
    }

    static function departments()
    {
        $departments = array(
// DEBUT
// =============================DEBUT DEPARTEMENT NORD =====================
            array( //ENKONI
                'id'=> '000',
                'name'=>'Departement ENKONI',
                'cities'=> array(
                    array(

                        'id'=>'0000',
                        'name'=>'Commune ENKONI (Ntl)',
                        'sections'=>array(
                            array(
                            'id'=>'0000-00',
                            'name'=>'Section ENKONI (Ntl)'
                )
            )
                )
            )),
                

            array(// DEPARTEMENT DU NORD

                'id' => '031',
                'name' => 'Nò',
                'cities' => array(
                    //-------------------------------------------
                    array(
                        'id' => '0310',
                        'name' => 'Commune ENKONI (NO)',
                        'sections' => array(
                            array(
                                'id' => '0310-00',
                                'name' => 'Section ENKONI (NO)'
                        )
                        )
                        ),
                    //-----------------------------------------------------
                    array(
                        'id' => '0311',
                        'name' => 'Cap-Haïtien',
                        'sections' => array(
                            array(
                                'id' => '0311-90',
                                'name' => 'Ville du Cap-Haïtien'
                            ),
                            array(
                                'id' => '0311-80',
                                'name' => 'Quartier de Petit Anse'
                            ),
                            array(
                                'id' => '0311-01',
                                'name' => '1ère Sect. Bande du Nord'
                            ),
                            array(
                                'id' => '0311-02',
                                'name' => '2ème Sect. Haut du Cap'
                            ),
                            array(
                                'id' => '0311-03',
                                'name' => '3ème Sect. Petit Anse'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0312',
                        'name' => 'Quartier-Morin',
                        'sections' => array(
                            array(
                                'id' => '0312-90',
                                'name' => 'Ville de Quartier-Morin'
                            ),
                            array(
                                'id' => '0312-01',
                                'name' => '1ère Sect. Basse Plaine'
                            ),
                            array(
                                'id' => '0312-02',
                                'name' => '2ème Sect. Morne Pelé'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0313',
                        'name' => 'Limonade',
                        'sections' => array(
                            array(
                                'id' => '0313-90',
                                'name' => 'Ville de Limonade'
                            ),
                            array(
                                'id' => '0313-80',
                                'name' => 'Quartier de Bord de Mer Limonade'
                            ),
                            array(
                                'id' => '0313-01',
                                'name' => ' 1ère Sect. Basse Plaine'
                            ),
                            array(
                                'id' => '0313-02',
                                'name' => '2ème Sect. Bois de Lance'
                            ),
                            array(
                                'id' => '0313-03',
                                'name' => '3ème Sect. Roucou'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0321',
                        'name' => 'Acul-du-nord',
                        'sections' => array(
                            array(
                                'id' => '0321-90',
                                'name' => ' Ville de l\'Acul du Nord'
                            ),
                            array(
                                'id' => '0321-80',
                                'name' => 'Quartier la Soufrière'
                            ),
                            array(
                                'id' => '0321-81',
                                'name' => 'Quartier Camp-Louise'
                            ),
                            array(
                                'id' => '0321-01',
                                'name' => '   1ère Sect. Camp-Louise'
                            ),
                            array(
                                'id' => '0321-02',
                                'name' => ' 2ème Sect. Bas de l\'Acul (Bassse  Plaine)'
                            ),
                            array(
                                'id' => '0321-03',
                                'name' => '3ème Sect. Mornet'
                            ),
                            array(
                                'id' => '0321-04',
                                'name' => '4ème Sect. Grande Ravine'
                            ),
                            array(
                                'id' => '0321-05',
                                'name' => '5ème Sect. Coupe-à-David'
                            ),
                            array(
                                'id' => '0321-06',
                                'name' => '6ème Sect. Soufrière'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0322',
                        'name' => 'Plaine du Nord',
                        'sections' => array(
                            array(
                                'id' => '0322-90',
                                'name' => 'Ville de la Plaine du Nord'
                            ),
                            array(
                                'id' => '0322-80',
                                'name' => 'Quartier Robillard'
                            ),
                            array(
                                'id' => '0322-01',
                                'name' => '1ère Sect. Morne Rouge '
                            ),
                            array(
                                'id' => '0322-02',
                                'name' => '2ème Sect. Basse Plaine '
                            ),
                            array(
                                'id' => '0322-03',
                                'name' => ' 3ème Sect. Grand Boucan'
                            ),
                            array(
                                'id' => '0322-04',
                                'name' => ' 4ème Sect. Bassin Diamant'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0323',
                        'name' => 'Milot',
                        'sections' => array(
                            array(
                                'id' => '0323-90',
                                'name' => 'Ville de Milot'
                            ),
                            array(
                                'id' => '0323-80',
                                'name' => 'Quartier Carrefour des Pères'
                            ),
                            array(
                                'id' => '0323-01',
                                'name' => ' 1ère Sect. Perches-de-Bonnet'
                            ),
                            array(
                                'id' => '0323-02',
                                'name' => ' 2ème Sect. Bonnet-à-l\'Evèque'
                            ),
                            array(
                                'id' => '0323-03',
                                'name' => '3ème Sect. Génipailler'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0331',
                        'name' => 'Grande-riviere',
                        'sections' => array(
                            array(
                                'id' => '0331-90',
                                'name' => 'Ville de Grande Rivière du Nord'
                            ),
                            array(
                                'id' => '0331-01',
                                'name' => '1ère Sect. Grand Gilles'
                            ),
                            array(
                                'id' => '0331-02',
                                'name' => '2ème Sect. Solon'
                            ),
                            array(
                                'id' => '0331-03',
                                'name' => '3ème Sect. Caracol'
                            ),
                            array(
                                'id' => '0331-04',
                                'name' => '4ème Sect. Gambade'
                            ),
                            array(
                                'id' => '0331-05',
                                'name' => ' 5ème Sect. Joli-trou'
                            ),
                            array(
                                'id' => '0331-06',
                                'name' => '6ème Sect. Cormiers'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0332',
                        'name' => 'bahon',
                        'sections' => array(
                            array(
                                'id' => '0332-90',
                                'name' => 'Ville de Bahon'
                            ),
                            array(
                                'id' => '0332-01',
                                'name' => '1ère Sect. de Bois Pin'
                            ),
                            array(
                                'id' => '0332-02',
                                'name' => '2ème Sect. Bailla ou Bailly'
                            ), array(
                                'id' => '0332-03',
                                'name' => '3ème Sect. Montagne Noire'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0341',
                        'name' => 'st-raphael',
                        'sections' => array(
                            array(
                                'id' => '0341-90',
                                'name' => 'Ville de Saint-Raphaël'
                            ),
                            array(
                                'id' => '0341-01',
                                'name' => '1ère Sect. Bois-Neuf'
                            ),
                            array(
                                'id' => '0341-02',
                                'name' => ' 2ème Sect. Mathurin'
                            ),
                            array(
                                'id' => '0341-03',
                                'name' => ' 3ème Sect. Bouyaha'
                            ),
                            array(
                                'id' => '0341-04',
                                'name' => ' 4ème Sect. San-Yago'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0342',
                        'name' => 'dondon',
                        'sections' => array(
                            array(
                                'id' => '0342-90',
                                'name' => 'Ville de Dondon'
                            ),
                            array(
                                'id' => '0342-01',
                                'name' => ' 1ère Sect. Brostage'
                            ),
                            array(
                                'id' => '0342-02',
                                'name' => '2ème Sect. Bassin Caïman'
                            ),
                            array(
                                'id' => '0342-03',
                                'name' => '3ème Sect. Matador'
                            ),
                            array(
                                'id' => '0342-04',
                                'name' => '4ème Sect. Laguille'
                            ),
                            array(
                                'id' => '0342-05',
                                'name' => '  5ème Sect. Haut du Trou'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0343',
                        'name' => 'Ranquitte',
                        'sections' => array(
                            array(
                                'id' => '0343-90',
                                'name' => ' Ville de Ranquitte'
                            ),
                            array(
                                'id' => '0343-01',
                                'name' => '1ère Sect. de Bac-à-Soude'
                            ),
                            array(
                                'id' => '0343-02',
                                'name' => '2ème Sect. Bois de Lance'
                            ),
                            array(
                                'id' => '0343-03',
                                'name' => '3ème Sect. Cracaraille'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0344',
                        'name' => 'pignon',
                        'sections' => array(
                            array(
                                'id' => '0344-90',
                                'name' => 'Ville de Pignon'
                            ),
                            array(
                                'id' => '0344-01',
                                'name' => '1ère Sect. de Savannette'
                            ),
                            array(
                                'id' => '0344-02',
                                'name' => '2ème Sect. La Belle Mère'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0345',
                        'name' => 'La victoire',
                        'sections' => array(
                            array(
                                'id' => '0345-90',
                                'name' => 'Ville de La Victoire'
                            ),
                            array(
                                'id' => '0345-01',
                                'name' => '1ère Sect. de La Victoire'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0351',
                        'name' => 'borgne',
                        'sections' => array(
                            array(
                                'id' => '0351-90',
                                'name' => 'Ville du Borgne'
                            ),
                            array(
                                'id' => '0351-80',
                                'name' => 'Quartier du Petit Bourg de Borgne'
                            ),
                            array(
                                'id' => '0351-01',
                                'name' => '1ère Sect. Margot'
                            ),
                            array(
                                'id' => '0351-02',
                                'name' => '2ème Sect. Boucan-Michel'
                            ),
                            array(
                                'id' => '0351-03',
                                'name' => '3ème Sect. Petit Bourg de Borgne'
                            ),
                            array(
                                'id' => '0351-04',
                                'name' => '4ème Sect. Trou d\'Enfer'
                            ),
                            array(
                                'id' => '0351-05',
                                'name' => '5ème Sect. Champagne'
                            ),
                            array(
                                'id' => '0351-06',
                                'name' => '6ème Sect. Molas'
                            ),
                            array(
                                'id' => '0351-07',
                                'name' => '7ème Sect. Côtes de Fer et Lagrange'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0352',
                        'name' => 'port-margot',
                        'sections' => array(
                            array(
                                'id' => '0352-90',
                                'name' => 'Ville de Port Margot'
                            ),
                            array(
                                'id' => '0352-80',
                                'name' => 'Quartier de Bayeux'
                            ),
                            array(
                                'id' => '0352-81',
                                'name' => 'Quartier Petit Bourg de Port-Margot'
                            ),
                            array(
                                'id' => '0352-01',
                                'name' => '1ère Sect. de Grande Plaine'
                            ),
                            array(
                                'id' => '0352-02',
                                'name' => '2ème Sect. Bas Petit Borgne'
                            ),
                            array(
                                'id' => '0352-03',
                                'name' => '3ème Sect. de Corail'
                            ),
                            array(
                                'id' => '0352-04',
                                'name' => '4ème Sect. Haut Petit Borgne'
                            ),
                            array(
                                'id' => '0352-05',
                                'name' => '5ème Sect. Bas Quartier'
                            ),
                            array(
                                'id' => '0352-06',
                                'name' => '6ème Sect. Bras Gauche'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0361',
                        'name' => 'limbe',
                        'sections' => array(
                            array(
                                'id' => '0361-90',
                                'name' => 'Ville de Limbé'
                            ),
                            array(
                                'id' => '0361-80',
                                'name' => 'Quartier de Camp-Coq'
                            ),
                            array(
                                'id' => '0361-01',
                                'name' => '1ère Sect. Haut Limbé ou Acul Jeanot'
                            ),
                            array(
                                'id' => '0361-02',
                                'name' => '2ème Sect. Chabotte'
                            ),
                            array(
                                'id' => '0361-03',
                                'name' => '   3ème Sect. Camp Coq'
                            ),
                            array(
                                'id' => '0361-04',
                                'name' => '4ème Sect. Soufrière'
                            ),
                            array(
                                'id' => '0361-05',
                                'name' => '  5ème Sect. Ravine Desroches'
                            ),
                            array(
                                'id' => '0361-06',
                                'name' => '6ème Sect. Ilot-à-Cornes'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0362',
                        'name' => 'Bas-limbe',
                        'sections' => array(
                            array(
                                'id' => '0362-90',
                                'name' => 'Ville de Bas-Limbé'
                            ),
                            array(
                                'id' => '0362-01',
                                'name' => '1ère Sect. Garde Champètre (Bas-Limbé)'
                            ),
                            array(
                                'id' => '0362-02',
                                'name' => '2ème Sect. Petit Howars (La Fange)'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0371',
                        'name' => 'Plaisance',
                        'sections' => array(
                            array(
                                'id' => '0371-90',
                                'name' => 'Ville de Plaisance'
                            ),
                            array(
                                'id' => '0371-01',
                                'name' => '1ère Sect. Gobert ou Colline Gobert'
                            ),
                            array(
                                'id' => '0371-02',
                                'name' => '2ème Sect. Champagne'
                            ),
                            array(
                                'id' => '0371-03',
                                'name' => '3ème Sect. Haut Martineau'
                            ),
                            array(
                                'id' => '0371-04',
                                'name' => ' 4ème Sect. Mapou'
                            ),
                            array(
                                'id' => '0371-05',
                                'name' => ' 5ème Sect. La Trouble'
                            ),
                            array(
                                'id' => '0371-06',
                                'name' => '6ème Sect. La Ville'
                            ),
                            array(
                                'id' => '0371-07',
                                'name' => '  7ème Sect. Bassin'
                            ),
                            array(
                                'id' => '0371-08',
                                'name' => '8ème Grande Rivière'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0372',
                        'name' => 'Pilate',
                        'sections' => array(
                            array(
                                'id' => '0372-90',
                                'name' => 'Ville de Pilate'
                            ),
                            array(
                                'id' => '0372-01',
                                'name' => '1ère Sect. Ballon'
                            ),
                            array(
                                'id' => '0372-02',
                                'name' => '2ème Sect. Baudin'
                            ),
                            array(
                                'id' => '0372-03',
                                'name' => '3ème Sect. Ravine Trompette'
                            ),
                            array(
                                'id' => '0372-04',
                                'name' => '4ème Sect. Joly'
                            ),
                            array(
                                'id' => '0372-05',
                                'name' => '5ème Sect. Dubourg'
                            ),
                            array(
                                'id' => '0372-06',
                                'name' => '6ème Sect. Piment'
                            ),
                            array(
                                'id' => '0372-07',
                                'name' => '7ème Sect. Rivière Laporte'
                            ),
                            array(
                                'id' => '0372-08',
                                'name' => '8ème Sect. Margot'
                            ),
                        ),
                    ),
                ),
            ),
            array(// DEPARTEMENT DU NORD - EST

                'id' => '041',
                'name' => 'Nòdès',
                'cities' => array(
                    //-------------------------------------------
                      array(
                        'id' => '0410',
                        'name' => 'Commune Enkoni (NE)',
                        'sections' => array(
                            array(
                                'id' => '0410-00',
                                'name' => 'Section ENKONI (NE)'
                        )
                        )
                        ),
                    //----------------------------------------------------
                    array(
                        'id' => '0411',
                        'name' => 'Fort-Liberté',
                        'sections' => array(
                            array(
                                'id' => '0411-90',
                                'name' => 'Ville de Fort-Liberté'
                            ),
                            array(
                                'id' => '0411-80',
                                'name' => 'Quartier Acul-Samedi'
                            ),
                            array(
                                'id' => '0411-01',
                                'name' => ' 1ère Sect. Dumas'
                            ),
                            array(
                                'id' => '0411-02',
                                'name' => '2ème Sect. Bayaha'
                            ),
                            array(
                                'id' => '0411-03',
                                'name' => '  3ème Sect. Loiseau'
                            ),
                            array(
                                'id' => '0411-04',
                                'name' => '4ème Sect. Haut-Madeleine'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0412',
                        'name' => 'Ferrier',
                        'sections' => array(
                            array(
                                'id' => '0412-90',
                                'name' => 'Ville de Ferrier'
                            ),
                            array(
                                'id' => '0412-01',
                                'name' => '1ère Sect. Bas-Maribahoux'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0413',
                        'name' => 'Perches',
                        'sections' => array(
                            array(
                                'id' => '0413-90',
                                'name' => '  Ville de Perches'
                            ),
                            array(
                                'id' => '0413-01',
                                'name' => ' 1ère Sect. Haut des Perches'
                            ),
                            array(
                                'id' => '0413-02',
                                'name' => '2ème Sect. Bas des Perches'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0421',
                        'name' => 'Ouanaminthe',
                        'sections' => array(
                            array(
                                'id' => '0421-90',
                                'name' => 'Ville de Ouanaminthe'
                            ),
                            array(
                                'id' => '0421-01',
                                'name' => '1ère Sect. Haut Maribahoux'
                            ),
                            array(
                                'id' => '0421-02',
                                'name' => '2ème Sect. Acul des Pins'
                            ),
                            array(
                                'id' => '0421-03',
                                'name' => '3ème Sect. Savane Longue'
                            ),
                            array(
                                'id' => '0421-04',
                                'name' => '4ème Sect. Savane au lait'
                            ),
                            array(
                                'id' => '0421-05',
                                'name' => '5ème Sect. Gens de Nantes'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0422',
                        'name' => 'Capotille',
                        'sections' => array(
                            array(
                                'id' => '0422-90',
                                'name' => 'Ville de Capotille'
                            ),
                            array(
                                'id' => '0422-01',
                                'name' => '1ère Sect. de Capotille'
                            ),
                            array(
                                'id' => '0422-02',
                                'name' => '2ème Sect. Lamine'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0423',
                        'name' => 'Mont-Organisé',
                        'sections' => array(
                            array(
                                'id' => '0423-90',
                                'name' => 'Ville de Mont-Organisé'
                            ),
                            array(
                                'id' => '0423-01',
                                'name' => '1ère Sect. Savanette'
                            ),
                            array(
                                'id' => '0423-02',
                                'name' => '2ème Sect. Bois Poux'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0431',
                        'name' => 'Trou du Nord',
                        'sections' => array(
                            array(
                                'id' => '0431-90',
                                'name' => 'Ville du Trou du Nord'
                            ),
                            array(
                                'id' => '0431-01',
                                'name' => '1ère Sect. Garcin'
                            ),
                            array(
                                'id' => '0431-02',
                                'name' => '2ème Sect. Roucou'
                            ),
                            array(
                                'id' => '0431-03',
                                'name' => '3ème Sect. Roche-Plate'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0432',
                        'name' => 'Sainte Suzanne',
                        'sections' => array(
                            array(
                                'id' => '0432-90',
                                'name' => 'Ville de Sainte Suzanne'
                            ),
                            array(
                                'id' => '0432-80',
                                'name' => 'Quartier Dupity'
                            ),
                            array(
                                'id' => '0432-01',
                                'name' => ' 1ère Sect. Foulon'
                            ),
                            array(
                                'id' => '0432-02',
                                'name' => '2ème Sect. Bois-Blanc'
                            ),
                            array(
                                'id' => '0432-03',
                                'name' => '3ème Sect. Cotelette'
                            ),
                            array(
                                'id' => '0432-04',
                                'name' => '4ème Sect. Sarazin'
                            ),
                            array(
                                'id' => '0432-05',
                                'name' => '5ème Sect. Moka-Neuf'
                            ),
                            array(
                                'id' => '0432-06',
                                'name' => '6ème Sect. Fond-Bleu'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0433',
                        'name' => 'Terrier-Rouge',
                        'sections' => array(
                            array(
                                'id' => '0433-90',
                                'name' => 'Ville de Terrier-Rouge'
                            ),
                            array(
                                'id' => '0433-91',
                                'name' => 'Ville Industrielle de Phaéton'
                            ),
                            array(
                                'id' => '0433-92',
                                'name' => 'Ville Industrielle de Paulette'
                            ),
                            array(
                                'id' => '0433-80',
                                'name' => 'Quartier Grand Bassin'
                            ),
                            array(
                                'id' => '0433-01',
                                'name' => '1ère Sect. Fond-Blanc'
                            ),
                            array(
                                'id' => '0433-02',
                                'name' => '2ème Sect. Grand Bassin'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0434',
                        'name' => 'Caracol',
                        'sections' => array(
                            array(
                                'id' => '0434-90',
                                'name' => 'Ville de Caracol'
                            ),
                            array(
                                'id' => '0434-01',
                                'name' => '1ère Sect. Champin'
                            ),
                            array(
                                'id' => '0434-02',
                                'name' => '2ème Sect. Glaudine ou Jacquesy'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0441',
                        'name' => 'Vallières',
                        'sections' => array(
                            array(
                                'id' => '0441-90',
                                'name' => 'Ville de Valières'
                            ),
                            array(
                                'id' => '0441-80',
                                'name' => 'Quartier Grosse Roche'
                            ),
                            array(
                                'id' => '0441-01',
                                'name' => '1ère Sect. Trois Palmistes'
                            ),
                            array(
                                'id' => '0441-02',
                                'name' => '2ème Sect. Ecrevisse ou Grosse Roche'
                            ),
                            array(
                                'id' => '0441-03',
                                'name' => '3ème Sect. Corosse'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0442',
                        'name' => 'Carice',
                        'sections' => array(
                            array(
                                'id' => '0442-90',
                                'name' => 'Ville de Carice'
                            ),
                            array(
                                'id' => '0442-01',
                                'name' => '1ère Sect. Bois-Gamelle'
                            ),
                            array(
                                'id' => '0442-02',
                                'name' => '2ème Sect. Rose-Bonite'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0443',
                        'name' => 'Mombin Crochu',
                        'sections' => array(
                            array(
                                'id' => '0443-90',
                                'name' => 'Ville de Mombin Crochu'
                            ),
                            array(
                                'id' => '0443-80',
                                'name' => 'Quartier de Bois-Laurence'
                            ),
                            array(
                                'id' => '0443-01',
                                'name' => '1ère Sect. Sans-Souci'
                            ), array(
                                'id' => '0443-02',
                                'name' => '2ème Sect. Bois-Laurence'
                            ),
                        ),
                    ),
                ),
            ),
// FIN
// ========================= DEBUT DEPARTEMENT NORD OUEST ======================
            array(
                'id' => '091',
                'name' => 'Nòdwès',
                'cities' => array(
                  //---------------------------------------------  
                    array(
                        'id' => '0910',
                        'name' => 'Commune Enkoni (NOD)',
                        'sections' => array(
                            array(
                                'id' => '0910-00',
                                'name' => 'Section ENKONI (NOD)'
                        )
                        )
                        ),
                   //-------------------------------------------------------- 
                    array(
                        'id' => '0911',
                        'name' => 'Port-de-Paix',
                        'sections' => array(
                            array(
                                'id' => '0911-90',
                                'name' => 'Ville de Port-de-Paix'
                            ),
                            array(
                                'id' => '0911-01',
                                'name' => ' 1ère Sect. Baudin'
                            ),
                            array(
                                'id' => '0911-02',
                                'name' => '2ème Sect. La Pointe'
                            ),
                            array(
                                'id' => '0911-03',
                                'name' => '3ème Sect. Aubert'
                            ),
                            array(
                                'id' => '0911-04',
                                'name' => '4ème Sect. Mahotière'
                            ),
                            array(
                                'id' => '0911-05',
                                'name' => '5ème Sect. Bas des moustiques'
                            ),
                            array(
                                'id' => '0911-06',
                                'name' => '6ème Sect. La Corne'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0912',
                        'name' => 'La Tortue',
                        'sections' => array(
                            array(
                                'id' => '0912-90',
                                'name' => 'Ville de la tortue'
                            ),
                            array(
                                'id' => '0912-01',
                                'name' => '1ère Sect. Pointe des Oiseaux'
                            ),
                            array(
                                'id' => '0912-02',
                                'name' => '2ème Sect. Mare Rouge'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0913',
                        'name' => 'bassin bleu',
                        'sections' => array(
                            array(
                                'id' => '0913-90',
                                'name' => 'Ville de Bassin Bleu'
                            ),
                            array(
                                'id' => '0913-01',
                                'name' => '1ère Sect. La Plate'
                            ),
                            array(
                                'id' => '0913-02',
                                'name' => '2ème Sect. Carreau Datty'
                            ),
                            array(
                                'id' => '0913-03',
                                'name' => '3ème Sect. Haut des Moustiques'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0914',
                        'name' => 'chansolme',
                        'sections' => array(
                            array(
                                'id' => '0914-90',
                                'name' => 'Ville de Chansolme'
                            ),
                            array(
                                'id' => '0914-01',
                                'name' => '1ère Section Chansolme'
                            ),
                            array(
                                'id' => '0914-02',
                                'name' => '2ème Sect. Source Beauvoir'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0921',
                        'name' => 'Saint-Louis du Nord',
                        'sections' => array(
                            array(
                                'id' => '0921-90',
                                'name' => 'Ville de Saint-Louis du Nord'
                            ),
                            array(
                                'id' => '0921-80',
                                'name' => 'Quartier de Bonneau'
                            ),
                            array(
                                'id' => '0921-81',
                                'name' => 'Quartier de Guichard'
                            ),
                            array(
                                'id' => '0921-01',
                                'name' => '1ère Sect. Rivière des Nègres'
                            ),
                            array(
                                'id' => '0921-02',
                                'name' => '2ème Sect. Derourvay'
                            ),
                            array(
                                'id' => '0921-03',
                                'name' => '3ème Sect. des Granges'
                            ),
                            array(
                                'id' => '0921-04',
                                'name' => ' 4ème Sect. Rivière des Barres'
                            ),
                            array(
                                'id' => '0921-05',
                                'name' => '5ème Sect. Bonneau'
                            ),
                            array(
                                'id' => '0921-06',
                                'name' => '6ème Sect. Lafague (Chamoise)'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0922',
                        'name' => 'Anse-à-Foleur',
                        'sections' => array(
                            array(
                                'id' => '0922-90',
                                'name' => 'Ville d\'Anse-à-Foleur'
                            ),
                            array(
                                'id' => '0922-01',
                                'name' => '1ère Sect. Bas de Sainte-Anne'
                            ),
                            array(
                                'id' => '0922-02',
                                'name' => '2ème Sect. Mayance'
                            ),
                            array(
                                'id' => '0922-03',
                                'name' => '3ème Sect. Côtes de Fer'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0931',
                        'name' => 'Môle Saint-Nicolas',
                        'sections' => array(
                            array(
                                'id' => '0931-90',
                                'name' => 'Ville du Môle Saint-Nicolas'
                            ),
                            array(
                                'id' => '0931-01',
                                'name' => '1ère Sect. de Côtes de Fer'
                            ),
                            array(
                                'id' => '0931-02',
                                'name' => '2ème Sect. Mare-Rouge'
                            ),
                            array(
                                'id' => '0931-03',
                                'name' => '3ème Sect. Damé'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0932',
                        'name' => 'Henne',
                        'sections' => array(
                            array(
                                'id' => '0932-90',
                                'name' => 'Ville de Baie de Henne'
                            ),
                            array(
                                'id' => '0932-01',
                                'name' => '1ère Sect. Citerne Rémy'
                            ),
                            array(
                                'id' => '0932-02',
                                'name' => '2ème Sect. Dos d\'Ane'
                            ),
                            array(
                                'id' => '0932-03',
                                'name' => '3ème Sect. Réserve (Ti Paradis)'
                            ),
                            array(
                                'id' => '0932-04',
                                'name' => '4ème Sect. L\'Estère Dere'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0933',
                        'name' => 'Bombardopolis',
                        'sections' => array(
                            array(
                                'id' => '0933-90',
                                'name' => 'Ville de Bombardopolis'
                            ), array(
                                'id' => '0933-01',
                                'name' => '1ère Sect. Plate Forme'
                            ),
                            array(
                                'id' => '0933-02',
                                'name' => '2ème Sect. des Forges'
                            ),
                            array(
                                'id' => '0933-03',
                                'name' => '3ème Sect. Plaine d\'Orange'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0934',
                        'name' => 'Jean Rabel',
                        'sections' => array(
                            array(
                                'id' => '0934-90',
                                'name' => 'Ville de Jean Rabel'
                            ),
                            array(
                                'id' => '0934-80',
                                'name' => 'Quartier Bord de Mer'
                            ),
                            array(
                                'id' => '0934-01',
                                'name' => '1ère Sect. Lacoma'
                            ),
                            array(
                                'id' => '0934-02',
                                'name' => '2e Sect. Guinaudée'
                            ),
                            array(
                                'id' => '0934-03',
                                'name' => '3e Sect. Vieille Hatte'
                            ),
                            array(
                                'id' => '0934-04',
                                'name' => '4e Sect. La Montagne'
                            ),
                            array(
                                'id' => '0934-05',
                                'name' => '5e Sect. Dessources'
                            ),
                            array(
                                'id' => '0934-06',
                                'name' => '6e Sect. Grande Source'
                            ),
                            array(
                                'id' => '0934-07',
                                'name' => '7e Diondion'
                            ),
                        ),
                    ),
                ),
            ),
// =============================FIN DEPARTEMENT NORD OUEST =====================
            array(// DEPARTEMENT DU SUD - EST

                'id' => '021',
                'name' => 'Sidès',
                'cities' => array(
                    
                    //---------------------------------------------  
                    array(
                        'id' => '0210',
                        'name' => 'Commune ENKONI (Jac)',
                        'sections' => array(
                            array(
                                'id' => '0210-00',
                                'name' => 'Section ENKONI (Jac)'
                        )
                        )
                        ),
                   //-------------------------------------------------------- 
                    array(
                        'id' => '02100',
                        'name' => 'Commune ENKONI (Thio)',
                        'sections' => array(
                            array(
                                'id' => '02100-00',
                                'name' => 'Section ENKONI (Thio)'
                        )
                        )
                        ),
                   //-------------------------------------------------------- 
                    array(
                        'id' => '0211',
                        'name' => 'Jacmel ',
                        'sections' => array(
                            array(
                                'id' => '0211-90',
                                'name' => 'Ville de Jacmel '
                            ),
                            array(
                                'id' => '0211-80',
                                'name' => 'Quartier de Marbial '
                            ),
                            array(
                                'id' => '0211-01',
                                'name' => '1ère Sect. Bas Cap Rouge '
                            ),
                            array(
                                'id' => '0211-02',
                                'name' => '2ème Sect. Fond Melon (Selle)  '
                            ),
                            array(
                                'id' => '0211-03',
                                'name' => '3ème Sect. Cochon Gras  '
                            ),
                            array(
                                'id' => '0211-04',
                                'name' => '4ème Sect. La Gosseline '
                            ),
                            array(
                                'id' => '0211-05',
                                'name' => '5ème Sect. Marbial   '
                            ),
                            array(
                                'id' => '0211-06',
                                'name' => '6ème Sect. Montagne la Voute  '
                            ),
                            array(
                                'id' => '0211-07',
                                'name' => '7ème Sect. Grande Rivière de Jacmel'
                            ),
                            array(
                                'id' => '0211-08',
                                'name' => '8ème Sect. Bas Coq Chante  '
                            ),
                            array(
                                'id' => '0211-09',
                                'name' => ' 9ème Sect. Haut Coq qui Chante '
                            ),
                            array(
                                'id' => '0211-10',
                                'name' => '12ème Sect. La Vanneau '
                            ),
                            array(
                                'id' => '0211-11',
                                'name' => '13ème Sect. La Montagne '
                            ),
                        ),
                    ),
                    array(
                        'id' => '0212',
                        'name' => ' Marigot',
                        'sections' => array(
                            array(
                                'id' => '0212-90',
                                'name' => ' Ville de Marigot     '
                            ),
                            array(
                                'id' => '0212-80',
                                'name' => ' Quartier de Seguin '
                            ),
                            array(
                                'id' => '0212-01',
                                'name' => '1ère Sect. Corail Soult '
                            ),
                            array(
                                'id' => '0212-02',
                                'name' => '2ème Sect. Grande Riviére Fesles '
                            ),
                            array(
                                'id' => '0212-03',
                                'name' => ' 3ème Sect. Macary  '
                            ),
                            array(
                                'id' => '0212-04',
                                'name' => '4ème Sect. Fond Jean-Noël   '
                            ),
                            array(
                                'id' => '0212-05',
                                'name' => ' 5ème Sect. Savane Dubois   '
                            ),
                        ),
                    ),
                    array(
                        'id' => '0213',
                        'name' => 'Cayes Jacmel',
                        'sections' => array(
                            array(
                                'id' => '0213-90',
                                'name' => ' Ville Cayes Jacmel '
                            ),
                            array(
                                'id' => '0213-01',
                                'name' => '1ère Sect. Ravine Normande '
                            ),
                            array(
                                'id' => '0213-02',
                                'name' => '2ème Sect. Gaillard  '
                            ),
                            array(
                                'id' => '0213-03',
                                'name' => '3ème Sect. Haut Cap Rouge '
                            ),
                            array(
                                'id' => '0213-04',
                                'name' => '4ème Fond Melon-Michineau'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0214',
                        'name' => 'La Vallée',
                        'sections' => array(
                            array(
                                'id' => '0214-90',
                                'name' => 'Ville La Vallée  '
                            ),
                            array(
                                'id' => '0214-01',
                                'name' => '1ère Sect. La Vallée de Jacmel ou Muzac'
                            ),
                            array(
                                'id' => '0214-02',
                                'name' => '2ème Sect. Ternier'
                            ),
                            array(
                                'id' => '0214-03',
                                'name' => '3ème Sect. Morne à Brûler '
                            ),
                        ),
                    ),
                    array(
                        'id' => '0221',
                        'name' => 'Bainet',
                        'sections' => array(
                            array(
                                'id' => '0221-90',
                                'name' => 'Ville de Bainet '
                            ),
                            array(
                                'id' => '0221-01',
                                'name' => ' 1ère Sect. Brésilienne '
                            ),
                            array(
                                'id' => '0221-02',
                                'name' => '2ème Sect. Trou Mahot  '
                            ),
                            array(
                                'id' => '0221-03',
                                'name' => '3ème Sect. La Vallée de Bainet'
                            ),
                            array(
                                'id' => '0221-04',
                                'name' => '4ème Sect. Haut Grandou   '
                            ),
                            array(
                                'id' => '0221-05',
                                'name' => '5ème Sect. Bas de Grandou '
                            ),
                            array(
                                'id' => '0221-06',
                                'name' => '6ème Sect. Bas de la Croix'
                            ),
                            array(
                                'id' => '0221-07',
                                'name' => '7ème Sect. Bras Gauche '
                            ),
                            array(
                                'id' => '0221-08',
                                'name' => ' 8ème Sect. Orangers '
                            ),
                            array(
                                'id' => '0221-09',
                                'name' => '9ème Sect. Bas des Gris Gris'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0222',
                        'name' => 'Côtes de Fer ',
                        'sections' => array(
                            array(
                                'id' => '0222-90',
                                'name' => ' Ville de Cotes de Fer '
                            ),
                            array(
                                'id' => '0222-01',
                                'name' => ' 1ème Sect. Gris Gris  '
                            ),
                            array(
                                'id' => '0222-02',
                                'name' => ' 2ème Sect. Labiche   '
                            ),
                            array(
                                'id' => '0222-03',
                                'name' => '3ème Sect. Bras Gauche'
                            ),
                            array(
                                'id' => '0222-04',
                                'name' => ' 4ème Sect. Amazone '
                            ),
                            array(
                                'id' => '0222-05',
                                'name' => '5ème Sect. Boucan Bélier '
                            ),
                            array(
                                'id' => '0222-06',
                                'name' => ' 6ème Sect. Jamais Vu  '
                            ),
                        ),
                    ),
                    array(
                        'id' => '0231',
                        'name' => 'Belle Anse ',
                        'sections' => array(
                            array(
                                'id' => '0231-90',
                                'name' => 'Ville de Belle Anse '
                            ),
                            array(
                                'id' => '0231-80',
                                'name' => 'Quartier de Mapou  '
                            ),
                            array(
                                'id' => '0231-01',
                                'name' => '1ère Sect. Baie d\'Orange '
                            ),
                            array(
                                'id' => '0231-02',
                                'name' => '2ème Sect. Mabriole  '
                            ),
                            array(
                                'id' => '0231-03',
                                'name' => '3ème Sect. Callumette '
                            ),
                            array(
                                'id' => '0231-04',
                                'name' => '4ème Sect. Corail-Lamothe   '
                            ),
                            array(
                                'id' => '0231-05',
                                'name' => '5ème Sect. Bel-Air '
                            ),
                            array(
                                'id' => '0231-06',
                                'name' => '6ème Sect. Pichon'
                            ),
                            array(
                                'id' => '0231-07',
                                'name' => '7ème Sect. Mapou  '
                            ),
                        ),
                    ),
                    array(
                        'id' => '0232',
                        'name' => 'Grand Gosier',
                        'sections' => array(
                            array(
                                'id' => '0232-90',
                                'name' => 'Ville de Grand Gosier'
                            ),
                            array(
                                'id' => '0232-80',
                                'name' => 'Quartier de Bodarie '
                            ),
                            array(
                                'id' => '0232-01',
                                'name' => '1ère Sect.Colline des Chènes'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0233',
                        'name' => 'Thiotte',
                        'sections' => array(
                            array(
                                'id' => '0233-90',
                                'name' => ' Ville de Thiotte'
                            ),
                            array(
                                'id' => '0233-01',
                                'name' => '1ère Sect. Thiotte'
                            ),
                            array(
                                'id' => '0233-02',
                                'name' => '2ème Sect. Pot de Chambre'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0234',
                        'name' => 'Anse à Pitre ',
                        'sections' => array(
                            array(
                                'id' => '0234-90',
                                'name' => 'Ville de l\'Anse à Pitre'
                            ),
                            array(
                                'id' => '0234-80',
                                'name' => 'Quartier de Banane'
                            ),
                            array(
                                'id' => '0234-01',
                                'name' => '1ère Sect. Boucan Guillaume'
                            ),
                            array(
                                'id' => '0234-02',
                                'name' => ' 2ème Sect. Bois d\'Ormes'
                            ),
                        ),
                    ),
                ),
            ),
//============================== FIN SUD EST ===================================
//================================ DEBUT DEPARTEMENT CENTRE ================================
            array(
                'id' => '061',
                'name' => 'Sant',
                'cities' => array(
                    
                    //---------------------------------------------  
                    array(
                        'id' => '0610',
                        'name' => 'Commune ENKONI (B-PC)',
                        'sections' => array(
                            array(
                                'id' => '0610-00',
                                'name' => 'Section ENKONI (B-PC)'
                        )
                        )
                        ),
                   //-------------------------------------------------------- 
                    array(
                        'id' => '06100',
                        'name' => 'Commune ENKONI (H-PC)',
                        'sections' => array(
                            array(
                                'id' => '06100-00',
                                'name' => 'Section ENKONI (H-PC)'
                        )
                        )
                        ),
                   //--------------------------------------------------------
                    
                    array(
                        'id' => '0611',
                        'name' => 'Hinche  ',
                        'sections' => array(
                            array(
                                'id' => '0611-90',
                                'name' => 'Ville de Hinche'
                            ),
                            array(
                                'id' => '0611-80',
                                'name' => 'Quartier Los Palis'
                            ),
                            array(
                                'id' => '0611-01',
                                'name' => '1ère Sect. Juanaria'
                            ),
                            array(
                                'id' => '0611-02',
                                'name' => '2ème Sect. Marmont'
                            ),
                            array(
                                'id' => '0611-03',
                                'name' => '3ème Sect. Aguahédionde(rive droite)'
                            ),
                            array(
                                'id' => '0611-04',
                                'name' => '4ème Sect. Aguahédionde(rive gauche)'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0612',
                        'name' => 'Maïssade',
                        'sections' => array(
                            array(
                                'id' => '0612-90',
                                'name' => 'Ville de Maïssade'
                            ),
                            array(
                                'id' => '0612-80',
                                'name' => 'Quartier Louverture'
                            ),
                            array(
                                'id' => '0612-01',
                                'name' => '1ère Sect. Savane Grande'
                            ),
                            array(
                                'id' => '0612-02',
                                'name' => '2ème Sect. Narang '
                            ),
                            array(
                                'id' => '0612-03',
                                'name' => '3ème Sect. Hatty'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0613',
                        'name' => 'Thomonde',
                        'sections' => array(
                            array(
                                'id' => '0613-90',
                                'name' => 'Ville de Thomonde'
                            ),
                            array(
                                'id' => '0613-01',
                                'name' => ' 1ère Sect. Cabral'
                            ),
                            array(
                                'id' => '0613-02',
                                'name' => '2ème Sect. Tierra Muscady'
                            ),
                            array(
                                'id' => '0613-03',
                                'name' => '3ème Sect. Baille Tourrible'
                            ),
                            array(
                                'id' => '0613-04',
                                'name' => '4ème Sect. La Hoye'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0614',
                        'name' => ' Cerca Carvajal  ',
                        'sections' => array(
                            array(
                                'id' => '0614-90',
                                'name' => 'Ville de Cerca Carvajal'
                            ),
                            array(
                                'id' => '0614-01',
                                'name' => '1ère  Section Rang'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0621',
                        'name' => ' Mirebalais',
                        'sections' => array(
                            array(
                                'id' => '0621-90',
                                'name' => 'Ville de Mirebalais'
                            ),
                            array(
                                'id' => '0621-01',
                                'name' => '1ère Sect. Gascogne'
                            ),
                            array(
                                'id' => '0621-02',
                                'name' => '2ème Sect. Sarazin'
                            ),
                            array(
                                'id' => '0621-03',
                                'name' => '3ème Sect. Grand-Boucan'
                            ),
                            array(
                                'id' => '0621-04',
                                'name' => '4ème Sect. Crête Brûlée'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0622',
                        'name' => 'Saut d\'Eau',
                        'sections' => array(
                            array(
                                'id' => '0622-90',
                                'name' => 'Ville de Saut d\'Eau'
                            ),
                            array(
                                'id' => '0622-01',
                                'name' => '1ère Sect. Canot'
                            ),
                            array(
                                'id' => '0622-02',
                                'name' => '2ème Sect. La Selle'
                            ),
                            array(
                                'id' => '0622-03',
                                'name' => '3ème Sect. Coupe Mardi-Gras'
                            ),
                            array(
                                'id' => '0622-04',
                                'name' => '4ème Sect. Montagne Terrible'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0623',
                        'name' => 'Boucan Carré',
                        'sections' => array(
                            array(
                                'id' => '0623-90',
                                'name' => 'Ville de Boucan Carré'
                            ),
                            array(
                                'id' => '0623-80',
                                'name' => 'Quartier Dufailly'
                            ),
                            array(
                                'id' => '0623-01',
                                'name' => '1ère Sect. Petite Montagne'
                            ),
                            array(
                                'id' => '0623-02',
                                'name' => '2ème Sect. Boucan Carré'
                            ),
                            array(
                                'id' => '0623-03',
                                'name' => '3ème Sect. des Bayes'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0631',
                        'name' => 'Lascahobas',
                        'sections' => array(
                            array(
                                'id' => '0631-90',
                                'name' => 'Ville de Lascahobas'
                            ),
                            array(
                                'id' => '0631-01',
                                'name' => '1ère Sect. Petit Fond'
                            ),
                            array(
                                'id' => '0631-02',
                                'name' => '2ème Sect. Juampas'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0632',
                        'name' => 'Belladères',
                        'sections' => array(
                            array(
                                'id' => '0632-90',
                                'name' => 'Ville de Belladère'
                            ),
                            array(
                                'id' => '0632-80',
                                'name' => 'Quartier de Baptiste'
                            ),
                            array(
                                'id' => '0632-01',
                                'name' => '1ère Sect. Renthe-Mathe'
                            ),
                            array(
                                'id' => '0632-02',
                                'name' => '2ème Sect. Roye-Sec'
                            ),
                            array(
                                'id' => '0632-03',
                                'name' => '3ème Sect. Riaribes'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0633',
                        'name' => 'Savanette  ',
                        'sections' => array(
                            array(
                                'id' => '0633-90',
                                'name' => 'Ville de Savenette'
                            ),
                            array(
                                'id' => '0633-01',
                                'name' => '1ère Sect. Savanette(Colombier)'
                            ),
                            array(
                                'id' => '0633-02',
                                'name' => '2ème Sect. La Haye'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0641',
                        'name' => 'Cerca-la-Source',
                        'sections' => array(
                            array(
                                'id' => '0641-90',
                                'name' => 'Ville de Cerca-La-Source'
                            ),
                            array(
                                'id' => '0641-01',
                                'name' => '1ère Sect. Acajou Brûlé1'
                            ),
                            array(
                                'id' => '0641-02',
                                'name' => '1ère Sect. Acajou Brûlé2'
                            ),
                            array(
                                'id' => '0641-03',
                                'name' => '3ème Sect. Lamielle'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0642',
                        'name' => 'Thomassique',
                        'sections' => array(
                            array(
                                'id' => '0642-90',
                                'name' => 'Ville de Thomassique'
                            ),
                            array(
                                'id' => '0642-01',
                                'name' => '1ère Sect. Matelgate'
                            ),
                            array(
                                'id' => '0642-02',
                                'name' => '2ème Sect. Lociane'
                            ),
                        ),
                    ),
                ),
            ),
//============================== FIN CENTRE ====================================
//================================ DEBUT DEPARTEMENT ARTIBONITE ================
            array(
                'id' => '051',
                'name' => 'Latibonit',
                'cities' => array(
                     //---------------------------------------------  
                    array(
                        'id' => '0510',
                        'name' => 'Commune ENKONI (B-ART)',
                        'sections' => array(
                            array(
                                'id' => '0510-00',
                                'name' => 'Section ENKONI (B-ART)'
                        )
                        )
                        ),
                   //-------------------------------------------------------- 
                    array(
                        'id' => '05100',
                        'name' => 'Commune ENKONI (H-ART)',
                        'sections' => array(
                            array(
                                'id' => '05100-00',
                                'name' => 'Section ENKONI (H-ART)'
                        )
                        )
                        ),
                   //--------------------------------------------------------
                    array(
                        'id' => '0511',
                        'name' => 'Gonaïves',
                        'sections' => array(
                            array(
                                'id' => '0511-90',
                                'name' => ' Ville des Gonaïves'
                            ),
                            array(
                                'id' => '0511-80',
                                'name' => 'Quartier Pte Rivière des Bayonnais'
                            ),
                            array(
                                'id' => '0511-01',
                                'name' => '  1ère Sect. Pont Tamarin'
                            ),
                            array(
                                'id' => '0511-02',
                                'name' => ' 2ème Sect. Bassin'
                            ),
                            array(
                                'id' => '0511-03',
                                'name' => ' 3ème Sect. Pte Rivière de Bayonnais'
                            ),
                            array(
                                'id' => '0511-04',
                                'name' => ' 4ème Sect. Poteaux'
                            ),
                            array(
                                'id' => '0511-05',
                                'name' => ' 5ème Sect. Labranle'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0512',
                        'name' => 'Ennery',
                        'sections' => array(
                            array(
                                'id' => '0512-90',
                                'name' => 'Ville d\'Ennery'
                            ),
                            array(
                                'id' => '0512-01',
                                'name' => '1ère Sect. Savane Carrée'
                            ),
                            array(
                                'id' => '0512-02',
                                'name' => '2ème Sect.Passe-Reine ou bas d\'Ennery'
                            ),
                            array(
                                'id' => '0512-03',
                                'name' => '3ème Sect. Chemin Neuf'
                            ),
                            array(
                                'id' => '0512-04',
                                'name' => '4ème Sect. Puilboreau'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0513',
                        'name' => 'L\'estère',
                        'sections' => array(
                            array(
                                'id' => '0513-90',
                                'name' => 'Ville de l\'Estère'
                            ),
                            array(
                                'id' => '0513-01',
                                'name' => '1ère Sect. Lacroix-Périsse'
                            ),
                            array(
                                'id' => '0513-02',
                                'name' => '2ème Sect. Petite Desdunes'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0521',
                        'name' => 'Gros-Morne',
                        'sections' => array(
                            array(
                                'id' => '0521-90',
                                'name' => 'Ville de Gros-Morne'
                            ),
                            array(
                                'id' => '0521-01',
                                'name' => '1ère Sect. Boucan Richard '
                            ),
                            array(
                                'id' => '0521-02',
                                'name' => '2ème Sect. Rivière Mancelle   '
                            ),
                            array(
                                'id' => '0521-03',
                                'name' => '3ème Sect. Rivière Blanche  '
                            ),
                            array(
                                'id' => '0521-04',
                                'name' => '4ème Sect. l\'Acul   '
                            ),
                            array(
                                'id' => '0521-05',
                                'name' => ' 5ème Sect. Pendu  '
                            ),
                            array(
                                'id' => '0521-06',
                                'name' => '6ème Sect. Savane Carrée  '
                            ),
                            array(
                                'id' => '0521-07',
                                'name' => '7ème Sect. Moulin  '
                            ),
                            array(
                                'id' => '0521-08',
                                'name' => '8ème Sect. Ravine Gros-Morne  '
                            ),
                        ),
                    ),
                    array(
                        'id' => '0522',
                        'name' => 'Terre-Neuve',
                        'sections' => array(
                            array(
                                'id' => '0522-90',
                                'name' => 'Ville de Terre-Neuve'
                            ),
                            array(
                                'id' => '0522-01',
                                'name' => '1ère Sect. Doland'
                            ),
                            array(
                                'id' => '0522-02',
                                'name' => '2ème Sect. Bois Neuf '
                            ),
                            array(
                                'id' => '0522-03',
                                'name' => '3ème Sect. Lagon '
                            ),
                        ),
                    ),
                    array(
                        'id' => '0523',
                        'name' => 'Anse Rouge',
                        'sections' => array(
                            array(
                                'id' => '0523-90',
                                'name' => 'Ville de l\'Anse Rouge '
                            ),
                            array(
                                'id' => '0523-80',
                                'name' => 'Quartier Sources Chaudes'
                            ),
                            array(
                                'id' => '0523-01',
                                'name' => '1ère Sect. l\'Arbre'
                            ),
                            array(
                                'id' => '0523-02',
                                'name' => '2ème Sect. Sources Chaudes '
                            ),
                        ),
                    ),
                    array(
                        'id' => '0531',
                        'name' => ' Saint-Marc',
                        'sections' => array(
                            array(
                                'id' => '0531-90',
                                'name' => ' Ville de Saint-Marc'
                            ),
                            array(
                                'id' => '0531-80',
                                'name' => ' Quartier de Montrouis '
                            ),
                            array(
                                'id' => '0531-01',
                                'name' => '   1ère Sect. Délugé  '
                            ),
                            array(
                                'id' => '0531-02',
                                'name' => ' 2ème Sect. Bois Neuf   '
                            ),
                            array(
                                'id' => '0531-03',
                                'name' => ' 3ème Sect. Goyavier  '
                            ),
                            array(
                                'id' => '0531-04',
                                'name' => ' 4ème Sect. Lalouère   '
                            ),
                            array(
                                'id' => '0531-05',
                                'name' => '  5ème Sect. Bocozelle  '
                            ),
                            array(
                                'id' => '0531-06',
                                'name' => '  6ème Sect. Charrette   '
                            ),
                        ),
                    ),
                    array(
                        'id' => '0532',
                        'name' => 'Verrettes ',
                        'sections' => array(
                            array(
                                'id' => '0532-90',
                                'name' => ' Ville de Verrettes         '
                            ),
                            array(
                                'id' => '0532-80',
                                'name' => '   Quartier Désarmes  '
                            ),
                            array(
                                'id' => '0532-81',
                                'name' => 'Quartier Liancourt  '
                            ),
                            array(
                                'id' => '0532-01',
                                'name' => '1ère Sect. Liancourt       '
                            ),
                            array(
                                'id' => '0532-02',
                                'name' => '     2ème Sect. Bélanger         '
                            ),
                            array(
                                'id' => '0532-03',
                                'name' => '   3ème Sect. Guillaume-Mogé   '
                            ),
                            array(
                                'id' => '0532-04',
                                'name' => '   4ème Sect. Désarmes   '
                            ),
                            array(
                                'id' => '0532-05',
                                'name' => '   5ème Sect. Bastien  '
                            ),
                            array(
                                'id' => '0532-06',
                                'name' => '    6ème Sect. Terre Nette    '
                            ),
                        ),
                    ),
                    array(
                        'id' => '0533',
                        'name' => 'La Chapelle',
                        'sections' => array(
                            array(
                                'id' => '0533-90',
                                'name' => 'Ville de La Chapelle'
                            ),
                            array(
                                'id' => '0533-01',
                                'name' => '1ère Sect. Martineau'
                            ),
                            array(
                                'id' => '0533-02',
                                'name' => '2ème Sect. Bossous'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0541',
                        'name' => 'Dessalines',
                        'sections' => array(
                            array(
                                'id' => '0541-90',
                                'name' => 'Marchand Dessalines   '
                            ),
                            array(
                                'id' => '0541-01',
                                'name' => '1ère Sect. Villars '
                            ),
                            array(
                                'id' => '0541-02',
                                'name' => '2ème Sect. Fossé Naboth ou Duvallon '
                            ),
                            array(
                                'id' => '0541-03',
                                'name' => ' 3ème Sect. Ogé   '
                            ),
                            array(
                                'id' => '0541-04',
                                'name' => '4ème Sect. Poste-Pierrot   '
                            ),
                            array(
                                'id' => '0541-05',
                                'name' => '5ème Sect. Fiéfié ou Petit Cahos   '
                            ),
                            array(
                                'id' => '0541-06',
                                'name' => '6ème Sect. La Croix ou Grand Cahos  '
                            ),
                        ),
                    ),
                    array(
                        'id' => '0542',
                        'name' => 'Pt. Riv. de l\'Artibonite',
                        'sections' => array(
                            array(
                                'id' => '0542-90',
                                'name' => 'Ville de Petite Rivière de l\'Artibonite '
                            ),
                            array(
                                'id' => '0542-80',
                                'name' => ' Quartier Savane à Roche '
                            ),
                            array(
                                'id' => '0542-01',
                                'name' => '   1ère Sect. Bas-Coursin I   '
                            ),
                            array(
                                'id' => '0542-02',
                                'name' => ' 2ème Sect. Bas-Coursin II  '
                            ),
                            array(
                                'id' => '0542-03',
                                'name' => '   3ème Sect. Labady  '
                            ),
                            array(
                                'id' => '0542-04',
                                'name' => ' 4ème Sect. Savane à Roche   '
                            ),
                            array(
                                'id' => '0542-05',
                                'name' => ' 5ème Sect. Pérodin  '
                            ),
                            array(
                                'id' => '0542-06',
                                'name' => ' 6ème Sect. Médor  '
                            ),
                        ),
                    ),
                    array(
                        'id' => '0543',
                        'name' => 'Grande Saline',
                        'sections' => array(
                            array(
                                'id' => '0543-90',
                                'name' => ' Ville de Grande Saline   '
                            ),
                            array(
                                'id' => '0543-01',
                                'name' => ' 1ère Sect. Poteneau '
                            ),
                        ),
                    ),
                    array(
                        'id' => '0544',
                        'name' => 'Desdunes',
                        'sections' => array(
                            array(
                                'id' => '0544-90',
                                'name' => ' Ville de Desdunes '
                            ),
                            array(
                                'id' => '0544-01',
                                'name' => '1ère Sect. de Desdunes'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0551',
                        'name' => 'Saint-Michel de l\'Attalaye',
                        'sections' => array(
                            array(
                                'id' => '0551-90',
                                'name' => 'Ville de Saint-Michel de l\'Attalaye '
                            ),
                            array(
                                'id' => '0551-80',
                                'name' => 'Quartier Mamont'
                            ),
                            array(
                                'id' => '0551-01',
                                'name' => '1ère Sect. Platana '
                            ),
                            array(
                                'id' => '0551-02',
                                'name' => ' 2ème Sect. Camathe '
                            ),
                            array(
                                'id' => '0551-03',
                                'name' => '3ème Sect. Bas de Sault '
                            ),
                            array(
                                'id' => '0551-04',
                                'name' => '4ème Sect. Lalomas '
                            ),
                            array(
                                'id' => '0551-05',
                                'name' => ' 5ème Sect. l\'Ermite'
                            ),
                            array(
                                'id' => '0551-06',
                                'name' => ' 6ème Sect. Lacedras '
                            ),
                            array(
                                'id' => '0551-07',
                                'name' => '7ème Sect. Mamont '
                            ),
                            array(
                                'id' => '0551-08',
                                'name' => '8ème Sect. l\'Attalaye'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0552',
                        'name' => ' Marmelade',
                        'sections' => array(
                            array(
                                'id' => '0552-90',
                                'name' => ' Ville de Marmelade     '
                            ),
                            array(
                                'id' => '0552-01',
                                'name' => '1ère Sect. Crète à Pins  '
                            ),
                            array(
                                'id' => '0552-02',
                                'name' => '2ème Sect. Bassin ou Billier  '
                            ),
                            array(
                                'id' => '0552-03',
                                'name' => ' 3ème Sect. Platon  '
                            ),
                        ),
                    ),
                ),
            ),
//============================== FIN ARTIBONITE ==================================
//============================== DEBUT DEPARTEMENT DU SUD ==================================
            array(//**************  ***************

                'id' => '071',
                'name' => 'Sid',
                'cities' => array(
                    
                    
                      //---------------------------------------------  
                    array(
                        'id' => '0710',
                        'name' => 'Commune ENKONI (SID)',
                        'sections' => array(
                            array(
                                'id' => '0710-00',
                                'name' => 'Section ENKONI (SID)'
                        )
                        )
                        ),
                   //-------------------------------------------------------- 
                    
                    array(
                        'id' => '0711',
                        'name' => 'cayes',
                        'sections' => array(
                            array(
                                'id' => '0711-90',
                                'name' => 'Ville des Cayes'
                            ),
                            array(
                                'id' => '0711-80',
                                'name' => 'Quartier Laborde'
                            ),
                            array(
                                'id' => '0711-01',
                                'name' => '1ère Sect. Bourdet'
                            ),
                            array(
                                'id' => '0711-02',
                                'name' => '2ème Sect. Fonfrède'
                            ),
                            array(
                                'id' => '0711-03',
                                'name' => '3ème Sect. Laborde'
                            ),
                            array(
                                'id' => '0711-04',
                                'name' => '4ème Sect. Laurent'
                            ),
                            array(
                                'id' => '0711-05',
                                'name' => '5ème Sect. Mercy'
                            ),
                            array(
                                'id' => '0711-06',
                                'name' => '6ème Sect. Boulmier'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0712',
                        'name' => 'torbeck',
                        'sections' => array(
                            array(
                                'id' => '0712-90',
                                'name' => 'Ville de Torbeck'
                            ),
                            array(
                                'id' => '0712-80',
                                'name' => 'Quartier Ferme Leblanc'
                            ),
                            array(
                                'id' => '0712-81',
                                'name' => 'Quartier Ducis'
                            ),
                            array(
                                'id' => '0712-01',
                                'name' => '1ère Sect. Boury'
                            ),
                            array(
                                'id' => '0712-02',
                                'name' => '2ème Sect. Bérault'
                            ),
                            array(
                                'id' => '0712-03',
                                'name' => '3ème Sect. Solon'
                            ),
                            array(
                                'id' => '0712-04',
                                'name' => '4ème Sect. Moreau'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0713',
                        'name' => 'chantal',
                        'sections' => array(
                            array(
                                'id' => '0713-90',
                                'name' => 'Ville de Chantal'
                            ),
                            array(
                                'id' => '0713-01',
                                'name' => '1ère Sect. Fond-Palmiste'
                            ),
                            array(
                                'id' => '0713-02',
                                'name' => '2ème Sect. Melonière'
                            ),
                            array(
                                'id' => '0713-03',
                                'name' => '3ème Sect. Carrefour Canon'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0714',
                        'name' => 'camp-perrin',
                        'sections' => array(
                            array(
                                'id' => '0714-90',
                                'name' => 'Ville de Camp-Perrin'
                            ),
                            array(
                                'id' => '0714-01',
                                'name' => '1ère Sect. Levy-Mersan'
                            ),
                            array(
                                'id' => '0714-02',
                                'name' => '2ème Sect. Champlois'
                            ),
                            array(
                                'id' => '0714-03',
                                'name' => '3ème Sect. Tibi-Davezac'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0715',
                        'name' => 'maniche',
                        'sections' => array(
                            array(
                                'id' => '0715-90',
                                'name' => 'Ville de Maniche'
                            ),
                            array(
                                'id' => '0715-01',
                                'name' => '1ère Sect. Maniche'
                            ),
                            array(
                                'id' => '0715-02',
                                'name' => '2ème Sect. Dory'
                            ),
                            array(
                                'id' => '0715-03',
                                'name' => '3ème Sect. Melon'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0716',
                        'name' => 'ile-a-vache',
                        'sections' => array(
                            array(
                                'id' => '0716-01',
                                'name' => '1ère Sect. Ile-à-Vache'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0721',
                        'name' => 'port-salut',
                        'sections' => array(
                            array(
                                'id' => '0721-90',
                                'name' => 'Ville de Port-Salut'
                            ),
                            array(
                                'id' => '0721-01',
                                'name' => 's1ère Sect. Barbois'
                            ),
                            array(
                                'id' => '0721-02',
                                'name' => '2ème Sect. Dumont'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0722',
                        'name' => 'saint-jean du Sud',
                        'sections' => array(
                            array(
                                'id' => '0722-90',
                                'name' => 'Ville de Saint-Jean du Sud'
                            ),
                            array(
                                'id' => '0722-01',
                                'name' => '1ère Sect. Tapion'
                            ),
                            array(
                                'id' => '0722-02',
                                'name' => '2ème Sect. Débouchette'
                            ),
                            array(
                                'id' => '0722-03',
                                'name' => '3ème Sect. Trichet'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0723',
                        'name' => 'arniquet',
                        'sections' => array(
                            array(
                                'id' => '0723-90',
                                'name' => 'Ville de Arniquet'
                            ),
                            array(
                                'id' => '0723-01',
                                'name' => '1ère Sect. Lazarre'
                            ),
                            array(
                                'id' => '0723-02',
                                'name' => '2ème Sect. Anse à Drick'
                            ),
                            array(
                                'id' => '0723-03',
                                'name' => '3ème Sect. d\'Arniquet '
                            ),
                        ),
                    ),
                    array(
                        'id' => '0731',
                        'name' => 'aquin',
                        'sections' => array(
                            array(
                                'id' => '0731-90',
                                'name' => 'Ville d\'Aquin'
                            ),
                            array(
                                'id' => '0731-80',
                                'name' => 'Quartier Fond des Blancs'
                            ),
                            array(
                                'id' => '0731-81',
                                'name' => 'Quartier Vieux Bourg d\'Aquin'
                            ),
                            array(
                                'id' => '0731-01',
                                'name' => '1ère Sect. Macéan'
                            ),
                            array(
                                'id' => '0731-02',
                                'name' => '2ème Sect. Bellevue'
                            ),
                            array(
                                'id' => '0731-03',
                                'name' => '3ème Sect. Brodequin'
                            ),
                            array(
                                'id' => '0731-04',
                                'name' => '4ème Sect. Flamands'
                            ),
                            array(
                                'id' => '0731-05',
                                'name' => '5ème Sect. Mare à Coiffe'
                            ),
                            array(
                                'id' => '0731-06',
                                'name' => '6ème Sect. La Colline'
                            ),
                            array(
                                'id' => '0731-07',
                                'name' => '7ème Sect. Frangipane'
                            ),
                            array(
                                'id' => '0731-08',
                                'name' => '8ème Sect. Colline à Mongons'
                            ),
                            array(
                                'id' => '0731-09',
                                'name' => '9ème Sect. Fond des Blancs'
                            ),
                            array(
                                'id' => '0731-10',
                                'name' => '10ème Sect. Guirand'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0732',
                        'name' => 'st-louis du Sud',
                        'sections' => array(
                            array(
                                'id' => '0732-90',
                                'name' => 'Ville de Saint-Louis du Sud'
                            ),
                            array(
                                'id' => '0732-01',
                                'name' => '1ère Sect. de Grand Fonds'
                            ),
                            array(
                                'id' => '0732-02',
                                'name' => '2ème Sect. Baie Dumesle'
                            ),
                            array(
                                'id' => '0732-03',
                                'name' => '3ème Sect. Grenodière'
                            ),
                            array(
                                'id' => '0732-04',
                                'name' => '4ème Sect. Zanglais'
                            ),
                            array(
                                'id' => '0732-05',
                                'name' => '5ème Sect. Sucrerie-Henri'
                            ),
                            array(
                                'id' => '0732-06',
                                'name' => ' 6ème Sect. Solon'
                            ),
                            array(
                                'id' => '0732-07',
                                'name' => ' 7ème Sect. Chérette'
                            ),
                            array(
                                'id' => '0732-08',
                                'name' => '8ème Sect. Corail-Henri'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0733',
                        'name' => 'cavaillon',
                        'sections' => array(
                            array(
                                'id' => '0733-90',
                                'name' => 'Ville de Cavaillon'
                            ),
                            array(
                                'id' => '0733-01',
                                'name' => '1ère Sect. Boileau'
                            ),
                            array(
                                'id' => '0733-02',
                                'name' => '2ème Sect. Martineau'
                            ),
                            array(
                                'id' => '0733-03',
                                'name' => '3ème Sect. Gros-Marin'
                            ),
                            array(
                                'id' => '0733-04',
                                'name' => '4ème Sect. Mare-Henri'
                            ),
                            array(
                                'id' => '0733-05',
                                'name' => '5ème Sect. Laroque'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0741',
                        'name' => 'coteaux',
                        'sections' => array(
                            array(
                                'id' => '0741-90',
                                'name' => 'Ville des Côteaux'
                            ),
                            array(
                                'id' => '0741-80',
                                'name' => 'Quartier de Damassin'
                            ),
                            array(
                                'id' => '0741-01',
                                'name' => '1ère Sect. Condé'
                            ),
                            array(
                                'id' => '0741-02',
                                'name' => '2ème Sect. Despas'
                            ),
                            array(
                                'id' => '0741-03',
                                'name' => '3ème Sect. Quentin'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0742',
                        'name' => 'port-a-piment',
                        'sections' => array(
                            array(
                                'id' => '0742-90',
                                'name' => 'Ville de Port-à-Piment'
                            ),
                            array(
                                'id' => '0742-01',
                                'name' => '1ère Sect. Paricot'
                            ),
                            array(
                                'id' => '0742-02',
                                'name' => '2ème Sect. Balais'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0743',
                        'name' => 'roche-a-bateau',
                        'sections' => array(
                            array(
                                'id' => '0743-90',
                                'name' => 'Ville de Roche-à-Bateau'
                            ),
                            array(
                                'id' => '0743-01',
                                'name' => '1ère Sect. Beaulieu'
                            ),
                            array(
                                'id' => '0743-02',
                                'name' => '2ème Sect. Renaudin'
                            ),
                            array(
                                'id' => '0743-03',
                                'name' => '3ème Sect. Beauclos'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0751',
                        'name' => 'Chardonnieres',
                        'sections' => array(
                            array(
                                'id' => '0751-90',
                                'name' => 'Ville de Chardonnières'
                            ),
                            array(
                                'id' => '0751-80',
                                'name' => 'Quartier Randel'
                            ),
                            array(
                                'id' => '0751-01',
                                'name' => '1ère Sect. Randel'
                            ),
                            array(
                                'id' => '0751-02',
                                'name' => '2ème Sect. Déjoie'
                            ),
                            array(
                                'id' => '0751-03',
                                'name' => '3ème Sect. Bony'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0752',
                        'name' => 'des anglais',
                        'sections' => array(
                            array(
                                'id' => '0752-90',
                                'name' => 'Ville des Anglais'
                            ),
                            array(
                                'id' => '0752-01',
                                'name' => '1ère Sect. Verone'
                            ),
                            array(
                                'id' => '0752-02',
                                'name' => '2ème Sect. Edelin'
                            ),
                            array(
                                'id' => '0752-03',
                                'name' => '3ème Sect. Cosse'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0753',
                        'name' => 'tiburon',
                        'sections' => array(
                            array(
                                'id' => '0753-90',
                                'name' => 'Ville de Tiburon'
                            ),
                            array(
                                'id' => '0753-80',
                                'name' => 'Quartier La Cahouane'
                            ),
                            array(
                                'id' => '0753-01',
                                'name' => '1ère Sect. Blactote'
                            ),
                            array(
                                'id' => '0753-02',
                                'name' => '2ème Sect. Sevre'
                            ),
                            array(
                                'id' => '0753-03',
                                'name' => '3ème Sect. Loby'
                            ),
                            array(
                                'id' => '0753-04',
                                'name' => '4ème Sect. Dalmette'
                            ),
                        ),
                    ),
                ),
            ),
            //----------------------
            array(//**************************** GRAND ANSE *******************

                'id' => '081',
                'name' => 'Grandans',
                'cities' => array(
                    
                    
                      //---------------------------------------------  
                    array(
                        'id' => '0810',
                        'name' => 'Commune ENKONI (GA)',
                        'sections' => array(
                            array(
                                'id' => '0810-00',
                                'name' => 'Section ENKONI (GA)'
                        )
                        )
                        ),
                   //-------------------------------------------------------- 
                    
                    array(
                        'id' => '0811',
                        'name' => 'jeremie',
                        'sections' => array(
                            array(
                                'id' => '0811-90',
                                'name' => 'Ville de Jérémie'
                            ),
                            array(
                                'id' => '0811-80',
                                'name' => 'Quartier de Léon'
                            ),
                            array(
                                'id' => '0811-81',
                                'name' => 'Quartier de Marfranc'
                            ),
                            array(
                                'id' => '0811-01',
                                'name' => '1ère Sect. Basse Voldrogue'
                            ),
                            array(
                                'id' => '0811-02',
                                'name' => '2ème Sect. Haute Voldrogue'
                            ),
                            array(
                                'id' => '0811-03',
                                'name' => '3ème Sect. Haute Guinaudée'
                            ),
                            array(
                                'id' => '0811-04',
                                'name' => '4ème Sect. Basse Guinaudée'
                            ),
                            array(
                                'id' => '0811-05',
                                'name' => '5ème Sect. Ravine à Charles'
                            ),
                            array(
                                'id' => '0811-06',
                                'name' => '6ème Sect. Iles Blanches'
                            ),
                            array(
                                'id' => '0811-07',
                                'name' => '7ème Sect. Marfranc ou Grande Rivière'
                            ),
                            array(
                                'id' => '0811-08',
                                'name' => '8ème Sect. Fond Rouge Dahere'
                            ),
                            array(
                                'id' => '0811-09',
                                'name' => '9ème Sect. Fond Rouge Torbeck'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0812',
                        'name' => 'abricots',
                        'sections' => array(
                            array(
                                'id' => '0812-90',
                                'name' => 'Ville des Abricots'
                            ),
                            array(
                                'id' => '0812-01',
                                'name' => '1ère Sect. Anse du Clerc'
                            ),
                            array(
                                'id' => '0812-02',
                                'name' => '2ème Sect. Balisiers'
                            ),
                            array(
                                'id' => '0812-03',
                                'name' => '3ère Sect. Danglise'
                            ),
                            array(
                                'id' => '0812-04',
                                'name' => '4ère Sect. La Seringue'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0813',
                        'name' => 'bonbon',
                        'sections' => array(
                            array(
                                'id' => '0813-90',
                                'name' => 'Ville de Bonbon'
                            ),
                            array(
                                'id' => '0813-01',
                                'name' => '1ère Section de Désormeau ou Bonbon'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0814',
                        'name' => 'moron',
                        'sections' => array(
                            array(
                                'id' => '0814-90',
                                'name' => 'Ville de Moron'
                            ),
                            array(
                                'id' => '0814-80',
                                'name' => 'Quartier Sources Chaudes'
                            ),
                            array(
                                'id' => '0814-01',
                                'name' => '1ère Sect. Anote ou 1ère Tapion'
                            ),
                            array(
                                'id' => '0814-02',
                                'name' => '2ème Sect. Sources Chaudes'
                            ),
                            array(
                                'id' => '0814-03',
                                'name' => '3ème Sect. L\'Assise ou Chameau'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0815',
                        'name' => 'chambellan',
                        'sections' => array(
                            array(
                                'id' => '0815-90',
                                'name' => 'Ville de Chambellan'
                            ),
                            array(
                                'id' => '0815-01',
                                'name' => '1ère Sect. de Dejean'
                            ),
                            array(
                                'id' => '0815-02',
                                'name' => '2ème Sect. de Boucan'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0821',
                        'name' => 'anse-dhainault',
                        'sections' => array(
                            array(
                                'id' => '0821-90',
                                'name' => 'Ville d\'Anse d\'hainault'
                            ),
                            array(
                                'id' => '0821-01',
                                'name' => '1ère Sect. Grandoit'
                            ),
                            array(
                                'id' => '0821-02',
                                'name' => '2ème Sect. Boudon'
                            ),
                            array(
                                'id' => '0821-03',
                                'name' => '3ème Sect. Ilet à Pierre Joseph'
                            ),
                            array(
                                'id' => '0821-04',
                                'name' => '4ème Sect. Mandou'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0822',
                        'name' => 'dame-marie',
                        'sections' => array(
                            array(
                                'id' => '0822-90',
                                'name' => 'Ville de Dame Marie'
                            ),
                            array(
                                'id' => '0822-80',
                                'name' => 'Quartier de Lesson'
                            ),
                            array(
                                'id' => '0822-01',
                                'name' => '1ère Sect. Bariadelle'
                            ),
                            array(
                                'id' => '0822-02',
                                'name' => '2ème Sect. Dallier'
                            ),
                            array(
                                'id' => '0822-03',
                                'name' => '3ème Sect. Désormeau'
                            ),
                            array(
                                'id' => '0822-04',
                                'name' => '4ème Sect. Petite Rivière'
                            ),
                            array(
                                'id' => '0822-05',
                                'name' => '5ème Sect. Baliverne'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0823',
                        'name' => 'irois',
                        'sections' => array(
                            array(
                                'id' => '0823-90',
                                'name' => 'Ville des Irois'
                            ),
                            array(
                                'id' => '0823-80',
                                'name' => 'Quartier de Garcasse'
                            ),
                            array(
                                'id' => '0823-01',
                                'name' => '5ème Sect. Matador (Jorgue)'
                            ),
                            array(
                                'id' => '0823-02',
                                'name' => '6ème Sect. Belair'
                            ),
                            array(
                                'id' => '0823-03',
                                'name' => '7ème Sect. Garcasse'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0831',
                        'name' => 'corail',
                        'sections' => array(
                            array(
                                'id' => '0831-90',
                                'name' => 'Ville de Corail'
                            ),
                            array(
                                'id' => '0831-01',
                                'name' => '1ère Sect. Duquillon'
                            ),
                            array(
                                'id' => '0831-02',
                                'name' => '2ème Sect. Fonds d\'Icaque'
                            ),
                            array(
                                'id' => '0831-03',
                                'name' => '3ème Sect. Champy (Nan Campèche)'
                            ),
                            array(
                                'id' => '0831-04',
                                'name' => '2ème Sect. Chardonnette'
                            ),
                            array(
                                'id' => '0831-05',
                                'name' => '3ème Sect. Mouline'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0832',
                        'name' => 'roseaux',
                        'sections' => array(
                            array(
                                'id' => '0832-90',
                                'name' => 'Ville de Roseaux'
                            ),
                            array(
                                'id' => '0832-01',
                                'name' => '1ère Sec. Carrefour Charles ou Jacquin'
                            ),
                            array(
                                'id' => '0832-02',
                                'name' => '2ème Sect. Fond-Cochon ou Lopineau'
                            ),
                            array(
                                'id' => '0832-03',
                                'name' => '3ème Sect. Grand-Vincent'
                            ),
                            array(
                                'id' => '0832-04',
                                'name' => '4ème Sect. Les Gommiers'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0833',
                        'name' => 'beaumont',
                        'sections' => array(
                            array(
                                'id' => '0833-90',
                                'name' => 'Ville de Beaumont'
                            ),
                            array(
                                'id' => '0833-01',
                                'name' => '1ère Sect. Beaumont'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0834',
                        'name' => 'pestel',
                        'sections' => array(
                            array(
                                'id' => '0834-90',
                                'name' => 'Ville de Pestel'
                            ),
                            array(
                                'id' => '0834-01',
                                'name' => '1ère Sect. Bernagousse'
                            ),
                            array(
                                'id' => '0834-02',
                                'name' => '2ème Sect. Espère'
                            ),
                            array(
                                'id' => '0834-03',
                                'name' => '3ème Sect. Jn Bellune'
                            ),
                            array(
                                'id' => '0834-04',
                                'name' => '4ème Sect. Tozia'
                            ),
                            array(
                                'id' => '0834-05',
                                'name' => '5ème Sect. Duchity'
                            ),
                            array(
                                'id' => '0834-06',
                                'name' => '6ème Sect. Les Iles Cayemittes'
                            ),
                        ),
                    ),
                ),
            ),
            //============================== DEBUT DEPARTEMENT OUEST ==================================
            array(
                'id' => '011',
                'name' => 'Lwès',
                'cities' => array(
                    
                          
                    //---------------------------------------------  
                    array(
                        'id' => '0110',
                        'name' => 'Commune Enkoni (OSL)',
                        'sections' => array(
                            array(
                                'id' => '0110-00',
                                'name' => 'Section Enkoni (OSL)'
                        )
                        )
                        ),
                   //-------------------------------------------------------- 
                    array(
                        'id' => '01100',
                        'name' => 'Commune Enkoni (OSN)',
                        'sections' => array(
                            array(
                                'id' => '01100-00',
                                'name' => 'Section Enkoni (OSN)'
                        )
                        )
                        ),
                   //--------------------------------------------------------
                    
                    array(
                        'id' => '0111',
                        'name' => 'port-au-prince',
                        'sections' => array(
                            array(
                                'id' => '0111-90',
                                'name' => 'Ville de Port-au-Prince'
                            ),
                            array(
                                'id' => '0111-01',
                                'name' => '1ère Sect. Turgeau'
                            ),
                            array(
                                'id' => '0111-02',
                                'name' => '2ème Sect. Morne l\'Hôpital'
                            ),
                            array(
                                'id' => '0111-03',
                                'name' => '3ème Sect. Martissant'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0112',
                        'name' => 'delmas',
                        'sections' => array(
                            array(
                                'id' => '0112-90',
                                'name' => 'Ville de Delmas'
                            ),
                            array(
                                'id' => '0112-01',
                                'name' => '1ère Sect. St-Martin'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0113',
                        'name' => 'Carrefour',
                        'sections' => array(
                            array(
                                'id' => '0113-90',
                                'name' => 'Ville de Carrefour'
                            ),
                            array(
                                'id' => '0113-01',
                                'name' => '1ère Sect. Morne Chandelle'
                            ),
                            array(
                                'id' => '0113-02',
                                'name' => '2ème Sect. Platon Dufrene'
                            ),
                            array(
                                'id' => '0113-03',
                                'name' => '3ème Sect. Taifer'
                            ),
                            array(
                                'id' => '0113-04',
                                'name' => '4ème Sect. Procy'
                            ),
                            array(
                                'id' => '0113-05',
                                'name' => '5ème Sect. Coupeau'
                            ),
                            array(
                                'id' => '0113-06',
                                'name' => '6ème Sect. Bouvier'
                            ),
                            array(
                                'id' => '0113-07',
                                'name' => '7ème Sect. Lavalle '
                            ),
                            array(
                                'id' => '0113-08',
                                'name' => '8ème Sect. Berly'
                            ),
                            array(
                                'id' => '0113-09',
                                'name' => '9ème Sect. Bizoton'
                            ),
                            array(
                                'id' => '0113-10',
                                'name' => '10ème Sect. Thor'
                            ),
                            array(
                                'id' => '0113-11',
                                'name' => '11ème Sect. Rivière Froide'
                            ),
                            array(
                                'id' => '0113-12',
                                'name' => '12ème Sect. Malanga'
                            ),
                            array(
                                'id' => '0113-13',
                                'name' => '13ème Sect. Corail Thors'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0114',
                        'name' => 'Pétion-ville',
                        'sections' => array(
                            array(
                                'id' => '0114-90',
                                'name' => 'Ville de Pétion-Ville'
                            ),
                            array(
                                'id' => '0114-80',
                                'name' => 'Quartier de Thomassin'
                            ),
                            array(
                                'id' => '0114-01',
                                'name' => '1ère Sect. Montagne Noire'
                            ),
                            array(
                                'id' => '0114-02',
                                'name' => '2ème Sect. Aux Cadets'
                            ),
                            array(
                                'id' => '0114-03',
                                'name' => '3ème Sect. Etang du Jonc'
                            ),
                            array(
                                'id' => '0114-04',
                                'name' => '4ème Sect. Bellevue La Montagne'
                            ),
                            array(
                                'id' => '0114-05',
                                'name' => '5ème Sect. Bellevue Chardonnière'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0115',
                        'name' => 'kenscoff',
                        'sections' => array(
                            array(
                                'id' => '0115-90',
                                'name' => 'Ville de Kenscoff'
                            ),
                            array(
                                'id' => '0115-01',
                                'name' => '1ère Sect. Nouvelle Tourraine'
                            ),
                            array(
                                'id' => '0115-02',
                                'name' => '2ème Sect. Bongars'
                            ),
                            array(
                                'id' => '0115-03',
                                'name' => '3ème Sect. Sourcailles'
                            ),
                            array(
                                'id' => '0115-04',
                                'name' => '4ème Sect. Belle Fontaine'
                            ),
                            array(
                                'id' => '0115-05',
                                'name' => '5ème Sect. Grand Fond'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0116',
                        'name' => 'gressier',
                        'sections' => array(
                            array(
                                'id' => '0116-90',
                                'name' => 'Ville de Gressier'
                            ),
                            array(
                                'id' => '0116-01',
                                'name' => '1ère Sect. Morne à Bateau'
                            ),
                            array(
                                'id' => '0116-02',
                                'name' => '2ème Sect. Morne Chandelle'
                            ),
                            array(
                                'id' => '0116-03',
                                'name' => '3ème Sect. Petit Boucan'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0117',
                        'name' => 'cite-soleil',
                        'sections' => array(
                            array(
                                'id' => '0117-90',
                                'name' => 'Ville de Cité Soleil'
                            ),
                            array(
                                'id' => '0117-01',
                                'name' => '1ère Sect. Varreux'
                            ),
                            array(
                                'id' => '0117-02',
                                'name' => '2ème Sect. Varreux'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0118',
                        'name' => 'tabarre',
                        'sections' => array(
                            array(
                                'id' => '0118-90',
                                'name' => 'Ville de Tabarre'
                            ),
                            array(
                                'id' => '0118-80',
                                'name' => 'Quartier de la Croix-Des-Missions'
                            ),
                            array(
                                'id' => '0118-01',
                                'name' => '3ème Sect. Bellevue'
                            ),
                            array(
                                'id' => '0118-02',
                                'name' => '4ème Sect. Bellevue'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0121',
                        'name' => 'leogane',
                        'sections' => array(
                            array(
                                'id' => '0121-90',
                                'name' => 'Ville de Léogane'
                            ),
                            array(
                                'id' => '0121-80',
                                'name' => 'Quartier de Trouin'
                            ),
                            array(
                                'id' => '0121-01',
                                'name' => '1ère Sect. Dessources'
                            ),
                            array(
                                'id' => '0121-02',
                                'name' => '2ème Sect. Petite Rivière'
                            ),
                            array(
                                'id' => '0121-03',
                                'name' => '3ème Sect. Grande Rivière'
                            ),
                            array(
                                'id' => '0121-04',
                                'name' => '4ème Sect. Fond de Boudin'
                            ),
                            array(
                                'id' => '0121-05',
                                'name' => '5ème Sect. Palmiste à Vin'
                            ),
                            array(
                                'id' => '0121-06',
                                'name' => '6ème Sect. Orangers'
                            ),
                            array(
                                'id' => '0121-07',
                                'name' => '7ème Sect. Parques'
                            ),
                            array(
                                'id' => '0121-08',
                                'name' => '8ème Sect. Beausejour'
                            ),
                            array(
                                'id' => '0121-09',
                                'name' => '9ème Sect. Citronniers'
                            ),
                            array(
                                'id' => '0121-10',
                                'name' => '10ème Sect. Fond d\'Oie'
                            ),
                            array(
                                'id' => '0121-11',
                                'name' => '11ème Sect. Gros Morne'
                            ),
                            array(
                                'id' => '0121-12',
                                'name' => '12ème Sect. Cormiers'
                            ),
                            array(
                                'id' => '0121-13',
                                'name' => '13ème Sect. Petit Harpon'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0122',
                        'name' => 'petit-goave',
                        'sections' => array(
                            array(
                                'id' => '0122-90',
                                'name' => 'Ville de Petit Gôave'
                            ),
                            array(
                                'id' => '0122-80',
                                'name' => 'Quartier de Vialet'
                            ),
                            array(
                                'id' => '0122-01',
                                'name' => '1ère Sect. Bino(Première Plaine)'
                            ),
                            array(
                                'id' => '0122-02',
                                'name' => '2ème Sect.Delatre(2ème Plaine)'
                            ),
                            array(
                                'id' => '0122-03',
                                'name' => '3ème Sect. Trou Chouchou'
                            ),
                            array(
                                'id' => '0122-04',
                                'name' => '4ème Sect. Fond Arabie'
                            ),
                            array(
                                'id' => '0122-05',
                                'name' => '5ème Sect. Trou Canar'
                            ),
                            array(
                                'id' => '0122-06',
                                'name' => '6ème Sect. Trou Canari'
                            ),
                            array(
                                'id' => '0122-07',
                                'name' => '7ème Sect. Des Platons'
                            ),
                            array(
                                'id' => '0122-08',
                                'name' => '8ème Sect. Des Platons'
                            ),
                            array(
                                'id' => '0122-09',
                                'name' => '9ème Sect. Des Palmes'
                            ),
                            array(
                                'id' => '0122-10',
                                'name' => '10ème Sect. Des Palmes'
                            ),
                            array(
                                'id' => '0122-11',
                                'name' => '11ème Sect. Ravine Sèche'
                            ),
                            array(
                                'id' => '0122-12',
                                'name' => '12ème Sect. Des Fourques'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0123',
                        'name' => 'grand-goave',
                        'sections' => array(
                            array(
                                'id' => '0123-90',
                                'name' => 'Ville de Grand-Gôave'
                            ),
                            array(
                                'id' => '0123-01',
                                'name' => '1ère Sect. Tête-à-Boeuf'
                            ),
                            array(
                                'id' => '0123-02',
                                'name' => '2ème Sect. Tête-à-Boeuf'
                            ),
                            array(
                                'id' => '0123-03',
                                'name' => '3ème Sect. Moussambé'
                            ),
                            array(
                                'id' => '0123-04',
                                'name' => '4ème Sect. Moussambé'
                            ),
                            array(
                                'id' => '0123-05',
                                'name' => '5ème Sect. Grande Colline'
                            ),
                            array(
                                'id' => '0123-06',
                                'name' => '6ème Sect. Grande Colline'
                            ),
                            array(
                                'id' => '0123-07',
                                'name' => '7ème Sect. Gérard'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0131',
                        'name' => 'croix-des-bouquets',
                        'sections' => array(
                            array(
                                'id' => '0131-90',
                                'name' => 'Ville de Croix des Bouquets'
                            ),
                            array(
                                'id' => '0131-01',
                                'name' => '1ère Sect. des Varreux'
                            ),
                            array(
                                'id' => '0131-02',
                                'name' => '2ème Sect. des Varreux'
                            ),
                            array(
                                'id' => '0131-03',
                                'name' => '3ème Sect. Petit Bois'
                            ),
                            array(
                                'id' => '0131-04',
                                'name' => '4ème Sect. Petit Bois'
                            ),
                            array(
                                'id' => '0131-05',
                                'name' => '5ème Sect. Petit Bois'
                            ),
                            array(
                                'id' => '0131-06',
                                'name' => '6ème Sect. Belle Fontaine'
                            ),
                            array(
                                'id' => '0131-07',
                                'name' => '7ème Sect. Belle Fontaine'
                            ),
                            array(
                                'id' => '0131-08',
                                'name' => '8ème Belle Fontaine'
                            ),
                            array(
                                'id' => '0131-09',
                                'name' => '9ème Sect. des Crochus'
                            ),
                            array(
                                'id' => '0131-10',
                                'name' => '10ème Sect. des Orangers'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0132',
                        'name' => 'thomazeau',
                        'sections' => array(
                            array(
                                'id' => '0132-90',
                                'name' => 'Ville de Thomazeau'
                            ),
                            array(
                                'id' => '0132-01',
                                'name' => '1ère Sect. Grande Plaine'
                            ),
                            array(
                                'id' => '0132-02',
                                'name' => '2ème Sect. Grande Plaine'
                            ),
                            array(
                                'id' => '0132-03',
                                'name' => '3ème Sect. Trou d\'Eau'
                            ),
                            array(
                                'id' => '0132-04',
                                'name' => '4ème Sect. des Crochus'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0133',
                        'name' => 'ganthier',
                        'sections' => array(
                            array(
                                'id' => '0133-90',
                                'name' => 'Ville de Ganthier'
                            ),
                            array(
                                'id' => '0133-80',
                                'name' => 'Quartier Fond Parisien'
                            ),
                            array(
                                'id' => '0133-01',
                                'name' => '1ère Sect. Galette Chambon'
                            ),
                            array(
                                'id' => '0133-02',
                                'name' => '2ème Sect. Balan'
                            ),
                            array(
                                'id' => '0133-03',
                                'name' => '3ème Sect. Fond Parisien'
                            ),
                            array(
                                'id' => '0133-04',
                                'name' => '4ème Sect. Pays Pourri'
                            ),
                            array(
                                'id' => '0133-05',
                                'name' => '5ème Sect. Mare Roseaux'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0134',
                        'name' => 'cornillon',
                        'sections' => array(
                            array(
                                'id' => '0134-90',
                                'name' => 'Ville de Cornillon'
                            ),
                            array(
                                'id' => '0134-01',
                                'name' => '1ère Sect. Plaine Céleste'
                            ),
                            array(
                                'id' => '0134-02',
                                'name' => '2ème Sect. Plaine Céleste'
                            ),
                            array(
                                'id' => '0134-03',
                                'name' => '3ème Boucan Bois Pin'
                            ),
                            array(
                                'id' => '0134-04',
                                'name' => '4ème Boucan Bois Pin'
                            ),
                            array(
                                'id' => '0134-05',
                                'name' => '5ème Génipailler'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0135',
                        'name' => 'fonds-verrettes',
                        'sections' => array(
                            array(
                                'id' => '0135-90',
                                'name' => 'Ville de Fonds-Verrettes'
                            ),
                            array(
                                'id' => '0135-01',
                                'name' => '1ère Sect. Fonds-Verrettes'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0141',
                        'name' => 'arcahaie',
                        'sections' => array(
                            array(
                                'id' => '0141-90',
                                'name' => 'Ville de l\’Arcahaie'
                            ),
                            array(
                                'id' => '0141-80',
                                'name' => 'Quartier de Saintard'
                            ),
                            array(
                                'id' => '0141-01',
                                'name' => '1ère Boucassin'
                            ),
                            array(
                                'id' => '0141-02',
                                'name' => '2ème Sect. Fonds Baptiste'
                            ),
                            array(
                                'id' => '0141-03',
                                'name' => '3ème Sect. Des Vases'
                            ),
                            array(
                                'id' => '0141-04',
                                'name' => '4ème Sect. Montrouis'
                            ),
                            array(
                                'id' => '0141-05',
                                'name' => '5ème Sect. Délices'
                            ),
                            array(
                                'id' => '0141-06',
                                'name' => '6ème Sect. Matheux'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0142',
                        'name' => 'cabaret',
                        'sections' => array(
                            array(
                                'id' => '0142-90',
                                'name' => 'Ville de Cabaret'
                            ),
                            array(
                                'id' => '0142-01',
                                'name' => '1ère Sect. Boucassin'
                            ),
                            array(
                                'id' => '0142-02',
                                'name' => '2ème Sect. Boucassin'
                            ),
                            array(
                                'id' => '0142-03',
                                'name' => '3ème Sect. Source-Matelas'
                            ),
                            array(
                                'id' => '0142-04',
                                'name' => '4ème Sect. Fonds-des-Blancs(Casale)'
                            ),
                        ),
                    ),
                    array(
                        'id' => '0151',
                        'name' => 'Anse-à-galets',
                        'sections' => array(
                            array(
                                'id' => '0151-90',
                                'name' => 'Ville de l\'Anse à Galets '
                            ),
                            array(
                                'id' => '0151-01',
                                'name' => ' 1ère Sect. Palma   '
                            ),
                            array(
                                'id' => '0151-02',
                                'name' => '  2ème Sect. Petite Source    '
                            ),
                            array(
                                'id' => '0151-03',
                                'name' => ' 3ème Sect. Grande Source   '
                            ),
                            array(
                                'id' => '0151-04',
                                'name' => ' 4ème Sect. Grand Lagon    '
                            ),
                            array(
                                'id' => '0151-05',
                                'name' => ' 5ème Sect. Picmy    '
                            ),
                            array(
                                'id' => '0151-06',
                                'name' => ' 6ème Sect. Petit Anse    '
                            ),
                        ),
                    ),
                    array(
                        'id' => '0152',
                        'name' => 'Pointe-à-raquette ',
                        'sections' => array(
                            array(
                                'id' => '0152-90',
                                'name' => '  Ville de Pointe à Raquette  '
                            ),
                            array(
                                'id' => '0152-01',
                                'name' => '  1ère Sect. La Source   '
                            ),
                            array(
                                'id' => '0152-02',
                                'name' => '   2ème Sect. Grand Vide '
                            ),
                            array(
                                'id' => '0152-03',
                                'name' => '3ème Sect. Trou Louis     '
                            ),
                            array(
                                'id' => '0152-04',
                                'name' => '4ème Sect. Pointe à Raquette '
                            ),
                            array(
                                'id' => '0152-05',
                                'name' => '5ème Sect. Gros Mangle'
                            ),
                        ),
                    ),
                ),
            ),
            array(//************* NIPPES ***************



                'id' => '101',
                'name' => 'Nip',
                'cities' => array(
                    
                      //---------------------------------------------  
                    array(
                        'id' => '1010',
                        'name' => 'Commune ENKONI (NIP)',
                        'sections' => array(
                            array(
                                'id' => '1010-00',
                                'name' => 'Section ENKONI (NIP)'
                        )
                        )
                        ),
                   //-------------------------------------------------------- 
                    array(
                        'id' => '1011',
                        'name' => 'miragoane',
                        'sections' => array(
                            array(
                                'id' => '1011-90',
                                'name' => 'Ville de Miragoane'
                            ),
                            array(
                                'id' => '1011-80',
                                'name' => 'Quartier Saint Michel du Sud'
                            ),
                            array(
                                'id' => '1011-01',
                                'name' => '1ère Sect. Chalon'
                            ),
                            array(
                                'id' => '1011-02',
                                'name' => '2ème Sect. Belle-Rivière'
                            ),
                            array(
                                'id' => '1011-03',
                                'name' => '3ème Sect. Dessources'
                            ),
                            array(
                                'id' => '1011-04',
                                'name' => '4ème Sect. Saint-Michel'
                            ),
                        ),
                    ),
                    array(
                        'id' => '1012',
                        'name' => 'pte-riviere',
                        'sections' => array(
                            array(
                                'id' => '1012-90',
                                'name' => 'Ville de Petite-Rivière de Nippes'
                            ),
                            array(
                                'id' => '1012-80',
                                'name' => 'Quartier Charlier'
                            ),
                            array(
                                'id' => '1012-01',
                                'name' => '1ère Sect. Fond-des-Lianes'
                            ),
                            array(
                                'id' => '1012-02',
                                'name' => '2ème Sect. Cholette'
                            ),
                            array(
                                'id' => '1012-03',
                                'name' => '3ème Sect. Silègue'
                            ),
                            array(
                                'id' => '1012-04',
                                'name' => '4ème Sect. Bézin'
                            ),
                        ),
                    ),
                    array(
                        'id' => '1013',
                        'name' => 'fonds-des-negres',
                        'sections' => array(
                            array(
                                'id' => '1013-90',
                                'name' => 'Ville de Fonds-des-Nègres'
                            ),
                            array(
                                'id' => '1013-80',
                                'name' => 'Quartier Bouzi'
                            ),
                            array(
                                'id' => '1013-01',
                                'name' => '1ère Sect. Bouzi'
                            ),
                            array(
                                'id' => '1013-02',
                                'name' => '2ème Sect. Fonds-des-Nègres ou Morne Brice'
                            ),
                            array(
                                'id' => '1013-03',
                                'name' => '3ème Sect. Pémerle'
                            ),
                            array(
                                'id' => '1013-04',
                                'name' => '4ème Sect. Cocoyers-Ducheine'
                            ),
                        ),
                    ),
                    array(
                        'id' => '1014',
                        'name' => 'paillant',
                        'sections' => array(
                            array(
                                'id' => '1014-90',
                                'name' => 'Ville de Paillant'
                            ),
                            array(
                                'id' => '1014-01',
                                'name' => '1ère Sect. Salagnac'
                            ),
                            array(
                                'id' => '1014-02',
                                'name' => '2ème Sect. Bézin II'
                            ),
                        ),
                    ),
                    array(
                        'id' => '1021',
                        'name' => 'Anse-à-veau',
                        'sections' => array(
                            array(
                                'id' => '1021-90',
                                'name' => 'Ville de l\'Anse à Veau'
                            ),
                            array(
                                'id' => '1021-80',
                                'name' => 'Quartier de Baconnois'
                            ),
                            array(
                                'id' => '1021-81',
                                'name' => 'Quartier Saut du Baril'
                            ),
                            array(
                                'id' => '1021-01',
                                'name' => '1ère Sect. Baconnois-Grand-Fond'
                            ),
                            array(
                                'id' => '1021-02',
                                'name' => '2ème Sect. Grande-Rivière-Joly'
                            ),
                            array(
                                'id' => '1021-03',
                                'name' => '3ème Sect. Saut du Baril'
                            ),
                        ),
                    ),
                    array(
                        'id' => '1022',
                        'name' => 'trou-de-nippes',
                        'sections' => array(
                            array(
                                'id' => '1022-90',
                                'name' => 'Ville de Petit Trou de Nippes'
                            ),
                            array(
                                'id' => '1022-80',
                                'name' => 'Quartier de Grande-Ravine'
                            ),
                            array(
                                'id' => '1022-81',
                                'name' => 'Quartier Lièvre'
                            ),
                            array(
                                'id' => '1022-01',
                                'name' => '1ère Sect. Raymond'
                            ),
                            array(
                                'id' => '1022-02',
                                'name' => '2ème Sect. Tiby'
                            ),
                            array(
                                'id' => '1022-03',
                                'name' => '3ème Sect. Lièvre'
                            ),
                        ),
                    ),
                    array(
                        'id' => '1023',
                        'name' => 'Asile',
                        'sections' => array(
                            array(
                                'id' => '1023-90',
                                'name' => 'Ville de l\'Asile'
                            ),
                            array(
                                'id' => '1023-80',
                                'name' => 'Quartier Changieux'
                            ),
                            array(
                                'id' => '1023-81',
                                'name' => 'Quartier Morisseau'
                            ),
                            array(
                                'id' => '1023-01',
                                'name' => '1ère Section l\'Asile ou Nan Paul'
                            ),
                            array(
                                'id' => '1023-02',
                                'name' => '2ème Section Changieux'
                            ),
                            array(
                                'id' => '1023-03',
                                'name' => '3ème Sect. Tournade'
                            ),
                            array(
                                'id' => '1023-04',
                                'name' => '4ème Sect. Morisseau'
                            ),
                        ),
                    ),
                    array(
                        'id' => '1024',
                        'name' => 'arnaud',
                        'sections' => array(
                            array(
                                'id' => '1024-90',
                                'name' => 'Ville d\'Arnaud'
                            ),
                            array(
                                'id' => '1024-01',
                                'name' => '1ère Sect. Baconnois-Barreau'
                            ),
                            array(
                                'id' => '1024-02',
                                'name' => '2ème Sect. Baquet'
                            ),
                            array(
                                'id' => '1024-03',
                                'name' => '3ème Sect. Arnaud (Morcou)'
                            ),
                        ),
                    ),
                    array(
                        'id' => '1025',
                        'name' => 'plaisance',
                        'sections' => array(
                            array(
                                'id' => '1025-90',
                                'name' => 'Ville de Plaisance du Sud'
                            ),
                            array(
                                'id' => '1025-01',
                                'name' => '1ère Sect. Plaisance (ou Ti François)'
                            ),
                            array(
                                'id' => '1025-02',
                                'name' => '2ème Sect. Anse-aux-Pins'
                            ),
                            array(
                                'id' => '1025-03',
                                'name' => '3ème Sect. Vassal Labiche,Dorlette(avec Sénéac et Dupuy'
                            ),
                        ),
                    ),
                    array(
                        'id' => '1031',
                        'name' => 'baraderes',
                        'sections' => array(
                            array(
                                'id' => '1031-90',
                                'name' => 'Ville des Baradères'
                            ),
                            array(
                                'id' => '1031-81',
                                'name' => 'Quartier Fond-Tortue'
                            ),
                            array(
                                'id' => '1031-01',
                                'name' => '1ère Sect. Gérin ou Mouton'
                            ),
                            array(
                                'id' => '1031-02',
                                'name' => '2ème Sect. Tête d\'Eau'
                            ),
                            array(
                                'id' => '1031-03',
                                'name' => '3ème Sect. Fond-Tortue'
                            ),
                            array(
                                'id' => '1031-04',
                                'name' => '4ème Sect. La Plaine'
                            ),
                            array(
                                'id' => '1031-05',
                                'name' => '5ème Sect. Rivière Salée'
                            ),
                        ),
                    ),
                    array(
                        'id' => '1032',
                        'name' => 'grand-boucan',
                        'sections' => array(
                            array(
                                'id' => '1032-90',
                                'name' => 'Ville de Grand Boucan'
                            ),
                            array(
                                'id' => '1032-80',
                                'name' => 'Quartier Eaux Basses'
                            ),
                            array(
                                'id' => '1032-01',
                                'name' => '1ère Sect. Grand Boucan'
                            ),
                            array(
                                'id' => '1032-02',
                                'name' => '2ème Sect. Eaux Basses'
                            ),
                        ),
                    ),
                ),
            ),
        );

        return $departments;
    }

}

$departments = array();
