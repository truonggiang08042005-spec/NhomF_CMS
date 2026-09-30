<?php
/**
 * The main template file (index.php) - TRANG CHỦ
 * Bố cục 3 cột theo đúng sơ đồ thiết kế [Trang chủ] trong Ảnh:
 * [Header (1)]
 * [Archive (11) (nhóm 6 sv) - Cột Trái] | [Content (2) - Cột Giữa] | [Comments (12) (nhóm 6 sv) - Cột Phải]
 * [Footer (3)]
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 */

get_header(); 
?>

<style>
    /* ==========================================================================
     BỐ CỤC TRANG CHỦ: 3 CỘT [Archive 11] | [Content 2] | [Comments 12]
     ========================================================================== */
    .page-three-column-layout {
        max-width: 1200px;
        margin: 25px auto 45px auto;
        padding: 0 15px;
        display: flex;
        gap: 25px;
        align-items: flex-start;
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    /* Cột bên trái: Archive (11) (nhóm 6 sv) - 280px */
    .left-sidebar-column {
        width: 280px;
        min-width: 280px;
    }

    /* Cột ở giữa: Content (2) */
    .center-content-column {
        flex: 1;
        min-width: 0;
    }

    /* Cột bên phải: Comments (12) (nhóm 6 sv) - 280px */
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

    /* ==========================================================================
     WIDGET KHỐI TRÁI (Archive 11) & PHẢI (Comments 12)
     ========================================================================== */
    .categories-widget-box,
    .comments-widget-box {
        background-color: #ededed;
        background-image: repeating-linear-gradient(45deg, #f4f4f4, #f4f4f4 10px, #e9e9e9 10px, #e9e9e9 20px);
        padding: 20px 16px;
        border-radius: 4px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        box-sizing: border-box;
    }

    .widget-title-styled {
        font-size: 22px !important;
        font-weight: 800 !important;
        color: #1a1a1a !important;
        margin: 0 0 6px 0 !important;
        padding: 0 !important;
        line-height: 1.2 !important;
    }

    .widget-striped-bar {
        width: 100%;
        height: 12px;
        margin-top: 8px;
        margin-bottom: 14px;
        background: repeating-linear-gradient(-45deg, #d5d5d5, #d5d5d5 3px, #e9e9e9 3px, #e9e9e9 6px);
        border-radius: 1px;
    }

    .widget-white-container {
        background: #ffffff;
        padding: 10px 14px;
        border-radius: 3px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    /* ==========================================================================
     ARCHIVE (11): DANH SÁCH BÀI VIẾT ĐÁNH SỐ THỨ TỰ (1..N) CHUẨN ẢNH 1
     ========================================================================== */
    .archive-ranked-list {
        display: flex;
        flex-direction: column;
    }

    .archive-rank-item {
        display: flex;
        align-items: flex-start;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
        gap: 10px;
    }

    .archive-rank-item:last-child {
        border-bottom: none;
    }

    /* Số thứ tự 1..5 in đậm phong cách Georgia Serif */
    .archive-rank-number {
        font-family: "Georgia", "Times New Roman", Times, serif;
        font-size: 22px;
        font-weight: 700;
        color: #1a1a1a;
        line-height: 1;
        min-width: 22px;
        text-align: center;
        padding-top: 2px;
    }

    .archive-rank-body {
        flex: 1;
        min-width: 0;
    }

    .archive-rank-title {
        font-size: 13.5px;
        line-height: 1.35;
        margin: 0;
        font-weight: 500;
    }

    .archive-rank-title a {
        color: #1f2937;
        text-decoration: none;
        transition: color 0.15s;
    }

    .archive-rank-title a:hover {
        color: #0284c7;
        text-decoration: underline;
    }

    .archive-rank-meta {
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .archive-comment-badge {
        display: inline-flex;
        align-items: center;
        gap: 3px;
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

    /* Phân mục Lưu trữ theo tháng */
    .archive-month-section-title {
        font-size: 12.5px;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
        margin: 14px 0 8px 0;
        letter-spacing: 0.5px;
        border-top: 1px dashed #e2e8f0;
        padding-top: 10px;
    }

    .archive-month-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .archive-month-list li {
        padding: 6px 0;
        font-size: 13px;
        border-bottom: 1px solid #f8fafc;
        display: flex;
        align-items: center;
    }

    .archive-month-list li::before {
        content: "";
        display: inline-block;
        width: 6px;
        height: 6px;
        background-color: #f5b025;
        border-radius: 50%;
        margin-right: 8px;
    }

    .archive-month-list li a {
        color: #5587b7;
        text-decoration: none;
        font-weight: 500;
    }

    .archive-month-list li a:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    /* ==========================================================================
     CONTENT (2): CỘT Ở GIỮA
     ========================================================================== */
    .post-card-item {
        display: flex;
        align-items: center;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 20px 24px;
        margin-bottom: 16px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .post-card-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .post-card-date {
        width: 85px;
        min-width: 85px;
        text-align: center;
        padding-right: 18px;
        margin-right: 18px;
        border-right: 1px solid #e2e8f0;
    }

    .post-card-date .day-num {
        font-size: 38px;
        font-weight: bold;
        line-height: 1;
        color: #1e293b;
        font-family: "Georgia", "Times New Roman", Times, serif;
    }

    .post-card-date .month-text {
        font-size: 11px;
        color: #64748b;
        text-transform: uppercase;
        margin-top: 6px;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .post-card-info {
        flex: 1;
    }

    .post-card-title {
        font-size: 16.5px;
        font-weight: 700;
        margin: 0 0 8px 0;
        line-height: 1.35;
        text-transform: uppercase;
    }

    .post-card-title a {
        color: #0284c7;
        text-decoration: none;
        transition: color 0.15s;
    }

    .post-card-title a:hover {
        color: #0369a1;
        text-decoration: underline;
    }

    .post-card-excerpt {
        font-size: 13.5px;
        color: #64748b;
        margin: 0;
        line-height: 1.55;
    }

    /* ==========================================================================
     COMMENTS (12): CỘT BÊN PHẢI
     ========================================================================== */
    .comments-list-wrapper {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .recent-comment-item {
        border-bottom: 1px solid #f0f0f0;
        padding: 10px 0;
    }

    .recent-comment-item:last-child {
        border-bottom: none;
    }

    .comment-content a {
        color: #5587b7;
        text-decoration: none;
        font-size: 13.5px;
        line-height: 1.45;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .comment-content a:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }
</style>

<div class="page-three-column-layout">

    <!-- CỘT BÊN TRÁI: Archive (11) (nhóm 6 sv) -->
    <div class="left-sidebar-column">
        <aside class="categories-widget-box block-11">
            <h3 class="widget-title-styled">Archive</h3>
            <div class="widget-striped-bar"></div>
            
            <div class="widget-white-container">
                <!-- Danh sách bài viết đánh số thứ tự (1, 2, 3...) theo Ảnh 1 -->
                <div class="archive-ranked-list">
                    <?php
                    $archive_posts = wp_get_recent_posts( array(
                        'numberposts' => 5,
                        'post_status' => 'publish',
                    ) );

                    if ( ! empty( $archive_posts ) ) :
                        foreach ( $archive_posts as $idx => $a_post ) :
                            $rank = $idx + 1;
                            $link = get_permalink( $a_post['ID'] );
                            $comments = get_comments_number( $a_post['ID'] );
                            $post_date = get_the_date( 'd/m', $a_post['ID'] );
                        ?>
                            <div class="archive-rank-item">
                                <div class="archive-rank-number"><?php echo $rank; ?></div>
                                <div class="archive-rank-body">
                                    <h4 class="archive-rank-title">
                                        <a href="<?php echo esc_url( $link ); ?>">
                                            <?php echo esc_html( wp_trim_words( $a_post['post_title'], 9, '...' ) ); ?>
                                        </a>
                                    </h4>
                                    <div class="archive-rank-meta">
                                        <span><?php echo $post_date; ?></span>
                                        <?php if ( $comments > 0 ) : ?>
                                            <span class="archive-comment-badge">
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

                <!-- Phân mục Lưu trữ theo tháng (Monthly Archives) -->
                <div class="archive-month-section-title">Lưu trữ theo tháng</div>
                <ul class="archive-month-list">
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

    <!-- CỘT Ở GIỮA: Content (2) -->
    <div class="center-content-column">
        <main id="site-content">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); 
                    $day = get_the_date('d');
                    $month = get_the_date('m');
                ?>
                    <article class="post-card-item">
                        <!-- 1. Cột Ngày / Tháng -->
                        <div class="post-card-date">
                            <div class="day-num"><?php echo $day; ?></div>
                            <div class="month-text">THÁNG <?php echo $month; ?></div>
                        </div>

                        <!-- 2. Cột Tiêu đề & Tóm tắt bài viết -->
                        <div class="post-card-info">
                            <h2 class="post-card-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            <p class="post-card-excerpt">
                                <?php echo wp_trim_words( get_the_excerpt(), 25, ' [...]' ); ?>
                            </p>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <p style="padding: 20px 0; color: #64748b;">Chưa có bài viết nào trong Database.</p>
            <?php endif; ?>
        </main>
    </div>

    <!-- CỘT BÊN PHẢI: Comments (12) (nhóm 6 sv) -->
    <div class="right-sidebar-column">
        <aside class="comments-widget-box block-12">
            <h3 class="widget-title-styled">Comments</h3>
            <div class="widget-striped-bar"></div>

            <div class="widget-white-container">
                <ul class="comments-list-wrapper">
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