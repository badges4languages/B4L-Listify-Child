<?php
/**
 * The Template for displaying all single passports.
 *
 * @package Listify
 */
get_header(); ?>

<?php //Passports with featured image
if ( has_post_thumbnail() ){ ?>
	<div 
		<?php
		echo apply_filters(
			'listify_cover', 'page-cover page-cover--large badge-image', array( // WPCS: XSS ok.
				'size' => 'full',
			)
		);
		?>
	>
		<h1 class="page-title cover-wrapper passport-title" style="color: white;">
		<?php
			the_post();
			the_title();
			$language = get_term_by('id', get_post_meta( $post->ID,'_passport_language',true ), 'field_of_education');
			echo '<center><h3 style="color: white;">Language : '. $language->name . '</h3></center>';
			rewind_posts();
		?>
		</h1>
	</div>
<?php } 
//Passports without featured image
else { ?>
	<div>
		<h1 class="page-title cover-wrapper passport-title">
		<?php
			the_post();
			the_title();
			$language = get_term_by('id', get_post_meta( $post->ID,'_passport_language',true ), 'field_of_education');
			echo '<center><h3>Language : '. $language->name . '</h3></center>';
			rewind_posts();
		?>
		</h1>
	</div>
<?php } ?>

	

<div id="primary" class="container single-badge-content">
	<div class="row content-area">

		<?php if ( 'left' === esc_attr( listify_theme_mod( 'content-sidebar-position', 'right' ) ) ) : ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>

		<main id="main" class="site-main col-xs-12 
			<?php
			if ( 'none' !== esc_attr( listify_theme_mod( 'content-sidebar-position', 'right' ) ) && is_active_sidebar( 'widget-area-sidebar-1' ) ) :
			?>
			col-sm-7 col-md-8<?php endif; ?>" role="main">

			<?php
			while ( have_posts() ) :
				the_post();
			?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="content-box-inner">

					<?php
						$value = 'yes';
						$counter = 0;
						$counter_li = 1;
						$counter_re = 1;
						$counter_si = 1;
						$counter_sp = 1;
						$counter_wr = 1;

						//Content of the passport form
						$t_passport = array(

							 "language" => array(

									"li" => array(

										11 => "I can recognise familiar words and very basic phrases concerning myself, my family and immediate concrete surroundings when people speak slowly and clearly.",
										21 => "I can understand phrases and the highest frequency vocabulary related to areas of most immediate personal relevance (e.g. very basic personal and family information, shopping, local area, employment).
										I can catch the main point in short, clear, simple messages and announcements. ",
										31 => "I can understand the main points of clear standard speech on familiar matters regularly encountered in work, school, leisure, etc.
										I can understand the main point of many radio or TV programmes on current affairs or topics of personal or professional interest when the delivery is relatively slow and clear. ",
										41 => "I can understand extended speech and lectures and follow even complex lines of argument provided the topic is reasonably familiar.
										I can understand most TV news and current affairs programmes. I can understand the majority of films in standard dialect. ",
										51 => "I can understand extended speech even when it is not clearly structured and when relationships are only implied and not signalled explicitly.
										I can understand television programmes and films without too much effort. ",
										61 => "I have no difficulty in understanding any kind of spoken language, whether live or broadcast, even when delivered at fast native speed, provided.
										I have some time to get familiar with the accent. "
									),
									"re" => array(
										11 => "I can understand familiar names, words and very simple sentences, for example on notices and posters or in catalogues.",
										21 => "I can read very short, simple texts.
										I can find specific, predictable information in simple everyday material such as advertisements, prospectuses, menus and timetables and I can understand short simple personal letters. ",
										31 => "I can understand texts that consist mainly of high frequency everyday or job-related language.
										I can understand the description of events, feelings and wishes in personal letters. ",
										41 => "I can read articles and reports concerned with contemporary problems in which the writers adopt particular attitudes or viewpoints.
										I can understand contemporary literary prose. ",
										51 => "I can understand long and complex factual and literary texts, appreciating distinctions of style.
										I can understand specialised articles and longer technical instructions, even when they do not relate to my field. ",
										61 => "I can read with ease virtually all forms of the written language, including abstract, structurally or linguistically complex texts such as manuals, specialised articles and literary works."
									),
									"si" => array(
										11 => "I can interact in a simple way provided the other person is prepared to repeat or rephrase things at a slower rate of speech and help me formulate what I'm trying to say.
										I can ask and answer simple questions in areas of immediate need or on very familiar topics. ",
										21 => "I can communicate in simple and routine tasks requiring a simple and direct exchange of information on familiar topics and activities.
										I can handle very short social exchanges, even though I can't usually understand enough to keep the conversation going myself. ",
										31 => "I can deal with most situations likely to arise whilst travelling in an area where the language is spoken.
										I can enter unprepared into conversation on topics that are familiar, of personal interest or pertinent to everyday life (e.g. family, hobbies, work, travel and current events). ",
										41 => "I can interact with a degree of fluency and spontaneity that makes regular interaction with native speakers quite possible.
										I can take an active part in discussion in familiar contexts, accounting for and sustaining my views. ",
										51 => "I can express myself fluently and spontaneously without much obvious searching for expressions.
										I can use language flexibly and effectively for social and professional purposes.
										I can formulate ideas and opinions with precision and relate my contribution skilfully to those of other speakers. ",
										61 => "I can take part effortlessly in any conversation or discussion and have a good familiarity with idiomatic expressions and colloquialisms.
										I can express myself fluently and convey finer shades of meaning precisely.
										If I do have a problem I can backtrack and restructure around the difficulty so smoothly that other people are hardly aware of it. "
									),
									"sp" => array(
										11 => "I can use simple phrases and sentences to describe where I live and people I know.",
										21 => "I can use a series of phrases and sentences to describe in simple terms my family and other people, living conditions, my educational background and my present or most recent job.",
										31 => "I can connect phrases in a simple way in order to describe experiences and events, my dreams, hopes and ambitions.
										I can briefly give reasons and explanations for opinions and plans.
										I can narrate a story or relate the plot of a book or film and describe my reactions. ",
										41 => "I can present clear, detailed descriptions on a wide range of subjects related to my field of interest.
										I can explain a viewpoint on a topical issue giving the advantages and disadvantages of various options. ",
										51 => "I can present clear, detailed descriptions of complex subjects integrating sub-themes, developing particular points and rounding off with an appropriate conclusion.",
										61 => "I can present a clear, smoothly-flowing description or argument in a style appropriate to the context and with an effective logical structure which helps the recipient to notice and remember significant points. "
									),
									"wr" => array(
										11 => "I can write a short, simple postcard, for example sending holiday greetings.
										I can fill in forms with personal details, for example entering my name, nationality and address on a hotel registration form. ",
										21 => "I can write short, simple notes and messages relating to matters in areas of immediate needs.
										I can write a very simple personal letter, for example thanking someone for something. ",
										31 => "I can write simple connected text on topics which are familiar or of personal interest.
										I can write personal letters describing experiences and impressions. ",
										41 => "I can write clear, detailed text on a wide range of subjects related to my interests.
										I can write an essay or report, passing on information or giving reasons in support of or against a particular point of view.
										I can write letters highlighting the personal significance of events and experiences. ",
										51 => "I can express myself in clear, well-structured text, expressing points of view at some length.
										I can write about complex subjects in a letter, an essay or a report, underlining what I consider to be the salient issues.
										I can select style appropriate to the reader in mind. ",
										61 => "I can write clear, smoothly-flowing text in an appropriate style.
										I can write complex letters, reports or articles which present a case with an effective logical structure which helps the recipient to notice and remember significant points.
										I can write summaries and reviews of professional or literary works."
									),
								)

							);

						?>

						<?php
							//Listening level
							$i = 0;
							while($i <= 5 && in_array( $value.$i, get_post_meta( $post->ID, "_passport", true ) ) ){
								$i++;
							}
							$level_li = get_result($i);

							//Reading level
							$i = 6;
							$lvl = 0;
							while($i <= 11 && in_array( $value.$i, get_post_meta( $post->ID, "_passport", true ) ) ){
								$i++;
								$lvl++;
							}
							$level_re = get_result($lvl);

							//Spoken Interaction level
							$i = 12;
							$lvl = 0;
							while($i <= 17 && in_array( $value.$i, get_post_meta( $post->ID, "_passport", true ) ) ){
								$i++;
								$lvl++;
							}
							$level_si = get_result($lvl);

							//Spoken Production level
							$i = 18;
							$lvl = 0;
							while($i <= 23 && in_array( $value.$i, get_post_meta( $post->ID, "_passport", true ) ) ){
								$i++;
								$lvl++;
							}
							$level_sp = get_result($lvl);

							//Writing level
							$i = 24;
							$lvl = 0;
							while($i <= 29 && in_array( $value.$i, get_post_meta( $post->ID, "_passport", true ) ) ){
								$i++;
								$lvl++;
							}
							$level_wr = get_result($lvl);
						?>

						<p>
							"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
							Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
							Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
							Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
						</p>

						<!-- Result of the student levels in each section -->
						<div id="result_content">
							<center><h1>Current Result</h1></center>
							<?php
								echo "Listening level : " . $level_li . "<br>";
								echo "Reading level : " . $level_re . "<br>";
								echo "Spoken Interaction level : " . $level_si . "<br>";
								echo "Spoken Production level : " . $level_sp . "<br>";
								echo "Writing level : " . $level_wr . "<br>";
							?>
						</div>

						<div id="error-content">
							
						</div>

						<script>
					        jQuery(document).ready(function(jQuery) {
						        jQuery('#tabs').tabs();
						        jQuery(".nav-tab").click(function(){
							        jQuery(".nav-tab").removeClass("nav-tab-active");
							        jQuery(this).addClass("nav-tab-active");
					        	});
					        });
					    </script>
					    
					    <!-- Form to update the passport (display the content above) -->
					    <form action="" id="save-passport-form" method="POST">

							<div id="tabs" style="border: 0px;">

								<h2 class="nav-tab-wrapper">
						        	<ul id="passport-list">
							            <li style="border: 0px;"><a href="#tabs-1" class="nav-tab nav-tab-active"><?php _e( 'Listening','b4l-portofolio' ); ?></a></li>
							            <li style="border: 0px;"><a href="#tabs-2" class="nav-tab"><?php _e( 'Reading','b4l-portofolio' ); ?></a></li>
							            <li style="border: 0px;"><a href="#tabs-3" class="nav-tab"><?php _e( 'Spoken Interaction','b4l-portofolio' ); ?></a></li>
										<li style="border: 0px;"><a href="#tabs-4" class="nav-tab"><?php _e( 'Spoken Production','b4l-portofolio' ); ?></a></li>
										<li style="border: 0px;"><a href="#tabs-5" class="nav-tab"><?php _e( 'Writing','b4l-portofolio' ); ?></a></li>
						          	</ul>
								</h2>

								<div id="tabs-1" style="border: 0px;">
									<?php
										for($i = 0 ; $i < count($t_passport["language"]["li"]); $i++){
											echo '<br>'.  '<input type="checkbox" name="passport[]" id="li'.$counter_li.'" value="'.$value.$counter.'" style="margin-left: 30px;" ' . check_passport($value.$counter) . '>' .  $t_passport["language"]["li"][$i+1 . 1]. '</br>';
											$counter++;
											$counter_li++;
										}
									?>
								</div>

								<div id="tabs-2" style="border: 0px;">
									<?php
										for($i = 0 ; $i < count($t_passport["language"]["re"]); $i++){
											echo '<br>'.  '<input type="checkbox" name="passport[]" id="re'.$counter_re.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_passport($value.$counter) . '>' .  $t_passport["language"]["re"][$i+1 . 1]. '</br>';
											$counter++;
											$counter_re++;
										}
									?>
								</div>

								<div id="tabs-3" style="border: 0px;">
									<?php
										for($i = 0 ; $i < count($t_passport["language"]["si"]); $i++){
											echo '<br>'.  '<input type="checkbox" name="passport[]" id="si'.$counter_si.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_passport($value.$counter) . '>' .  $t_passport["language"]["si"][$i+1 . 1]. '</br>';
											$counter++;
											$counter_si++;
										}
									?>

								</div>

								<div id="tabs-4" style="border: 0px;">
									<?php
										for($i = 0 ; $i < count($t_passport["language"]["sp"]); $i++){
											echo '<br>'.  '<input type="checkbox" name="passport[]" id="sp'.$counter_sp.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_passport($value.$counter) . '> ' .  $t_passport["language"]["sp"][$i+1 . 1]. '</br>';
											$counter++;
											$counter_sp++;
										}
									?>
								</div>

								<div id="tabs-5" style="border: 0px;">
									<?php
										for($i = 0 ; $i < count($t_passport["language"]["wr"]); $i++){
											echo '<br>'.  '<input type="checkbox" name="passport[]" id="wr'.$counter_wr.'" value="'.$value.$counter.'"style="margin-left: 30px;" ' . check_passport($value.$counter) . '> ' .  $t_passport["language"]["wr"][$i+1 . 1]. '</br>';
											$counter++;
											$counter_wr++;
										}
									?>
								</div>

							</div>

							<input type="hidden" name="postID" id="postID" value="<?php echo $post->ID; ?>" />

							<button type="submit" class="button button-small passport-save-button">Save Portfolio</button>
						</form>

						<!-- Delete a passport form (just a button) -->
						<form action="" id="delete-passport-form" method="POST">

							<input type="hidden" name="postID" id="postID" value="<?php echo $post->ID; ?>" />

							<button type="submit" class="button button-small passport-delete-button">Delete Portfolio</button>

						</form>
						
					</div>

					<!-- Change the passport thumbnail form -->
					<div id="portfolio-cover">
						<h3>Portfolio's cover</h3>
						<form action="" id="thumbnail-passport-form" method="POST">

							<input type="hidden" name="postID" id="postID" value="<?php echo $post->ID; ?>" />

							<input id="thumbnail" accept=".png, .jpeg, .jpg" type="file"/>

							<button type="submit" class="button button-small">Change portfolio's image</button>

						</form>
						
						<div id="result_upload_files">
							
						</div>
					</div>

				</article><!-- #post-## -->

			<?php endwhile; ?>

		</main>
	</div>

</div>

<?php get_footer(); ?>
