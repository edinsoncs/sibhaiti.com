<div class="container">
    <?php
    if ($page_id == 'animals_index' || $page_id == 'animals_blacklist')
    {
        ?>
        <div class="pull-right">
            <form class="navbar-form navbar-left" role="search">
<div class="form-group">
                    <?php $numbers = array(50, 100, 200); ?>
                    <select class="form-control" name="number">
                        <!--<option></option>-->
                        <?php
                        foreach ($numbers as $num)
                        {
                            ?>
                            <option value="<?php echo $num ?>" <?php echo (isset($number) && $number == $num) ? 'selected="selected"' : NULL; ?>><?php echo $num ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input action="{{URL::route('adminanimals')}}" name="search" type="text" class="form-control" placeholder="Jwenn" value="<?php echo (isset($search)) ? $search : NULL ?>">
                </div>
                <button type="submit" class="btn btn-info">Jwenn</button>
            </form>
        </div>
        <?php
    }
    ?>
        <p class="titre_top"><?php echo 'sib / Pati Bèf Yo'; ?></p>

    <?php //Application::show_messages($messages);  ?>

    <ul class="nav nav-tabs" id="admin-animals-tab">
        <li class="<?php echo $page_id == 'animals_index' ? 'active' : NULL; ?>" >
            <a href="{{URL::route('adminanimals')}}">
                <?php echo 'Lis bèf yo'; ?>
            </a>
        </li>
        <!--<li class="<?php echo $page_id == 'animals_create' ? 'active' : NULL; ?>">
            <a href="{{URL::route('admincreateanimal')}}" >
                <?php echo 'Anrejistre yon bèf'; ?>
            </a>
        </li>-->
        <?php
        if (isset($edit_item))
        {
            ?>
            <li class="<?php echo $page_id == 'animals_edit' ? 'active' : NULL; ?>" >
                <a href="#tab_animals_edit" data-toggle="tab">
                    <?php echo 'Modifye yon bèf'; ?>
                </a>
            </li>
            <?php
        }
        ?>
       <!-- <li class="<?php echo $page_id == 'animals_blacklist' ? 'active' : NULL; ?>">
            <a href="{{URL::route('adminanimalsblacklist')}}" >
                <?php echo 'Blaklis'; ?>
            </a>
        </li>-->
    </ul>

    <div class="tab-content">
