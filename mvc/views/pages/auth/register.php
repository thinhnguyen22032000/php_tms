<form method="post" action="<?=Domain::get()?>/auth/authRegister" class="border border-secondar p-4">
    <h1><?=$lang['REGISTER_TITLE']?></h1>
  <div class="form-group">
    <label><?=$lang['LABLE_USERNAME']?></label>
    <input type="text" name="username" class="form-control"  placeholder="<?=$lang['LABLE_USERNAME']?>...">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1"><?=$lang['LABLE_PASSWORD']?></label>
    <input type="password" class="form-control" name="password" placeholder="<?=$lang['LABLE_PASSWORD']?>...">
  </div>
  <button type="submit" class="btn btn-primary mr-3"><?=$lang['REGISTER_BTN']?></button>
  <a href="<?=Domain::get()?>/auth/login"><?=$lang['SIGN_IN_BTN']?></a>
</form>