<div class="container">
    <?php
    if ($page_id == 'agents_index' || $page_id == 'agents_blacklist')
    {
        $values = array(
            array('key' => 'ai', 'value' => 'Idantifikatè'),
            array('key' => 'ev', 'value' => 'Enspektè Veterinè'),
            array('key' => 'aiev', 'value' => 'Toulède'),
            array('key' => 'm', 'value' => 'Gason'),
            array('key' => 'f', 'value' => 'Fanm'));
        ?>
        <div class="pull-right">
            <form action="{{URL::route('adminagents')}}" class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <select class="form-control" name="filter">
                        <option value="">10 Dènye Enskri Yo</option>
                        <?php
                        foreach ($values as $value)
                        {
                            ?>
                            <option value="<?php echo $value['key']; ?>" <?php echo (isset($filter) && $filter == $value['key']) ? 'selected="selected"' : NULL; ?>><?php echo $value['value']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <?php $numbers = array(50, 100, 200); ?>
                    <select class="form-control" name="number">
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
                    <input name="search" type="text" class="form-control" placeholder="Jwenn" value="<?php echo (isset($search)) ? $search : NULL ?>">
                </div>
                <button type="submit" class="btn btn-info">Jwenn</button>
            </form>
        </div>
        <?php
    }
    ?>

    <p class="titre_top"><?php echo 'sib / AJAN IDANTIFIKATÈ AK ENSPEKTÈ VETERINÈ YO'; ?></p>

    <?php //Application::show_messages($messages); ?>

    <ul class="nav nav-tabs" id="admin-agents-tab">
        <li class="<?php echo $page_id == 'agents_index' ? 'active' : NULL; ?>" >
            <a href="{{URL::route('adminagents')}}">
                <?php echo 'Lis ajan yo'; ?>
            </a>
        </li>
        <li class="<?php echo $page_id == 'agents_create' ? 'active' : NULL; ?>">
            <a href="{{URL::route('admincreateagent')}}" >
                <?php echo 'Anrejistre yon ajan'; ?>
            </a>
        </li>
        <li class="<?php echo $page_id == 'agents_blacklist' ? 'active' : NULL; ?>">
            <a href="{{URL::route('adminagentsblacklist')}}" >
                <?php echo 'Ajan Blacklist'; ?>
            </a>
        </li>
        <?php
        if (isset($edit_item))
        {
            ?>
            <li class="<?php echo $page_id == 'agents_edit' ? 'active' : NULL; ?>" >
                <a href="#tab_agents_edit" data-toggle="tab">
                    <?php echo 'Modifye yon ajan'; ?>
                </a>
            </li>
            <?php
        }
        ?>
    </ul>

    <div class="tab-content">
