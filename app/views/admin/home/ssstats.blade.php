@extends('admin.layouts.common')
@section('content')
@include('templates.headerTop')
@include('admin.templates.header')
<div class="container">
    <!--<div id="search_admin" class="row">
        <form role="search">
            <div class="col-lg-3">
                <input name="search[text]" type="text" class="form-control" placeholder="mot-cle" value="<?php echo (isset($search)) ? array_get($search, 'text') : NULL ?>">
            </div>
            <div class="col-lg-2">
                <select name="search[obj]" id="search_type" class="form-control" >
                    <option value=""></option>
                    <option value="so" <?php echo (array_get($search, 'obj') == "so") ? 'selected="selected"' : NULL; ?>># So</option>
                    <option value="tag" <?php echo (array_get($search, 'obj') == "tag") ? 'selected="selected"' : NULL; ?>># Tag</option>
                    <option value="kane" <?php echo (array_get($search, 'obj') == "kane") ? 'selected="selected"' : NULL; ?>># Kanè</option>
                    <option value="cin" <?php echo (array_get($search, 'obj') == "cin") ? 'selected="selected"' : NULL; ?>># Cin</option>
                </select>
            </div>
            <div class="col-lg-2">
                <select name="search[type]" id="search_type" class="form-control" >
                    <option value="eleveur" <?php echo (array_get($search, 'type') == "eleveur") ? 'selected="selected"' : NULL; ?>>Elvè</option>
                    <option value="agent" <?php echo (array_get($search, 'type') == "agent") ? 'selected="selected"' : NULL; ?>>Ajan</option>
                    <option value="animal" <?php echo (array_get($search, 'type') == "animal") ? 'selected="selected"' : NULL; ?>>Bèf</option>
                    <option value="abattoir" <?php echo (array_get($search, 'type') == "abattoir") ? 'selected="selected"' : NULL; ?>>Abattoir</option>
                </select>
            </div>
            <div class="col-lg-2">
                <select name="search[department]" id="search_department" class="form-control">
                    <option value="">Depatman...</option>
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
            <div class="col-lg-2">
                <select name="search[city]" id="search_city" class="form-control" >  
                    <option value="">Komin...</option>
                </select>
            </div>
            <div class="col-lg-1">
                <button type="submit" class="btn btn-info">Jwenn</button>
            </div>
        </form>
    </div> -->
    <?php
    if ($page_id == 'admin_dashboard')
    {
        ?>
        <div id="search_admin">
            <form role="search">
                <div class="col-lg-6">
                    <input name="search[text]" type="text" class="form-control" placeholder="MoKle" value="<?php echo (isset($search)) ? array_get($search, 'text') : NULL ?>">
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-3">
                    <select name="search[obj]" id="search_type" class="form-control" >
                        <option value="">Tout Peyi a</option>
                        <option value="so">#So</option>
                        <option value="tag">#Tag</option>
                        <option value="kane">#Kanè</option>
                        <option value="cin">#Cin</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <select name="search[type]" id="search_type" class="form-control" >
                        <option value="eleveur">Elvè</option>
                        <option value="agent">Ajan</option>
                        <option value="animal">Bèf</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <select name="search[department]" id="search_department" class="form-control">
                        <option value="">Tout Peyi a</option>
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
                <div class="col-lg-3">
                    <select name="search[city]" id="search_city" class="form-control" >  
                        <option value="">Komin...</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-2">
                    <button type="submit" class="btn btn-info">Chache</button>
                </div>
            </form>
        </div>
        <div class="clearfix"></div>
        <div id="search_admin">
            <form role="search">

                <div class="col-lg-3">
                    <select name="search[department]" id="search_department" class="form-control">
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
                <div class="col-lg-3">
                    <select name="search[city]" id="search_city" class="form-control" >  
                        <option value="">Komin...</option>
                    </select>
                </div>
                <div class="col-lg-1">
                    <button type="submit" class="btn btn-info">OK</button>
                </div>
            </form>
        </div>
        <?php
    }
    ?>
    <!--<div class="page-header">
        <h2><?php echo 'Pòtay'; ?></h2>
    </div>-->
    <div id="row">
        <?php
        if (isset($departments) && !empty($departments))
        {
            foreach ($departments as $dept)
            {
                if (array_get($dept, 'id'))
                {
                    ?>
                    <!--<div class="col-lg-3 dept-box">-->
                    <legend><a href="<?php echo URL::route('admindepartment', array_get($dept, 'id')); ?>"><?php echo array_get($dept, 'name'); ?></a>

                    </legend>
                    <ul>
                        <li><a href="<?php echo URL::route('adminanimals', array_get($dept, 'id')); ?>"><?php echo 'Bèf' . " (" . User::deptCounter('animal', array_get($dept, 'id')) . ")"; ?></a></li>
                        <li><a href="<?php echo URL::route('adminagents', array_get($dept, 'id')); ?>"><?php echo 'Ajan' . " (" . User::deptCounter('agent', array_get($dept, 'id')) . ")"; ?></a></li>
                        <li><a href="<?php echo URL::route('admineleveurs', array_get($dept, 'id')); ?>"><?php echo 'Elvè' . " (" . User::deptCounter('eleveur', array_get($dept, 'id')) . ")"; ?></a></li>
                        <li><a href="<?php echo URL::route('adminabbatages', array_get($dept, 'id')); ?>"><?php echo 'Abataj ' . " (" . User::deptCounter('abbatage', array_get($dept, 'id')) . ")"; ?></a></li>
                        <ul>
                            <li class="dlist"><?php echo 'Estimasyon Kabrit' . " (" . Abattoir::betDeptCounter(array_get($dept, 'id'), 'kabri') . ")"; ?></li>
                            <li class="dlist"><?php echo 'Estimasyon Mouton' . " (" . Abattoir::betDeptCounter(array_get($dept, 'id'), 'mouton') . ")"; ?></li>
                            <li class="dlist"><?php echo 'Estimasyon Kochon' . " (" . Abattoir::betDeptCounter(array_get($dept, 'id'), 'kochon') . ")"; ?></li>
                            <li class="dlist"><?php echo 'Estimasyon Bèf' . " (" . Abattoir::betDeptCounter(array_get($dept, 'id'), 'bef') . ")"; ?></li>
                            <li class="dlist"><?php echo 'Total Bèf ki Anrejistre' . " (" . Abattoir::notificationDeptCounter(array_get($dept, 'id')) . ")"; ?></li>
                        </ul>
                    </ul>
                    <?php /* <div><a href="<?php echo URL::route('adminabbatages', array_get($dept, 'id')); ?>"><?php echo 'Abbatage ' . " (" . User::deptCounter('abbatage', array_get($dept, 'id')) . ")"; ?></a></div> */ ?>
                    <!--</div>-->
                    <?php
                }
            }
        }
        ?>
    </div>
</div>
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
    });
</script>
@include('templates.footer')

@endsection