@extends('layouts.common')



@section('content')

@include('templates.headerTop')



@include('templates.header')

@include('abattoirs.tab_top')

<div class="tab-pane <?php echo $active_tab == 'abattoirs_index' ? 'active' : NULL; ?>" id="tab_abattoirs_index">

    <?php

    if (isset($list))

    {

        ?>

        <form action="" method="post" name="abattoirs_list" id="abattoirs_list">

            <table class="table table-hover">

                <thead>

                    <tr>

                       

                        <th>NON</th>
                         <th>TIP</th>

                        <th>DEPATMAN</th>

                        <th>KOMIN</th>

                        <th>SEKSYON</th>

                        <th>TOTAL BÈF</th>

                        <th>KABRIT</th>

                        <th>MOUTON</th>

                        <th>KOCHON</th>

                        <th>BÈF</th>

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

                            <!--<td><input type="checkbox" name="list[items][selected][]" value="<?php echo (string) $row->id; ?>" class="list_checkbox" /></td>-->

                            <td><?php echo $row->name; ?></td>

                            <td><?php echo $row->type; ?></td>

                            <!--<td><?php echo $row->phone; ?></td>-->

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