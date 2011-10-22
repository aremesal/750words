<div id="dvRememberPass" class="dvRegister">
    <h1>Resetear contraseña</h1>
    <form method="post" action="/user/resetnewpass">
        <input type="hidden" name="token" value="<?=$token?>" />
        <input type="hidden" name="salt" value="<?=$uid?>" />
        <label for="pass">
            <span style="width: 130px;">Nueva contraseña</span>
            <input type="text" name="pass" id="registerpass" style="width: 260px;" />
        </label>
        <br />
        <input type="submit" value="Resetear contraseña" />
    </form>
</div>
<div id="dvRememberPassInfo" class="dvRegister">
    Si has olvidado tu contrase&ntilde;a para acceder a 750 palabras, escribe una
    nueva contraseña y te la cambiaremos al momento para que puedas volver a acceder.
</div>