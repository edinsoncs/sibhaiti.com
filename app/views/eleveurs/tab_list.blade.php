@extends('layouts.common')

@section('content')
@include('templates.headerTop')

@include('templates.header')
@include('eleveurs.tab_top')
<div class="tab-pane <?php echo $active_tab == 'eleveurs_index' ? 'active' : NULL; ?>" id="tab_eleveurs_index">
    <?php
    if (isset($list))
    {
        ?>
        <form action="" method="post" name="eleveurs_list" id="eleveurs_list">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th><?php echo Lang::get('siyati ak Non '); ?></th>
                        <th><?php echo Lang::get('#fich'); ?></th>
                        <th><?php echo Lang::get('cheptel'); ?></th>
                        <th><?php echo Lang::get('CIN'); ?></th>
                        <th><?php echo Lang::get('Depatman'); ?></th>
                        <th><?php echo Lang::get('komin'); ?></th>
                        <th><?php echo Lang::get('seksyon'); ?></th>
                        <?php
                        if ($user->role != 'user')
                        {
                            ?>
                            <th></th>
                            <?php
                        }
                        ?>
                        <th></th>
                    </tr>
                </thead>
                <?php
                if (!empty($list))
                {
                    foreach ($list as $key => $row)
                    {
                        ?>
                        <tr>
                            <td><?php echo $row->lName . ", " . $row->fName;
                            //echo $row->lName . ", " . $row->fName . " (" . $row->getAnimals() . ")"; ?></td>
                            <td><?php echo $row->fiche; ?></td>
                            <td><?php echo 'caché';
                            //echo $row->heritage('user'); ?></td>
                            <td><?php echo $row->cin; ?></td>
                            <td><?php echo User::getDepartment($row->department); ?></td>
                            <td><?php echo User::getCity($row->department, $row->city); ?></td>
                            <td><?php echo User::getSection($row->department, $row->city, $row->cSection); ?></td>
                            <?php
                            if ($user->role != 'user')
                            {
                                ?>
                                <td>
                                    <a class="btn btn-success" title="Anrejistre Bèf" href="<?php echo URL::route('createanimal', $row->id); ?>"><span class="glyphicon glyphicon-plus"></span></a>
                                </td>
                                <?php
                            }
                            ?>
                            <td>
                                <div class="btn-group">
                                    <a class="btn btn-info" type="button" value="Edit" href="<?php echo URL::route('editeleveur', $row->id); ?>"><span class="glyphicon glyphicon-edit"></span></a>
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