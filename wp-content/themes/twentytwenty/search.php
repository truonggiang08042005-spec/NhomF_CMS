<?php
/**
 * The template for displaying search results pages (Trang danh sách tìm kiếm)
 * Bố cục chuẩn theo sơ đồ thiết kế trong Ảnh 2:
 * [Header (1)]
 * [Search (4)]
 * [13 (Pages - dạng rớt dòng)] | [Search result (5)] | [14 (Comments)]
 * [15]
 * [Footer]
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 */

get_header();

$theme_uri = get_template_directory_uri();

// Lấy bài viết cho Module 13 (Pages)
$pages_posts = get_posts( array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 3,
    'orderby'        => 'date',
    'order'          => 'DESC',
) );

function nhomf_search_page_image( $post_id, $post_title, $index = 0 ) {
    global $theme_uri;
    
    // Nếu có thumbnail thật
    if ( has_post_thumbnail( $post_id ) ) {
        $thumb_url = get_the_post_thumbnail_url( $post_id, 'medium_large' );
        if ( ! empty( $thumb_url ) ) {
            return $thumb_url;
        }
    }

    $title_lower = mb_strtolower( $post_title, 'UTF-8' );
    if ( strpos( $title_lower, 'giặt' ) !== false || strpos( $title_lower, 'electrolux' ) !== false ) {
        return $theme_uri . '/assets/images/post-may-giat.svg';
    } elseif ( strpos( $title_lower, 'robot' ) !== false || strpos( $title_lower, 'hút bụi' ) !== false ) {
        return $theme_uri . '/assets/images/post-robot-hut-bui.svg';
    } elseif ( strpos( $title_lower, 'đồng hồ' ) !== false ) {
        return $theme_uri . '/assets/images/post-dong-ho.svg';
    } elseif ( strpos( $title_lower, 'gaming' ) !== false || strpos( $title_lower, 'pc' ) !== false ) {
        return $theme_uri . '/assets/images/post-pc-gaming.svg';
    }

    // Default SVG chuẩn theo Ảnh 1
    $sample_svgs = array(
        $theme_uri . '/assets/images/page-cntt.svg',
        $theme_uri . '/assets/images/page-network.svg',
        $theme_uri . '/assets/images/page-graphic-design.svg',
    );

    return isset( $sample_svgs[ $index ] ) ? $sample_svgs[ $index ] : $sample_svgs[0];
}
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&display=swap');

    /* Khung bọc toàn bộ trang tìm kiếm */
    .search-layout-wrapper {
        max-width: 1240px;
        margin: 20px auto 40px auto;
        padding: 0 15px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        box-sizing: border-box;
    }

    /* ==========================================================================
     1. Khối Search (4): Nằm ngang ngay dưới Header
     ========================================================================== */
    .search-top-bar-module {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 22px 28px;
        margin-bottom: 25px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    }

    .search-top-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .search-top-title {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .search-top-title span {
        color: #dc2626; /* Tô đỏ từ khóa tìm kiếm */
    }

    .search-top-count {
        font-size: 13.5px;
        color: #64748b;
    }

    .search-input-form {
        display: flex;
        gap: 10px;
        align-items: center;
        background-color: #f8fafc;
        border: 1.5px solid #cbd5e1;
        border-radius: 6px;
        padding: 5px 8px 5px 14px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .search-input-form:focus-within {
        border-color: #0284c7;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
        background-color: #ffffff;
    }

    .search-input-form input[type="search"] {
        flex: 1;
        border: none !important;
        outline: none !important;
        font-size: 15px !important;
        background: transparent !important;
        color: #1e293b !important;
        padding: 6px 0 !important;
    }

    .search-input-form button {
        background-color: #0284c7 !important;
        color: #ffffff !important;
        border: none !important;
        padding: 9px 20px !important;
        border-radius: 4px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        cursor: pointer !important;
        transition: background-color 0.2s;
    }

    .search-input-form button:hover {
        background-color: #0369a1 !important;
    }

    /* ==========================================================================
     2. Bố cục 3 cột: [13] (Trái) | [Search result (5)] (Giữa) | [14] (Phải)
     ========================================================================== */
    .search-three-columns {
        display: flex;
        gap: 24px;
        align-items: flex-start;
    }

    /* Cột bên trái: Module số 13 (Pages) - Rộng 280px */
    .search-left-col-13 {
        width: 280px;
        min-width: 280px;
    }

    /* Cột ở giữa: Search result (5) */
    .search-center-col-5 {
        flex: 1;
        min-width: 0;
    }

    /* Cột bên phải: Module số 14 (Comments) - Rộng 280px */
    .search-right-col-14 {
        width: 280px;
        min-width: 280px;
    }

    @media (max-width: 1080px) {
        .search-three-columns {
            flex-direction: column;
        }

        .search-left-col-13,
        .search-right-col-14 {
            width: 100%;
            min-width: 100%;
        }
    }

    /* Khối Widget bên Sidebar */
    .widget-box-wrapper {
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
        margin-bottom: 16px;
        background: repeating-linear-gradient(-45deg, #d5d5d5, #d5d5d5 3px, #e9e9e9 3px, #e9e9e9 6px);
        border-radius: 1px;
    }

    .widget-inner-white-box {
        background: #ffffff;
        padding: 14px 14px;
        border-radius: 3px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    /* ==========================================================================
     MODULE SỐ 13: PAGES (HÌNH ĐỨNG DẠNG CỘT - RỚT DÒNG THEO ẢNH 1 & 2)
     ========================================================================== */
    .module-13-vertical-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .page-item-card {
        display: flex;
        flex-direction: column;
        background: #ffffff;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 18px;
    }

    .page-item-card:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .page-item-title {
        font-size: 14.5px;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 6px 0;
        line-height: 1.35;
    }

    .page-item-title a {
        color: #1e293b;
        text-decoration: none;
        transition: color 0.15s;
    }

    .page-item-title a:hover {
        color: #0284c7;
    }

    .page-item-divider {
        width: 38px;
        height: 2px;
        background-color: #cbd5e1;
        margin-bottom: 10px;
        border-radius: 1px;
    }

    .page-item-thumb {
        width: 100%;
        height: 140px;
        overflow: hidden;
        border-radius: 3px;
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        margin-bottom: 8px;
        display: block;
    }

    .page-item-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.25s ease;
    }

    .page-item-card:hover .page-item-thumb img {
        transform: scale(1.03);
    }

    .page-item-desc {
        font-size: 12.5px;
        color: #64748b;
        line-height: 1.5;
        margin: 0;
    }

    /* ==========================================================================
     SEARCH RESULT (5): CỘT Ở GIỮA
     ========================================================================== */
    .search-results-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .post-card-item {
        display: flex;
        flex-direction: row;
        align-items: stretch;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        min-height: 140px;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .post-card-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0, 0, 0, 0.07);
        border-color: #cbd5e1;
    }

    /* Thumbnail cột kết quả */
    .post-card-thumb {
        width: 220px;
        min-width: 220px;
        flex-shrink: 0;
        background-color: #f1f5f9;
        overflow: hidden;
    }

    .post-card-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* Cột Ngày / Tháng */
    .post-card-date {
        width: 80px;
        min-width: 80px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 10px;
        border-right: 1px solid #e2e8f0;
    }

    .post-card-date .day-num {
        font-size: 34px;
        font-weight: 700;
        line-height: 1;
        color: #111827;
        font-family: "Playfair Display", Georgia, serif;
    }

    .post-card-date .month-text {
        font-size: 10.5px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        margin-top: 5px;
        letter-spacing: 0.5px;
    }

    /* Cột Tiêu đề & Tóm tắt */
    .post-card-info {
        flex: 1;
        min-width: 0;
        padding: 15px 18px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .post-card-title {
        font-size: 15.5px;
        font-weight: 700;
        line-height: 1.35;
        margin: 0 0 8px 0;
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
        font-size: 13px;
        color: #64748b;
        line-height: 1.5;
        margin: 0;
    }

    /* Khi không có kết quả */
    .search-no-results-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 35px 20px;
        text-align: center;
    }

    /* ==========================================================================
     MODULE SỐ 14: COMMENTS SIDEBAR
     ========================================================================== */
    .recent-comments-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .recent-comment-item {
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
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

    /* ==========================================================================
     3. Khối Số 15: Nằm ngang bên dưới 3 cột
     ========================================================================== */
    .module-15-bottom-bar {
        margin-top: 30px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 20px 25px;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
    }

    .module-15-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 14px 0;
        border-left: 3.5px solid #0284c7;
        padding-left: 10px;
    }

    .module-15-tags-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .module-15-tag-item {
        display: inline-flex;
        align-items: center;
        padding: 6px 14px;
        background-color: #f1f5f9;
        color: #334155;
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
        border-radius: 4px;
        transition: all 0.15s ease;
    }

    .module-15-tag-item:hover {
        background-color: #0284c7;
        color: #ffffff;
    }

    /* Phân trang */
    .search-pagination {
        margin-top: 25px;
        display: flex;
        justify-content: center;
    }

    .search-pagination .nav-links {
        display: flex;
        gap: 6px;
    }

    .search-pagination .page-numbers {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 34px;
        padding: 0 10px;
        border: 1px solid #e2e8f0;
        border-radius: 4px;
        background: #ffffff;
        color: #475569;
        text-decoration: none;
        font-size: 13.5px;
        font-weight: 500;
    }

    .search-pagination .page-numbers.current {
        background: #0284c7;
        border-color: #0284c7;
        color: #ffffff;
    }

    @media (max-width: 768px) {
        .post-card-item {
            flex-direction: column;
        }

        .post-card-thumb {
            width: 100%;
            min-width: 100%;
            height: 180px;
        }

        .post-card-date {
            flex-direction: row;
            width: 100%;
            border-right: none;
            border-bottom: 1px solid #e2e8f0;
            justify-content: flex-start;
            gap: 8px;
            padding: 8px 15px;
        }

        .post-card-date .day-num {
            font-size: 24px;
        }
    }
</style>

<div class="search-layout-wrapper">

    <!-- 1. KHỐI SEARCH (4): Thanh tìm kiếm trên cùng -->
    <section class="search-top-bar-module block-4">
        <div class="search-top-header">
            <h1 class="search-top-title">
                Kết quả tìm kiếm cho: "<span><?php echo esc_html( get_search_query() ); ?></span>"
            </h1>
            <?php if ( have_posts() ) : ?>
                <span class="search-top-count">
                    Tìm thấy <strong><?php global $wp_query; echo $wp_query->found_posts; ?></strong> bài viết phù hợp
                </span>
            <?php endif; ?>
        </div>

        <form role="search" method="get" class="search-input-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <span style="font-size: 16px;">🔍</span>
            <input type="search" placeholder="Nhập từ khóa tìm kiếm khác..." value="<?php echo get_search_query(); ?>" name="s" required />
            <button type="submit">Tìm kiếm</button>
        </form>
    </section>

    <!-- 2. BỐ CỤC 3 CỘT: 13 (Pages) | Search result (5) | 14 (Comments) -->
    <div class="search-three-columns">

        <!-- CỘT BÊN TRÁI: Module số 13 (Pages) - Dạng hình đứng dạng cột / rớt dòng -->
        <div class="search-left-col-13">
            <aside class="widget-box-wrapper block-13">
                <h3 class="widget-title-styled">Pages</h3>
                <div class="widget-striped-bar"></div>

                <div class="widget-inner-white-box">
                    <div class="module-13-vertical-list">
                        <?php if ( ! empty( $pages_posts ) ) : ?>
                            <?php foreach ( $pages_posts as $idx => $p_item ) : 
                                $p_id    = $p_item->ID;
                                $p_title = get_the_title( $p_id );
                                $p_link  = get_permalink( $p_id );
                                $p_img   = nhomf_search_page_image( $p_id, $p_title, $idx );
                                $p_desc  = ! empty( $p_item->post_excerpt ) ? wp_trim_words( $p_item->post_excerpt, 15, '...' ) : wp_trim_words( wp_strip_all_tags( $p_item->post_content ), 15, '...' );
                            ?>
                                <article class="page-item-card">
                                    <h4 class="page-item-title">
                                        <a href="<?php echo esc_url( $p_link ); ?>" title="<?php echo esc_attr( $p_title ); ?>">
                                            <?php echo esc_html( $p_title ); ?>
                                        </a>
                                    </h4>

                                    <div class="page-item-divider"></div>

                                    <div class="page-item-thumb">
                                        <a href="<?php echo esc_url( $p_link ); ?>">
                                            <img src="<?php echo esc_url( $p_img ); ?>" 
                                                 alt="<?php echo esc_attr( $p_title ); ?>" 
                                                 loading="lazy" />
                                        </a>
                                    </div>

                                    <p class="page-item-desc">
                                        <?php echo esc_html( $p_desc ); ?>
                                    </p>
                                </article>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </aside>
        </div>

        <!-- CỘT Ở GIỮA: Search result (5) (Kết quả tìm kiếm) -->
        <div class="search-center-col-5">
            <main id="site-content">
                <?php if ( have_posts() ) : ?>
                    <div class="search-results-list">
                        <?php while ( have_posts() ) : the_post(); 
                            $day = get_the_date('d');
                            $month = get_the_date('m');
                            $res_thumb = nhomf_search_page_image( get_the_ID(), get_the_title() );
                        ?>
                            <article class="post-card-item">
                                <!-- 1. Ảnh Thumbnail -->
                                <div class="post-card-thumb">
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo esc_url( $res_thumb ); ?>" 
                                             alt="<?php the_title_attribute(); ?>" 
                                             loading="lazy" />
                                    </a>
                                </div>

                                <!-- 2. Ngày / Tháng -->
                                <div class="post-card-date">
                                    <div class="day-num"><?php echo $day; ?></div>
                                    <div class="month-text">THÁNG <?php echo $month; ?></div>
                                </div>

                                <!-- 3. Tiêu đề & Tóm tắt -->
                                <div class="post-card-info">
                                    <h2 class="post-card-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>
                                    <p class="post-card-excerpt">
                                        <?php echo wp_trim_words( get_the_excerpt(), 22, ' [...]' ); ?>
                                    </p>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>

                    <!-- Phân trang -->
                    <div class="search-pagination">
                        <?php
                        the_posts_pagination( array(
                            'mid_size'  => 2,
                            'prev_text' => '&laquo; Trước',
                            'next_text' => 'Sau &raquo;',
                        ) );
                        ?>
                    </div>
                <?php else : ?>
                    <div class="search-no-results-box">
                        <p style="color: #64748b; font-size: 15px; margin-bottom: 0;">
                            Không tìm thấy bài viết nào phù hợp với từ khóa "<strong><?php echo esc_html( get_search_query() ); ?></strong>". Vui lòng thử từ khóa khác.
                        </p>
                    </div>
                <?php endif; ?>
            </main>
        </div>

        <!-- CỘT BÊN PHẢI: Module số 14 (Comments) -->
        <div class="search-right-col-14">
            <aside class="widget-box-wrapper block-14">
                <h3 class="widget-title-styled">Comments</h3>
                <div class="widget-striped-bar"></div>

                <div class="widget-inner-white-box">
                    <ul class="recent-comments-list">
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

    </div><!-- .search-three-columns -->

    <!-- 3. KHỐI SỐ 15: Nằm ngang bên dưới 3 cột -->
    <section class="module-15-bottom-bar block-15">
        <h3 class="module-15-title">Khám phá theo chuyên mục & từ khóa</h3>
        <div class="module-15-tags-grid">
            <?php
            $categories = get_categories( array( 'hide_empty' => false ) );
            if ( ! empty( $categories ) ) :
                foreach ( $categories as $cat ) : ?>
                    <a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="module-15-tag-item">
                        📁 <?php echo esc_html( $cat->name ); ?> (<?php echo $cat->count; ?>)
                    </a>
                <?php endforeach;
            endif;
            ?>
        </div>
    </section>

</div><!-- .search-layout-wrapper -->

<?php get_footer(); ?>