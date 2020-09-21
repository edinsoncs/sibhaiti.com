<?php

class Eleveur extends Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'eleveurs';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = array('id');
    protected $fillable = array(
        'idEleveur',
        'fiche',
        'phone',
        'fName',
        'lName',
        'sex',
        'cin',
        'department',
        'cSection',
        'city',
        'nif',
        'isActv',
        'desc'
    );
	
	public function creator()
    {
        $name = "";
        if ($this->desc)
        {
            $user = User::find($this->desc);
            if($user)
            {
                $name = $user->getFullNameAttribute();
                return $name;
            }
        }

        return $name;
    }

    public function getFullNameAttribute()
    {
        return $this->fName . ' ' . $this->lName;
    }

    public function getAnimals()
    {
        if($this->cin != '00-00-00-0000-00-00000')
        {
            $animals = Animal::where('isActv', TRUE)->where('eleveur', $this->id)->count();
            return $animals;
        } else
        {
            return 0;
        }
    }

public function heritage($type = 'user')
    {
        if ($this->cin != '00-00-00-0000-00-00000')
        {
            $heritage = "";
            $animals = Animal::where('isActv', TRUE)->where('eleveur', $this->id)->get();
            foreach ($animals as $animal)
            {
                if ($type == 'user')
                {
                    $url = URL::route('editanimal', $animal->id);
                } else
                {
                    $url = URL::route('admineditanimal', $animal->id);
                }
                $heritage .= "<a href='" . $url . "'>" . $animal->tag . "</a><br>";
            }
            return $heritage;
        } else
        {
            return 0;
        }
    }

}
