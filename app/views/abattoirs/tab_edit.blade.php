@extends('layouts.common')



@section('content')

@include('templates.headerTop')



@include('templates.header')

@include('abattoirs.tab_top')

<div class="tab-pane <?php echo $active_tab == 'abattoirs_edit' ? 'active' : NULL; ?>" id="tab_abattoirs_edit">

    <form action="" method="post" name="abattoirs_edit" class="form-horizontal">

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

                <label class="col-lg-3 control-label" for="edit_abattoir_name">NOM DU POINT D'ABATTAGE<span class="req">*</span></label>

                <div class="col-lg-5">

                    <input name="edit[abattoir][name]" id="edit_abattoir_name" class="form-control" type="text" placeholder="NOM DU POINT D'ABATTAGE" value="<?php echo array_get($edit_item, 'name'); ?>" />

                    <span class="help-inline"></span>

                </div>

            </div>



            <div class="form-group">

                <label class="col-lg-3 control-label" for="edit_abattoir_type"><?php echo Lang::get('Type'); ?><span class="req">*</span></label>

                <div class="col-lg-5">

                    <select name="edit[abattoir][type]" id="edit_abattoir_type" class="form-control" >

                        
                        
                      <option value="public" <?php echo (array_get($edit_item, 'type') == 'public') ? 'selected="selected"' : NULL; ?>>Piblik (Nan yon mache)</option>  
                      <option value="public-isole" <?php echo (array_get($edit_item, 'type') == 'public-isole') ? 'selected="selected"' : NULL; ?>>Piblik (Izole)</option>

                        <option value="prive" <?php echo (array_get($edit_item, 'type') == 'prive') ? 'selected="selected"' : NULL; ?> >Prive</option>

                        <option value="ong" <?php echo (array_get($edit_item, 'type') == 'ong') ? 'selected="selected"' : NULL; ?>>Ong</option> 

                         

                          

                         

                    </select>

                    <span class="help-inline"></span>

                </div>

            </div>

          

            <div class="form-group">

                <label class="col-lg-3 control-label" for="edit_abattoir_department_1"><?php echo Lang::get('Depatman'); ?><span class="req">*</span></label>

                <div class="col-lg-5">

                    <select name="edit[abattoir][department]" id="edit_abattoir_department_1" class="form-control">

                        <option value="">Chwazi depatman...</option>

                        <?php

                        $obj = Abattoir::find(array_get($edit_item, 'id'));

                        foreach ($departments as $dept)

                        {

                            ?>

                            <option value="<?php echo array_get($dept, 'id'); ?>" <?php echo ($obj->department() == array_get($dept, 'id')) ? 'selected="selected"' : NULL; ?>><?php echo array_get($dept, 'name'); ?></option>

                            <?php

                        }

                        ?>

                    </select>

                    <span class="help-inline"></span>

                </div>

            </div>

            <div class="form-group">

                <label class="col-lg-3 control-label" for="edit_abattoir_city"><?php echo Lang::get('Komin'); ?><span class="req">*</span></label>

                <div class="col-lg-5">

                    <select name="edit[abattoir][city]" id="edit_abattoir_city" class="form-control" >  

                        <option value="">Chwazi komin...</option>

                        <?php

                        $dept = $obj->department();

                        $cit = $obj->city();

                        $cSect = $obj->cSection();

                        if ($dept != "")

                        {

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

                                    <option value="<?php echo array_get($city, 'id'); ?>" <?php echo ($cit == array_get($city, 'id')) ? 'selected="selected"' : NULL; ?>><?php echo array_get($city, 'name'); ?></option>

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

                <label class="col-lg-3 control-label" for="edit_abattoir_cSection"><?php echo Lang::get('Seksyon'); ?></label>

                <div class="col-lg-5">

                    <select name="edit[abattoir][cSection]" id="edit_abattoir_cSection" class="form-control" >  

                        <option value="">Seksyon...</option>

                        <?php

                        if ($dept && $cit && isset($cities))

                        {

                            foreach ($cities as $city)

                            {

                                if ($cit == array_get($city, 'id'))

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

                                    <option value="<?php echo array_get($section, 'id'); ?>" <?php echo ($cSect == array_get($section, 'id')) ? 'selected="selected"' : NULL; ?>><?php echo array_get($section, 'name'); ?></option>

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

                <label class="col-lg-3 control-label" for="edit_abattoir_owner">Responsab<span class="req">*</span></label>

                <div class="col-lg-5">

                    <input name="edit[abattoir][owner]" id="edit_abattoir_owner" class="form-control" type="text" placeholder="Responsab" value="<?php echo array_get($edit_item, 'owner'); ?>" />

                </div>

            </div>
			<div class="form-group">

                <label class="col-lg-3 control-label" for="edit_abattoir_phone"><?php echo Lang::get('Telefòn'); ?></label>

                <div class="col-lg-5">

                    <input name="edit[abattoir][phone]" id="edit_abattoir_phone" class="form-control" maxlength="9" type="phone" placeholder="<?php echo Lang::get('3634-4098'); ?>" value="<?php echo array_get($edit_item, 'phone'); ?>" />

                    <span class="help-inline"></span>

                </div>

            </div>

            <div class="form-group">

                <label class="col-lg-3 control-label" for="edit_abattoir_description">Remak</label>

                <div class="col-lg-5">

                    <textarea name="edit[abattoir][description]" id="edit_abattoir_description" rows="5" class="form-control" placeholder="Remarque"><?php echo array_get($edit_item, 'description'); ?></textarea>

                </div>

            </div>

            

            <legend>ESTIMASYON ABATAJ CHAK SEMÈN</legend>


            <div class="form-group">

                <label class="col-lg-3 control-label" for="edit_abattoir_bef">Bèf</label>

                <div class="col-lg-5">

                    <input name="edit[abattoir][bef]" id="edit_abattoir_bef" class="form-control" type="number" min="1" max="999" placeholder="000" value="<?php echo array_get($edit_item, 'bef'); ?>" maxlength ="3" />

                    <span class="help-inline"></span>

                </div>

            </div>



            <div class="form-group">

                <label class="col-lg-3 control-label" for="edit_abattoir_kabri">Kabrit</label>

                <div class="col-lg-5">

                    <input name="edit[abattoir][kabri]" id="edit_abattoir_kabri" class="form-control" type="number" min="1" max="999" placeholder="000" value="<?php echo array_get($edit_item, 'kabri'); ?>" maxlength ="3" />

                    <span class="help-inline"></span>

                </div>

            </div>



            <div class="form-group">

                <label class="col-lg-3 control-label" for="edit_abattoir_mouton">Mouton</label>

                <div class="col-lg-5">

                    <input name="edit[abattoir][mouton]" id="edit_abattoir_mouton" class="form-control" type="number" min="1" max="999" placeholder="000" value="<?php echo array_get($edit_item, 'mouton'); ?>"  maxlength ="3" />

                    <span class="help-inline"></span>

                </div>

            </div>



            <div class="form-group">

                <label class="col-lg-3 control-label" for="edit_abattoir_kochon">Kochon</label>

                <div class="col-lg-5">

                    <input name="edit[abattoir][kochon]" id="edit_abattoir_kochon" class="form-control" type="number" min="1" max="999" placeholder="000" value="<?php echo array_get($edit_item, 'kochon'); ?>" maxlength ="3" />

                    <span class="help-inline"></span>

                </div>

            </div>

<legend>#SO AJAN KI KONTWOLE ABATAJ NAN LABATWA SA A</legend>

            <div class="form-group">

                <label class="col-lg-3 control-label" for="edit_abattoir_agent1">Ajan 1</label>

                <div class="col-lg-5">

                    <select name="edit[abattoir][agent1]" id="edit_abattoir_agent1" class="form-control edit_abattoir_agents" >

                        <option value="<?php echo array_get($edit_item, 'agent1'); ?>"><?php

                            $agent1 = Agent::find(array_get($edit_item, 'agent1'));

                            echo ($agent1) ? $agent1->so : "";

                            ?></option>

                    </select>

                    <span class="help-inline"></span>

                </div>

            </div>



            <div class="form-group">

                <label class="col-lg-3 control-label" for="edit_abattoir_agent2"> Ajan 2  </label>

                <div class="col-lg-5">

                    <select name="edit[abattoir][agent2]" id="edit_abattoir_agent2" class="form-control edit_abattoir_agents" >

                        <option value="<?php echo array_get($edit_item, 'agent2'); ?>"><?php

                            $agent2 = Agent::find(array_get($edit_item, 'agent2'));

                            echo ($agent2) ? $agent2->so : "";

                            ?></option>

                    </select>

                    <span class="help-inline"></span>

                </div>

            </div>



            <div class="form-group">

                <label class="col-lg-3 control-label" for="edit_abattoir_agent3">    Ajan 3    </label>

                <div class="col-lg-5">

                    <select name="edit[abattoir][agent3]" id="edit_abattoir_agent3" class="form-control edit_abattoir_agents" >

                        <option value="<?php echo array_get($edit_item, 'agent3'); ?>"><?php

                            $agent3 = Agent::find(array_get($edit_item, 'agent3'));

                            echo ($agent3) ? $agent3->so : "";

                            ?></option>

                    </select>

                    <span class="help-inline"></span>

                </div>

            </div>



            <div class="form-group">

                <label class="col-lg-3 control-label" for="edit_abattoir_agent4">    Ajan 4    </label>

                <div class="col-lg-5">

                    <select name="edit[abattoir][agent4]" id="edit_abattoir_agent4" class="form-control edit_abattoir_agents" >

                        <option value="<?php echo array_get($edit_item, 'agent4'); ?>"><?php

                            $agent4 = Agent::find(array_get($edit_item, 'agent4'));

                            echo ($agent4) ? $agent4->so : "";

                            ?></option>

                    </select>

                    <span class="help-inline"></span>

                </div>

            </div>



            <div class="form-group">

                <label class="col-lg-3 control-label" for="edit_abattoir_agent5">    Ajan 5    </label>

                <div class="col-lg-5">

                    <select name="edit[abattoir][agent5]" id="edit_abattoir_agent5" class="form-control edit_abattoir_agents" >

                        <option value="<?php echo array_get($edit_item, 'agent5'); ?>"><?php

                            $agent5 = Agent::find(array_get($edit_item, 'agent5'));

                            echo ($agent5) ? $agent5->so : "";

                            ?></option>

                    </select>

                    <span class="help-inline"></span>

                </div>

            </div>



            



            



            <div class="form-group">

                <div class="col-lg-offset-2 col-lg-10">

                    <a href="{{URL::route('abbatages')}}"class="btn btn-danger">Sòti</a>

                    <?php

                    if ($user->role != 'user')

                    {

                        ?>

                        <button type="submit" class="btn btn-primary" name="edit[submit]" onClick="return verifierPost();"><?php echo Lang::get('Modifye Abatwa'); ?></button>

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

    $(document).ready(function() {

        $(function() {

            $.mask.definitions['~'] = "[+-]";

            $("#create_abattoir_phone").mask("9999-9999");

            $("input").blur(function() {

                $("#info").html("Unmasked value: " + $(this).mask());

            }).dblclick(function() {

                $(this).unmask();

            });

        });



        $('#edit_abattoir_department_1').change(function() {

            var dept = $('#edit_abattoir_department_1').val();

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

                    $("#edit_abattoir_city").empty();

                    var option = $('<option></option>').attr({

                        value: null

                    })

                            .text('Chwazi komin...');



                    //add the option to the select

                    $("#edit_abattoir_city").append(option);

                    for (var i = 0; i < cities.length; i++) {

                        var value = cities[i].id;

                        var text = cities[i].name;

                        // edit an option with attributes 

                        var option = $('<option></option>').attr({

                            value: value

                        })

                                .text(text);



                        //add the option to the select

                        $("#edit_abattoir_city").append(option);

                    }

                }



                var data = {department: dept};

                $.ajax({

                    'url': '<?php echo URL::route('adminagentdepartment'); ?>',

                    'type': 'POST',

                    'data': data,

                    'success': function(data) {

                        var agents = data.data;

                        $(".edit_abattoir_agents").empty();

                        var option = $('<option></option>').attr({

                            value: null

                        })

                                .text('Select');

                        $(".edit_abattoir_agents").append(option);

                        for (var i = 0; i < agents.length; i++) {

                            var value = agents[i].id;

                            var text = agents[i].so;

                            // create an option with attributes 

                            option = $('<option></option>').attr({

                                value: value

                            })

                                    .text(text);



                            //add the option to the select

                            $(".edit_abattoir_agents").append(option);

                        }

                    }

                });



            }

        });



        $('#edit_abattoir_city').change(function() {

            var city_id = $('#edit_abattoir_city').val();

            var dept = $('#edit_abattoir_department_1').val();

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

                    $("#edit_abattoir_cSection").empty();

                    for (var i = 0; i < sections.length; i++)

                    {

                        var value = sections[i].id;

                        var text = sections[i].name;

                        // edit an option with attributes 

                        var option = $('<option></option>').attr({

                            value: value

                        })

                                .text(text);



                        //add the option to the select

                        $("#edit_abattoir_cSection").append(option);

                    }

                }

            }

        });

    });

</script>

@include('templates.footer')



@endsection