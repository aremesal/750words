<div id="dvRegister" class="dvRegister">
<h1>Registro de usuario</h1>
    <form action="/user/create" method="post">
        <label for="name">
            <span>Nombre</span>
            <input type="text" name="name" value="<?=$name?>" />
        </label>

        <label for="email">
            <span>Email</span>
            <input type="email" name="email" value="<?=$email?>" />
        </label>
        
        <label for="pass">
            <span>Password</span>
            <input type="text" name="pass" id="registerpass" />
        </label>
        <br />
        <input type="submit" value="Registrarse" />
        
        <a href="/user/rememberpass">¿Olvidaste tu contrase&ntilde;a?</a>
    </form>
</div>
<div id="dvLogin" class="dvRegister">
    <?php $this->load->view('user/partials/_login'); ?>
</div>