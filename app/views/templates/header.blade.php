<?php
if (Auth::user())
{
    ?>
    <nav class="navbar navbar-inverse" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{URL::route('dashboard')}}">Pòtay</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
			
			<li class="dropdown">
						<?php if (Auth::user()->role != 'user') { ?>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Betay</a>
                        <ul class="dropdown-menu">
                            <li><a href="{{URL::route('animals')}}"><?php echo 'Bèf yo'; ?></a></li>
							<li><a href="{{URL::route('eleveurs')}}"><?php echo 'Elvè yo'; ?></a></li>
							<li><a href="{{URL::route('agents')}}"><?php echo 'Ajan yo'; ?></a></li>
							<li><a href="{{URL::route('abbatages')}}"><?php echo 'Abatwa yo'; ?></a></li>
							
							<li><a href="{{URL::route('remarke')}}"><?php echo 'Remak'; ?></a></li>
							
						</ul>
						<?php } ?>
                    </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                if (Auth::user())
                {
                    ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo (isset(Auth::user()->fullname)) ? Auth::user()->fullname : Auth::user()->email ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{URL::route('edituser')}}"><?php echo 'Pwofil'; ?></a></li>
                            <li><a href="{{URL::route('logout')}}"><?php echo 'Kite sib'; ?></a></li>
                        </ul>
                    </li>
                    <?php
                } else
                {
                    
                }
                ?>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>


    <?php
}
?>