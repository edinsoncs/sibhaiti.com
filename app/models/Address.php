<?php

class Address extends Eloquent {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'address';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $guarded = array('id');
    protected $fillable = array(
        'rId', // reference id
        'rOb', // reference object
        'department',
        'city',
        'cSection',
        'isActv',
        'desc',
    );
}