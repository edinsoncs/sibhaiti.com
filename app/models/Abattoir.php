<?php

class Abattoir extends Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'abattoirs';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = array('id');
    protected $fillable = array(
        'name',
        'type',
        'owner',
        'phone',
        'description',
        'bef',
        'kabri',
        'mouton',
        'kochon',
        'agent1',
        'agent2',
        'agent3',
        'agent4',
        'agent5',
        'isActv',
        'dept', 
        'city',
        'cSection',
        'desc'
    );

    public function department()
    {
        $address = Address::where('rId', $this->id)->where('rOb', 'abattoir')->first();
        if ($address)
        {
            return $address->department;
        }
        return NULL;
    }

    public function city()
    {
        $address = Address::where('rId', $this->id)->where('rOb', 'abattoir')->first();
        if ($address)
        {
            return $address->city;
        }
        return NULL;
    }

    public function cSection()
    {
        $address = Address::where('rId', $this->id)->where('rOb', 'abattoir')->first();
        if ($address)
        {
            return $address->cSection;
        }
        return NULL;
    }

    static function indepartment($dept)
    {
        $list = array();
        $abattoirs = Abattoir::where('isActv', TRUE)->get();
        foreach ($abattoirs as $item)
        {
            if ($item->department() == $dept)
            {
                array_push($list, $item);
            }
        }
        return $list;
    }

    static function betDeptCounter($dept = NULL, $bet = NULL, $city = NULL)
    {
        $cant = 0;
        if ($dept != NULL && $bet != NULL)
        {
            if ($city != NULL)
            {
                $abattoirs = Abattoir::where('isActv', TRUE)->where('dept', $dept)->where('city', $city)->get();
            } else
            {
                $abattoirs = Abattoir::where('isActv', TRUE)->where('dept', $dept)->get();
            }
            foreach ($abattoirs as $item)
            {
                $cant += $item->$bet;
            }
        }
        return $cant;
    }

    public function notifications()
    {
        $notifications = Notification::where('isActv', TRUE)->where('type','a')->where('abbatoire', $this->id)->count();
        return $notifications;
    }
    
     static function notificationDeptCounter($dept = NULL, $city = NULL)
    {
        $notifications = 0;
        if ($dept != NULL)
        {
            if ($city != NULL)
            {
                $notifications = Notification::where('isActv', TRUE)->where('type', 'a')->where('department', $dept)->where('city', $city)->count();
            } else
            {
                $notifications = Notification::where('isActv', TRUE)->where('type', 'a')->where('department', $dept)->count();
            }
        }
        return $notifications;
    }

}
