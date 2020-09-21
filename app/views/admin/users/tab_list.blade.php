@extends('admin.layouts.common')

@section('content')
@include('templates.headerTop')

@include('admin.templates.header')
@include('admin.users.tab_top')
<div class="tab-pane <?php echo $active_tab == 'admin_users_index' ? 'active' : NULL; ?>" id="tab_admin_users_index">
    <?php
    if (isset($list)) {
        ?>
        <form action="" method="post" name="admin_users_list" id="admin_users_list">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><input type="checkbox" name="list[items][selected][]" onclick="toggle_list_checkboxes(this);" /></th>
                        <!--<th>ID</th>-->
                        <th><?php echo Lang::get('siyati ak non'); ?></th>
                        <!--<th><?php echo Lang::get('Imèl'); ?></th>-->
						<th><?php echo Lang::get('Elvè'); ?></th>
						<th><?php echo Lang::get('Ajan'); ?></th>
						<th><?php echo Lang::get('Bèf'); ?></th>
<th><?php echo Lang::get('Abataj'); ?></th>
                        <th><?php echo Lang::get('nivo'); ?></th>
                        <th><?php echo Lang::get('enskripsyon'); ?></th>
                        <th><?php echo Lang::get('estati'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <?php
                if (!empty($list))
                    foreach ($list as $row) {
                        ?>
                        <tr>
                            <td><input type="checkbox" name="list[items][selected][]" value="<?php echo (string) $row->id; ?>" class="list_checkbox" /></td>
                            <!--<td><?php echo $row->id ?></td>-->
                            <td><?php echo $row->getFullNameAttribute(); ?></td>
                           <!-- <td><?php echo $row->email; ?></td>-->
							<td><?php echo $row->eleveurs(); ?></td>
							<td><?php echo $row->agents(); ?></td>
							<td><?php echo $row->animals(); ?></td>
<td><?php echo $row->notifications('a'); ?></td>
                            <td><?php echo $row->role; ?></td>
                            <td><?php echo $row->created_at; ?></td>
                            <!--<td><?php echo ($row->confirmed == 1) ? 'Oui' : 'Non'; ?></td>-->
                            <td class="<?php echo ($row->isActv) ? 'green' : 'red'; ?>"><?php echo $row->isActv ? 'Active' : 'Deactive'; ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info" type="button" value="Edit" href="<?php echo URL::route('adminedituser', $row->id); ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                ?>
            </table>
            <?php echo $list->links(); ?>
            <div class="form-actions">
                <?php echo ''; ?> 
                <input name="list[activate]" type="submit" class="btn" value="<?php echo 'Aktive Yon Itilizatè'; ?>" onclick="if (confirm('Are you sure?'))
                    return true;
                else
                    return false;" />
                <input name="list[deactivate]" type="submit" class="btn" value="<?php echo 'Dezaktive Yon Itilizatè'; ?>" onclick="if (confirm('Are you sure?'))
                    return true;
                else
                    return false;" />
                <!--<input name="list[delete]" type="submit" class="btn btn-danger" value="<?php echo 'Efase Yon Itilizatè'; ?>" onclick="if (confirm('Are you sure?'))
                    return true;
                else
                    return false;" />-->
            </div>
        </form>
        <?php
    }
    ?>
</div>
<!-- eo list tab -->
@include('templates.footer')

@endsection