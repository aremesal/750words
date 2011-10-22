<div id="dvRememberPass" class="dvRegister">
    <h1>Recordar contraseña</h1>
    <form method="post" action="/user/sendrememberpass">
        <label for="email">
            <span>Email</span>
            <input type="email" name="email" value="<?=$email?>" />
        </label>
        <br />
        <input type="submit" value="Recuperar contraseña" />
    </form>
</div>
<div id="dvRememberPassInfo" class="dvRegister">
    Si has olvidado tu contrase&ntilde;a para acceder a 750 palabras, escribe tu
    email y te enviaremos las instrucciones para resetearla.
</div>