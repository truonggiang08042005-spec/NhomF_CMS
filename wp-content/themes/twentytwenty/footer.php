</div> <!-- Đóng thẻ site-main-content từ header.php -->

<style>
    /* CSS cho Footer chuẩn mẫu */
    .custom-site-footer {
        background-color: #006849;
        /* Tông màu xanh lá đậm theo ảnh */
        color: #ffffff;
        padding: 40px 20px 20px 20px;
        font-family: Arial, sans-serif;
        margin-top: 50px;
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Chia 3 cột Quick links */
    .footer-grid {
        display: flex;
        justify-content: space-between;
        gap: 30px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        padding-bottom: 30px;
    }

    .footer-col {
        flex: 1;
    }

    .footer-col-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        border-left: 3px solid #ffffff;
        padding-left: 10px;
        text-transform: capitalize;
    }

    .footer-col ul {
        list-style: none !important;
        padding: 0 !important;
        padding-left: 0 !important;
        margin: 0 !important;
        margin-left: 0 !important;
    }

    .footer-col ul li {
        margin-bottom: 8px;
        font-size: 14px;
        padding-left: 0 !important;
        margin-left: 0 !important;
        list-style-type: none !important;
    }

    .footer-col ul li a {
        color: #e0e0e0;
        text-decoration: none;
        transition: color 0.2s;
    }

    .footer-col ul li a:hover {
        color: #ffffff;
        text-decoration: underline;
    }

    /* Cột mạng xã hội và bản quyền */
    .footer-bottom {
        text-align: center;
        padding-top: 25px;
        font-size: 12px;
        color: #d0d0d0;
    }

    .footer-socials {
        margin-bottom: 15px;
    }

    .footer-socials a {
        color: #ffffff;
        text-decoration: none;
        margin: 0 10px;
        font-size: 16px;
        font-weight: bold;
    }

    .footer-copyright-text {
        line-height: 1.6;
    }
    /* Module 10 - Truong Giang */
    .truonggiang-module-10 {
        max-width: 420px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        background: #ffffff;
        padding: 15px 15px 10px 15px;
        box-sizing: border-box;
        margin: 20px auto;
        color: #222;
    }

    .truonggiang-module-10 .module-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        padding-bottom: 4px;
    }

    .truonggiang-module-10 .category-title {
        color: #d3202a;
        font-size: 20px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0;
        text-decoration: none;
    }

    .truonggiang-module-10 .category-title a {
        color: #d3202a;
        text-decoration: none;
    }

    .truonggiang-module-10 .subcategory-link {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #4a7ab5;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
    }

    .truonggiang-module-10 .subcategory-link:hover {
        color: #1a56a4;
        text-decoration: underline;
    }

    .truonggiang-module-10 .sub-icon {
        display: inline-flex;
        flex-direction: column;
        justify-content: space-between;
        width: 14px;
        height: 10px;
    }

    .truonggiang-module-10 .sub-icon span {
        display: block;
        height: 2px;
        background-color: #777;
        border-radius: 1px;
    }
    .truonggiang-module-10 .sub-icon span:first-child,
    .truonggiang-module-10 .sub-icon span:last-child {
        width:50%;
        background-color: #000;
        margin-left: auto;
    }

    /* Featured Post (Post 1: Thumbnail on left, Title on right) */
    .truonggiang-module-10 .featured-post {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        margin-bottom: 14px;
    }

    .truonggiang-module-10 .featured-thumbnail {
        flex: 0 0 135px;
        width: 135px;
        height: 90px;
        overflow: hidden;
        border-radius: 2px;
    }

    .truonggiang-module-10 .featured-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .truonggiang-module-10 .featured-title {
        flex: 1;
        margin: 0;
        font-size: 15px;
        font-weight: 600;
        line-height: 1.35;
    }

    .truonggiang-module-10 .featured-title a {
        color: #2c2c2c;
        text-decoration: none;
        display: block;
    }

    .truonggiang-module-10 .featured-title a:hover {
        color: #d3202a;
    }

    /* Danh sách các bài viết phía dưới */
    .truonggiang-module-10 .sub-posts-list {
        list-style: none !important;
        padding: 0 !important;
        margin: 14px 0 0 -20px !important;
        border-bottom: 1px solid #eaeaea;
        padding-bottom: 0px !important;
    }

    .truonggiang-module-10 .sub-post-item {
        margin-bottom: 12px;
        padding: 0;
    }

    .truonggiang-module-10 .sub-post-item:last-child {
        margin-bottom: 6px;
    }

    .truonggiang-module-10 .sub-post-item a {
        color: #333333;
        font-weight: 500;
        font-size: 14.5px;
        line-height: 1.4;
        text-decoration: none;
        display: block;
    }

    .truonggiang-module-10 .sub-post-item a:hover {
        color: #d3202a;
    }
</style>
<!-- =====================================================
     TRUONGGIANG MODULE #10 - FOOTER
     ===================================================== -->


<?php
// 1. Tìm 1 bài viết mới nhất để lấy thông tin chuyên mục
$latest_post_args = array(
    'posts_per_page' => 1,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC'
);
$latest_post_query = new WP_Query($latest_post_args);

$cat_id          = '';
$cat_name        = 'TIN TỨC'; // Tên mặc định nếu không có chuyên mục
$cat_link        = '#';
$cat_description = '';        // Biến lưu mô tả chuyên mục

if ($latest_post_query->have_posts()) {
    while ($latest_post_query->have_posts()) {
        $latest_post_query->the_post();
        
        // Lấy tất cả categories của bài viết mới nhất
        $categories = get_the_category();
        
        if (!empty($categories)) {
            $selected_cat = $categories[0];
            
            // Nếu là chuyên mục con -> lấy chuyên mục cha làm tiêu đề chính
            if ($selected_cat->category_parent != 0) {
                $parent_cat      = get_category($selected_cat->category_parent);
                $cat_id          = $parent_cat->term_id;
                $cat_name        = $parent_cat->name;
                $cat_link        = get_category_link($parent_cat->term_id);
                $cat_description = $parent_cat->description; // Lấy description của chuyên mục cha
            } else {
                // Chuyên mục chính
                $cat_id          = $selected_cat->term_id;
                $cat_name        = $selected_cat->name;
                $cat_link        = get_category_link($selected_cat->term_id);
                $cat_description = $selected_cat->description; // Lấy description của chuyên mục
            }
        }
    }
    wp_reset_postdata();
}

// 2. Truy vấn lấy 5 bài viết thuộc chuyên mục vừa tìm được
$args = array(
    'posts_per_page' => 5,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC'
);

if (!empty($cat_id)) {
    $args['cat'] = $cat_id;
}

$truonggiang_query = new WP_Query($args);

if ($truonggiang_query->have_posts()) :
    $post_count = 0;
    ?>
    <div class="truonggiang-module-10">
        <!-- Module Header -->
        <div class="module-header">
            <h2 class="category-title">
                <a href="<?php echo esc_url($cat_link); ?>"><?php echo esc_html(mb_strtoupper($cat_name, 'UTF-8')); ?></a>
            </h2>
            
            <?php if (!empty($cat_description)) : ?>
                <a href="<?php echo esc_url($cat_link); ?>" class="subcategory-link">
                    <?php echo esc_html($cat_description); ?>
                    <span class="sub-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </a>
            <?php endif; ?>
        </div>

        <?php while ($truonggiang_query->have_posts()) : $truonggiang_query->the_post(); $post_count++; ?>
            
            <?php if ($post_count === 1) : ?>
                <!-- BÀI VIẾT ĐẦU TIÊN (Ảnh + Tiêu đề) -->
                <div class="featured-post">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="featured-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <h3 class="featured-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                </div>

                <!-- BẮT ĐẦU DANH SÁCH CÁC BÀI TIẾP THEO -->
                <ul class="sub-posts-list">

            <?php else : ?>
                <!-- CÁC BÀI VIẾT TIẾP THEO (Chỉ hiển thị tiêu đề) -->
                <li class="sub-post-item">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </li>
            <?php endif; ?>

        <?php endwhile; ?>
        
        <?php if ($post_count > 1) : ?>
            </ul> <!-- Đóng danh sách sub-posts -->
        <?php endif; ?>

    </div>
    <?php
    wp_reset_postdata();
endif;
?>
<!-- =====================================================
     TONYQUYEN MODULE #23 - FOOTER
     ===================================================== -->


<!-- =====================================================
     PHAMLONGVU MODULE #34 - FOOTER
     ===================================================== -->
<?php
if (is_search()) :
?>

    <div class="site-above-footer-wrapper">

        <?php
        if (function_exists('the_widget')) {
            the_widget('LastPost_Widget');
        }
        ?>

    </div>

<?php endif; ?>

    <!-- 1. GỌI WIDGET_TEST_4 (TIN MỚI | ĐỌC NHIỀU - MODULE 23) PHÍA TRÊN FOOTER -->
    <?php 
    if ( is_home() || is_front_page() || is_archive() || is_search() || is_category() || is_tag() || is_date() || is_author() || is_single() || is_singular('post') ) : 
    ?>
        <div class="site-above-footer-wrapper" style="max-width: 1200px; margin: 30px auto 35px auto; padding: 0 15px; box-sizing: border-box;">
            <?php 
            if ( function_exists('the_widget') ) {
                the_widget('Widget_Test_4');
            }
            ?>
        </div>
    <?php endif; ?>

<div class="phamlongvu-footer-module-34">

    <?php
    the_widget(
        'PhamLongVu_Module_34_Widget',
        array(),
        array(
            'before_widget' => '',
            'after_widget'  => '',
        )
    );
    ?>

</div>

<!-- 2. KHU VỰC FOOTER CHÍNH -->
<footer class="custom-site-footer">
    <div class="footer-container">

        <div class="footer-grid">

            <!-- Cột 1: Bài viết mới (Recent Posts) -->
            <div class="footer-col">
                <div class="footer-col-title">Bài viết mới</div>
                <ul>
                    <?php
                    $recent_posts = wp_get_recent_posts(array('numberposts' => 5, 'post_status' => 'publish'));
                    foreach ($recent_posts as $post_item) : ?>
                        <li>» <a href="<?php echo get_permalink($post_item['ID']); ?>"><?php echo $post_item['post_title']; ?></a></li>
                    <?php endforeach;
                    wp_reset_query(); ?>
                </ul>
            </div>

            <!-- Cột 2: Chuyên mục (Categories) -->
            <div class="footer-col">
                <div class="footer-col-title">Chuyên mục</div>
                <ul>
                    <?php
                    $categories = get_categories(array('number' => 5));
                    foreach ($categories as $category) : ?>
                        <li>» <a href="<?php echo get_category_link($category->term_id); ?>"><?php echo $category->name; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Cột 3: Bình luận mới (Comments) -->
            <div class="footer-col">
                <div class="footer-col-title">Bình luận mới</div>
                <ul>
                    <?php
                    $comments = get_comments(array('number' => 5, 'status' => 'approve'));
                    if ($comments) :
                        foreach ($comments as $comment) : ?>
                            <li>» <a href="<?php echo get_permalink($comment->comment_post_ID); ?>"><?php echo wp_trim_words($comment->comment_content, 5); ?></a></li>
                        <?php endforeach;
                    else : ?>
                        <li>» Chưa có bình luận</li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Cột 4: Trang mới nhất (Pages) -->
            <div class="footer-col">
                <div class="footer-col-title">Trang mới nhất</div>
                <ul>
                    <?php
                    $footer_pages = get_posts(array('post_type' => 'page', 'posts_per_page' => 4, 'orderby' => 'date', 'order' => 'ASC'));
                    if (! empty($footer_pages)) :
                        foreach ($footer_pages as $fp) : ?>
                            <li>» <a href="<?php echo esc_url(get_permalink($fp->ID)); ?>"><?php echo esc_html($fp->post_title); ?></a></li>
                        <?php endforeach;
                    else : ?>
                        <li>» <a href="<?php echo esc_url(home_url('/?page_id=2')); ?>">Trang mẫu</a></li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>

        <!-- Phần Icon Mạng Xã Hội và Copyright phía dưới -->
        <div class="footer-bottom">
            <div class="footer-socials">
                <a href="#">f</a>
                <a href="#">t</a>
                <a href="#">i</a>
                <a href="#">g+</a>
                <a href="#">✉</a>
            </div>
            <div class="footer-copyright-text">
                <p><?php bloginfo('name'); ?> is a Registered Website. All rights reserved.</p>
                <p>© All right Reversed. Sunlimetech</p>
            </div>
        </div>

    </div>
</footer>

<?php wp_footer(); ?>
</body>

</html>