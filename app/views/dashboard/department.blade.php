@extends('layouts.common')

@section('content')
@include('templates.headerTop')

@include('templates.header')
<div class="container">
    <p class="titre_top"><?php echo 'Depatman ' . array_get($deparment, 'name'); ?></p>
    <div id="search_admin">				
        <div class="row">
            <?php
            if (isset($deparment) && !empty($deparment)) {
                $cities = array_get($deparment, 'cities');
                foreach ($cities as $city) {
                    ?>					 
                    <legend><a href="{{URL::route('city', array(array_get($deparment, 'id'), array_get($city, 'id')))}}"><?php echo array_get($city, 'name'); ?></a></legend>
                    <ul>
                        <li><a href="<?php echo URL::route('animalscity', array_get($city, 'id')); ?>"><?php echo 'Bèf yo' . " (" . User::cityCounter('animal', array_get($deparment, 'id'), array_get($city, 'id')) . ")"; ?></a></li>
                        <li><a href="<?php echo URL::route('agentscity', array_get($city, 'id')); ?>"><?php echo 'Ajan Yo' . " (" . User::cityCounter('agent', array_get($deparment, 'id'), array_get($city, 'id')) . ")"; ?></a></li>
                        <li><a href="<?php echo URL::route('eleveurscity', array_get($city, 'id')); ?>"><?php echo 'Elvè Yo' . " (" . User::cityCounter('eleveur', array_get($deparment, 'id'), array_get($city, 'id')) . ")"; ?></a></li>                    					
                        <li><a href="<?php echo URL::route('abattoircity', array_get($city, 'id')); ?>"><?php echo 'Labatwa Yo' . " (" . User::cityCounter('abattoir', array_get($deparment, 'id'), array_get($city, 'id')) . ")"; ?></a></li>
                    </ul>
                    <?php
                }
            }
            ?>
        </div>		
    </div>
</div>
@include('templates.footer')

@endsection