@extends('admin.layouts.common')

@section('content')
@include('templates.headerTop')

@include('admin.templates.header')
@include('admin.animals.tab_top')
<div class="tab-pane <?php echo $active_tab == 'animals_blacklist' ? 'active' : NULL; ?>" id="tab_animals_blacklist">
    <?php
    if (isset($list)) {
        ?>
        <form action="" method="post" name="animals_blacklist" id="animals_blacklist">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th></th>
                        <th><?php echo Lang::get('#Tag'); ?></th>
                        <th><?php echo Lang::get('#Kanè'); ?></th>
                        <th><?php echo Lang::get('Elvè'); ?></th>
                        <th><?php echo Lang::get('#So Ajan'); ?></th>
                        <th><?php echo Lang::get('Depatman'); ?></th>
                        <th><?php echo Lang::get('seksyon kominal'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <?php
                if (!empty($list))
                    foreach ($list as $row) {
                        ?>
                        <tr>
                            <td><input type="checkbox" name="list[items][selected][]" value="<?php echo (string) $row->id; ?>" class="list_checkbox" /></td>
                            <td><?php echo $row->tag; ?></td>
                            <td><?php echo ucfirst($row->carnet); ?></td>
                            <td><?php echo $row->getEleveur(); ?></td>
                            <td><?php echo $row->so; ?></td>
                            <td><?php echo User::getDepartment($row->department); ?></td>
                            <td><?php echo User::getSection($row->department, $row->city, $row->cSection); ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info" type="button" value="Edit" href="<?php echo URL::route('admineditanimal', $row->id); ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                ?>
            </table>
            <?php
            if (count($list)) {
                echo $list->links();
                ?>

                <div class="form-actions">
                    <p><?php echo 'Ou ka kwoche youn ou plizyè bèf pouw retire nan blaklis la'; ?> </p>
                    <input name="list[islive]" type="submit" class="btn btn-danger" value="<?php echo 'Retire'; ?>" onclick="if (confirm('Are you sure?'))
                                return true;
                            else
                                return false;" />
                </div>
                <?php
            }
            ?>
        </form>
        <?php
    }
    ?>
</div>
<!-- eo list tab -->
@include('templates.footer')

@endsection