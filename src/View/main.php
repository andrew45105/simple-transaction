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

    <div class="row" style="margin-top: 30px">
        <div class="col-sm-4 offset-sm-4">

            <form method="post">
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Имя пользователя</label>
                    <div class="col-sm-9">
                        <input type="text" readonly class="form-control-plaintext" id="name" value="<?=$user['username'];?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="amount" class="col-sm-3 col-form-label">Баланс</label>
                    <div class="col-sm-9">
                        <input type="text" readonly class="form-control-plaintext" id="amount" value="<?=$user['amount'];?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sum" class="col-sm-3 col-form-label">Снять</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="sum" name="sum" value="0.00">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Подтвердить</button>
            </form>

        </div>
    </div>
</div>
</body>

</html>