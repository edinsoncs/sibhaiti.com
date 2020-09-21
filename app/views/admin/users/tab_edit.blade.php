@extends('admin.layouts.common')

@section('content')
@include('templates.headerTop')

@include('admin.templates.header')
@include('admin.users.tab_top')
<div class="tab-pane <?php echo $active_tab == 'admin_users_edit' ? 'active' : NULL; ?>" id="tab_admin_users_edit">
    <div class="col-lg-9">
        <form action="<?php echo URL::route('adminedituser', array_get($edit_item, 'id')); ?>" method="post" name="admin_users_edit" class="form-horizontal">
            <div class="admin-form">
                <?php
                if (isset($errors)) {
                    foreach ($errors as $error) {
                        ?>
                        <div class="text-danger"><?php echo array_get($error, 0); ?></div>
                        <?php
                    }
                }
                //var_dump($edit_item);
                ?>
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="edit_user_fName"><?php echo Lang::get('Prenom'); ?></label>
                    <div class="col-lg-10">
                        <input name="edit[user][fName]" id="edit_user_fName" class="form-control" type="text" placeholder="<?php echo Lang::get('Prenom'); ?>" value="<?php echo array_get($edit_item, 'fName'); ?>">
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="edit_user_lName"><?php echo Lang::get('Nom'); ?></label>
                    <div class="col-lg-10">
                        <input name="edit[user][lName]" id="edit_user_lName" class="form-control" type="text" placeholder="<?php echo Lang::get('Nom'); ?>" value="<?php echo array_get($edit_item, 'lName'); ?>">
                        <span class="help-inline"></span>
                    </div>
                </div>
                <?php /*
                  <div class="form-group">
                  <label class="col-lg-2 control-label" for="edit_user_rank"><?php echo Lang::get('Rank'); ?></label>
                  <div class="col-lg-6">
                  <div class="col-lg-10">
                  <input name="edit[user][lrank]" id="edit_user_lrank" class="form-control" type="text" placeholder="<?php echo Lang::get('Min rank'); ?>" value="<?php echo array_get($edit_item,'lRank'); ?>">
                  </div>
                  <div class="col-lg-10">
                  <input name="edit[user][hrank]" id="edit_user_hrank" class="form-control" type="text" placeholder="<?php echo Lang::get('Max rank'); ?>" value="<?php echo array_get($edit_item,'hRank'); ?>">
                  </div>
                  </div>
                  </div>
                 */ ?>
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="edit_user_phone"><?php echo Lang::get('Telefòn'); ?></label>
                    <div class="col-lg-10">
                        <input name="edit[user][phone]" id="edit_user_phone" class="form-control" type="text" placeholder="<?php echo Lang::get('Téléphone'); ?>" value="<?php echo array_get($edit_item, 'phone'); ?>">
                        <span class="help-inline"></span>
                    </div>
                </div>
                <?php /*
                  <div class="form-group">
                  <label class="col-lg-2 control-label" for="edit_user_password"><?php echo Lang::get('Mot de passe'); ?></label>
                  <div class="col-lg-10">
                  <input name="edit[user][password]" id="edit_user_password" class="form-control" type="password" placeholder="<?php echo Lang::get('Mot de passe'); ?>">
                  <span class="help-inline"></span>
                  </div>
                  </div>
                  <div class="form-group">
                  <label class="col-lg-2 control-label" for="edit_user_repeat_password"><?php echo Lang::get('Re mot de passe'); ?></label>
                  <div class="col-lg-10">
                  <input name="edit[user][repeat_password]" id="edit_user_repeat_password" class="form-control" type="password" placeholder="<?php echo Lang::get('Re mot de passe'); ?>">
                  <span class="help-inline"></span>
                  </div>
                  </div>
                 */ ?>
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="edit_user_email"><?php echo Lang::get('Imèl'), "*"; ?></label>
                    <div class="col-lg-10">
                        <input readonly name="edit[user][email]" id="edit_user_email" class="form-control" type="text" placeholder="<?php echo Lang::get('Email'); ?>" value="<?php echo array_get($edit_item, 'email'); ?>">
                        <span class="help-inline"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-2 control-label" for="edit_user_role"><?php echo Lang::get('Wòl'); ?></label>
                    <div class="col-lg-10">
                        <select name="edit[user][role]" id="edit_user_role" class="form-control" >
                            <option value="user" <?php echo (array_get($edit_item, 'role') == 'user') ? 'selected="selected"' : NULL; ?>><?php echo Lang::get('Itilizatè Semp'); ?></option>
                            <option value="advanced" <?php echo (array_get($edit_item, 'role') == 'advanced') ? 'selected="selected"' : NULL; ?>><?php echo Lang::get('Itilizatè avanse'); ?></option>
                            <?php
                            if ($user->id == 34 || $user->id == 29) { //cn.cherubin@gmail.com ou michelchancy@gmail.com
                                ?>
                                <option value="admin" <?php echo (array_get($edit_item, 'role') == 'admin') ? 'selected="selected"' : NULL; ?>><?php echo Lang::get('Admin'); ?></option>                         
                                <?php
                            }
                            ?>
                        </select>
                        <span class="help-inline"></span>
                    </div>
                </div>
                <?php
                if ($user->id == 34 || $user->id == 29) { //cn.cherubin@gmail.com ou michelchancy@gmail.com
                    ?>
                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-primary" name="edit[submit]"><?php echo Lang::get('Edit'); ?></button>
                        </div>
                    </div>	
                    <?php
                }
                ?>
            </div>
        </form>
    </div>
    <div class="col-lg-3 admin-form">
        <?php
        $user_obj = User::find(array_get($edit_item, 'id'));
        if ($user_obj) {
            ?>
            <table class="table table-bordered">
                <tr>
                    <th>Estatistik</th>
                </tr>
                <tr>
                    <td>
                        Bèf  <?php echo $user_obj->animals(); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Elvè  <?php echo $user_obj->eleveurs(); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Ajan  <?php echo $user_obj->agents(); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Abataj  <?php echo $user_obj->notifications('a'); ?>
                    </td>
                </tr>
            </table>
            <?php
        }
        ?>
        <?php
        if (array_get($edit_item, 'email') && $user->id == 34 || $user->id == 29) {
            ?>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <a href="<?php echo URL::route('adminresetpass', array_get($edit_item, 'id')); ?>" class="btn btn-success"><?php echo Lang::get('Modifye Modpass'); ?></a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <div class="clearfix"></div>
</div>
<!-- eo list tab -->
@include('templates.footer')

@endsection