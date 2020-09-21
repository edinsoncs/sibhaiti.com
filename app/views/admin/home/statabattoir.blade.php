@extends('admin.layouts.common')

@section('content')
@include('templates.headerTop')

@include('admin.templates.header')
<div class="container">
      <p class="titre_top"><?php echo 'sib / rapò abataj pa depatman'; ?></p>
    
        <div class="col-lg-12">
         <div id="search_admin">
        <form action="" class="">
           
                       

              
                <div class="col-lg-3">
                    <select name="search[start_month]" id="search_start_month" class="form-control" >
                        <option value="">Tout lane a</option>
                        <?php
                        if ($months)
                        {
                            foreach ($months as $m => $month)
                            {
                                ?>
                                <option value="{{$m+1}}" <?php echo (array_get($search, 'start_month') == $m + 1) ? 'selected="selected"' : NULL; ?> >{{$month}}</option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <select name="search[start_year]" id="search_start_year" class="form-control" >
                        <?php
                        if ($years)
                        {
                            foreach ($years as $year)
                            {
                                ?>
                                <option value="{{$year}}" <?php echo (array_get($search, 'start_year') == $year) ? 'selected="selected"' : NULL; ?> >{{$year}}</option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                
            
           
            <div class="row">
                <div class="col-lg-12">
                   
                    <button type="submit" id="search-btn" class="btn btn-primary pull-right">Chache</button>
                </div>
            </div>
             </form></div>
              <div id="loader" hidden><img src="/frontapp/img/ajax-loader.gif" width="50" class="img-responsive pull-right" /></div>
        <div class="col-lg-12">
          
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Depatman</th>
                            <th>Total</th>
                            <?php
                            if (isset($departments) && !empty($departments))
                            {
                                foreach ($departments as $department)
                                {
                                    ?>
                                    <th>{{array_get($department,'name')}}</th>
                                    <?php
                                }
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($data && !empty($data))
                        {
                            $lastrow = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
                            foreach ($data as $row)
                            {
                                ?>
                                <tr>
                                    <?php
                                    foreach ($row as $i=>$item)
                                    {
                                        $lastrow[$i] =$lastrow[$i]+$item;
                                        ?>
                                        <td>{{$item}}</td>
                                        <?php
                                    }
                                    ?>
                                </tr>
                                <?php
                            }
                            $lastrow[0] = 'Total';
                            foreach ($lastrow as $lr)
                            {
                                ?>
                                         <td>{{$lr}}</td>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#search-btn').click(function () {
            $(this).fadeOut();
            $('#loader').fadeIn();
        });
    });
</script>
@include('templates.footer')
@endsection