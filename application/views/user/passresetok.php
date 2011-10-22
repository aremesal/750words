<div id="dvRememberPass" class="dvRegister">
    <h1>Resetear contraseña</h1>
    <p>
        <?php if( $status ): ?>
        La contraseña ha sido actualizada, ya puedes <a href="/user/register">iniciar sesión</a> con tu nueva contraseña.
        <?php else: ?>
        No se ha podido actualizar la contraseña, por favor, inténtalo de nuevo.
        <?php endif; ?>
    </p>
</div>