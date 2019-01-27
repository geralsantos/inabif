<div  class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo">
                    <a href="#">
                        <img class="align-content" src="<?php echo IMAGES?>/logo.png" alt="">
                    </a>
                </div>
                <div class="login-form">
                    <form id="login-form" v-on:submit.prevent="form_submit()" action="<?php $this->url('index') ?>" method="post">
                        <div class="form-group">
                            <label>Usuario</label>
                            <input type="text" class="form-control" name="usuario" placeholder="Ingrese su usuario">
                        </div>
                        <div class="form-group">
                            <label>Contraseña</label>
                            <input type="password" class="form-control" name="clave" placeholder="Ingrese su clave">
                        </div>
                        <div class="form-group">
                            <label>Captcha</label>
                            <?php
                            if ($_SERVER['HTTP_HOST']=="localhost") {
                               ?>
                            <div class="g-recaptcha" data-sitekey="6LdHmIYUAAAAAHCY9Y7VI35Hs44IUaVWZpFnNGzm"></div>

                               <?php
                            }else {
                                ?>
                            <div class="g-recaptcha" data-sitekey="6LcysIcUAAAAAE3Xju4Ee_ZhFlOw6D-JyudgfUAB"></div>

                               <?php
                            }
                            ?>
                        </div>
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Entrar</button>


                    </form>
                </div>
            </div>
        </div>
    </div>
<script>
document.body.style.backgroundImage = "url('../images/logo3.jpg')";

</script>