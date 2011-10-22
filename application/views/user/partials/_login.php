<h1>Entra y escribe</h1>
<form action="/user/login" method="post">
    <label for="email">
        <span>Email</span>
        <input type="email" name="email" />
    </label>
    <label for="pass">
        <span>Password</span>
        <input type="password" name="pass" />
    </label>
    
    <br />
    <input type="submit" value="Entrar" />
    <?php if(isset($swPortada) && $swPortada): ?>
    <a class="aRegister" href="/user/register">Regístrate</a>
    <?php endif; ?>
</form>