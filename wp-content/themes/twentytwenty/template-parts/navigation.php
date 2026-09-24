<?php
/**
 * Displays the next and previous post navigation in single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 * @since Twenty Twenty 1.0
 */

$next_post = get_next_post();
$prev_post = get_previous_post();

if ( $next_post || $prev_post ) {
    $pagination_classes = '';

    if ( ! $next_post ) {
        $pagination_classes = ' only-one only-prev';
    } elseif ( ! $prev_post ) {
        $pagination_classes = ' only-one only-next';
    }
    ?>

    <nav class="pagination-single section-inner<?php echo esc_attr( $pagination_classes ); ?>" aria-label="<?php esc_attr_e( 'Post', 'twentytwenty' ); ?>" role="navigation">
        <hr class="styled-separator is-style-wide" aria-hidden="true" />
        
        <div class="custom-post-navigation">
            
            <?php if ( $next_post ) : ?>
                <!-- BÀI VIẾT TIẾP THEO (HIỂN THỊ TRƯỚC THEO THỨ TỰ THỜI GIAN) -->
                <div class="nav-item">
                    <div class="nav-date">
                        <div class="date-fraction">
                            <span class="date-day"><?php echo get_the_time('d', $next_post->ID); ?></span>
                            <hr class="date-divider">
                            <span class="date-month"><?php echo get_the_time('m', $next_post->ID); ?></span>
                        </div>
                        <span class="date-year"><?php echo get_the_time('y', $next_post->ID); ?></span>
                    </div>
                    <div class="nav-title">
                        <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">
                            <?php echo esc_html( get_the_title( $next_post->ID ) ); ?>
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ( $prev_post ) : ?>
                <!-- BÀI VIẾT TRƯỚC ĐÓ -->
                <div class="nav-item">
                    <div class="nav-date">
                        <div class="date-fraction">
                            <span class="date-day"><?php echo get_the_time('d', $prev_post->ID); ?></span>
                            <hr class="date-divider">
                            <span class="date-month"><?php echo get_the_time('m', $prev_post->ID); ?></span>
                        </div>
                        <span class="date-year"><?php echo get_the_time('y', $prev_post->ID); ?></span>
                    </div>
                    <div class="nav-title">
                        <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>">
                            <?php echo esc_html( get_the_title( $prev_post->ID ) ); ?>
                        </a>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </nav><!-- .pagination-single -->

    <?php
}