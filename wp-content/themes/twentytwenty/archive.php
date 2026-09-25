<?php
/**
 * The template for displaying archive pages (Archive / Bài viết mới nhất)
 * Bố cục 3 cột theo đúng sơ đồ thiết kế:
 * [Header (1)]
 * [Archive (11) - Trái] | [Content (2) - Giữa] | [Comments (12) - Phải]
 * [Footer (3)]
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 */

get_header();

// Thu thập danh sách bài viết từ truy vấn chính (lấy theo ngày tháng mới nhất)
$posts_list = array();
if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        $posts_list[] = array(
            'id'            => get_the_ID(),
            'title'         => get_the_title(),
            'permalink'     => get_permalink(),
            'comment_count' => get_comments_number(),
            'date'          => get_the_date('d/m/Y'),
        );
    }
}

// Nếu truy vấn ít hơn 8 bài (ví dụ lọc tháng có ít bài), query bổ sung để hiển thị đủ 8 bài theo chuẩn giao diện
if ( count( $posts_list ) < 8 ) {
    $needed = 8 - count( $posts_list );
    $exclude_ids = wp_list_pluck( $posts_list, 'id' );
    $extra_query = new WP_Query( array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $needed,
        'post__not_in'   => $exclude_ids,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );
    if ( $extra_query->have_posts() ) {
        while ( $extra_query->have_posts() ) {
            $extra_query->the_post();
            $posts_list[] = array(
                'id'            => get_the_ID(),
                'title'         => get_the_title(),
                'permalink'     => get_permalink(),
                'comment_count' => get_comments_number(),
                'date'          => get_the_date('d/m/Y'),
            );
        }
        wp_reset_postdata();
    }
}

// Giới hạn 8 bài viết cho giao diện 2 cột x 4 hàng chuẩn theo ảnh 1
$display_posts = array_slice( $posts_list, 0, 8 );
$half = 4;
$col1 = array_slice( $display_posts, 0, $half );
$col2 = array_slice( $display_posts, $half );
?>

<style>
    /* Bố cục 3 cột đồng bộ: Trái (Archive 11) | Giữa (Content 2) | Phải (Comments 12) */
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

    /* Widget Box bên trái và phải */
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
        padding: 8px 16px;
        border-radius: 2px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    /* Danh sách sidebar item */
    .sidebar-rank-item {
        display: flex;
        align-items: flex-start;
        padding: 10px 0;
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

    .sidebar-archive-section-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
        margin: 14px 0 8px 0;
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
     Khung Content (2) - Khối Archive hiển thị chuẩn theo Ảnh 1
     ========================================================================== */
    .archive-page-container {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 26px 30px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    /* Tiêu đề mục: "Xem nhiều / Archives" có gạch đỏ ở chân chuẩn VnExpress theo Ảnh 1 */
    .archive-header {
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 8px;
        display: flex;
        align-items: baseline;
        gap: 12px;
    }

    .archive-header-title {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        display: inline-block;
        margin: 0;
        padding-bottom: 8px;
        border-bottom: 2.5px solid #b91c1c; /* Gạch đỏ đậm chuẩn Ảnh 1 */
        margin-bottom: -1px;
        font-family: Arial, "Helvetica Neue", sans-serif;
    }

    .archive-header-subtitle {
        font-size: 14px;
        color: #6b7280;
        font-weight: normal;
    }

    /* Lưới 2 cột chia đôi chuẩn 100% Ảnh 1 */
    .archive-rank-grid {
        display: flex;
        flex-direction: row;
        align-items: stretch;
    }

    /* Cột bên trái (Số 1 -> 4) */
    .archive-rank-col.col-left {
        flex: 1;
        border-right: 1px solid #e5e7eb;
        padding-right: 24px;
    }

    /* Cột bên phải (Số 5 -> 8) */
    .archive-rank-col.col-right {
        flex: 1;
        padding-left: 24px;
    }

    /* Từng hàng bài viết */
    .archive-rank-item {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        padding: 16px 0;
        border-bottom: 1px solid #f1f5f9;
        min-height: 75px;
    }

    .archive-rank-col .archive-rank-item:last-child {
        border-bottom: none;
    }

    /* Số thứ tự 1..8 phong cách Georgia Serif lớn chuẩn Ảnh 1 */
    .rank-number {
        font-family: "Georgia", "Times New Roman", Times, serif;
        font-size: 38px;
        font-weight: 700;
        color: #111827;
        line-height: 1;
        width: 32px;
        min-width: 32px;
        margin-right: 16px;
        flex-shrink: 0;
        text-align: center;
        padding-top: 2px;
        user-select: none;
    }

    .rank-content {
        flex: 1;
        min-width: 0;
    }

    .rank-title {
        font-size: 15px;
        font-weight: 500;
        line-height: 1.45;
        margin: 0;
        font-family: Arial, "Helvetica Neue", sans-serif;
    }

    .rank-title a {
        color: #1f2937;
        text-decoration: none;
        transition: color 0.15s ease;
    }

    .rank-title a:hover {
        color: #0066cc;
    }

    /* Icon bình luận kèm số lượng */
    .rank-comment-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-left: 6px;
        color: #94a3b8;
        font-size: 13px;
        font-weight: normal;
        vertical-align: middle;
        white-space: nowrap;
    }

    .comment-bubble-icon {
        width: 14px;
        height: 14px;
        fill: #94a3b8;
        display: inline-block;
        vertical-align: middle;
    }

    @media (max-width: 768px) {
        .archive-rank-grid {
            flex-direction: column;
        }

        .archive-rank-col.col-left {
            border-right: none;
            padding-right: 0;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 10px;
        }

        .archive-rank-col.col-right {
            padding-left: 0;
            padding-top: 10px;
        }

        .rank-number {
            font-size: 30px;
            margin-right: 12px;
        }
    }
</style>

<div class="page-three-column-layout">

    <!-- CỘT BÊN TRÁI: Archive (11) (nhóm 6 sv) -->
    <div class="left-sidebar-column">
        <aside class="categories-widget-box block-11">
            <h3 class="widget-title-styled">Archive</h3>
            <div class="widget-striped-bar"></div>
            
            <div class="categories-white-box">
                <!-- Danh sách bài viết mới nhất đánh số theo Ảnh 1 -->
                <div class="sidebar-ranked-posts">
                    <?php
                    $sidebar_recent = wp_get_recent_posts( array(
                        'numberposts' => 5,
                        'post_status' => 'publish',
                    ) );
                    if ( ! empty( $sidebar_recent ) ) :
                        foreach ( $sidebar_recent as $s_idx => $s_post ) :
                            $s_rank = $s_idx + 1;
                            $s_link = get_permalink( $s_post['ID'] );
                            $s_comments = get_comments_number( $s_post['ID'] );
                        ?>
                            <div class="sidebar-rank-item">
                                <div class="sidebar-rank-num"><?php echo $s_rank; ?></div>
                                <div class="sidebar-rank-title">
                                    <a href="<?php echo esc_url( $s_link ); ?>">
                                        <?php echo esc_html( wp_trim_words( $s_post['post_title'], 8, '...' ) ); ?>
                                    </a>
                                    <?php if ( $s_comments > 0 ) : ?>
                                        <span class="rank-comment-badge" style="font-size: 11px;">
                                            <svg class="comment-bubble-icon" style="width: 11px; height: 11px;" viewBox="0 0 20 20">
                                                <path d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7z"/>
                                            </svg>
                                            <?php echo $s_comments; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach;
                    endif;
                    ?>
                </div>

                <!-- Danh sách lưu trữ theo tháng (Monthly Archives) -->
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

    <!-- CỘT Ở GIỮA: Content (2) - Hiển thị Archive theo chuẩn Ảnh 1 -->
    <div class="center-content-column">
        <main id="site-content" class="archive-page-container">
            <!-- Header tiêu đề "Xem nhiều / Archives" -->
            <div class="archive-header">
                <h2 class="archive-header-title">
                    <?php
                    if ( is_date() ) {
                        echo 'Lưu trữ: ' . get_the_archive_title();
                    } elseif ( is_category() ) {
                        echo 'Chuyên mục: ' . single_cat_title( '', false );
                    } elseif ( is_tag() ) {
                        echo 'Thẻ: ' . single_tag_title( '', false );
                    } else {
                        echo 'Xem nhiều';
                    }
                    ?>
                </h2>
                <?php if ( is_date() || is_category() || is_tag() ) : ?>
                    <span class="archive-header-subtitle">&bull; <?php echo count( $posts_list ); ?> bài viết</span>
                <?php endif; ?>
            </div>

            <?php if ( ! empty( $display_posts ) ) : ?>
                <!-- Lưới 2 cột: Cột 1 (1->4) và Cột 2 (5->8) đúng chuẩn 100% Ảnh 1 -->
                <div class="archive-rank-grid">
                    <!-- Cột trái: 1..4 -->
                    <div class="archive-rank-col col-left">
                        <?php foreach ( $col1 as $index => $item ) : 
                            $rank = $index + 1;
                        ?>
                            <article class="archive-rank-item">
                                <div class="rank-number"><?php echo $rank; ?></div>
                                <div class="rank-content">
                                    <h3 class="rank-title">
                                        <a href="<?php echo esc_url( $item['permalink'] ); ?>">
                                            <?php echo esc_html( $item['title'] ); ?>
                                        </a>
                                        <?php if ( $item['comment_count'] > 0 ) : ?>
                                            <span class="rank-comment-badge" title="<?php echo esc_attr( $item['comment_count'] . ' bình luận' ); ?>">
                                                <svg class="comment-bubble-icon" viewBox="0 0 20 20">
                                                    <path d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7z"/>
                                                </svg>
                                                <span><?php echo $item['comment_count']; ?></span>
                                            </span>
                                        <?php endif; ?>
                                    </h3>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>

                    <!-- Cột phải: 5..8 -->
                    <div class="archive-rank-col col-right">
                        <?php foreach ( $col2 as $index => $item ) : 
                            $rank = $half + $index + 1;
                        ?>
                            <article class="archive-rank-item">
                                <div class="rank-number"><?php echo $rank; ?></div>
                                <div class="rank-content">
                                    <h3 class="rank-title">
                                        <a href="<?php echo esc_url( $item['permalink'] ); ?>">
                                            <?php echo esc_html( $item['title'] ); ?>
                                        </a>
                                        <?php if ( $item['comment_count'] > 0 ) : ?>
                                            <span class="rank-comment-badge" title="<?php echo esc_attr( $item['comment_count'] . ' bình luận' ); ?>">
                                                <svg class="comment-bubble-icon" viewBox="0 0 20 20">
                                                    <path d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7z"/>
                                                </svg>
                                                <span><?php echo $item['comment_count']; ?></span>
                                            </span>
                                        <?php endif; ?>
                                    </h3>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else : ?>
                <p style="color: #64748b; padding: 20px 0;">Chưa có bài viết nào trong mục này.</p>
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
