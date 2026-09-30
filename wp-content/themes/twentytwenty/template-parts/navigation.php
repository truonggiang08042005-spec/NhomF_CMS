<?php
$next_post = get_next_post();
$prev_post = get_previous_post();

if ( $next_post || $prev_post ) :
?>
	<div class="custom-post-navigation">
		
		<?php if ( $prev_post ) : ?>
			<a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="nav-item">
				<div class="nav-date">
					<div class="date-fraction">
						<span class="date-day"><?php echo get_the_time( 'd', $prev_post->ID ); ?></span>
						<span class="date-divider"></span>
						<span class="date-month"><?php echo get_the_time( 'm', $prev_post->ID ); ?></span>
					</div>
					<span class="date-year"><?php echo get_the_time( 'y', $prev_post->ID ); ?></span>
				</div>
				<div class="nav-title">
					<?php echo get_the_title( $prev_post->ID ); ?>
				</div>
			</a>
		<?php endif; ?>

		<?php if ( $next_post ) : ?>
			<a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="nav-item">
				<div class="nav-date">
					<div class="date-fraction">
						<span class="date-day"><?php echo get_the_time( 'd', $next_post->ID ); ?></span>
						<span class="date-divider"></span>
						<span class="date-month"><?php echo get_the_time( 'm', $next_post->ID ); ?></span>
					</div>
					<span class="date-year"><?php echo get_the_time( 'y', $next_post->ID ); ?></span>
				</div>
				<div class="nav-title">
					<?php echo get_the_title( $next_post->ID ); ?>
				</div>
			</a>
		<?php endif; ?>

	</div>
<?php endif; ?>