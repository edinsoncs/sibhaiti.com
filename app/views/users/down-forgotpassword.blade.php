@extends('layouts.common')

@section('content')
@include('templates.headerTop')

<div class="container">
    <legend> Mot de passe oublié? </legend> 
    <h4>Silvouplè, ranpli tout chan ki nan fòmilè sa a.</h4>

    <form action="{{URL::route('forgotpassword')}}" method="post" name="forgotpassword" class="form-horizontal">				
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
        <div class="form-group">
            <label class="col-lg-3 control-label" for="password_fName"><?php echo Lang::get('Siyati'); ?></label>
            <div class="col-lg-7">
                <input name="password[fName]" id="password_fName" class="form-control" maxlength="20" type="text" placeholder="<?php echo Lang::get('Siyati'); ?> ">
            </div>											
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label" for="password_lName"><?php echo Lang::get('Non'); ?></label>
            <div class="col-lg-7">
                <input name="password[lName]" id="password_lName" class="form-control" maxlength="20" type="text" placeholder="<?php echo Lang::get('Non'); ?> ">
            </div>											
        </div>
        <div class="form-group">
            <label class="col-lg-3 control-label" for="password_fName"><?php echo Lang::get('Imèl'); ?></label>
            <div class="col-lg-7">
                <input name="password[email]" id="password_email" class="form-control" maxlength="24" type="text" placeholder="<?php echo Lang::get('Imèl'); ?> ">
            </div>
        </div>	
        <div class="form-group">
            <label class="col-lg-3 control-label" for="password_password"><?php echo Lang::get('Nouvelle mot de passe') ?></label>
            <div class="col-lg-7">
                <input name="password[password]" id="password_password" class="form-control" maxlength="10" type="password" placeholder="<?php echo Lang::get('Ex: Jhon8doe7k') ?> ">                    
                <span class="help-inline">[8-10 carakte]</span>
            </div>											
        </div>	
        <div class="form-group">
            <label class="col-lg-3 control-label" for="password_repassword"><?php echo Lang::get('re-ModPas'); ?></label>
            <div class="col-lg-7">
                <input name="password[re_password]" id="password_repassword" class="form-control" maxlength="10" type="password" placeholder="<?php echo Lang::get('re-ModPas'); ?> ">
            </div>
        </div>	
        <div class="form-group">
            <label class="col-lg-3 control-label" for="captcha"><?php echo Lang::get('kòd'); ?> </label>
            <div class="col-lg-7">
                {{HTML::image(Captcha::img(), 'Captcha image')}}
                <input name="password[captcha]" id="password_captcha" class="form-control"  maxlength="5" type="text" placeholder="<?php echo Lang::get('kòd'); ?> ">												
                <span class="help-inline"></span>
            </div>											
        </div>																							
        <div class="form-group">
            <div class="col-lg-offset-3 col-lg-6">
                <button type="submit" class="btn btn-primary" name="create[submit]" onClick="return inscr();" > <?php echo Lang::get('Changer'); ?> </button> 
                <a href="/">Koneksyon</a> 
            </div>
        </div>
    </form>
</div>
<div id="footer"> <p> &copy; Sib 2014. Developpé par <a href="mailto:cn.cherubin@gmail.com"> 2CH </a> </p></div>
<script type="text/javascript">   
    $(document).ready(function(){
        
    });
</script>

@endsection