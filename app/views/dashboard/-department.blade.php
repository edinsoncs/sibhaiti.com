@extends('layouts.common')

@section('content')
@include('templates.headerTop')

@include('templates.header')
<div class="container">
    <?php
    /*
      if ($page_id == '_dashboard')
      {
      ?>
      <div class="pull-right">
      <form class="navbar-form navbar-left" role="search">
      <div class="form-group">
      <input name="search" type="text" class="form-control" placeholder="Recherche" value="<?php echo (isset($search)) ? $search : NULL ?>">
      </div>
      <button type="submit" class="btn btn-info">Recherche</button>
      </form>
      </div>
      <?php
      } */
    ?>
    <div class="page-header">
        <h2><?php echo 'Department: ' . array_get($deparment, 'name'); ?></h2>
    </div>
    <div class="row">
        <?php
        if (isset($deparment) && !empty($deparment))
        {
            $cities = array_get($deparment, 'cities');
            foreach ($cities as $city)
            {
                ?>
                <div class="col-lg-3 dept-box">
                    <legend><?php echo array_get($city, 'name'); ?></legend>
                    <div><?php echo 'Animals' . " (" . User::cityCounter('animal', array_get($deparment, 'id'), array_get($city, 'id')) . ")"; ?></div>
                    <div><?php echo 'Agents' . " (" . User::cityCounter('agent', array_get($deparment, 'id'), array_get($city, 'id')) . ")"; ?></div>
                    <div><?php echo 'Eleveurs' . " (" . User::cityCounter('eleveur', array_get($deparment, 'id'), array_get($city, 'id')) . ")"; ?></div>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>
@include('templates.footer')

@endsection