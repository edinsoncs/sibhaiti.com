@extends('layouts.common')

@section('content')
@include('templates.headerTop')

@include('templates.header')
@include('agents.tab_top')
<div class="tab-pane <?php echo $active_tab == 'agents_edit' ? 'active' : NULL; ?>" id="tab_agents_edit">
    <form action="" method="post" name="agents_create" class="form-horizontal">
        <div class="user-form">
            <?php
            if (isset($errors))
            {
                foreach ($errors as $error)
                {
                    ?>
                    <div class="text-danger"><?php echo array_get($error, 0); ?></div>
                    <?php
                }
            }
            ?>
            <legend>Enfòmasyon sou moun nan</legend>
			 <p class = "information"><?php echo $user->finduser(array_get($edit_item, 'desc')); ?> kreye ajan saa nan dat kite: 
                
                  <?php echo substr(array_get($edit_item, 'created_at'), 0, strrpos(array_get($edit_item, 'created_at'), ' ')); ?>
                    
                . Denye dat enfòmasyon sou ajan sa a modifye se: 
               
                   
                    
              
                
                    <?php echo substr(array_get($edit_item, 'updated_at'), 0, strrpos(array_get($edit_item, 'updated_at'), ' ')); ?>
                    
                </p>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="edit_agent_lName"><?php echo Lang::get('siyati'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <input name="edit[agent][lName]" id="edit_agent_lName" class="form-control" maxlength="30" type="text" placeholder="<?php echo Lang::get('Nom'); ?>" value="<?php echo array_get($edit_item, 'lName'); ?>">
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label" for="edit_agent_fName"><?php echo Lang::get('non'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <input name="edit[agent][fName]" id="edit_agent_fName" class="form-control" maxlength="30" type="text" placeholder="<?php echo Lang::get('Prenom'); ?>" value="<?php echo array_get($edit_item, 'fName'); ?>">
                    <span class="help-inline"></span>
                </div>
            </div>
			
			<div class="form-group">
                <label class="col-lg-2 control-label" for="edit_agent_phone"><?php echo Lang::get('Telefòn'); ?></label>
                <div class="col-lg-5">
                    <input name="edit[agent][phone]" id="edit_agent_phone" class="form-control" maxlength="9" type="phone" placeholder="<?php echo Lang::get('3634-4098'); ?>" value="<?php echo array_get($edit_item, 'phone'); ?>">
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="edit_agent_phone2"><?php echo Lang::get('Telefòn2'); ?></label>
                <div class="col-lg-5">
                    <input name="edit[agent][phone2]" id="edit_agent_phone2" class="form-control" maxlength="9" type="phone" placeholder="<?php echo Lang::get('3634-0000'); ?>" value="<?php echo array_get($edit_item, 'phone2'); ?>">
                    <span class="help-inline"></span>
                </div>
            </div>
			
			
            <div class="form-group">
                <label class="col-lg-2 control-label" for="edit_agent_sex"><?php echo Lang::get('Sèks'); ?><span class="req">*</span></label>                
                <div class="col-lg-5">
                    <select name="edit[agent][sex]" id="edit_agent_sex" class="form-control" >
                        <option value=""><?php echo Lang::get('---'); ?></option>
                        <option value="m" <?php echo (array_get($edit_item, 'sex') == 'm') ? 'selected="selected"' : NULL; ?>><?php echo Lang::get('Gason'); ?></option>
                        <option value="f" <?php echo (array_get($edit_item, 'sex') == 'f') ? 'selected="selected"' : NULL; ?>><?php echo Lang::get('Fi'); ?></option>                        
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="edit_agent_birthday"><?php echo Lang::get('Dat Nesans'); ?></label>
                <div class="col-lg-5">
                    <input name="edit[agent][birthday]" id="edit_agent_birthday" class="form-control" type="text" value="<?php echo array_get($edit_item, 'birthday'); ?>" maxlength="10" >
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label" for="edit_agent_tipajan"><?php echo Lang::get('tip Ajan'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <select name="edit[agent][type]" id="edit_agent_type" class="form-control" >
                        <option value=""><?php echo Lang::get('---'); ?></option>
                        <option value="ai" <?php echo (array_get($edit_item, 'type') == 'ai') ? 'selected="selected"' : NULL; ?>><?php echo Lang::get('Ajan Idantifikatè Abataj (AIB)'); ?></option>
                        <option value="ev" <?php echo (array_get($edit_item, 'type') == 'ev') ? 'selected="selected"' : NULL; ?>><?php echo Lang::get('Ajan Kontwòl Abataj (AKA)'); ?></option> 
                        <option value="aiev" <?php echo (array_get($edit_item, 'type') == 'aiev') ? 'selected="selected"' : NULL; ?>><?php echo Lang::get('Ajan Alafwa (AIB, AKA)'); ?></option>                        
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>

            <legend>ADRÈS</legend>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="edit_agent_department_1"><?php echo Lang::get('Depatman'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <select name="edit[agent][department]" id="edit_agent_department_1" class="form-control">
                        <option value="">Chwazi depatman...</option>
                        <?php
                        foreach ($departments as $dept)
                        {
                            ?>
                            <option value="<?php echo array_get($dept, 'id'); ?>" <?php echo (array_get($edit_item, 'department') == array_get($dept, 'id')) ? 'selected="selected"' : NULL; ?>><?php echo array_get($dept, 'name'); ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="edit_agent_city"><?php echo Lang::get('Komin'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <select name="edit[agent][city]" id="edit_agent_city" class="form-control" >  
                        <option value="">Chwazi komin...</option>
                        <?php
                        if (array_get($edit_item, 'department'))
                        {
                            $dept = array_get($edit_item, 'department');
                            for ($i = 0; $i < count($departments); $i++)
                            {
                                if ($departments[$i]['id'] == $dept)
                                {
                                    $cities = $departments[$i]['cities'];
                                    break;
                                }
                            }
                            if (isset($cities) && !empty($cities))
                            {
                                foreach ($cities as $city)
                                {
                                    ?>
                                    <option value="<?php echo array_get($city, 'id'); ?>" <?php echo (array_get($edit_item, 'city') == array_get($city, 'id')) ? 'selected="selected"' : NULL; ?>><?php echo array_get($city, 'name'); ?></option>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label" for="edit_agent_cSection"><?php echo Lang::get('Seksyon'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <select name="edit[agent][cSection]" id="edit_agent_cSection" class="form-control" >  
                        <option value="">Seksyon...</option>
                        <?php
                        if (array_get($edit_item, 'department') && array_get($edit_item, 'city') && isset($cities))
                        {
                            foreach ($cities as $city)
                            {
                                if (array_get($edit_item, 'city') == array_get($city, 'id'))
                                {
                                    $sections = array_get($city, 'sections');
                                    break;
                                }
                            }
                            if (isset($sections) && !empty($sections))
                            {
                                foreach ($sections as $section)
                                {
                                    ?>
                                    <option value="<?php echo array_get($section, 'id'); ?>" <?php echo (array_get($edit_item, 'cSection') == array_get($section, 'id')) ? 'selected="selected"' : NULL; ?>><?php echo array_get($section, 'name'); ?></option>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>
            <legend>MATRIKIL YO</legend>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="edit_agent_cin"><?php echo Lang::get('CIN'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <input name="edit[agent][cin]" id="edit_agent_cin" class="form-control" type="text" placeholder="<?php echo "__-__-__-____-__-_____"; ?>" value="<?php echo array_get($edit_item, 'cin'); ?>"  />
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="edit_agent_so"><?php echo Lang::get('#SO'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <input name="edit[agent][so]" style="text-transform:uppercase;" id="edit_agent_so" class="form-control"  maxlength="8" type="text" placeholder="<?php echo Lang::get('HTI-9806'); ?>" value="<?php echo array_get($edit_item, 'so'); ?>"  />
                    <span class="help-inline"></span>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <a href="{{URL::route('agents')}}"class="btn btn-danger">Sòti</a>
                   <?php
                    if ($user->role != 'user')
                    {
                        ?>
                    <button type="submit" class="btn btn-primary" name="edit[submit]"><?php echo Lang::get('Modifye Ajan'); ?></button>
                   <?php
                      }
                   ?>
                </div>
            </div>
        </div>
    </form>
	
	
</div>

<script type="text/javascript">   
    var departments = <?php echo (!empty($departments)) ? json_encode($departments) : "{}"; ?>; 
    $(document).ready(function(){
        $(function() {
            $.mask.definitions['~'] = "[+-]";
            $("#edit_agent_cin").mask("99-99-99-9999-99-99999");
            $("#edit_agent_birthday").mask("99/99/9999");
            $("#edit_agent_phone").mask("9999-9999");
			$("#edit_agent_phone2").mask("9999-9999");
            $("input").blur(function() {
                $("#info").html("Unmasked value: " + $(this).mask());
            }).dblclick(function() {
                $(this).unmask();
            });
        });
        
        $('#edit_agent_department_1').change(function(){
            var dept = $('#edit_agent_department_1').val();         
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
                    $("#edit_agent_city").empty();
                    var option = $('<option></option>').attr({
                        value : null
                    })
                    .text('Chwazi komin...');
                        
                    //add the option to the select
                    $("#edit_agent_city").append(option);
                    for(var i = 0; i<cities.length; i++){
                        var value = cities[i].id;
                        var text = cities[i].name;
                        // create an option with attributes 
                        var option = $('<option></option>').attr({
                            value : value
                        })
                        .text(text);
                        
                        //add the option to the select
                        $("#edit_agent_city").append(option);
                    }
                }
            }
        });
        
        $('#edit_agent_city').change(function(){
            var city_id = $('#edit_agent_city').val();
            var dept = $('#edit_agent_department_1').val();
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
                    $("#edit_agent_cSection").empty();
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
                        $("#edit_agent_cSection").append(option);
                    }
                }
            }
        });
    });
</script>
@include('templates.footer')

@endsection