<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?=$title;?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <div class="page-wrapper">

        <h1 style="text-align: center"><?=$title;?></h1>

        <div class="row">
            <div class="col-sm-2 offset-sm-5">

                <form method="post">
                    <div class="form-group">
                        <label for="login">Логин</label>
                        <input type="text" class="form-control" id="login" name="login">
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Войти</button>
                </form>

            </div>
        </div>
    </div>
</body>

</html>
