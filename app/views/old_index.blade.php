@extends('layouts.common')
@section('content')
<div class="container">

    <div id="intro"> 
		 {{HTML::image('/frontapp/img/logoSib2.png')}}
    </div>
	
    <div id="header">
        <div class="connect">
            <div class="col-lg-4">
                <form action="{{URL::route('login')}}" method="post" name="users_login" id="users_login" class="form-horizontal">
                    <p class="titre_top">Konektew nan Sib</p>
						<?php
							if (isset($errors))
							{
								foreach ($errors as $error)
								{
									?> 
									<div class="text-danger"> <?php echo array_get($error, 0); ?> </div> 
									<?php
								}
							}
						?>

                        <div class="col-lg-12"> 
                            <input name="username"  id="username" maxlength="50" type="email" placeholder="Imèl" class="form-control input-medium" /> 
                        </div> 
                    
                        <div class="col-lg-12"> 
                            <input name="password" id="password" maxlength="10" type="password" placeholder="Modpas" class="form-control input-medium" /> 
                        </div>
                    
                    
                        <div class="col-lg-12"><button type="submit" class="btn btn-primary" onClick="return cnt();" >koneksyon</button>
                            <a data-toggle="modal" href="#" data-target="#myModal">Enskripsyon</a>
                        </div>
                        
                
				</form>
            </div>
        </div>
    </div>

<!--    MODAL   -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="gridSystemModalLabel">Silvouplè, ranpli tout chan ki nan fòmilè sa a.</h4>
      </div>
      <div class="modal-body">
                <form action="{{URL::route('register')}}" method="post" name="admin_users_create" class="form-horizontal">				
                    <?php
                    $user_arr = array();
                    if (isset($errors))
                    {
                        foreach ($errors as $error)
                        {
                            ?> 
                            <div class="text-danger"> <?php echo array_get($error, 0); ?> </div> 
                            <?php
                        }
                    }
                    ?>

                    <div class="col-lg-12">
                        <input name="create[user][fName]" id="create_user_fName" class="form-control" maxlength="20" type="text" placeholder="<?php echo Lang::get('Siyati'); ?> ">
                    </div>

                    <div class="col-lg-12">
                        <input name="create[user][lName]" id="create_user_lName" class="form-control" maxlength="20" type="text" placeholder="<?php echo Lang::get('Non'); ?> ">
                    </div>

                    <div class="col-lg-12">
                        <input name="create[user][phone]" id="create_user_phone" class="form-control" maxlength="8" type="text" placeholder="<?php echo Lang::get('36344098'); ?> ">
                    </div>

                    <div class="col-lg-12">
                        <input name="create[user][email]" id="create_user_email" class="form-control" maxlength="50" type="email" placeholder="<?php echo Lang::get('Imèl'); ?> ">
                    </div>
                    <div class="col-lg-12">
                        <input name="create[user][password]" id="create_user_password" class="form-control" maxlength="10" type="password" placeholder="<?php echo Lang::get('ModPas [8-10]') ?> ">
                    </div>

                    <div class="col-lg-12">
                        <input name="create[user][repeat_password]" id="create_user_repeat_password" class="form-control" maxlength="10" type="password" placeholder="<?php echo Lang::get('re-ModPas'); ?> ">
                    </div>
                    <div class="col-lg-12">
                        {{HTML::image(Captcha::img(), 'Captcha image')}}
                        <input name="create[user][captcha]" id="captcha" class="form-control"  maxlength="5" type="text"  placeholder="<?php echo Lang::get('kòd'); ?> ">
                    </div>	
                    <span id="err"></span>
                    
                
            </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Sòti</button>
        <button type="submit" class="btn btn-primary" name="create[submit]" onClick="return inscr();" > <?php echo Lang::get('Enskripsyon'); ?> </button> 
		</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- FIN -->

</div>

@include('templates.footer')
@endsection

<script type="text/javascript">
    $(document).ready(function() {
        $(function() {
            $.mask.definitions['~'] = "[+-]";


            $("#create_user_phone").mask("99999999");

            $("input").blur(function() {
                $("#info").html("Unmasked value: " + $(this).mask());
            }).dblclick(function() {
                $(this).unmask();
            }
            );
        }
        );
    }
    );
</script>







