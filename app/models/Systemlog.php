<?php

class Systemlog extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'systemlogs';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = array('id');
    protected $fillable = array(
        'text',
        'user_id',
        'rId', // reference id
        'rOb', // reference object
        'desc',
        'isActv',
    );

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function history($object, $old, $new)
    {
        $text = "";
        if ($object && $old && $new)
        {
            $this->rId = array_get($old, 'id');
            $this->rOb = $object;
            $this->isActv = TRUE;
            if ($object == 'Animal')
            {
                $compare = array(
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
                    'country',
                    'isDead');
            }
            else if ($object == 'Eleveur')
            {
                $compare = array(
                    'idEleveur',
                    'fiche',
                    'phone',
                    'fName',
                    'lName',
                    'sex',
                    'cin',
                    'department',
                    'city',
                    'cSection',
                    'nif',
                );
            }
            else if ($object == 'Agent')
            {
                $compare = array(
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
                    'tipajan',
                    'lRank',
                    'hRank',
                    'tTotal',
                    'aDate',
                );
            }
            else if ($object == 'Abattoir')
            {
                $compare = array(
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
                    'dept',
                    'city',
                    'cSection',
                );
            }
            if (isset($compare))
            {
                foreach ($compare as $i)
                {
                    if (array_get($old, $i) != array_get($new, $i))
                    {
                        $from = array_get($old, $i);
                        $to = array_get($new, $i);
                        if ($i == 'department' || $i == 'dept')
                        {
                            $deptFrom = $from;
                            $deptTo = $to;
                            $from = User::getDepartment($from);
                            $to = User::getDepartment($to);
                        }
                        if ($i == 'city' && isset($deptFrom) && isset($deptTo))
                        {
                            $cityFrom = $from;
                            $cityTo = $to;
                            $from = User::getCity($deptFrom, $from);
                            $to = User::getCity($deptTo, $to);
                        }
                        if ($i == 'cSection' && isset($deptFrom) && isset($deptTo) && isset($cityFrom) && isset($cityTo))
                        {
                            $from = User::getSection($deptFrom, $cityFrom, $from);
                            $to = User::getSection($deptTo, $cityTo, $to);
                        }
                        if ($i == 'country')
                        {
                            $from = ($from) ? 'DOMINIKÈN' : 'AYISYÈN';
                            $to = ($to) ? 'DOMINIKÈN' : 'AYISYÈN';
                        }

                        $text.= "MODIFYÉ " . $i . " de " . $from . " a " . $to . " <br> ";
                    }
                }
            }
        }
        $this->text = $text;
    }

}
