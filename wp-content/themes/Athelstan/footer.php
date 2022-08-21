<footer id="footer" class="site-footer bg-23">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-6 infor">
				<img class="logo" src="<?php echo get_field('logo_footer','option')['url'] ?>" alt="<?php echo get_field('logo_footer','option')['alt'] ?>">
				<div class="connect d-flex">
					<?php $connect=get_field('link_connect','option');
					if($connect):
						foreach($connect as $cnt):
					?>
					<a href="<?php echo $cnt['link'] ?>"><?php echo $cnt['icon'] ?></a>
					<?php endforeach;endif; ?>
				</div>
				<img class="noti" src="<?php echo get_field('noti_footer','option')['url'] ?>" alt="<?php echo get_field('noti_footer','option')['alt'] ?>">
			</div>
			<?php $thePages=get_field('the_column','option');
			if($thePages):
				foreach($thePages as $pages):
			?>
			<div class="col-lg-3 col-6 pages">
				<h3 class="title fs-18 color-main"><?php echo $pages['title'] ?></h3>
				<ul>
					<?php $linkPages=$pages['the_pages'];
					if($linkPages):
					foreach ($linkPages as $link):
					?>
					<li><a href="<?php echo $link['link'] ?>"><?php echo $link['title'] ?></a></li>
					<?php endforeach;endif; ?>
				</ul>
			</div>
			<?php endforeach;endif; ?>
		</div>
	</div>
</footer>


<?php wp_footer(); ?>

</body>
</html>
