@extends('layouts.common')

@section('content')
@include('templates.headerTop')

@include('templates.header')

<div id="search_admin">
    <form role="search">
        <div class="col-lg-6">
            <input name="search[text]" type="text" class="form-control" placeholder="mokle" value="<?php echo (isset($search)) ? array_get($search, 'text') : NULL ?>">
        </div>
		   <div class="clearfix"></div>

        <div class="col-lg-3">
            <select name="search[obj]" id="search_type" class="form-control" >
                 <option value="">Tout peyi a</option>
                <option value="so" <?php echo (array_get($search, 'obj') == "so") ? 'selected="selected"' : NULL; ?>># So</option>
                <option value="tag" <?php echo (array_get($search, 'obj') == "tag") ? 'selected="selected"' : NULL; ?>># Tag</option>
                <option value="kane" <?php echo (array_get($search, 'obj') == "kane") ? 'selected="selected"' : NULL; ?>># Kanè</option>
                <option value="cin" <?php echo (array_get($search, 'obj') == "cin") ? 'selected="selected"' : NULL; ?>># Cin</option>
            </select>
        </div>
        <div class="col-lg-3">
            <select name="search[type]" id="search_type" class="form-control" >
                <option value="eleveur" <?php echo (array_get($search, 'type') == "eleveur") ? 'selected="selected"' : NULL; ?>>Elvè</option>
                <option value="agent" <?php echo (array_get($search, 'type') == "agent") ? 'selected="selected"' : NULL; ?>>Ajan</option>
                <option value="animal" <?php echo (array_get($search, 'type') == "animal") ? 'selected="selected"' : NULL; ?>>Bèf</option>
                <option value="abattoir" <?php echo (array_get($search, 'type') == "abattoir") ? 'selected="selected"' : NULL; ?>>Labatwa</option>
            </select>
        </div>
        <div class="col-lg-3">
            <select name="search[department]" id="search_department" class="form-control">
                <option value="">Tout Depatman yo</option>
                <?php
                foreach ($departments as $dept)
                {
                    ?>
                    <option value="<?php echo array_get($dept, 'id'); ?>" <?php echo (array_get($search, 'department') == array_get($dept, 'id')) ? 'selected="selected"' : NULL; ?>><?php echo array_get($dept, 'name'); ?></option>
                    <?php
                }
                ?>
            </select>
            <span class="help-inline"></span>
        </div>
        <div class="col-lg-3">
            <select name="search[city]" id="search_city" class="form-control" >  
                <option value="">Tout Komin yo</option>
            </select>
        </div>
		                <div class="clearfix"></div>

        <div class="col-lg-1">
            <button type="submit" class="btn btn-info">CHACHE</button>
        </div>
    </form>
</div>

<div class="clearfix"></div>
<div>
    <?php
    if (isset($list))
    {
        ?>
        <form action="" method="post" name="agents_list" id="agents_list">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <?php
                        foreach ($header as $item)
                        {
                            ?>
                            <th><?php echo $item; ?></th>
                            <?php
                        }
                        ?>
                        <th></th>
                    </tr>
                </thead>
                <?php
                if (!empty($list))
                {
                    foreach ($list as $row)
                    {
                        if ($type == 'agent')
                        {
                            ?>
                            <tr>
                                <?php /* <td><input type="checkbox" name="list[items][selected][]" value="<?php echo (string) $row->id; ?>" class="list_checkbox" /></td> */ ?>
                                <td><?php echo $row->fName . " " . $row->lName; ?></td>
                                <td><?php echo $row->phone ." <br /> ". $row->phone2; ?></td>
								<td><?php echo $row->so; ?></td>
                                <td><?php echo User::getDepartment($row->department); ?></td>
                                <td><?php echo User::getCity($row->department, $row->city); ?></td>
                                <td><?php echo User::getSection($row->department, $row->city, $row->cSection); ?></td>
                                <!--<td class="<?php echo ($row->isActv) ? 'green' : 'red'; ?>"><?php echo $row->isActv ? 'Active' : 'Deactive'; ?></td>-->
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-info" type="button" value="Edit" href="<?php echo URL::route('editagent', $row->id); ?>">										<span class="glyphicon glyphicon-edit"></span></a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        } else if ($type == 'eleveur')
                        {
                            ?>
                            <tr>
                                <td><?php echo $row->fName . " " . $row->lName . " (" . $row->getAnimals() . ")"; ?></td>
                                <td><?php echo $row->phone; ?></td>
								<td><?php echo $row->heritage('user'); ?></td>
                                <td><?php echo $row->cin; ?></td>
                                <td><?php echo $row->fiche; ?></td>
                                <td><?php echo User::getDepartment($row->department); ?></td>
                                <td><?php echo User::getCity($row->department, $row->city); ?></td>
                                <td><?php echo User::getSection($row->department, $row->city, $row->cSection); ?></td>
                               <!-- <td class="<?php echo ($row->isActv) ? 'green' : 'red'; ?>"><?php echo $row->isActv ? 'Active' : 'Deactive'; ?></td>
                                <td>
                                    <a class="btn btn-success" type="button" value="Create" href="<?php echo URL::route('createanimal', $row->id); ?>"><span class="glyphicon glyphicon-plus"></span></a>
                                </td>-->
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-info" type="button" value="Edit" href="<?php echo URL::route('editeleveur', $row->id); ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        } else if ($type == 'animal')
                        {
                            ?>
                            <tr>
                                <td><?php echo $row->tag; ?></td>
                                <td><?php echo ucfirst($row->carnet); ?></td>
                                <td><?php echo $row->getEleveur(); ?></td>
                                <td><?php echo $row->so; ?></td>
                                <td><?php echo User::getDepartment($row->department); ?></td>
                                <td><?php echo User::getCity($row->department, $row->city); ?></td>
                                <td><?php echo User::getSection($row->department, $row->city, $row->cSection); ?></td>
                                <!--<td class="<?php echo ($row->isActv) ? 'green' : 'red'; ?>"><?php echo $row->isActv ? 'Active' : 'Deactive'; ?></td>
                                <td>
                                    <button class="btn btn-danger btn-modal" data-toggle="modal" data-target="#notificationModal" data-id="<?php echo $row->id; ?>" data-tag="<?php echo $row->tag; ?>">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                </td>-->
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-info" type="button" value="Edit" href="<?php echo URL::route('editanimal', $row->id); ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        } else if ($type == 'abattoir')
                        {
                            ?>
                            <tr>
                                <td><?php echo $row->name; ?></td>
                                <td><?php echo $row->type; ?></td>
                                <td><?php echo User::getDepartment($row->department()); ?></td>
                                <td><?php echo User::getCity($row->department(), $row->city()); ?></td>
                                <td><?php echo User::getSection($row->department(), $row->city(), $row->cSection()); ?></td>
                                <td><?php echo $row->notifications(); ?></td>
                                <td><?php echo $row->kabri; ?></td>
                                <td><?php echo $row->mouton; ?></td>
                                <td><?php echo $row->kochon; ?></td>
                                <td><?php echo $row->bef; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-info" type="button" value="Edit" href="<?php echo URL::route('abattoir', $row->id); ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
            </table>
            <?php echo $list->appends(Request::only('search'))->links(); ?>
        </form>
        <?php
    }
    ?>
</div>
<!-- eo list tab -->

<script type="text/javascript">
    var departments = <?php echo (!empty($departments)) ? json_encode($departments) : "{}"; ?>;
    $(document).ready(function() {
        $('#search_department').change(function() {
            var dept = $('#search_department').val();
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
                    $("#search_city").empty();
                    var option = $('<option></option>').attr({
                        value: null
                    })
                            .text('Chwazi komin...');

                    //add the option to the select
                    $("#search_city").append(option);
                    for (var i = 0; i < cities.length; i++) {
                        var value = cities[i].id;
                        var text = cities[i].name;
                        // create an option with attributes 
                        var option = $('<option></option>').attr({
                            value: value
                        })
                                .text(text);

                        //add the option to the select
                        $("#search_city").append(option);
                    }
                }
            }
        });

        $("#notification-date").mask("99-99-9999");

        $('.btn-modal').click(function() {
            var rId = $(this).attr('data-id');
            var tag = $(this).attr('data-tag');
            $('#notification-rid').val(rId);
            $('#notification-tag').val(tag);
        });

        $('#create-notification').click(function() {
            if ($('#notification-desc').val() != "" && $('#notification-type').val() != "" && $('#notification-date').val() != "") {
                var type = $('#notification-type').val();
                var text = $('#notification-desc').val();
                var date = $('#notification-date').val();
                var department = $('#notification-department-1').val();
                var city = $('#notification-city').val();
                var section = $('#notification-cSection').val();
                var abbatoire = $('#notification-abbatoire').val();
                var so = $('#notification-so').val();

                var rId = $('#notification-rid').val();

                var data = {text: text, type: type, date: date, rId: rId, department: department, city: city, section: section, abbatoire: abbatoire, so: so};

                $.ajax({
                    'url': '<?php echo URL::route('createnotification'); ?>',
                    'type': 'POST',
                    'data': data,
                    'success': function(data) {
                        $('#notificationModal').modal('hide');
                    }
                });
            }
            else {
                alert('Oups!!! Tout chan yo obligatwa.');
            }
        });

        $('#notification-department-1').change(function() {
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
                    //console.log(dept);
                    // console.log(cities);
                    // clear the select
                    $("#notification-city").empty();
                    var option = $('<option>aaaa</option>').attr({
                        value: null
                    })
                            .text('Chwazi komin...');

                    //add the option to the select
                    $("#notification-city").append(option);
                    for (var i = 0; i < cities.length; i++) {
                        var value = cities[i].id;
                        var text = cities[i].name;
                        // create an option with attributes 
                        var option = $('<option></option>').attr({
                            value: value
                        })
                                .text(text);

                        //add the option to the select
                        $("#notification-city").append(option);
                    }
                }
            }
        });

        $('#notification-city').change(function() {
            var city_id = $('#notification-city').val();
            var dept = $('#notification-department-1').val();
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
            }
        });
    });
</script>
@include('templates.footer')

@endsection