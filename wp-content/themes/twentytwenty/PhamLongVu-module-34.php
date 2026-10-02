<?php

/**
 * PhamLongVu Module #34
 *
 * Widget hiển thị 3 bài viết mới nhất phía trên footer.
 *
 * @package PhamLongVu_Module_34
 */

if (! defined('ABSPATH')) {
    exit;
}


class PhamLongVu_Module_34_Widget extends WP_Widget
{

    /**
     * Khởi tạo Widget.
     */
    public function __construct()
    {

        parent::__construct(
            'phamlongvu_module_34_widget',
            'PhamLongVu Module #34',
            array(
                'description' => __(
                    'Widget hiển thị 3 bài viết mới nhất phía trên footer.',
                    'phamlongvu-module-34'
                ),
            )
        );
    }


    /**
     * Hiển thị Widget ngoài website.
     *
     * @param array $args     Widget arguments.
     * @param array $instance Widget instance.
     */
    public function widget($args, $instance)
    {

        echo $args['before_widget'];

        /*
		 * Lấy 3 bài viết mới nhất.
		 */
        $phamlongvu_module_34_posts = new WP_Query(
            array(
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'posts_per_page' => 3,
                'orderby'        => 'date',
                'order'          => 'DESC',
                'no_found_rows'  => true,
            )
        );


        /*
		 * Nếu có bài viết.
		 */
        if ($phamlongvu_module_34_posts->have_posts()) :
?>

            <div class="phamlongvu-module-34">

                <div class="phamlongvu-module-34-list">

                    <?php
                    while ($phamlongvu_module_34_posts->have_posts()) :
                        $phamlongvu_module_34_posts->the_post();
                    ?>

                        <article class="phamlongvu-module-34-item">

                            <!-- Ảnh đại diện -->
                            <a
                                href="<?php echo esc_url(get_permalink()); ?>"
                                class="phamlongvu-module-34-image"
                                aria-label="<?php echo esc_attr(get_the_title()); ?>">

                                <?php if (has_post_thumbnail()) : ?>

                                    <?php
                                    the_post_thumbnail(
                                        'medium_large',
                                        array(
                                            'class'   => 'phamlongvu-module-34-thumbnail',
                                            'loading' => 'lazy',
                                        )
                                    );
                                    ?>

                                <?php else : ?>

                                    <div class="phamlongvu-module-34-no-image">
                                        <?php
                                        echo esc_html__(
                                            'Không có ảnh',
                                            'phamlongvu-module-34'
                                        );
                                        ?>
                                    </div>

                                <?php endif; ?>

                            </a>


                            <!-- Nội dung -->
                            <div class="phamlongvu-module-34-content">

                                <!-- Tiêu đề -->
                                <h3 class="phamlongvu-module-34-title">

                                    <a href="<?php echo esc_url(get_permalink()); ?>">

                                        <?php
                                        echo esc_html(get_the_title());
                                        ?>

                                    </a>

                                </h3>


                                <!-- Người đăng + thời gian -->
                                <div class="phamlongvu-module-34-meta">

                                    <span class="phamlongvu-module-34-author">

                                        <?php
                                        echo esc_html(get_the_author());
                                        ?>

                                    </span>


                                    <span class="phamlongvu-module-34-time">

                                        <?php
                                        echo esc_html(
                                            human_time_diff(
                                                get_the_time('U'),
                                                current_time('timestamp')
                                            )
                                        );
                                        ?>

                                    </span>

                                </div>

                            </div>

                        </article>

                    <?php endwhile; ?>

                </div>

            </div>

        <?php

            wp_reset_postdata();

        else :

        ?>

            <p class="phamlongvu-module-34-empty">
                <?php
                echo esc_html__(
                    'Chưa có bài viết nào.',
                    'phamlongvu-module-34'
                );
                ?>
            </p>

<?php

        endif;


        echo $args['after_widget'];
    }
}


/* =========================================================
 * ĐĂNG KÝ WIDGET
 * ========================================================= */

function phamlongvu_module_34_register_widget()
{

    register_widget('PhamLongVu_Module_34_Widget');
}

add_action(
    'widgets_init',
    'phamlongvu_module_34_register_widget'
);
