<?php
require_once 'core/start.php';

if (isset($_POST['name']) && isset($_POST['year']) && isset($_POST['format']) && isset($_POST['actors'])) {
	list($name, $year, $format, $actors) = [ trim($_POST['name']), trim($_POST['year']), trim($_POST['format']), trim($_POST['actors']) ];
	if (mb_strlen($name) == 0)
		$err[] = 'Введите название фильма';
	elseif (mb_strlen($name) > 100)
		$err[] = 'Название фильма слишком длинное';

	if (!is_numeric($year) || mb_strlen($year) != 4)
		$err[] = 'Введите верный год выпуска';

	if (empty($config['formats'][$format]))
		$err[] = 'Выберите доступный формат из списка';

	if (empty($actors))
		$err[] = 'Укажите хотя бы одного актёра';

	if (!isset($err)) {
		addFilm($name, $year, $format, $actors);
		message('Фильм успешно добавлен');
		header('Location: /');
		exit;
	}
}

$page_title = 'Добавить фильм';
require_once HEAD;
?>
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading"><?php echo $page_title; ?></div>
            <div class="panel-body">
            <?php echo errors(); ?>
                <form class="form-horizontal" role="form" method="POST" action="">
                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Название фильма</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="year" class="col-md-4 control-label">Год выпуска</label>
                        <div class="col-md-6">
                            <input id="year" type="text" class="form-control" name="year" value="" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="format" class="col-md-4 control-label">Формат</label>
                        <div class="col-md-6">
                        	<select name="format" id="form" class="form-control">
                        		<?php foreach ($config['formats'] as $format_key => $format_name): ?>
                        		<option value="<?php echo $format_key; ?>"><?php echo $format_name; ?></option>
                        		<?php endforeach; ?>
                        	</select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="actors" class="col-md-4 control-label">Список актёров</label>
                        <div class="col-md-6">
                            <input id="actors" type="text" class="form-control" name="actors" value="" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Добавить
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#year').datetimepicker({
        format: 'YYYY'
    });
</script>
<?php

require_once FOOT;