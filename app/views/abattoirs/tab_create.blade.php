@extends('layouts.common')

@section('content')
@include('templates.headerTop')


@include('templates.header')
@include('abattoirs.tab_top')

<div class="tab-pane <?php echo $active_tab == 'abattoirs_create' ? 'active' : NULL; ?>" id="tab_abattoirs_create">
    <form action="" method="post" name="abattoirs_create" class="form-horizontal">
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
            <legend>ENFÒMASYON AK ADRÈS PWEN ABATAJ LA</legend>
            <h4>Silvouplè, ranpli tout chan ki gen <span class="req">*</span></h4>
			<div class="form-group">
                <label class="col-lg-3 control-label" for="create_abattoir_name">non pwen abataj la<span class="req">*</span></label>
                <div class="col-lg-5">
                    <input name="create[abattoir][name]" id="create_abattoir_name" class="form-control" type="text" placeholder="pwen abataj la">
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label" for="create_abattoir_type"><?php echo Lang::get('Tip'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <select name="create[abattoir][type]" id="create_abattoir_type" class="form-control" >
                        <option value="public">Piblik (Nan yon mache)</option>
						<option value="public-isole">Piblik (Izole)</option>
                         <option value="prive">Prive</option>
                        <option value="ong">Ong</option>   
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label" for="create_abattoir_department_1"><?php echo Lang::get('Depatman'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <select name="create[abattoir][department]" id="create_abattoir_department_1" class="form-control">
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
                <label class="col-lg-3 control-label" for="create_abattoir_city"><?php echo Lang::get('Komin'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <select name="create[abattoir][city]" id="create_abattoir_city" class="form-control" >  
                        <option value="">Chwazi komin...</option>
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label" for="create_abattoir_cSection"><?php echo Lang::get('Seksyon'); ?><span class="req">*</span></label>
                <div class="col-lg-5">
                    <select name="create[abattoir][cSection]" id="create_abattoir_cSection" class="form-control" >  
                        <option value="">Seksyon...</option>
                    </select>
                    <span class="help-inline"></span>

                </div>
            </div>
			<div class="form-group">
                <label class="col-lg-3 control-label" for="create_abattoir_owner">Responsab</label>
                <div class="col-lg-5">
                    <input name="create[abattoir][owner]" id="create_abattoir_owner" class="form-control" type="text" placeholder="Ekri 'NA' si pa gen responsab">
                 <span class="help-inline"></span>
				 </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label" for="create_abattoir_phone"><?php echo Lang::get('Telefòn'); ?></label>
                <div class="col-lg-5">
                    <input name="create[abattoir][phone]" id="create_abattoir_phone" class="form-control" maxlength="9" type="phone" placeholder="<?php echo Lang::get('3634-4098'); ?>">
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label" for="create_abattoir_description">Remak</label>
                <div class="col-lg-5">
                    <textarea name="create[abattoir][description]" id="create_abattoir_description" rows="4" class="form-control" placeholder="Remak"></textarea>
                </div>
            </div>
			
            

            <legend>ESTIMASYON ABATAJ CHAK SEMÈN</legend>
            

            <div class="form-group">
                <label class="col-lg-3 control-label" for="create_abattoir_bef">bèf</label>
                <div class="col-lg-5">
                    <input name="create[abattoir][bef]" id="create_abattoir_bef" class="form-control" type="text" placeholder="000" >
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label" for="create_abattoir_kabri">kabrit</label>
                <div class="col-lg-5">
                    <input name="create[abattoir][kabri]" id="create_abattoir_kabri" class="form-control" type="text" placeholder="000"  >
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label" for="create_abattoir_mouton">mouton</label>
                <div class="col-lg-5">
                    <input name="create[abattoir][mouton]" id="create_abattoir_mouton" class="form-control" type="text" placeholder="000"  >
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label" for="create_abattoir_kochon">kochon</label>
                <div class="col-lg-5">
                    <input name="create[abattoir][kochon]" id="create_abattoir_kochon" class="form-control" type="text" placeholder="000"  >
                    <span class="help-inline"></span>
                </div>
            </div>
			<legend>#SO AJAN KI KONTWOLE ABATAJ NAN LABATWA SA A</legend>
            <div class="form-group">
                <label class="col-lg-3 control-label" for="create_abattoir_agent1">Ajan 1 </label>
                <div class="col-lg-5">
                    <select name="create[abattoir][agent1]" id="create_abattoir_agent1" class="form-control create_abattoir_agents" >
                        <option value="">Chwazi yon #So</option>
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label" for="create_abattoir_agent2">Ajan 2 </label>
                <div class="col-lg-5">
                    <select name="create[abattoir][agent2]" id="create_abattoir_agent2" class="form-control create_abattoir_agents" >
                        <option value="">Chwazi yon #So</option>
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label" for="create_abattoir_agent3">Ajan 3 </label>
                <div class="col-lg-5">
                    <select name="create[abattoir][agent3]" id="create_abattoir_agent3" class="form-control create_abattoir_agents" >
                       <option value="">Chwazi yon #So</option>
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label" for="create_abattoir_agent4">Ajan 4</label>
                <div class="col-lg-5">
                    <select name="create[abattoir][agent4]" id="create_abattoir_agent4" class="form-control create_abattoir_agents" >
                       <option value="">Chwazi yon #So</option>
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg-3 control-label" for="create_abattoir_agent5">Ajan 5 </label>
                <div class="col-lg-5">
                    <select name="create[abattoir][agent5]" id="create_abattoir_agent5" class="form-control create_abattoir_agents" >
                         <option value="">Chwazi yon #So</option>
                    </select>
                    <span class="help-inline"></span>
                </div>
            </div>

            

            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <a href="{{URL::route('abbatages')}}"class="btn btn-danger">Sòti</a>
                    <button type="submit" class="btn btn-primary" name="create[submit]" onClick="return verifierPost();"><?php echo Lang::get('Anrejistre Abatwa'); ?></button>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- eo list tab -->
<script type="text/javascript">
    var departments = <?php echo (!empty($departments)) ? json_encode($departments) : "{}"; ?>;
    $(document).ready(function() {
        $(function() {
            $.mask.definitions['~'] = "[+-]";

            $("#create_abattoir_phone").mask("9999-9999");
			$("#create_abattoir_bef").mask("999");
			$("#create_abattoir_kabri").mask("999");
			$("#create_abattoir_mouton").mask("999");
			$("#create_abattoir_kochon").mask("999");

            $("input").blur(function() {
                $("#info").html("Unmasked value: " + $(this).mask());
            }).dblclick(function() {
                $(this).unmask();
            });
        });

        $('#create_abattoir_department_1').change(function() {
            var dept = $('#create_abattoir_department_1').val();
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
                    $("#create_abattoir_city").empty();
                    var option = $('<option></option>').attr({
                        value: null
                    })
                            .text('Chwazi komin...');

                    //add the option to the select
                    $("#create_abattoir_city").append(option);
                    for (var i = 0; i < cities.length; i++) {
                        var value = cities[i].id;
                        var text = cities[i].name;
                        // create an option with attributes 
                        var option = $('<option></option>').attr({
                            value: value
                        })
                                .text(text);

                        //add the option to the select
                        $("#create_abattoir_city").append(option);
                    }
                }


                var data = {department: dept};
                $.ajax({
                    'url': '<?php echo URL::route('adminagentdepartment'); ?>',
                    'type': 'POST',
                    'data': data,
                    'success': function(data) {
                        var agents = data.data;
                        $(".create_abattoir_agents").empty();
                        var option = $('<option></option>').attr({
                            value: null
                        })
                                .text('...');
                        $(".create_abattoir_agents").append(option);
                        for (var i = 0; i < agents.length; i++) {
                            var value = agents[i].id;
                            var text = agents[i].so;
                            // create an option with attributes 
                            option = $('<option></option>').attr({
                                value: value
                            })
                                    .text(text);

                            //add the option to the select
                            $(".create_abattoir_agents").append(option);
                        }
                    }
                });
            }
        });

        $('#create_abattoir_city').change(function() {
            var city_id = $('#create_abattoir_city').val();
            var dept = $('#create_abattoir_department_1').val();
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
                        if (cities[k].id == city_id) {
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
                    $("#create_abattoir_cSection").empty();
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
                        $("#create_abattoir_cSection").append(option);
                    }
                }
            }
        });
    });
</script> 
@include('templates.footer')

@endsection

