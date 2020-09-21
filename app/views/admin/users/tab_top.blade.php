<div class="container">
    <?php
    if ($page_id == 'admin_users_index') {
 $values = array('active', 'desactive', 'admin', 'advanced', 'simple');
        ?>
        <div class="pull-right">
            <form class="navbar-form navbar-left" role="search">
<div class="form-group">
                    <select class="form-control" name="filter">
                        <option value="">10 Dènye Enskri Yo</option>
                        <?php
                        foreach ($values as $value)
                        {
                            ?>
                            <option value="<?php echo $value; ?>" <?php echo (isset($filter) && $filter == $value) ? 'selected="selected"' : NULL; ?>><?php echo ucfirst($value); ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input name="search" type="text" class="form-control" placeholder="Non ak Siyati" value="<?php echo (isset($search)) ? $search : NULL ?>">
                </div>
                <button type="submit" class="btn btn-info">Jwenn</button>
            </form>
        </div>
        <?php
    }
    ?>
        <p class="titre_top"><?php echo 'sib / itlizatè YO'; ?></p>


        <ul class="nav nav-tabs" id="admin-users-tab">
        <li class="<?php echo $page_id == 'admin_users_index' ? 'active' : NULL; ?>" >
            <a href="{{URL::route('adminusers')}}">
                <?php echo 'Lis Itilizatè Yo'; ?>
            </a>
        </li>
        <li class="<?php echo $page_id == 'admin_users_create' ? 'active' : NULL; ?>">
            <a href="{{URL::route('admincreateuser')}}" >
                <?php echo 'Kreye yon Itilizatè'; ?>
            </a>
        </li>
        <?php
        if (isset($edit_item)) {
            ?>
            <li class="<?php echo $page_id == 'admin_users_edit' ? 'active' : NULL; ?>" >
                <a href="#tab_adminedituser" data-toggle="tab">
                    <?php echo 'Edit'; ?>
                </a>
            </li>
            <?php
        }
        ?>
    </ul>

    <div class="tab-content">
