<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="login-container">
        <form class="login-form" action="login.php" method="post">
            <h2>Iniciar Sesión</h2>
            
            <div class="form-group">
                <i class="fas fa-user icon"></i>
                <input type="text" name="usuario" placeholder="Usuario" required>
            </div>
        
            <div class="form-group">
                <i class="fas fa-envelope icon"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
        
            <div class="form-group password-group">
                <i class="fas fa-lock icon"></i>
                <input type="password" name="password" placeholder="Contraseña" id="password" required>
                <i class="toggle-password" id="togglePassword"></i>
            </div>
        
            <button type="submit" class="btn">Acceder</button>
        
            <div class="signup-link">
                
        </form>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            let passwordInput = document.getElementById('password');
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                this.classList.add('active');
            } else {
                passwordInput.type = "password";
                this.classList.remove('active');
            }
        });
    </script>
</body>
</html>
