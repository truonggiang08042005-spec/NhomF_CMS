<?php
/**
 * The template for displaying all single posts (Detail page)
 * Bố cục 3 cột theo đúng sơ đồ thiết kế trong Ảnh 2:
 * [Header (1)]
 * [Archive (11) - Trái (nhóm 6 sv)] | [Content (2) - Giữa] | [Comments (12) - Phải (nhóm 6 sv)]
 * [Footer (3)]
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 */

get_header();
?>

<style>
    /* Bố cục 3 cột đồng đều chuẩn hình thiết kế Ảnh 2: Left (Archive 11) | Center (Content 2) | Right (Comments 12) */
    .page-three-column-layout {
        max-width: 1200px;
        margin: 25px auto;
        padding: 0 15px;
        display: flex;
        gap: 25px;
        align-items: flex-start;
        box-sizing: border-box;
    }

    .left-sidebar-column {
        width: 280px;
        min-width: 280px;
    }

    .center-content-column {
        flex: 1;
        min-width: 0;
    }

    .right-sidebar-column {
        width: 280px;
        min-width: 280px;
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

    /* Widget Khối Bên Trái (Archive 11) & Bên Phải (Comments 12) */
    .categories-widget-box,
    .comments-widget-box {
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
        background: repeating-linear-gradient(-45deg,
                #d5d5d5,
                #d5d5d5 3px,
                #e9e9e9 3px,
                #e9e9e9 6px);
        border-radius: 1px;
    }

    .categories-white-box,
    .comments-white-box {
        background: #ffffff;
        padding: 10px 16px;
        border-radius: 2px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    /* Danh sách bài viết đánh số trong Archive Sidebar theo Ảnh 1 */
    .sidebar-rank-item {
        display: flex;
        align-items: flex-start;
        padding: 11px 0;
        border-bottom: 1px solid #f0f0f0;
        gap: 10px;
    }

    .sidebar-rank-item:last-child {
        border-bottom: none;
    }

    .sidebar-rank-num {
        font-family: "Georgia", "Times New Roman", serif;
        font-size: 22px;
        font-weight: 700;
        color: #1a1a1a;
        line-height: 1;
        min-width: 20px;
        text-align: center;
        padding-top: 2px;
    }

    .sidebar-rank-title {
        flex: 1;
        font-size: 13.5px;
        line-height: 1.35;
    }

    .sidebar-rank-title a {
        color: #334155;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.15s;
    }

    .sidebar-rank-title a:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    .sidebar-rank-meta {
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 3px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .rank-comment-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        color: #94a3b8;
        font-size: 11.5px;
    }

    .comment-bubble-icon {
        width: 12px;
        height: 12px;
        fill: #94a3b8;
        display: inline-block;
        vertical-align: middle;
    }

    .sidebar-archive-section-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
        margin: 15px 0 8px 0;
        letter-spacing: 0.5px;
        border-top: 1px dashed #e2e8f0;
        padding-top: 10px;
    }

    .sidebar-monthly-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .sidebar-monthly-list li {
        padding: 6px 0;
        font-size: 13.5px;
        border-bottom: 1px solid #f8fafc;
        display: flex;
        align-items: center;
    }

    .sidebar-monthly-list li::before {
        content: "";
        display: inline-block;
        width: 6px;
        height: 6px;
        background-color: #f5b025;
        border-radius: 50%;
        margin-right: 8px;
    }

    .sidebar-monthly-list li a {
        color: #5587b7;
        text-decoration: none;
        font-weight: 500;
    }

    .sidebar-monthly-list li a:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    /* Comments Sidebar */
    .comments-white-box ul,
    .comments-white-box li {
        margin: 0 !important;
        list-style: none !important;
    }

    .recent-comment-item {
        border-bottom: 1px solid #f0f0f0 !important;
        padding: 10px 0;
    }

    .recent-comment-item:last-child {
        border-bottom: none !important;
    }

    .comment-content a {
        color: #5587b7;
        text-decoration: none;
        font-size: 14px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .comment-content a:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    /* ==========================================================================
     Khung chứa bài viết chi tiết (Content 2)
     ========================================================================== */
    .detail-post-container {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 30px 35px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    .detail-header-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        position: relative;
    }

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

    .detail-clock-badge {
        width: 58px;
        height: 58px;
        min-width: 58px;
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

    .detail-divider {
        position: relative;
        width: 100%;
        height: 1px;
        background-color: #e5e7eb;
        margin: 22px 0 26px 0;
    }

    .detail-divider::before {
        content: "";
        position: absolute;
        top: -5px;
        left: 45px;
        width: 9px;
        height: 9px;
        background-color: #ffffff;
        border-top: 1px solid #e5e7eb;
        border-left: 1px solid #e5e7eb;
        transform: rotate(45deg);
    }

    .detail-content {
        color: #374151;
        font-size: 15.5px;
        line-height: 1.75;
    }

    .detail-excerpt,
    .detail-excerpt p {
        font-style: italic;
        color: #4b5563;
        font-size: 15.5px;
        line-height: 1.65;
        margin-bottom: 20px;
    }

    .detail-content p {
        margin-bottom: 18px;
        text-align: justify;
    }

    .detail-content img {
        max-width: 100%;
        height: auto;
        border-radius: 4px;
        margin: 18px 0;
    }
</style>

<div class="page-three-column-layout">

    <!-- CỘT BÊN TRÁI: Archive (11) (nhóm 6 sv) -->
    <div class="left-sidebar-column">
        <aside class="categories-widget-box block-11">
            <h3 class="widget-title-styled">Archive</h3>
            <div class="widget-striped-bar"></div>
            
            <div class="categories-white-box">
                <!-- Danh sách bài viết đánh số thứ tự chuẩn theo Ảnh 1 -->
                <div class="sidebar-ranked-posts">
                    <?php
                    $sidebar_posts = wp_get_recent_posts( array(
                        'numberposts' => 5,
                        'post_status' => 'publish',
                    ) );

                    if ( ! empty( $sidebar_posts ) ) :
                        foreach ( $sidebar_posts as $idx => $s_post ) :
                            $rank = $idx + 1;
                            $link = get_permalink( $s_post['ID'] );
                            $comments = get_comments_number( $s_post['ID'] );
                            $post_date = get_the_date( 'd/m', $s_post['ID'] );
                        ?>
                            <div class="sidebar-rank-item">
                                <div class="sidebar-rank-num"><?php echo $rank; ?></div>
                                <div class="sidebar-rank-title">
                                    <a href="<?php echo esc_url( $link ); ?>">
                                        <?php echo esc_html( wp_trim_words( $s_post['post_title'], 9, '...' ) ); ?>
                                    </a>
                                    <div class="sidebar-rank-meta">
                                        <span><?php echo $post_date; ?></span>
                                        <?php if ( $comments > 0 ) : ?>
                                            <span class="rank-comment-badge">
                                                <svg class="comment-bubble-icon" viewBox="0 0 20 20">
                                                    <path d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7z"/>
                                                </svg>
                                                <?php echo $comments; ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;
                    endif;
                    ?>
                </div>

                <!-- Danh sách Lưu trữ theo tháng (Monthly Archives) -->
                <div class="sidebar-archive-section-title">Lưu trữ theo tháng</div>
                <ul class="sidebar-monthly-list">
                    <?php
                    $archives_list = wp_get_archives( array(
                        'type'            => 'monthly',
                        'format'          => 'html',
                        'show_post_count' => true,
                        'echo'            => false
                    ) );

                    if ( ! empty( $archives_list ) ) {
                        echo $archives_list;
                    } else {
                        echo '<li><a href="#">October 2023</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </aside>
    </div>

    <!-- CỘT Ở GIỮA: Content (2) - Chi tiết bài viết -->
    <div class="center-content-column">
        <main id="site-content">
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

                        <?php 
                        // Bình luận bài viết nếu mở
                        if ( comments_open() || get_comments_number() ) {
                            comments_template();
                        }
                        ?>
                    </article>
                <?php endwhile; ?>
            <?php endif; ?>
        </main>
    </div>

    <!-- CỘT BÊN PHẢI: Comments (12) (nhóm 6 sv) -->
    <div class="right-sidebar-column">
        <aside class="comments-widget-box block-12">
            <h3 class="widget-title-styled">Comments</h3>
            <div class="widget-striped-bar"></div>

            <div class="comments-white-box">
                <ul>
                    <?php
                    $recent_comments = get_comments( array(
                        'number'      => 5,
                        'status'      => 'approve',
                        'post_status' => 'publish',
                        'type'        => 'comment',
                    ) );

                    if ( ! empty( $recent_comments ) ) :
                        foreach ( $recent_comments as $comment ) :
                            $comment_post = get_post( $comment->comment_post_ID );
                            ?>
                            <li class="recent-comment-item">
                                <?php if ( $comment_post ) : ?>
                                    <div class="comment-content">
                                        <a class="comment-post-link" href="<?php echo esc_url( get_comment_link( $comment ) ); ?>">
                                            <?php echo esc_html( wp_trim_words( $comment->comment_content, 12, '...' ) ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </li>
                        <?php
                        endforeach;
                    else :
                        ?>
                        <li>Chưa có bình luận nào.</li>
                    <?php endif; ?>
                </ul>
            </div>
        </aside>
    </div>

</div><!-- .page-three-column-layout -->

<?php get_footer(); ?>
