<?php

class Notification extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = array('id');
    protected $fillable = array(
        'date',
        'type',
        'rId', // reference id
        'rOb', // reference object
        'department',
        'city',
        'cSection',
        'so',
        'abbatoire',
        'day',
        'nday',
        'month',
        'year',
        'chabon',
        'old_cin',
        'new_cin',
        'tag',
        'kane',
        'cin_eleveur',
        'old_tag',
        'new_tag',
        'old_kane',
        'new_kane',
        'isActv',
        'desc',
        'text'
    );

    public function getAgent()
    {
        $agent = Agent::find($this->agent);
        if ($agent)
        {
            return $agent->getFullNameAttribute();
        }
        else
        {
            return NULL;
        }
    }

    public function abbatoir()
    {
        $abat = Abattoir::find($this->abbatoire);
        if ($abat)
        {
            return $abat->name;
        }
        else
        {
            return NULL;
        }
    }

    static function departments($notifications, $department)
    {
        $counter = 0;
        foreach ($notifications as $noti)
        {
            $animal = Animal::find($noti->rId);
            if ($animal)
            {
                if ($animal->department == $department)
                {
                    $counter++;
                }
            }
            else
            {
                // $noti->delete();
            }
        }
        return $counter;
    }

}
