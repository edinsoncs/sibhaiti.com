@extends('layouts.common')
@section('content')
@include('templates.headerTop')

@include('templates.header')
@include('animals.tab_top')
<div class="container">
    <h4>METE YON REMAK SOU BEF SA A</h4>
    <form action="" method="post" name="notification_create" id="notification_create" class="form-horizontal">
        <div class="user-form" style="padding-top: 20px">
            <div class="row">
                <div id="errors" class="col-md-offset-3 col-md-6">
                    <?php
                    if (!empty($errors)) {
                        foreach ($errors as $error) {
                            ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php
                        }
                    }
                    if (!empty($success)) {
                        foreach ($success as $succes) {
                            ?>
                            <div class="alert alert-success"><?php echo $succes; ?></div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div id="notification-selector">
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-tag">#Zanno</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="notification[tag]" id="notification-tag" 
                               placeholder="1234567890" value="<?php echo (array_get($form_data, 'tag')) ? array_get($form_data, 'tag') : NULL; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-type">Tip Remak</label>
                    <div class="col-md-6">
                        <select class="form-control" name="notification[type]" id="notification-type">
                            <option value=""><?php echo 'Tip Remak laa...'; ?></option>
                            <option value="c"><?php echo 'Vaksinasyon Chabon'; ?></option>					
                            <option value="a"><?php echo 'Abataj nan labatwa'; ?></option>
                            <option value="t"><?php echo 'Chanjman Mèt'; ?></option>
                            <option value="ks"><?php echo 'Chanjman kanè a sèlman'; ?></option>
							<option value="k"><?php echo 'Ranplasman Kanè ak zanno'; ?></option>

                        </select>
                        <span class="help-inline"></span>
                    </div>
                    <div class="col-md-2"><button type="button" class="btn btn-primary" id="btn-validate"><span class="glyphicon glyphicon-ok"></button></div>
                </div>
            </div>
            
            <div id="abbatoire" class="select-type" hidden>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-department-1">Depatman</label>
                    <div class="col-lg-6">
                        <select name="notification[department]" id="notification-department-1" class="form-control">
                            <option value="">Chwazi depatman...</option>
                            <?php
//$obj = Abattoir::find(array_get($edit_item, 'id'));
                            foreach ($departments as $dept) {
                                ?>
                                <option value="<?php echo array_get($dept, 'id'); ?>" <?php echo ( $animal && $animal->department == array_get($dept, 'id')) ? 'selected="selected"' : NULL; ?>><?php echo array_get($dept, 'name'); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-city">Komin</label>
                    <div class="col-lg-6">
                        <select name="notification[city]" id="notification-city" class="form-control" >
                            <option value="">Tout Komin yo</option>
                        </select>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-day">Dat</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="notification[day]" id="notification-day" placeholder="JJ/MM/AAAA" value="<?php echo array_get($form_data, 'day'); ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-abbatoire">Abatwa</label>
                    <div class="col-lg-6">
                        <select class="form-control" name="notification[abbatoire]" id="notification-abbatoire">
                            <option value="">Abatwa</option>
                            <?php
                            if (isset($abattoirs)) {
                                foreach ($abattoirs as $abat) {
                                    ?>
                                    <option value="<?php echo $abat->id; ?>"><?php echo $abat->name; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification_so">#SO</label>
                    <div class="col-lg-6">
                        <select name="notification[so]" id="notification_so" class="form-control" >
                            <option value="">#SO</option>
                            <?php
                            if (isset($agents)) {
                                foreach ($agents as $agent) {
                                    ?>
                                    <option value="<?php echo $agent->so; ?>"><?php echo $agent->so; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div id="chabon" class="select-type" hidden>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-dayc">Date</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="notification[dayc]" id="notification-dayc" placeholder="JJ/MM/AAAA" value="<?php echo array_get($form_data, 'dayc'); ?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-departmentc">Depatman</label>
                    <div class="col-lg-6">
                        <select name="notification[departmentc]" id="notification-departmentc" class="form-control">
                            <option value="">Chwazi depatman...</option>
                            <?php
//$obj = Abattoir::find(array_get($edit_item, 'id'));
                            foreach ($departments as $dept) {
                                ?>
                                <option value="<?php echo array_get($dept, 'id'); ?>" <?php echo ($animal && $animal->department == array_get($dept, 'id')) ? 'selected="selected"' : NULL; ?>><?php echo array_get($dept, 'name'); ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-cityc">Komin</label>
                    <div class="col-lg-6">
                        <select name="notification[cityc]" id="notification-cityc" class="form-control" >
                            <option value="">Tout Komin yo</option>
                        </select>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification_soc">#SO</label>
                    <div class="col-lg-6">
                        <select name="notification[soc]" id="notification_soc" class="form-control" >
                            <option value="">#SO</option>
                            <?php
                            if (isset($agents)) {
                                foreach ($agents as $agent) {
                                    ?>
                                    <option value="<?php echo $agent->so; ?>"><?php echo $agent->so; ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div id="met" class="select-type" hidden>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-old_cin">#Cin ansyen elvè</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="notification[old_cin]" id="notification-old_cin" 
                               placeholder="99-88-33-2222-11-00000" value="<?php echo (array_get($form_data, 'old_cin')) ? array_get($form_data, 'old_cin') : NULL; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-new_cin">#Cin nouvo Elvè</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="notification[new_cin]" id="notification-new_cin" 
                               placeholder="99-88-33-2222-11-00000" value="<?php echo (array_get($form_data, 'new_cin')) ? array_get($form_data, 'new_cin') : NULL; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-kane">#Kanè</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="notification[kane]" id="notification-kane" 
                               placeholder="0123456789" value="<?php echo (array_get($form_data, 'kane')) ? array_get($form_data, 'kane') : NULL; ?>" />
                    </div>
                </div>
            </div>

            <div id="kane" class="select-type" hidden>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="cin_eleveur">#Cin elvè</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="notification[cin_eleveur]" id="notification-cin_eleveur" 
                               placeholder="99-88-33-2222-11-00000" value="<?php echo (array_get($form_data, 'cin_eleveur')) ? array_get($form_data, 'cin_eleveur') : NULL; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-old_tag">#ansyen Zanno</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="notification[old_tag]" id="notification-old_tag" 
                               placeholder="0123456789" value="<?php echo (array_get($form_data, 'old_tag')) ? array_get($form_data, 'old_tag') : NULL; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-new_tag">#Nouvo Zanno</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="notification[new_tag]" id="notification-new_tag" 
                               placeholder="0123456789" value="<?php echo (array_get($form_data, 'new_tag')) ? array_get($form_data, 'new_tag') : NULL; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-old_kane">#ansyen Kanè</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="notification[old_kane]" id="notification-old_kane" 
                               placeholder="0123456789" value="<?php echo (array_get($form_data, 'old_kane')) ? array_get($form_data, 'old_kane') : NULL; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-new_kane">#Nouvo Kanè</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="notification[new_kane]" id="notification-new_kane" 
                               placeholder="0123456789" value="<?php echo (array_get($form_data, 'new_kane')) ? array_get($form_data, 'new_kane') : NULL; ?>"/>
                    </div>
                </div>
            </div>
            
            <div id="kane-selman" class="select-type" hidden>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="cin-eleveur-ks">#Cin elvè</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="notification[cin_eleveur_ks]" id="cin-eleveur-ks" 
                               placeholder="99-88-33-2222-11-00000" value="<?php echo (array_get($form_data, 'cin_eleveur_ks')) ? array_get($form_data, 'cin_eleveur_ks') : NULL; ?>" />
                    </div>
                </div>
                <?php /*
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-old_tag-ks">#ansyen Tag</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="notification[old_tag_ks]" id="notification-old_tag-ks" 
                               placeholder="0123456789" value="<?php echo (array_get($form_data, 'old_tag')) ? array_get($form_data, 'old_tag') : NULL; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-new_tag-ks">#Nouvo Tag</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="notification[new_tag_ks]" id="notification-new_tag-ks" 
                               placeholder="0123456789" value="<?php echo (array_get($form_data, 'new_tag_ks')) ? array_get($form_data, 'new_tag_ks') : NULL; ?>" />
                    </div>
                </div>
                */ ?>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-old_kane-ks">#ansyen Kanè</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="notification[old_kane_ks]" id="notification-old_kane-ks" 
                               placeholder="0123456789" value="<?php echo (array_get($form_data, 'old_kane_ks')) ? array_get($form_data, 'old_kane_ks') : NULL; ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-new_kane-ks">#Nouvo Kanè</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="notification[new_kane_ks]" id="notification-new_kane-ks" 
                               placeholder="0123456789" value="<?php echo (array_get($form_data, 'new_kane_ks')) ? array_get($form_data, 'new_kane_ks') : NULL; ?>"/>
                    </div>
                </div>
            </div>
            
            <div id="create-notification-div" hidden>
                <div class="form-group">
                    <label class="col-lg-3 control-label" for="notification-confirmation-tag">konfime ansyen #Zanno</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="notification[confirmation-tag]" id="notification-confirmation-tag" placeholder="1234567890" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-3 col-md-6" >
                        <a href="{{URL::route('animals')}}" class="btn btn-danger">Sòti</a>
                        <button type="button" id="create-notification" class="btn btn-primary">Anrejistre</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript">

    var departments = <?php echo (!empty($departments)) ? json_encode($departments) : "{}"; ?>;
    $(document).ready(function () {
        $(function () {
            $.mask.definitions['~'] = "[+-]";
            $("#notification-tag").mask("9999999999");
            $("#notification-confirmation-tag").mask("9999999999");

            $("#notification-old_tag").mask("9999999999");
            $("#notification-new_tag").mask("9999999999");
            $("#notification-kane").mask("9999999999");
            $("#notification-old_kane").mask("9999999999");
            $("#notification-new_kane").mask("9999999999");

			$("#cin-eleveur-ks").mask("99-99-99-9999-99-99999");
			$("#notification-old_kane-ks").mask("9999999999");
			$("#notification-new_kane-ks").mask("9999999999"); 
            $("#notification-day").mask("99/99/9999");
            $("#notification-dayc").mask("99/99/9999");
            $("#notification-old_cin").mask("99-99-99-9999-99-99999");
            $("#notification-new_cin").mask("99-99-99-9999-99-99999");
            $("#notification-cin_eleveur").mask("99-99-99-9999-99-99999");

            $("input").blur(function () {
                $("#info").html("Unmasked value: " + $(this).mask());
            }
            ).dblclick(function () {
                $(this).unmask();
            });
        });

        $('#notification-department-1').change(function () {
            var dept = $('#notification-department-1').val();
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
                    $("#notification-city").empty();
                    var option = $('<option>Select</option>').attr({
                        value: null
                    })
                            .text('Chwazi komin...');
                    //add the option to the select
                    $("#notification-city").append(option);
                    for (var i = 0; i < cities.length; i++) {
                        var value = cities[i].id;
                        var text = cities[i].name; // create an option with attributes 
                        var option = $('<option></option>').attr({
                            value: value
                        })
                                .text(text);
                        //add the option to the select
                        $("#notification-city").append(option);
                    }
                }

                var data = {department: dept};
                $.ajax({
                    'url': '<?php echo URL::route('abbatoirdepartment'); ?>',
                    'type': 'POST',
                    'data': data,
                    'success': function (data) {
                        var abbatoirs = data;
                        //console.log(abbatoirs);
                        $("#notification-abbatoire").empty();
                        var option = $('<option></option>').attr({
                            value: null
                        })
                                .text('Non Abatwa a');
                        $("#notification-abbatoire").append(option);
                        for (var i = 0; i < abbatoirs.length; i++) {
                            if (abbatoirs[i].desc == dept)
                            {
                                var value = abbatoirs[i].id;
                                var text = abbatoirs[i].name;
                                // create an option with attributes 
                                option = $('<option></option>').attr({
                                    value: value
                                })
                                        .text(text);
                                //add the option to the select
                                $("#notification-abbatoire").append(option);
                            }
                        }
                    }
                });
            }
        });

        $('#notification-departmentc').change(function () {
            var dept = $('#notification-departmentc').val();
            
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
                    $("#notification-cityc").empty();
                    var option = $('<option>Select</option>').attr({
                        value: null
                    })
                            .text('Chwazi komin...');
                    //add the option to the select
                    $("#notification-cityc").append(option);
                    for (var i = 0; i < cities.length; i++) {
                        var value = cities[i].id;
                        var text = cities[i].name; // create an option with attributes 
                        var option = $('<option></option>').attr({
                            value: value
                        })
                                .text(text);
                        //add the option to the select
                        $("#notification-cityc").append(option);
                    }
                }

            }
        });

        $('#notification-cityc').change(function () {
            var city_id = $('#notification-cityc').val();
            var dept = $('#notification-departmentc').val();

            var data = {department: dept, city: city_id};
            $.ajax({
                'url': '<?php echo URL::route('adminagentdepartment'); ?>',
                'type': 'POST',
                'data': data,
                'success': function (data) {
                    var agents = data.data;
                    $("#notification_soc").empty();
                    var option = $('<option></option>').attr({
                        value: null
                    })
                            .text('#SO');
                    $("#notification_soc").append(option);
                    for (var i = 0; i < agents.length; i++) {
                        var value = agents[i].so;
                        var text = agents[i].so;
                        // create an option with attributes 
                        option = $('<option></option>').attr({
                            value: value
                        })
                                .text(text);
                        //add the option to the select
                        $("#notification_soc").append(option);
                    }
                }
            });
        });

        $('#notification-city').change(function () {
            var city_id = $('#notification-city').val();
            var dept = $('#notification-department-1').val();
            if (typeof city_id != 'undefined' && typeof dept != 'undefined') {
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
                    $("#notification-cSection").empty();
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
                        $("#notification-cSection").append(option);
                    }
                }

                var data = {department: dept, city: city_id};
                $.ajax({
                    'url': '<?php echo URL::route('adminagentdepartment'); ?>',
                    'type': 'POST',
                    'data': data,
                    'success': function (data) {
                        var agents = data.data;
                        $("#notification_so").empty();
                        var option = $('<option></option>').attr({
                            value: null
                        })
                                .text('#SO');
                        $("#notification_so").append(option);
                        for (var i = 0; i < agents.length; i++) {
                            var value = agents[i].so;
                            var text = agents[i].so;
                            // create an option with attributes 
                            option = $('<option></option>').attr({
                                value: value
                            })
                                    .text(text);
                            //add the option to the select
                            $("#notification_so").append(option);
                        }
                    }
                });
            }
        });

        $('#btn-validate').click(function () {
            $('#errors').empty();
            var tag = $('#notification-tag').val();
            var type = $('#notification-type').val();

            if (tag && type)
            {
                var data = {tag: tag};
                $.ajax({
                    'url': '<?php echo URL::route('validatetag'); ?>',
                    'type': 'POST',
                    'data': data,
                    'success': function (data) {
                        if (data.status == 'success')
                        {
                            var agents = data.agents;
                            //console.log(agents);
                            $("#notification_soc").empty();
                            var option = $('<option></option>').attr({
                                value: null
                            })
                                    .text('#SO');
                            $("#notification_soc").append(option);
                            for (var i = 0; i < agents.length; i++) {
                                var value = agents[i].so;
                                var text = agents[i].so;
                                // create an option with attributes 
                                option = $('<option></option>').attr({
                                    value: value
                                })
                                        .text(text);
                                //add the option to the select
                                $("#notification_soc").append(option);
                            }

                            $('#errors').append("<div class='alert alert-success'>" + data.msg + "</div>");

                            $('.select-type').fadeOut();
                            if (type == 'a')
                            {
                                $('#abbatoire').fadeIn();
                            } else if (type == 'c')
                            {
                                $('#chabon').fadeIn();
                            } else if (type == 't')
                            {
                                $('#met').fadeIn();
                            } else if (type == 'k')
                            {
                                $('#kane').fadeIn();
                            }
                            else if (type == 'ks')
                            {
                                $('#kane-selman').fadeIn();
                            }

                            $('#notification-selector').fadeOut();
                            $('#create-notification-div').fadeIn();

                        } else
                        {
                            $('#errors').append("<div class='alert alert-danger'>" + data.msg + "</div>");
                        }
                    }
                });
            } else
            {
                $('#errors').append("<div class='alert alert-danger'>Erè! Mete yon #Tag epi Chwazi Tip Remak la.</div>");
            }
        });

        $('#create-notification').click(function () {
            $('#errors').empty();
            var type = $('#notification-type').val();
            var flag = true;
            if (type)
            {
                var tag = $('#notification-tag').val();
                var new_tag = $('#notification-old_tag').val();
                var confirmation_tag = $('#notification-confirmation-tag').val();
                if (type == "k" && tag != new_tag)
                {
                    $('#errors').append("<div class='alert alert-danger'>Erè! #Tag yo pa korespon n.</div>");
                    flag = false;
                }
                if (tag != confirmation_tag)
                {
                    $('#errors').append("<div class='alert alert-danger'>Erè! #Tag yo pa korespon n.</div>");
                    flag = false;
                }
                if (flag)
                {
                    $('#notification_create').submit();
                }
            } else
            {
                alert('SVP Chwazi tip de remak')
            }
        });
    });
</script>
@include('templates.footer')

@endsection