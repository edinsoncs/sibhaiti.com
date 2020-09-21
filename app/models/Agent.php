<?php

class Agent extends Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'agents';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = array('id');
    protected $fillable = array(
        'fName',
        'lName',
        'email',
        'sex',
        'nif',
        'cin',
        'birthday',
        'type',
        'phone',
        'phone2',
        'department',
        'city',
        'cSection',
        'so',
		'oldSo',
        'tipajan',
        'lRank',
        'hRank',
        'tTotal',
        'aDate',
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

    public function checkRank($lRank = NULL, $hRank = NULL, $id = NULL)
    {
        if ($id != NULL)
        {
            $agent = Agent::where('isActv', TRUE)->where('lRank', '<=', $lRank)->where('hRank', '>=', $hRank)->where('id', '<>', $id)->first();
        } else
        {
            $agent = Agent::where('isActv', TRUE)->where('lRank', '<=', $lRank)->where('hRank', '>=', $hRank)->first();
        }

        if ($agent)
        {
            //return FALSE;
            return TRUE;
        } else
        {
            return TRUE;
        }
    }

    public function notifications($year = NULL, $type = NULL)
    {
        if ($year != NULL && $type != NULL)
        {
            $notifications = Notification::where('isActv', TRUE)->where('year', $year)->where('type', $type)->count();
            return $notifications;
        }
        return 0;
    }

    public function animals($year = NULL)
    {
        if ($year != NULL)
        {
            $notifications = Animal::where('isActv', TRUE)->where('so', $this->so)->where('created_at', 'like', '%' . $year . '%')->count();
            return $notifications;
        }
        return 0;
    }

public function abattages() {
        $abattages = Notification::where('isActv', TRUE)->where('so', $this->so)->where('type','a')->count();
        return $abattages;
    }


}
