@extends('layouts.common')

@section('content')
@include('templates.headerTop')


<div class="container">



    <legend> Enskripsyon </legend> 
    <h4>Silvouplè, ranpli tout chan ki nan fòmilè sa a.</h4>



    <form action="{{URL::route('register')}}" method="post" name="admin_users_create" class="form-horizontal">				
        <?php $user_arr = array();
        if (isset($errors))
        {
            foreach ($errors as $error)
            { ?> <div class="text-danger"> <?php echo array_get($error, 0); ?> </div> <?php }
        } ?>



        <div class="form-group">
            <label class="col-lg-2 control-label" for="create_user_fName"><?php echo Lang::get('Siyati'); ?></label>

            <div class="col-lg-7">
                <input name="create[user][fName]" id="create_user_fName" class="form-control" maxlength="20" type="text" 
                       placeholder="<?php echo Lang::get('Siyati'); ?> ">


            </div>											</div>



        <div class="form-group">
            <label class="col-lg-2 control-label" for="create_user_fName"><?php echo Lang::get('Non'); ?></label>

            <div class="col-lg-7">
                <input name="create[user][lName]" id="create_user_lName" class="form-control" maxlength="20" type="text" 
                       placeholder="<?php echo Lang::get('Non'); ?> ">
            </div>											</div>



        <div class="form-group">
            <label class="col-lg-2 control-label" for="create_user_fName"><?php echo Lang::get('Telefon'); ?></label>

            <div class="col-lg-7">
                <input name="create[user][phone]" id="create_user_phone" class="form-control" maxlength="9" type="text" 
                       placeholder="<?php echo Lang::get('3634-4098'); ?> ">
                <span class="help-inline">San (509)</span>




            </div>											</div>	










        <div class="form-group">
            <label class="col-lg-2 control-label" for="create_user_fName"><?php echo Lang::get('Imèl'); ?></label>

            <div class="col-lg-7">
                <input name="create[user][email]" id="create_user_email" class="form-control" maxlength="30" type="text" 
                       placeholder="<?php echo Lang::get('Imèl'); ?> ">

            </div>											</div>	




        <div class="form-group">
            <label class="col-lg-2 control-label" for="create_user_fName"><?php echo Lang::get('ModPas') ?></label>

            <div class="col-lg-7">
                <input name="create[user][password]" id="create_user_password" class="form-control" maxlength="10" type="password" 
                       placeholder="<?php echo Lang::get('Ex: Jhon8doe7k') ?> ">                    
                <span class="help-inline">[8-10 carakte]</span>


            </div>											</div>	




        <div class="form-group">
            <label class="col-lg-2 control-label" for="create_user_fName"><?php echo Lang::get('re-ModPas'); ?></label>

            <div class="col-lg-7">
                <input name="create[user][repeat_password]" id="create_user_repeat_password" class="form-control" maxlength="10" type="password" 
                       placeholder="<?php echo Lang::get('re-ModPas'); ?> ">

            </div>											</div>	






        <div class="form-group">
            <label class="col-lg-2 control-label" for="create_user_fName"><?php echo Lang::get('kòd'); ?> </label>

            <div class="col-lg-7">

                <input name="create[user][captcha]" id="captcha" class="form-control"  maxlength="5" type="text" 
                       placeholder="<?php echo Lang::get('kòd'); ?> ">												
                <span class="help-inline"></span>



                {{HTML::image(Captcha::img(), 'Captcha image')}}</div>											

        </div>																							



        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-6">


                <button type="submit" class="btn btn-primary" name="create[submit]" onClick="return inscr();" > <?php echo Lang::get('Enskripsyon'); ?> </button> 
                </form>


            </div>
        </div>
</div>

</div>


<div id="footer"> <p> &copy; Sib 2014. Developpé par <a href="mailto:cn.cherubin@gmail.com"> 2CH </a> </p></div>


<script type="text/javascript">   
    $(document).ready(function(){
        $(function() {
            $.mask.definitions['~'] = "[+-]";
      
	  
            $("#create_user_phone").mask("9999-9999");
	  
            $("input").blur(function() {
                $("#info").html("Unmasked value: " + $(this).mask());
            }
        ).dblclick(function() {
                $(this).unmask();
            }
        );
        }
    );
    }
);
</script>

@endsection