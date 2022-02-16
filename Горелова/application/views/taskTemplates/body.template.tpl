<?php
	foreach ($data['records'] as $record) {
		?>
		<div class="comment">
			<p class="msgid">#<?php echo $record['msgid'];?></p>
			<p class="author-name">Author: <?php echo $record['username'];?></p>
			<p class="time">Time: {<?php echo $record['postdate']; ?>}</p><br />
			<p class="homepage">home: <?php echo $record['homepage'];?></p>
			<p class="mail">mail: <?php echo $record['email']; ?></p>
			<p class="ip">ip: [<?php echo $record['ip']?>]</p>
			<p class="useragent">user-agent: <?php echo $record['useragent'];?></p>
			<hr>
			<p class="message">
				<?php echo $record['message']; ?>
			</p>
		</div>
		<?php
	}
?>