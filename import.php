<?php
require_once 'core/start.php';

if (isset($_FILES['file'])) {
    $file = $_FILES['file'];
    if ($file['error'] != UPLOAD_ERR_OK)
        $err[] = 'Произошла ошибка при выгрузке файла';

    if (!isset($err)) {
        $number_of_added = 0;
        $content = trim(file_get_contents($file['tmp_name']));
        foreach (array_map(function ($v) { return trim($v); }, explode("\n\n", $content)) as $film) {
            preg_match_all('/Title: (.+?)\nRelease Year: (.+?)\nFormat: (.+?)\nStars: (.+?)$/', $film, $matches);
            $film_name = $matches[1][0];
            $film_year = $matches[2][0];
            $film_format = $matches[3][0];
            $film_actors = $matches[4][0];
            addFilm($film_name, $film_year, array_search($film_format, $config['formats']), $film_actors);
            $number_of_added++;
        }
        message('Добавлено фильмов: ' . $number_of_added);
        header('Location: ?');
        exit;
    }
}

$page_title = 'Импортировать фильмы';
require_once HEAD;
?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $page_title; ?></div>
            <div class="panel-body">
            <?php echo errors(); ?>
                <form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="file" class="col-md-4 control-label">Выберите файл</label>
                        <div class="col-md-6">
                            <input type="file" name="file" class="form-control" id="file" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Загрузить
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once FOOT;