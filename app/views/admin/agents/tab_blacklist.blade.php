@extends('admin.layouts.common')

@section('content')
@include('templates.headerTop')

@include('admin.templates.header')
@include('admin.agents.tab_top')
<div class="tab-pane <?php echo $active_tab == 'agents_blacklist' ? 'active' : NULL; ?>" id="tab_agents_blacklist">
    <?php
    if (isset($list))
    {
        ?>
        <form action="" method="post" name="agents_list" id="agents_list">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><?php echo Lang::get('siyati ak non'); ?></th>
                        <th><?php echo Lang::get('user'); ?></th>
                        <th><?php echo Lang::get('abataj'); ?></th>
                        <th><?php echo Lang::get('telefòn'); ?></th>
                        <th><?php echo Lang::get('#so'); ?></th>
                        <th>DEPATMAN</th>
                        <th><?php echo Lang::get('komin'); ?></th>
                        <th><?php echo Lang::get('seksyon'); ?></th>
                        <th></th>
                    </tr>
                </thead>
                <?php
                if (!empty($list))
                {
                    foreach ($list as $row)
                    {
                        ?>
                        <tr>
                            <td><?php echo $row->fName . " " . $row->lName; ?></td>
                            <td><a href="<?php echo URL::route('adminedituser', $row->desc); ?>"><?php echo $row->creator(); ?></a></td>
                            <td><?php echo $row->abattages(); ?></td>
                            <td><?php echo $row->phone . " <br/>" . $row->phone2; ?></td>
                            <td><?php echo $row->so; ?></td>
                            <td><?php echo User::getDepartment($row->department); ?></td>
                            <td><?php echo User::getCity($row->department, $row->city); ?></td>
                            <td><?php echo User::getSection($row->department, $row->city, $row->cSection); ?></td>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info" type="button" value="Edit" href="<?php echo URL::route('admineditagent', $row->id); ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>
            <?php echo $list->links(); ?>
        </form>
        <?php
    }
    ?>
</div>
<!-- eo list tab -->
@include('templates.footer')

@endsection