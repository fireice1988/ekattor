<?php
add_action('innofit_about_action','innofit_about_section');

function innofit_about_section()
{
	$about_section_enabled = get_theme_mod('home_about_section_enabled','on');
	$about_section_background = get_theme_mod('innofit_about_section_background');
	if($about_section_enabled !='off')
	{
$about_image = SPICEB_PLUGIN_URL .'inc/innofit/images/about/about.jpg';
$default = __('<div class="row v-center">
						<div class="col-md-5 col-sm-5 col-xs-12">	
							<figure class="about-thumbnail mbottom-50">	
								<img src="'.$about_image.'" alt="About">
							</figure>
						</div>
						
						<div class="col-md-7 col-sm-7 col-xs-12">
							<div class="about-content mbottom-50">
								<h6 class="entry-subtitle">Welcome to <span class="text-default">Innofit</span></h6>
								<h1 class="entry-title">We have the right solutions</h1>
								<p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totame rems aperiam, eaque ipsa quae ab illo inventore veritatis quasi architecto beatae vitaes dicta sunt explicabo. Nemo enim ipsam voluptatem.</p>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
								<div class="ptop-15"><a href="#" class="btn-ex-small btn-border">Our Story</a></div>
							</div>
						</div>
					</div>
					
				','spicebox');
			$about_section_content = get_theme_mod('about_section_content',$default);
			?> 
			<section class="section-module about bg-grey <?php if($about_section_background=='') {?> left-right-half<?php }?>"  <?php if($about_section_background!='') {?> style="background-image: url(<?php echo $about_section_background; ?>);"<?php } ?> id="about">
				<div class="container">
				<?php
			echo $about_section_content;
			?> </div>
			</section> <?php
	}
 }
?>