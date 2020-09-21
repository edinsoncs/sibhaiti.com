@extends('admin.layouts.common')

@section('content')
@include('templates.headerTop')

@include('admin.templates.header')
@include('admin.eleveurs.tab_top')
<div class="tab-pane <?php echo $active_tab == 'eleveurs_create' ? 'active' : NULL; ?>" id="tab_eleveurs_create">
    <form action="" method="post" name="eleveurs_create" class="form-horizontal">
        <div class="user-form">
            <?php
            if (isset($errors))
            {
                foreach ($errors as $error)
                {
                    ?>
                    <div class="text-danger">
                        <?php echo array_get($error, 0); ?>
                    </div>
                    <?php
                }
            }
            ?>
            <legend>Enfòmasyon sou moun nan</legend>
            <h4>Silvouplè, ranpli tout chan ki gen <span class="req">*</span></h4>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_eleveur_lName">
                    <?php echo Lang::get('Siyati'); ?><span class="req">*</span>
                </label>
                <div class="col-lg-5">
                    <input name="create[eleveur][lName]" id="create_eleveur_lName" class="form-control" maxlength="20" type="text" placeholder="<?php echo Lang::get('Siyati'); ?>" />
                    <span class="help-inline">
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_eleveur_fName">
                    <?php echo Lang::get('Non'); ?><span class="req">*</span>
                </label>
                <div class="col-lg-5">
                    <input name="create[eleveur][fName]" id="create_eleveur_fName" class="form-control" maxlength="20" type="text" placeholder="<?php echo Lang::get('non'); ?>"/>
                    <span class="help-inline">
                    </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_eleveur_sex">
                    <?php echo Lang::get('Sèks'); ?><span class="req">*</span>
                </label>
                <div class="col-lg-5">
                    <select name="create[eleveur][sex]" id="create_eleveur_sex" class="form-control" >
                        <option value=""><?php echo Lang::get('---'); ?></option>
                        <option value="m"> <?php echo Lang::get('Gason'); ?></option>
                        <option value="f"><?php echo Lang::get('Fi'); ?></option>
                    </select>
                    <span class="help-inline"> </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_eleveur_phone">
                    <?php echo Lang::get('Telefòn'); ?>
                </label>
                <div class="col-lg-5">
                    <input name="create[eleveur][phone]" id="create_eleveur_phone" class="form-control" maxlength="9" type="text" placeholder="<?php echo Lang::get('3634-4098'); ?>">
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_eleveur_fiche">
                    <?php echo Lang::get('#Fich'); ?><span class="req">*</span>
                </label>
                <div class="col-lg-5">
                    <input name="create[eleveur][fiche]" id="create_eleveur_fiche" class="form-control" maxlength="7" type="text" placeholder="<?php echo Lang::get('1234567'); ?>">
                    <span class="help-inline"></span>
                </div>
            </div>
            <legend>Nimewo MATRIKIL YO</legend>
            <?php /*
              <div class="form-group">
              <label class="col-lg-2 control-label" for="create_eleveur_nif">
              <?php echo Lang::get('NIF'); ?>
              </label>
              <div class="col-lg-5">
              <input name="create[eleveur][nif]" id="create_eleveur_nif" class="form-control" type="text"
              placeholder="<?php echo "054-764-087-8"; ?> ">
              <span class="help-inline">Si moun nan pa gen #nif, mete dis zero. ex:(0000000000)</span>

              </div>
              </div>
             */ ?>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_eleveur_cin">
                    <?php echo Lang::get('CIN'); ?><span class="req">*</span>
                </label>
                <div class="col-lg-5">
                    <input name="create[eleveur][cin]" id="create_eleveur_cin" class="form-control" type="text" placeholder="<?php echo "76-43-49-0985-51-9875"; ?>">
                    <span class="help-inline">Si moun nan pa gen cin mete sèt zero devan nif li (ex: 00-00-00-0132-43-00003)</span>
                </div>
            </div>
            <legend>ADRÈS</legend>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_eleveur_department_1"><?php echo Lang::get('Depatman'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <select name="create[eleveur][department]" id="create_eleveur_department_1" class="form-control">
                        <option value="">Chwazi depatman...</option>
                        <?php
                        foreach ($departments as $dept)
                        {
                            ?>
                            <option value="<?php echo array_get($dept, 'id'); ?>"><?php echo array_get($dept, 'name'); ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_eleveur_city"><?php echo Lang::get('Komin'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <select name="create[eleveur][city]" id="create_eleveur_city" class="form-control" >  
                        <option value="">Chwazi komin...</option>
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_eleveur_cSection"><?php echo Lang::get('Seksyon'); ?></label>
                <div class="col-lg-5">
                    <select name="create[eleveur][cSection]" id="create_eleveur_cSection" class="form-control" >  
                        <option value="">Seksyon...</option>
                    </select>
                    <?php /*
                      <input name="create[eleveur][cSection]" id="create_eleveur_cSection" maxlength="20" class="form-control" type="text" placeholder="<?php echo Lang::get('Seksyon'); ?>">
                     */ ?>
                    <span class="help-inline"></span>

                </div>
            </div>
            <legend>VERIFIKASYON MATRIKIL YO</legend>
            <?php /*
              <div class="form-group">
              <label class="col-lg-2 control-label" for="nif2"><?php echo Lang::get('NIF'); ?></label>
              <div class="col-lg-5">
              <input id="create_eleveur_nif2" class="form-control" type="text"
              placeholder="<?php echo "054-764-087-8"; ?> ">
              <span class="help-inline"></span>
              </div></div>
             */ ?>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="cin2"><?php echo Lang::get('CIN'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <input id="cin2" class="form-control" type="text" placeholder="<?php echo "76-43-49-0985-51-9875"; ?>">
                    <span class="help-inline">Si moun nan pa gen cin mete sèt zero devan nif li (ex: 00-00-00-0132-43-00003)</span>
                </div>
            </div>

        </div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-10">
                <button type="submit" class="btn btn-primary" name="create[submit]" onClick="return verifierPostEl();">
                    <?php echo Lang::get('Anrejistre Elvè'); ?>
                </button>
            </div>
        </div>
    </form>
</div>
<!-- eo list tab -->
<script type="text/javascript"> 
    var departments = <?php echo (!empty($departments)) ? json_encode($departments) : "{}"; ?>; 
    $(document).ready(function(){
        $(function() {
            $.mask.definitions['~'] = "[+-]";
            $("#create_eleveur_cin").mask("99-99-99-9999-99-99999");
            $("#create_eleveur_nif").mask("999-999-999-9");
            $("#cin2").mask("99-99-99-9999-99-99999");
            $("#create_eleveur_nif2").mask("999-999-999-9");
	  
            $("#create_eleveur_phone").mask("9999-9999");
            $("#create_eleveur_fiche").mask("9999999");
	  
            $("input").blur(function() {
                $("#info").html("Unmasked value: " + $(this).mask());
            }).dblclick(function() {
                $(this).unmask();
            });
        });
        
        $('#create_eleveur_department_1').change(function(){
            var dept = $('#create_eleveur_department_1').val();         
            var  cities = [];
            
            if(typeof dept != 'undefined'){
                
                for(var j =0 ; j<departments.length;j++ )
                {
                    if(departments[j].id == dept)
                    {
                        cities = departments[j].cities;
                        break;
                    }
                }
                if(cities.length != 0)
                {
                    //console.log(dept);
                    //console.log(cities);
                    // clear the select
                    $("#create_eleveur_city").empty();
                    var option = $('<option></option>').attr({
                        value : null
                    })
                    .text('Chwazi komin...');
                        
                    //add the option to the select
                    $("#create_eleveur_city").append(option);
                    for(var i = 0; i<cities.length; i++){
                        var value = cities[i].id;
                        var text = cities[i].name;
                        // create an option with attributes 
                        var option = $('<option></option>').attr({
                            value : value
                        })
                        .text(text);
                        
                        //add the option to the select
                        $("#create_eleveur_city").append(option);
                    }
                }
            }
        });
        
        $('#create_eleveur_city').change(function(){
            var city_id = $('#create_eleveur_city').val();
            var dept = $('#create_eleveur_department_1').val();
            if(typeof city_id != 'undefined' && typeof dept != 'undefined')
            {
                var cities = [];
                var sections = [];
                for(var j =0 ; j<departments.length;j++ )
                {
                    if(departments[j].id == dept)
                    {
                        cities = departments[j].cities;
                        break;
                    }
                }
                if(cities.length != 0)
                {
                    for(var k =0 ; k<cities.length;k++ )
                    {
                        if(cities[k].id == city_id)
                        {
                            sections = cities[k].sections;
                            break;
                        }
                    }
                }
                if (sections.length != 0)
                {
                    //console.log(dept);
                    //console.log(cities);
                    // clear the select
                    $("#create_eleveur_cSection").empty();
                    for(var i = 0; i<sections.length; i++)
                    {
                        var value = sections[i].id;
                        var text = sections[i].name;
                        // create an option with attributes 
                        var option = $('<option></option>').attr({
                            value : value
                        })
                        .text(text);
                        
                        //add the option to the select
                        $("#create_eleveur_cSection").append(option);
                    }
                }
            }
        });
    });
</script>

@include('templates.footer')
@endsection
