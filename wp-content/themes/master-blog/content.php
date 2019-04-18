<article class="news-item-content col-md-6">
	<div <?php post_class(); ?>>                    
		<div class="news-item text-center">
			<div class="news-text-wrap">
				<?php 
        if( 0 === $wp_query->current_post  ){ 
          master_blog_thumb_img( 'master-blog-single', '', true ); 
        } else {
          master_blog_thumb_img( 'master-blog-archive', '', true ); 
        }
        ?>
            <?php master_blog_widget_date_comments(); ?>
						<span class="author-meta">
							<span class="author-meta-by"><?php esc_html_e( 'By', 'master-blog' ); ?></span>
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ) ); ?>">
								<?php the_author(); ?>
							</a>
						</span>	
						<h2>
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h2>
						<?php
						$categories_list = get_the_category_list( ' ' );
						// Make sure there's more than one category before displaying.
						if ( $categories_list ) {
							echo '<div class="cat-links">' . wp_kses_data( $categories_list ) . '</div>';
						}
						?>
            						
						<div class="post-excerpt">
							<?php the_excerpt(); ?>
						</div><!-- .post-excerpt -->
            <div class="read-more-button">
    					<a href="<?php the_permalink(); ?>">
    						<?php esc_html_e( 'Read More', 'master-blog' ); ?>
    					</a>
    					</h2>
    				</div><!-- .read-more-button -->
				</div>
			</div><!-- .news-item -->
   </div>   
</article>
