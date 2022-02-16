
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="/css/style.task.css" />
        <title>Тестовое задание</title>
        <script src="/js/jquery-1.6.2.js" type="text/javascript"></script>
    </head>
    <body>
        <header class='idheader'>
            
        </header>
        
        <div class='options'>
	        <hr />
	        Опции:
	        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
	            Порядок вывода:
		        <?php if ($data['sortOrder'] == '0') :?>
	                <p><input type="radio" name="sortOrder" value="0" >С конца</p>
	                <p><input type="radio" name="sortOrder" value="1" checked="checked">C начала</p>
		        <?php else: ?>
			        <p><input type="radio" name="sortOrder" value="0" checked="checked">С конца</p>
			        <p><input type="radio" name="sortOrder" value="1">C начала</p>
		        <?php endif; ?>
	            Сортировка по:
	            <p><input type="radio" name="sortElem" value="0"
		            <?php if ($data['sortElem'] == '0') : ?>
	                        checked="checked"<?php endif; ?>>Дате</p>
	            <p><input type="radio" name="sortElem" value="1"
		            <?php if ($data['sortElem'] == '1') : ?>
		                    checked="checked"<?php endif; ?>>Имени</p>
	            <p><input type="radio" name="sortElem" value="2"
			            <?php if ($data['sortElem'] == '2') : ?>checked="checked"<?php endif; ?>>e-mail</p>
				<p><button>Save</button></p>
	        </form>
	        <hr />
        </div>
        
        <div class="sendData">
	        <hr />
	        <form action="/task/savepost" method="POST">
	            <p class="captcha"> Captcha: <input name="captcha"><img src="/application/views/capcha/capcha.php"></p>
	            <p><input type="hidden" name="secret" value="you"></p>
	            <p>Ваше имя: <input name="user"></p>
		        <p>Ваш e-mail: <input name="mail"></p>
		        <p>Ваш сайт: <input name="homepage"></p>
	            <p><textarea id='find' value="text" rows="10" cols="30" name="datatext" maxlength="600">Вводите данные</textarea></p>
	            <p><input type="submit" value="Отправить"></p>
	        </form>
        </div>
        <nav class="pagination">
	        <ul>
	        <?php
				if (array_key_exists('number_of_page', $data)) {
					$numbers = $data['number_of_page'];
					for($i = 0; $i < $numbers; $i++) { ?>
						<li>
							<a href="/task/index/<?php echo $i; ?>">[<?php echo $i; ?>]</a>
						</li>
			        <?php
					}?>
					<li>
		                <a href="/task/index/#">&rArr;</a>
		            </li>
		            <?
				}
	        ?>
	        </ul>
        </nav>