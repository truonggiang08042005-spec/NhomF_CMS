<?php
/**
 * The template for displaying all single posts (Detail page)
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 */

get_header();
?>

<style>
    /* Layout 3 cột chuẩn hình thiết kế "Trang chi tiết": Left (Categories) | Center (Detail) | Right (Recent Posts) */
    .page-three-column-layout {
        max-width: 1280px;
        margin: 30px auto;
        padding: 0 15px;
        display: flex;
        gap: 25px;
        align-items: flex-start;
        box-sizing: border-box;
    }

    /* Cột bên trái: Categories (9) */
    .left-sidebar-column {
        width: 270px;
        min-width: 270px;
    }

    /* Cột ở giữa: Detail (6) (Chi tiết sản phẩm) */
    .center-content-column {
        flex: 1;
        min-width: 0;
    }

    /* Cột bên phải: Recent post (10) */
    .right-sidebar-column {
        width: 270px;
        min-width: 270px;
    }

    @media (max-width: 1024px) {
        .page-three-column-layout {
            flex-direction: column;
        }
        .left-sidebar-column,
        .right-sidebar-column {
            width: 100%;
            min-width: 100%;
        }
    }

    /* Khung chứa bài viết chi tiết */
    .detail-post-container {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 30px 35px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    /* Khung Header: Tiêu đề + Huy hiệu Đồng hồ (Date Badge) */
    .detail-header-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        position: relative;
    }

    /* Tiêu đề bài viết */
    .detail-post-title {
        font-size: 26px;
        font-weight: 700;
        color: #111827;
        line-height: 1.35;
        margin: 0;
        flex: 1;
        text-align: left;
        font-family: Arial, "Helvetica Neue", sans-serif;
    }

    /* Huy hiệu Đồng hồ Ngày/Tháng/Năm (Hình tròn màu vàng) */
    .detail-clock-badge {
        width: 60px;
        height: 60px;
        min-width: 60px;
        background: #f2be1a;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.16);
        flex-shrink: 0;
        user-select: none;
        color: #1f2937;
        font-family: "Georgia", "Times New Roman", serif;
        margin-top: -3px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .detail-clock-badge:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.22);
    }

    .clock-badge-inner {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2px;
    }

    .clock-fraction-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }

    .clock-day {
        font-size: 13px;
        font-weight: 600;
        line-height: 1;
        padding-bottom: 2px;
    }

    .clock-divider-line {
        width: 16px;
        height: 1.2px;
        background-color: #2b2b2b;
        margin: 1px 0;
    }

    .clock-month {
        font-size: 13px;
        font-weight: 600;
        line-height: 1;
        padding-top: 2px;
    }

    .clock-year {
        font-size: 12.5px;
        font-weight: 600;
        line-height: 1;
        margin-left: 1px;
        align-self: center;
    }

    /* Đường gạch ngang phân cách có mũi nhọn (Notch divider) */
    .detail-divider {
        position: relative;
        width: 100%;
        height: 1px;
        background-color: #e5e7eb;
        margin: 22px 0 25px 0;
    }

    .detail-divider::before {
        content: "";
        position: absolute;
        top: -5px;
        left: 40px;
        width: 9px;
        height: 9px;
        background-color: #ffffff;
        border-top: 1px solid #e5e7eb;
        border-left: 1px solid #e5e7eb;
        transform: rotate(45deg);
    }

    /* Nội dung chi tiết bài viết */
    .detail-content {
        color: #374151;
        font-size: 15.5px;
        line-height: 1.75;
    }

    .detail-excerpt,
    .detail-excerpt p,
    .detail-content.no-excerpt > p:first-of-type {
        font-style: italic;
        color: #4b5563;
        font-size: 15.5px;
        line-height: 1.7;
        margin-bottom: 20px;
    }

    .detail-content p {
        margin-bottom: 18px;
    }

    .detail-content img {
        max-width: 100%;
        height: auto;
        border-radius: 6px;
        margin: 18px 0;
    }

    /* Widget Categories (Trái) & Widget Recent post (Phải) */
    .categories-widget-box,
    .recent-posts-widget-box {
        background-color: #ededed;
        background-image: repeating-linear-gradient(45deg, #f4f4f4, #f4f4f4 10px, #e9e9e9 10px, #e9e9e9 20px);
        padding: 22px 18px;
        border-radius: 4px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
    }

    .widget-title-styled {
        font-size: 24px !important;
        font-weight: 800 !important;
        color: #1a1a1a !important;
        margin: 0 0 6px 0 !important;
        padding: 0 !important;
        border: none !important;
        text-transform: none !important;
        letter-spacing: -0.4px !important;
        line-height: 1.2 !important;
    }

    .widget-striped-bar {
        width: 100%;
        height: 14px;
        margin-top: 8px;
        margin-bottom: 16px;
        background: repeating-linear-gradient(
            -45deg,
            #d5d5d5,
            #d5d5d5 3px,
            #e9e9e9 3px,
            #e9e9e9 6px
        );
        border-radius: 1px;
    }

    .widget-white-box {
        background: #ffffff;
        padding: 8px 16px;
        border-radius: 2px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .widget-white-box ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .widget-white-box ul li {
        display: flex;
        align-items: center;
        padding: 12px 0;
        margin: 0;
        border-bottom: 1px solid #f0f0f0;
        list-style: none;
        font-size: 14.5px;
    }

    .widget-white-box ul li:last-child {
        border-bottom: none;
    }

    .categories-white-box ul li::before {
        content: "";
        display: inline-block;
        width: 8px;
        height: 8px;
        min-width: 8px;
        background-color: #f5b025;
        border-radius: 50%;
        margin-right: 12px;
    }

    .categories-white-box ul li a {
        color: #5587b7;
        text-decoration: none;
        font-weight: 500;
        font-size: 14.5px;
        transition: color 0.2s ease-in-out;
    }

    .categories-white-box ul li a:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    /* ==========================================================================
       Widget Recent Post (#10 Phía bên phải) - Thiết kế chuẩn mẫu
       ========================================================================== */
    .recent-posts-teal-card {
        background-color: #45b5b4;
        border-radius: 4px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
    }

    .recent-posts-teal-list {
        padding: 20px 18px 10px 18px;
    }

    .recent-post-teal-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 15px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.22);
    }

    .recent-post-teal-item:last-child {
        border-bottom: none;
    }

    .recent-teal-date-badge {
        display: flex;
        align-items: center;
        gap: 3px;
        color: #ffffff;
        min-width: 50px;
        font-family: Arial, "Helvetica Neue", sans-serif;
        user-select: none;
    }

    .recent-teal-date-fraction {
        display: flex;
        flex-direction: column;
        align-items: center;
        line-height: 1;
    }

    .recent-teal-date-day {
        font-size: 13px;
        font-weight: 700;
        line-height: 1;
        padding-bottom: 2px;
    }

    .recent-teal-date-line {
        width: 17px;
        height: 1.5px;
        background-color: #ffffff;
        margin: 1px 0;
    }

    .recent-teal-date-month {
        font-size: 13px;
        font-weight: 700;
        line-height: 1;
        padding-top: 2px;
    }

    .recent-teal-date-year {
        font-size: 13px;
        font-weight: 700;
        line-height: 1;
        align-self: center;
        margin-left: 1px;
    }

    .recent-post-teal-title {
        flex: 1;
        font-size: 13.5px;
        line-height: 1.45;
        margin: 0;
    }

    .recent-post-teal-title a {
        color: #ffffff !important;
        text-decoration: none !important;
        font-weight: 400;
        transition: opacity 0.2s ease;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .recent-post-teal-title a:hover {
        opacity: 0.85;
        text-decoration: underline !important;
    }

    .recent-posts-btn-banner {
        display: block;
        background-color: #3ba3a2;
        color: #ffffff !important;
        text-align: center;
        padding: 16px 10px;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        text-decoration: none !important;
        transition: background-color 0.2s ease;
    }

    .recent-posts-btn-banner:hover {
        background-color: #2e8b89;
    }
</style>

<div class="detail-page-wrapper" style="max-width: 1280px; margin: 30px auto; padding: 0 15px; box-sizing: border-box;">

    <!-- 1. BỐ CỤC 3 CỘT (MIDDLE): Categories (9) | Detail (6) | Recent post (10) -->
    <div class="page-three-column-layout" style="max-width: 100%; margin: 0 0 25px 0;">
        
        <!-- CỘT BÊN TRÁI: Categories (9) -->
        <div class="left-sidebar-column">
            <aside class="categories-widget-box">
                <h3 class="widget-title-styled">Categories</h3>
                <div class="widget-striped-bar"></div>
                <div class="widget-white-box categories-white-box">
                    <ul>
                        <?php
                        $all_categories = get_categories( array(
                            'hide_empty' => false,
                            'orderby'    => 'name',
                            'order'      => 'ASC'
                        ) );

                        if ( ! empty( $all_categories ) ) :
                            foreach ( $all_categories as $cat ) : ?>
                                <li>
                                    <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>">
                                        <?php echo esc_html( $cat->name ); ?>
                                    </a>
                                </li>
                            <?php endforeach;
                        else : ?>
                            <li><a href="#">Uncategorized</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </aside>
        </div>

        <!-- CỘT Ở GIỮA: Detail (6) (Chi tiết sản phẩm/bài viết) -->
        <div class="center-content-column">
            <div style="margin-bottom: 20px;">
                <a href="<?php echo esc_url( home_url('/') ); ?>" style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background-color: #f1f5f9; color: #2a6fbe; text-decoration: none; font-weight: 600; font-size: 13.5px; border-radius: 6px;">
                    &larr; Quay lại danh sách sản phẩm
                </a>
            </div>

            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); 
                    $day   = get_the_date('d');
                    $month = get_the_date('m');
                    $year  = get_the_date('y');
                    $has_custom_excerpt = has_excerpt();
                ?>
                    <article class="detail-post-container" id="post-<?php the_ID(); ?>">
                        <!-- Header: Tiêu đề và Đồng hồ Ngày/Tháng -->
                        <div class="detail-header-wrapper">
                            <h1 class="detail-post-title"><?php the_title(); ?></h1>

                            <div class="detail-clock-badge" title="Ngày đăng: <?php echo esc_attr( get_the_date('d/m/Y') ); ?>">
                                <div class="clock-badge-inner">
                                    <div class="clock-fraction-col">
                                        <span class="clock-day"><?php echo $day; ?></span>
                                        <span class="clock-divider-line"></span>
                                        <span class="clock-month"><?php echo $month; ?></span>
                                    </div>
                                    <span class="clock-year">'<?php echo $year; ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Đường kẻ phân cách có mũi nhọn -->
                        <div class="detail-divider"></div>

                        <!-- Nội dung bài viết -->
                        <div class="detail-content <?php echo $has_custom_excerpt ? 'has-excerpt' : 'no-excerpt'; ?>">
                            <?php if ( $has_custom_excerpt ) : ?>
                                <div class="detail-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>
                            <?php endif; ?>

                            <?php the_content(); ?>
                        </div>

                        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
                            <a href="<?php echo esc_url( home_url('/') ); ?>" style="display: inline-flex; align-items: center; gap: 8px; padding: 8px 16px; background-color: #f1f5f9; color: #2a6fbe; text-decoration: none; font-weight: 600; font-size: 13.5px; border-radius: 6px;">
                                &larr; Quay lại danh sách sản phẩm
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>

        <!-- CỘT BÊN PHẢI: Recent post (#10) -->
        <div class="right-sidebar-column">
            <aside class="recent-posts-teal-card">
                <div class="recent-posts-teal-list">
                    <?php
                    $recent_posts = wp_get_recent_posts( array(
                        'numberposts' => 5,
                        'post_status' => 'publish'
                    ) );

                    if ( ! empty( $recent_posts ) ) :
                        foreach ( $recent_posts as $post_item ) : 
                            $recent_link = add_query_arg( 'p', $post_item['ID'], home_url( '/' ) );
                            $r_day   = date('d', strtotime($post_item['post_date']));
                            $r_month = date('m', strtotime($post_item['post_date']));
                            $r_year  = date('y', strtotime($post_item['post_date']));
                        ?>
                            <div class="recent-post-teal-item">
                                <div class="recent-teal-date-badge">
                                    <div class="recent-teal-date-fraction">
                                        <span class="recent-teal-date-day"><?php echo $r_day; ?></span>
                                        <span class="recent-teal-date-line"></span>
                                        <span class="recent-teal-date-month"><?php echo $r_month; ?></span>
                                    </div>
                                    <span class="recent-teal-date-year">─<?php echo $r_year; ?></span>
                                </div>

                                <div class="recent-post-teal-title">
                                    <a href="<?php echo esc_url( $recent_link ); ?>">
                                        <?php echo esc_html( $post_item['post_title'] ); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; wp_reset_query();
                    else : ?>
                        <p style="color:#ffffff; font-size:13px;">Chưa có bài viết mới</p>
                    <?php endif; ?>
                </div>

                <a href="<?php echo esc_url( home_url('/') ); ?>" class="recent-posts-btn-banner">
                    XEM TẤT CẢ TIN TỨC
                </a>
            </aside>
        </div>

    </div><!-- .page-three-column-layout -->

    <!-- 2. KHỐI ĐIỀU HƯỚNG BÀI VIẾT: Prev - Next Post (7) -->
    <?php
    $next_post = get_next_post();
    $prev_post = get_previous_post();

    if ( $next_post || $prev_post ) :
    ?>
        <nav id="prev-next" class="custom-post-navigation block-7">
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
        </nav>
    <?php endif; ?>

    <!-- 3. KHỐI BÌNH LUẬN: Comments (8) -->
    <section id="comments-detail" class="comments-block block-8" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; padding: 25px 30px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);">
        <h3 class="widget-title-styled" style="font-size: 20px; font-weight: 800; color: #1a1a1a; margin-bottom: 6px;">Comments (8)</h3>
        <div class="widget-striped-bar" style="width: 100%; height: 10px; margin-bottom: 20px; background: repeating-linear-gradient(-45deg, #d5d5d5, #d5d5d5 3px, #e9e9e9 3px, #e9e9e9 6px);"></div>
        <?php 
        if ( comments_open() || get_comments_number() ) {
            comments_template();
        } else {
            comment_form();
        }
        ?>
    </section>

</div><!-- .detail-page-wrapper -->

<?php get_footer(); ?>