@extends('layouts.common')

@section('content')
<div class="">
    <div class="col-lg-3">
    </div>
    <div class="well col-lg-6">
        <legend><?php echo Lang::get('Erreur'); ?></legend>
        <h3><?php echo Lang::get("Erreur! Veuillez re-vérifiez vos données d'inscriptions");?></h3>
        <div class="pull-right"><a href="/" class="btn btn-danger"><?php echo Lang::get('Enskripsyon'); ?></a></div>
    </div>
</div>
<!-- eo list tab -->
@endsection