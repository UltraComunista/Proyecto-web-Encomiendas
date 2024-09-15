<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Envíos Express</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #012D5E;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }
        .login-container {
            display: flex;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            overflow: hidden;
            width: 800px;
            max-width: 90%;
        }
        .form-container {
            flex: 1;
            padding: 40px;
            background: rgba(255, 255, 255, 0.9);
        }
        .illustration {
            flex: 1;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><rect width="100" height="100" fill="%23012D5E"/><path d="M20 20h60v60H20z" fill="%23FFFFFF" opacity="0.1"/><circle cx="50" cy="50" r="30" fill="%23FFFFFF" opacity="0.1"/></svg>') center/cover;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo img {
            width: 80px;
            height: auto;
        }
        h2 {
            color: #012D5E;
            text-align: center;
            margin-bottom: 20px;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #012D5E;
            border-radius: 50px;
            background: #FFFFFF;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        input:focus {
            outline: none;
            box-shadow: 0 0 0 2px #012D5E;
        }
        button {
            width: 100%;
            padding: 12px;
            margin: 20px 0 10px;
            border: none;
            border-radius: 50px;
            background: #012D5E;
            color: #FFFFFF;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background: #024394;
        }
        .animation-area {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        .package {
            position: absolute;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="%23FFFFFF"><path d="M3 3v18h18V3H3zm16 16H5V5h14v14zM7 7h10v2H7V7zm0 4h10v2H7v-2zm0 4h7v2H7v-2z"/></svg>') no-repeat center center;
            background-size: contain;
            opacity: 0.1;
            animation: float 20s infinite linear;
        }
        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(100%, 100%) rotate(90deg); }
            50% { transform: translate(200%, 50%) rotate(180deg); }
            75% { transform: translate(100%, -100%) rotate(270deg); }
            100% { transform: translate(0, 0) rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="form-container">
            <div class="logo">
                <img src="data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23012D5E'><path d='M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5'/></svg>" alt="Logo">
            </div>
            <h2>Bienvenido</h2>
            <form method="post">
                <input type="text" name="ingUsuario" placeholder="Usuario" required>
                <input type="password" name="ingPassword" placeholder="Contraseña" required>
                <button type="submit">Iniciar Sesión</button>
            </form>
        </div>
        <div class="illustration"></div>
    </div>
    <div class="animation-area">
        <div class="package" style="top: 10%; left: 10%; width: 50px; height: 50px;"></div>
        <div class="package" style="top: 30%; left: 70%; width: 70px; height: 70px;"></div>
        <div class="package" style="top: 70%; left: 30%; width: 60px; height: 60px;"></div>
        <div class="package" style="top: 50%; left: 50%; width: 80px; height: 80px;"></div>
        <div class="package" style="top: 80%; left: 80%; width: 40px; height: 40px;"></div>
    </div>

    <?php
    $login = new ControladorUsuarios();
    $login->ctrIngresoUsuario();
    ?>
</body>
</html>