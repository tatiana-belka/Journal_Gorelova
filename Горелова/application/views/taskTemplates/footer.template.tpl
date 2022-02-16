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
<div class='idheader'>
   
</div>
<hr />
</body>
</html>