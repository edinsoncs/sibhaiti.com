<div class="container">

    <?php

    if ($page_id == 'abattoirs_index')

    {

        ?>

        <div class="pull-right">
		
		<!-- Select by Chris 
			<form action="{{URL::route('abbatages')}}" class="navbar-form navbar-left" role="search" action="{{URL::route('abbatages')}}">
                <div class="form-group">
				
						<select name="search" id="search" class="form-control" >
							<option value="public">Piblik (Nan yon mache)</option>
							<option value="public-isole">Piblik (Izole)</option>
							 <option value="prive">Prive</option>
							<option value="ong">Ong</option>   
						</select>
						<span class="help-inline"></span>
				
				
                </div>
                <button type="submit" class="btn btn-info"> -> </button>
            </form>
		<!-- End Select  -->

            <form action="{{URL::route('abbatages')}}" class="navbar-form navbar-left" role="search" action="{{URL::route('abbatages')}}">

                <div class="form-group">

                    <input name="search" type="text" class="form-control" placeholder="Jwenn" value="<?php echo (isset($search)) ? $search : NULL ?>">

                </div>

                <button type="submit" class="btn btn-info">CHACHE</button>

            </form>
		

        </div>

        <?php

    }

    ?>

    <p class="titre_top"><?php echo 'sib / pati abatwa YO'; ?></p>



    <ul class="nav nav-tabs" id="abattoirs-tab">

        <li class="<?php echo $page_id == 'abattoirs_index' ? 'active' : NULL; ?>" >

            <a href="{{URL::route('abbatages')}}">

                <?php echo 'Lis Abatwa yo'; ?>

            </a>

        </li>

        <?php

        if ($user->role != 'user')

        {

            ?>

            <li class="<?php echo $page_id == 'abattoirs_create' ? 'active' : NULL; ?>">

                <a href="{{URL::route('usercreateabattoir')}}" >

                    <?php echo 'Anrejistre Yon Abatwa'; ?>

                </a>

            </li>

            <?php

        }

        ?>

        <?php

        if (isset($edit_item))

        {

            ?>

            <li class="<?php echo $page_id == 'abattoirs_edit' ? 'active' : NULL; ?>" >

                <a href="#tab_abattoirs_edit" data-toggle="tab">

                    <?php echo 'Modifye abatwa'; ?>

                </a>

            </li>

            <?php

        }

        ?>

    </ul>



    <div class="tab-content">

