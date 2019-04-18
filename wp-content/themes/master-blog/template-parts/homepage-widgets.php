<?php if ( is_active_sidebar( 'master-blog-homepage-area' ) ) { ?>
	<div class="homepage-widget-area"> 
		<?php
		dynamic_sidebar( 'master-blog-homepage-area' );
		?>
	</div>
<?php
}
