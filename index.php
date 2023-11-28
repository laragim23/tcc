<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iara Concept</title>

    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background-color: #f2f2f2; 
        }

        .login{
            width:100%;
            height: 100vh;
            align-items: center;
            justify-content: center;
            display: flex;
        }
    </style>
</head>
<body>
    <div class="login">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 offset-lg-4">
                    <div class="card">
                        <div class="card-body">
                        <img src="assets/img/logo.png" class="mx-auto d-block img-fluid" alt="Imagem de Login" style="width: 60px;">
                        <img src="assets/img/(17).png" class="mx-auto d-block img-fluid" alt="Imagem de Login" style="width: 150px;">
                        </div>
                        <div class="card-body">
                            <form action="login.php" method="POST">
                                <div>
                                    <div class="mb-3">
                                        <label>Usuário</label>
                                        <input type="text" name="usuario" class="form-control">
                                    </div>
                                </div>
                                <div>
                                    <div class="mb-3">
                                        <label>Senha</label>
                                        <input type="password" name="senha" class="form-control">
                                    </div>
                                </div>
                                <div>
                                    <div class="mb-3 text-center">
                                        <button type="submit" class="btn btn-primary">Entrar</button>
                                    </div>
                                </div>
                            </form>
                        </div>    
                    </div>    
                </div>
            </div>
        </div>
    </div>
</body>
</html>