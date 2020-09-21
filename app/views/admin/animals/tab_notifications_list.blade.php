@extends('admin.layouts.common')

@section('content')
@include('templates.headerTop')

@include('admin.templates.header')
@include('admin.animals.tab_top')
<div class="tab-pane <?php echo $active_tab == 'animals_notifications_list' ? 'active' : NULL; ?>" id="tab_animals_index">
    <?php
    if (isset($notifications))
    {
        ?>
        <form action="" method="post" name="animals_list" id="animals_list">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <?php /* <th><input type="checkbox" name="list[items][selected][]" onclick="toggle_list_checkboxes(this);" /></th> */ ?>
                        <th><?php echo Lang::get('Date'); ?></th>
                        <th><?php echo Lang::get('Texte'); ?></th>
                        <th><?php echo Lang::get('Abbatoire'); ?></th>
                        <th><?php echo Lang::get('#SO'); ?></th>
                        <th><?php echo Lang::get('Depatman'); ?></th>
                        <th><?php echo Lang::get('komin'); ?></th>
                        <th><?php echo Lang::get('seksyon kominal'); ?></th>
                    </tr>
                </thead>
                <?php
                if (!empty($notifications))
                    foreach ($notifications as $row)
                    {
                        ?>
                        <tr>
                            <td><?php echo $row->date; ?></td>
                            <td><?php echo $row->text; ?></td>
                            <td><?php echo $row->abbatoire; ?></td>
                            <td><?php echo $row->so; ?></td>
                            <td><?php echo User::getDepartment($row->department); ?></td>
                            <td><?php echo User::getCity($row->department, $row->city); ?></td>
                            <td><?php echo User::getSection($row->department, $row->city, $row->cSection); ?></td>
                        </tr>
                        <?php
                    }
                ?>
            </table>
        </form>
        <?php
    }
    ?>
</div>
<!-- eo list tab -->
<!-- Modal -->

<script type="text/javascript">

</script>  
@include('templates.footer')

@endsection