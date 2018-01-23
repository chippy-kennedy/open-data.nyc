<div id="content">

	<?
	$about = get_option('about_details');
	?>
	<div class="row section-about justify-content-between align-items-center">
		<div class="col-xl-12">
			<h2 class="section_title red text-center text-uppercase circles-above">About Us</h2>
		</div>
		<div class="info col-sm-12 col-md-6">
			<h2 class="text-center font-weight-light"><?= $about[cmb_pre().'headline']; ?></h2>
			<h5 class="font-weight-light"><?= $about[cmb_pre().'content']; ?></h5>
		</div>
		<div class="col-sm-12 col-md-5 md-push-1">
			<?= wp_oembed_get( $about[cmb_pre().'video'], array('width'=>800) ); ?>
		</div>
	</div>

	<div class="row section-calendar">
		<div class="col-xl-12">
			<h2 class="section_title red text-center text-uppercase circles-above">Calendar of Events</h2>
		</div>
		<div class="col-xl-12 blue-border">
			<?=moda_events_calendar();?>
		</div>
	</div>

	<div class="row section-partners">
		<div class="container blue-bg circles-above">
			<div class="col-xl-12">
				<h2 class="section_title white text-center text-uppercase">Partners</h2>
			</div>
			<div class="col-xl-12">
				<?=moda_display_partners();?>
			</div>
		</div>
	</div>

	<div class="row section-socialize lightestgrey-bg circles-above circles-high justify-content-center">
		<div class="contact col-sm-12 col-md-12 yellow-bg rounded">			
			<h3 class="white text-center">Drop us a line.</h3>
			<?=do_shortcode('[contact-form-7 id="23" title="Contact form 1"]');?>
		</div>
	</div>

	<div class="row section-news">
		<div class="container blue-bg">
			<div class="col-xl-12">
				<h2 class="section_title white text-center text-uppercase circles-above">Open Data News</h2>
			</div>
			<div class="col-xl-12">
				<?=moda_display_news();?>
			</div>
		</div>
	</div>

	<div class="row section-sponsors blue-border text-center justify-content-center">
		<h4 class="section_title font-italic">Open Data Week is brought to you by</h4>
		<div class="sponsors row col-xl-12 text-center justify-content-around align-items-center">
			<?php 	
				$sponsors = moda_get_items('sponsors');
				foreach($sponsors as $id=>$sponsor) {
					echo '<a href="#"><img src="'.get_the_post_thumbnail_url( $id, 'medium' ).'" 
					alt="'.$sponsor->post_title.'" /></a>';
				} 
			?>
		</div>
	</div>

	<div class="row section-coordinate circle-bg justify-content-center">
		<h5 class="rounded blurb text-center white-bg circles-above circles-high">
			Interested in putting on an event or adding your existing event to our list?<br />
			<a href="#"><strong>Click here</strong> to email our coordinator</a>.
		</h5>
		<div class="newsletter col-xl-12 text-center">
			<h4 class="text-uppercase"><strong>Stay up to date on all things NYC Open Data</strong></h4>
			<?=moda_newsletter_form();?>
		</div>
	</div>

</div>