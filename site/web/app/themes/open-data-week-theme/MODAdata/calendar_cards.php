<?php

function moda_calendar_cards() {

// Get events
$events = moda_get_items('events',array( 'date' => 'ASC'));

// Set Values
	// first start time to last end time
	$timespan = array('9','21'); 

	// event days
	$days = array(
		'Saturday, March 3',
		'Sunday, March 4',
		'Monday, March 5',
		'Tuesday, March 6',
		'Wednesday, March 7',
		'Thursday, March 8',
		'Friday, March 9',
		'Saturday, March 10',
	); 

// Queue EB 
	echo '<script src="https://www.eventbrite.com/static/widgets/eb_widgets.js"></script>';

?>

<div class="row">

	<div class="timeslots">
	<?php
		$n=$timespan[0];
			echo '<div class="header time"> <!----> </div>';
		while($n<=$timespan[1]) {
			if($n>12) { $th = $n-12; $td = 'pm'; } else { $th = $n; $td = 'am'; }
			echo '<div class="timeslot">'.$th.':00 '.$td.'</div>';
			$n++;
		}
	?>
	</div>

	<div class="days"><div class="planwide">
		<?php
			foreach ($days as $date) {
				$date_parts = explode(',', $date);
				echo '<div class="day '.$date_parts[0].'">';
					echo '<div class="header">'.$date_parts[0].' <span>'.$date_parts[1].'</span></div>';
					foreach ($events as $id => $event) {
						$allmeta = allmeta($id);
						$type = wp_get_post_terms( $id, 'event_type')[0];
						$borough = wp_get_post_terms( $id, 'borough')[0];
						$cost = wp_get_post_terms( $id, 'cost')[0];
						$post_date = wp_get_post_terms( $id, 'date')[0];
						$clean_date = strtolower(str_replace(' ','-',str_replace(',','',$date)));
						if($post_date->slug==strtolower(str_replace(' ','-',str_replace(',','',$date)))) {
							echo '<div class="event" data-type="'.$type->slug.'" data-borough="'.$borough->slug.'" data-date="'.$clean_date.'" data-cost="'.$cost->slug.'" data-event="'.$id.'">'
									.'<span class="title" data-toggle="modal" data-target="#details'.$id.'">'.get_the_title( $id ).' </span>'
									.'<span class="time" data-toggle="modal" data-target="#details'.$id.'">'.$allmeta[cmb_pre().'time_start'].' to '.$allmeta[cmb_pre().'time_end'].' </span>'
									.'<span class="borough" data-toggle="modal" data-target="#details'.$id.'">'.$borough->name.' </span>'
									.'<a class="more" data-toggle="modal" data-target="#details'.$id.'">-Click for more details-</a>';
							if(strpos( $allmeta[cmb_pre().'register'], 'eventbrite' ) > 0 ) {
								echo '<a class="button rounded" data-toggle="modal" data-target="#register'.$id.'">Register</a>'; 
							} else { 
								echo '<a class="button rounded" href="'.$allmeta[cmb_pre().'register'].'" target="_blank">Register</a>'; 
							}
							echo '</div>';
						}
					}
				echo '</div>';
			}
		?>
	</div></div>




<? 

////// INFO MODALS ////////// 
	foreach ($events as $id => $event) {
		$allmeta = allmeta($id);
		$type = wp_get_post_terms( $id, 'event_type')[0];
		$borough = wp_get_post_terms( $id, 'borough')[0];
		$cost = wp_get_post_terms( $id, 'cost')[0];
		$post_date = wp_get_post_terms( $id, 'date')[0];
		$clean_date = strtolower(str_replace(' ','-',str_replace(',','',$date)));
		$partners = unserialize($allmeta[cmb_pre().'attached_partners']);
			$partner_list = '';
		foreach ($partners as $partner) { 
			$partner_list .= '<a href="'.get_post_meta($partner,cmb_pre().'url',true).'" target="_blank" class="circle" style="background-image: url(\''.get_the_post_thumbnail_url( $partner, 'small' ).'\')" title="'.get_the_title($partner).'"></a>';
		}

		echo '<div class="modal fade" id="details'.$id.'" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
					<div class="row">
				        <div class="col-md-7">
				        	<h5 class="title">'.get_the_title( $id ).'</h5>
				        	<h5 class="time">'.$allmeta[cmb_pre().'time_start'].' to '.$allmeta[cmb_pre().'time_end'].'</h5>
				        	<h5 class="borough">'.$borough->name.'</h5>
				        </div>
				        <div class="col-md-5 partners">
				        	'.$partner_list.'
				        </div>
				    </div>
			        <div class="col-md-12">
			        	<p class="summary">This is the summary is this is the summary is this is the summary is this is the summary is this is the summary is this is the summary is this is the summary is this is the summary.</p>
			        </div>
					<div class="row justify-content-between">
						<div class="col">
				            <span class="type" data-option="'.$type->slug.'">'.$type->name.'</span>
				        </div>
						<div class="col">';
				            if(strpos( $allmeta[cmb_pre().'register'], 'eventbrite' ) > 0 ) {
								echo '<a class="register button rounded" data-toggle="modal" data-target="#register'.$id.'">Register</a>'; 
							} else { 
								echo '<a class="register button rounded" href="'.$allmeta[cmb_pre().'register'].'" target="_blank">Register</a>'; 
							}
				        echo '</div>
				    </div>
			    </div>
			  </div>
			</div>';
	}


//////// EVENTBRITE MODALS ////////
	foreach ($events as $id => $event) {
		$allmeta = allmeta($id);
		if(strpos( $allmeta[cmb_pre().'register'], 'eventbrite' ) > 0 ) {

			$eb_event_id = eb_event_id($allmeta[cmb_pre().'register']);

			echo '<div class="modal fade" id="register'.$id.'" tabindex="-1" role="dialog" aria-hidden="true">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				        <div id="eventbrite-widget-container-'.$eb_event_id.'"></div>
				    </div>
				  </div>
				</div>

				<script type="text/javascript">
				    var exampleCallback = function() {
				        console.log(\'Order complete!\');
				    };
				    window.EBWidgets.createWidget({
				        // Required
				        widgetType: \'checkout\',
				        eventId: \''.$eb_event_id.'\',
				        iframeContainerId: \'eventbrite-widget-container-'.$eb_event_id.'\',

				        // Optional
				        iframeContainerHeight: 425,  // Widget height in pixels. Defaults to a minimum of 425px if not provided
				        onOrderComplete: exampleCallback  // Method called when an order has successfully completed
				    });
				</script>
				';
		}

	}



?>

</div>








<?php 

}

?>