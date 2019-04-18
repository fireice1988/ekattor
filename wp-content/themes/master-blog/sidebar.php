<?php if ( is_active_sidebar( 'master-blog-right-sidebar' ) ) { ?>
	<aside id="sidebar" class="col-md-3">
    <div class="sidebar__inner">
		  <?php dynamic_sidebar( 'master-blog-right-sidebar' ); ?>
    </div>
	</aside>
<?php } ?>
