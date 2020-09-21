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
            <a class="navbar-brand" href="{{URL::route('admindashboard')}}">Pòtay</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav">
                <li><a href="{{URL::route('adminusers')}}">Itilizatè</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Done Yo</a>

                    <ul class="dropdown-menu">
                        <li><a href="{{URL::route('adminagents')}}">Ajan veterinè</a></li>
                        <li><a href="{{URL::route('adminanimals')}}">Bèf Yo</a></li>
                        <li><a href="{{URL::route('admineleveurs')}}">Elvè Yo</a></li>
                        <li><a href="{{URL::route('adminabattoirs')}}">Labatwa Yo </a></li>
                        <li><a href="{{URL::route('adminanimalsblacklist')}}">Blaklis Bèf Yo</a></li>
                        <li><a href="{{URL::route('adminagentsblacklist')}}">Blaklis Ajan Yo</a></li>
                    </ul>
                </li>



                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Rapò</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{URL::route('adminstats')}}">Tout Depatman yo</a></li>
                        <li><a href="{{URL::route('adminstatinfo')}}">Triye Pa Dat</a></li>
						<li><a href="{{URL::route('adminstatabattoir')}}">Rapò Abataj Depatman</a></li>
                        <li><a href="{{URL::route('adminstatabattoir2')}}">Rapò Abataj Komin</a></li>
<li><a href="{{URL::route('adminsystemlogs')}}">Lòg Sistèm Nan</a></li>
                    </ul>
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
                            <li><a href="{{URL::route('adminedituser', Auth::user()->id)}}"><?php echo 'Kont Mwen'; ?></a></li>
                            <li><a href="{{URL::route('adminlogout')}}"><?php echo 'Dekoneksyon'; ?></a></li>
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