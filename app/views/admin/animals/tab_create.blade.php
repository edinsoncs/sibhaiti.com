@extends('admin.layouts.common')

@section('content')
@include('templates.headerTop')

@include('admin.templates.header')
@include('admin.animals.tab_top')
<div class="tab-pane <?php echo $active_tab == 'animals_create' ? 'active' : NULL; ?>" id="tab_animals_create">
    <form action="" method="post" name="animals_create" class="form-horizontal">
        <div class="user-form">
            <?php
            if (isset($errors)) {
                foreach ($errors as $error) {
                    ?>
                    <div class="text-danger"><?php echo array_get($error, 0); ?></div>
                    <?php
                }
            }
            ?>
            <legend>enfomasyon sou bèf la</legend>
            <h4>Silvouplè, ranpli tout chan ki gen<span class="req">*</span></h4>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_animal_country"></label>
                <div class="col-lg-5">
                    <div class="radio">
                        <label>
                            <input type="radio" name="create[animal][country]" id="create_animal_country_0" value="<?php echo FALSE; ?>" checked>
                            vach  ayisyèn
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="create[animal][country]" id="create_animal_country_1" value="<?php echo TRUE; ?>">
                            vach dominikèn
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_animal_tag"><?php echo Lang::get('#Fich'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <input name="create[animal][fiche]" id="create_animal_fiche" maxlength="7" class="form-control" type="text" placeholder="<?php echo Lang::get('1234567'); ?>">
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_animal_carnet"><?php echo Lang::get('#Kanè'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <input name="create[animal][carnet]" id="create_animal_cin"  class="form-control" type="text" 
                           placeholder="<?php echo "1234567890"; ?> ">
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_animal_tag"><?php echo Lang::get('#Zanno'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <input name="create[animal][tag]" id="create_animal_nif"  class="form-control" type="text" 
                           placeholder="<?php echo "1234567890"; ?> ">
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_animal_type"><?php echo Lang::get('Sèks'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <select name="create[animal][type]" id="create_animal_type" class="form-control" >
                        <option value=""><?php echo Lang::get('---'); ?></option>
                        <option value="m"><?php echo Lang::get('Mal'); ?></option>
                        <option value="f"><?php echo Lang::get('Femèl'); ?></option>
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_animal_birthday"><?php echo Lang::get('Dat nesans'); ?></label>
                <div class="col-lg-5">
                    <input name="create[animal][birthday]" id="create_animal_birthday" maxlength="8" 
                           class="form-control" type="text" placeholder="<?php echo "01/01/1804"; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_animal_mTag"><?php echo Lang::get('#Zanno Manman'); ?></label>
                <div class="col-lg-5">
                    <input name="create[animal][mTag]" id="create_animal_mTag"  class="form-control" type="text" 
                           placeholder="<?php echo "1234567890"; ?> ">
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_animal_fTag"><?php echo Lang::get('#Zanno Papa'); ?></label>
                <div class="col-lg-5">
                    <input name="create[animal][fTag]" id="create_animal_fTag" class="form-control"  type="text" 
                           placeholder="<?php echo "1234567890"; ?> ">
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_animal_isVaccinated"><?php echo Lang::get('Vaksinen?'); ?></label>
                <div class="col-lg-5">
                    <select name="create[animal][isVaccinated]" id="create_animal_isVaccinated" class="form-control">
                        <option value=""><?php echo Lang::get('---'); ?></option>
                        <option value="o"><?php echo Lang::get('Wi'); ?></option>
                        <option value="n"><?php echo Lang::get('Non'); ?></option>                        
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_animal_eleveur"><?php echo Lang::get('Elvè'); ?></label>
                <div class="col-lg-5">
                    <select name="create[animal][eleveur]" id="create_animal_eleveur" class="form-control" >
                        <?php
                        if (isset($eleveurs)) {
                            foreach ($eleveurs as $eleveur) {
                                ?>
                                <option value="<?php echo $eleveur->id; ?>"><?php echo $eleveur->getFullNameAttribute(), " (", $eleveur->idEleveur, ")"; ?></option>
                                <?php
                            }
                        }
                        ?>                   
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>
            <legend>ADRÈS</legend>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_animal_department_1"><?php echo Lang::get('Depatman'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <select name="create[animal][department]" id="create_animal_department_1" class="form-control">
                        <option value="">Chwazi depatman...</option>
                        <?php
                        foreach ($departments as $dept) {
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
                <label class="col-lg-2 control-label" for="create_animal_city"><?php echo Lang::get('Komin'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <select name="create[animal][city]" id="create_animal_city" class="form-control" >  
                        <option value="">Chwazi komin...</option>
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_animal_cSection"><?php echo Lang::get('Seksyon'); ?></label>
                <div class="col-lg-5">
                    <select name="create[animal][cSection]" id="create_animal_cSection" class="form-control" >  
                        <option value="">Seksyon...</option>
                    </select>
                    <?php /*
                      <input name="create[animal][cSection]" id="create_animal_cSection" maxlength="20" class="form-control" type="text" placeholder="<?php echo Lang::get('Seksyon'); ?>">
                     */ ?>
                    <span class="help-inline"></span>

                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_animal_so"><?php echo Lang::get('#So'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <select name="create[animal][so]" id="create_animal_so" class="form-control">
                        <option>Select</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="create_animal_idant"><?php echo Lang::get('Dat idantifikasyon an fet'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <input name="create[animal][datIdant]" id="create_animal_idant" maxlength="8" class="form-control" type="text" 
                           placeholder="<?php echo "01/01/1804"; ?>">
                </div>
            </div>
            <legend>verifikasyon MATRIKIL YO</legend>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="cin2"><?php echo Lang::get('#Kanè'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <input id="cin2" class="form-control" type="text" 
                           placeholder="<?php echo "1234567890"; ?> ">
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="nif2"><?php echo Lang::get('#Zanno'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <input id="create_animal_nif2" class="form-control" type="text" 
                           placeholder="<?php echo "1234567890"; ?> ">
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <a href="{{URL::route('adminanimals')}}"class="btn btn-danger">Anile</a>
                    <button type="submit" class="btn btn-primary" name="create[submit]" onClick="return verifierPostEl();" ><?php echo Lang::get('Anrejistre Bèf'); ?></button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- eo list tab -->


<script type="text/javascript">
    var departments = <?php echo (!empty($departments)) ? json_encode($departments) : "{}"; ?>;
    $(document).ready(function () {
        $(function () {
            $.mask.definitions['~'] = "[+-]";
            $("#create_animal_cin").mask("9999999999");
            $("#cin2").mask("9999999999");
            $("#create_animal_nif").mask("9999999999");
            $("#create_animal_nif2").mask("9999999999");
            $("#create_animal_birthday").mask("99/99/9999");
            $("#create_animal_idant").mask("99/99/9999");

            $("#create_animal_fTag").mask("9999999999");
            $("#create_animal_mTag").mask("9999999999");
            $("#create_animal_tag").mask("9999999999");
            $("#create_animal_fiche").mask("9999999");

            $("input").blur(function () {
                $("#info").html("Unmasked value: " + $(this).mask());
            }
            ).dblclick(function () {
                $(this).unmask();
            });
        });

        $('#create_animal_department_1').change(function () {
            var dept = $('#create_animal_department_1').val();
            var cities = [];

            if (typeof dept != 'undefined') {

                for (var j = 0; j < departments.length; j++)
                {
                    if (departments[j].id == dept)
                    {
                        cities = departments[j].cities;
                        break;
                    }
                }
                if (cities.length != 0)
                {
                    //console.log(dept);
                    //console.log(cities);
                    // clear the select
                    $("#create_animal_city").empty();
                    var option = $('<option></option>').attr({
                        value: null
                    })
                            .text('Chwazi komin...');

                    //add the option to the select
                    $("#create_animal_city").append(option);
                    for (var i = 0; i < cities.length; i++) {
                        var value = cities[i].id;
                        var text = cities[i].name;
                        // create an option with attributes 
                        var option = $('<option></option>').attr({
                            value: value
                        })
                                .text(text);

                        //add the option to the select
                        $("#create_animal_city").append(option);
                    }
                }
            }
        });

        $('#create_animal_city').change(function () {
            var city_id = $('#create_animal_city').val();
            var dept = $('#create_animal_department_1').val();
            if (typeof city_id != 'undefined' && typeof dept != 'undefined')
            {
                var cities = [];
                var sections = [];
                for (var j = 0; j < departments.length; j++)
                {
                    if (departments[j].id == dept)
                    {
                        cities = departments[j].cities;
                        break;
                    }
                }
                if (cities.length != 0)
                {
                    for (var k = 0; k < cities.length; k++)
                    {
                        if (cities[k].id == city_id)
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
                    $("#create_animal_cSection").empty();
                    for (var i = 0; i < sections.length; i++)
                    {
                        var value = sections[i].id;
                        var text = sections[i].name;
                        // create an option with attributes 
                        var option = $('<option></option>').attr({
                            value: value
                        })
                                .text(text);

                        //add the option to the select
                        $("#create_animal_cSection").append(option);
                    }
                }
            }
            var data = {department: dept, city: city_id};
            $.ajax({
                'url': '<?php echo URL::route('adminagentdepartment'); ?>',
                'type': 'POST',
                'data': data,
                'success': function (data) {
                    var agents = data.data;
                    //console.log(agents);
                    $("#create_animal_so").empty();
                    var option = $('<option></option>').attr({
                        value: null
                    })
                            .text('Select');
                    $("#create_animal_so").append(option);
                    for (var i = 0; i < agents.length; i++) {
                        var value = agents[i].id;
                        var text = agents[i].so;
                        // create an option with attributes 
                        option = $('<option></option>').attr({
                            value: value
                        })
                                .text(text);

                        //add the option to the select
                        $("#create_animal_so").append(option);
                    }
                }
            });
        });
    });
</script>

@include('templates.footer')


@endsection
