<?php

class Animal extends Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'animals';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = array('id');
    protected $fillable = array(
        'carnet',
        'type',
        'tag',
        'fiche',
        'so',
        'birthday',
        'isVaccinated',
        'mTag',
        'fTag',
        'eleveur',
        'dDate',
        'department',
        'city',
        'cSection',
        'datIdant',
        'datIdantFix',
        'country',
        'isDead',
        'isActv',
        'desc'
    );

    public function creator()
    {
        $name = "";
        if ($this->desc)
        {
            $user = User::find($this->desc);
            if ($user)
            {
                $name = $user->getFullNameAttribute();
                return $name;
            }
        }

        return $name;
    }

    public function getAgent()
    {
        $agent = Agent::find($this->agent);
        if ($agent)
        {
            return $agent->getFullNameAttribute();
        } else
        {
            return NULL;
        }
    }

    public function noSoAgent()
    {
        $agent = Agent::select('*')->whereRaw("$this->tag between lRank and hRank")->first();
        if ($agent)
        {
            $so = (isset($agent->so)) ? $agent->so : NULL;
            return $so;
        } else
        {
            return NULL;
        }
    }

    public function getEleveur()
    {
        $eleveur = Eleveur::find($this->eleveur);
        if ($eleveur)
        {
            return $eleveur->getFullNameAttribute();
        } else
        {
            return NULL;
        }
    }

    static function getobjEleveur($eleveur_id)
    {
        $eleveur = Eleveur::find($eleveur_id);
        if ($eleveur)
        {
            return $eleveur;
        } else
        {
            return NULL;
        }
    }

}
