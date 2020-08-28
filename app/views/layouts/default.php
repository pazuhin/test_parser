<!DOCTYPE html>
<html lang="ru">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="../../../public/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="../../../public/css/style.css">
</head>

<body>
<button style="margin: 20px" class="btn btn-success" id="parse">Получить даные</button>
<div class="content-fluid">
    <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
            <form style="margin-top: 100px">
                <div class="form-group">
                    <label for="inputDate">Введите дату:</label>
                    <input id="date" name="date" type="date" class="form-control">
                    <button style="margin-top: 20px" class="btn btn-success" id="inputDate">Выбрать</button>
                </div>
            </form>
            <?php if ($groupFilms) :?>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <td>Позиция</td>
                        <td>Постер</td>
                        <td>Название</td>
                        <td>Рейтинг</td>
                        <td>Голосов</td>
                        <td>Средний балл</td>
                        <td>Год</td>
                    </tr>
                    </thead>
                    <?php foreach ($groupFilms as $group => $films) { ?>
                    <tbody>
                        <tr>
                            <th><?=$group?></th>
                        </tr>
                        <?php foreach ($films as $film):?>
                            <tr>
                                <td><?= $film['pos'] ?></td>
                                <td>
                                    <img src="public/imgs/<?= $film['img'] ?>" alt="">
                                </td>
                                <td><?= $film['name'] ?></td>
                                <td><?= $film['rait'] ?></td>
                                <td><?= $film['votes'] ?></td>
                                <td><?= $film['score'] ?></td>
                                <td><?= $film['year'] ?></td>
                            </tr>

                        <?php endforeach;?>
                    </tbody>
                    <?php } ?>
                </table>
            <?php else:?>
                <div class="alert alert-info">
                    <p>
                        Данные за выбранный день не найдены
                    </p>
                </div>
            <?php endif;?>
        </div>
        <div class="col-xs-6 col-md-4"></div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="../../../public/js/jquery-1.11.0.min.js"></script>
<script src="../../../public/js/bootstrap.min.js"></script>
<script src="../../../public/js/main.js"></script>
</body>
</html>