<?php
/**
 * The template for displaying all pages (module-Pages / Module số 13)
 *
 * Yêu cầu:
 * 1. Lấy bài viết trực tiếp từ bài viết có sẵn trong website (Ảnh 2: Máy giặt, Robot hút bụi, Đồng hồ, PC...), không tạo thêm bài mới.
 * 2. Hiển thị dạng 3 bài viết trên 1 dòng (Ảnh 1).
 * 3. Tạo thêm "Hình đứng dạng cột" (Ảnh 3) hiển thị trực quan ngay trên trang.
 * 4. Responsive tự động rớt dòng trên màn hình điện thoại / thiết bị di động.
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 */

get_header();

// Lấy danh sách các bài viết có sẵn của bạn trong Database (không tạo thêm bài mới)
$user_posts = get_posts( array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 6,
    'orderby'        => 'date',
    'order'          => 'DESC',
) );

function nhomf_get_featured_image( $post_id, $post_title ) {
    $theme_uri = get_template_directory_uri();
    
    // Gán ảnh vector minh họa chuẩn theo tên bài viết của bạn
    $title_lower = mb_strtolower( $post_title, 'UTF-8' );
    if ( strpos( $title_lower, 'giặt' ) !== false || strpos( $title_lower, 'electrolux' ) !== false ) {
        $fallback_svg = $theme_uri . '/assets/images/post-may-giat.svg';
    } elseif ( strpos( $title_lower, 'robot' ) !== false || strpos( $title_lower, 'hút bụi' ) !== false || strpos( $title_lower, 'dreame' ) !== false ) {
        $fallback_svg = $theme_uri . '/assets/images/post-robot-hut-bui.svg';
    } elseif ( strpos( $title_lower, 'đồng hồ' ) !== false || strpos( $title_lower, 'epos' ) !== false ) {
        $fallback_svg = $theme_uri . '/assets/images/post-dong-ho.svg';
    } elseif ( strpos( $title_lower, 'pc' ) !== false || strpos( $title_lower, 'gaming' ) !== false ) {
        $fallback_svg = $theme_uri . '/assets/images/post-pc-gaming.svg';
    } elseif ( strpos( $title_lower, 'laptop' ) !== false || strpos( $title_lower, 'macbook' ) !== false ) {
        $fallback_svg = $theme_uri . '/assets/images/post-laptop.svg';
    } else {
        $fallback_svg = $theme_uri . '/assets/images/page-cntt.svg';
    }

    // Nếu có ảnh đại diện và file ảnh vật lý thực sự tồn tại trên máy
    if ( has_post_thumbnail( $post_id ) ) {
        $thumb_id   = get_post_thumbnail_id( $post_id );
        $thumb_file = get_attached_file( $thumb_id );
        if ( $thumb_file && file_exists( $thumb_file ) ) {
            $thumb_url = get_the_post_thumbnail_url( $post_id, 'large' );
            if ( ! empty( $thumb_url ) ) {
                return $thumb_url;
            }
        }
    }
    
    return $fallback_svg;
}

// Hàm lấy tóm tắt nội dung gọn gàng
function nhomf_get_clean_excerpt( $post ) {
    if ( ! empty( $post->post_excerpt ) ) {
        return wp_trim_words( $post->post_excerpt, 22, '...' );
    }
    $clean_content = strip_shortcodes( $post->post_content );
    $clean_content = wp_strip_all_tags( $clean_content );
    if ( ! empty( $clean_content ) ) {
        return wp_trim_words( $clean_content, 22, '...' );
    }
    return 'Thông tin chi tiết về sản phẩm chính hãng, bảo hành đầy đủ, giá tốt nhất thị trường.';
}

// 3 bài viết đầu tiên cho phần Lưới ngang
$first_3_posts = array_slice( $user_posts, 0, 3 );
?>

<style>
  /* Khung bọc toàn bộ nội dung */
  .module-pages-wrapper {
      max-width: 1100px;
      margin: 35px auto 70px auto;
      padding: 0 15px;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  /* Khối section */
  .module-section {
      margin-bottom: 60px;
  }

  /* Header tiêu đề "Trang mới nhất" */
  .section-header-box {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 2px solid #e2e8f0;
      padding-bottom: 12px;
      margin-bottom: 28px;
  }

  .section-title {
      font-size: 22px;
      font-weight: 700;
      color: #0284c7; /* Màu xanh dương chủ đạo */
      margin: 0;
      font-family: Arial, "Helvetica Neue", sans-serif;
  }

  .section-badge {
      display: inline-block;
      font-size: 12px;
      font-weight: 600;
      color: #0369a1;
      background: #e0f2fe;
      padding: 4px 10px;
      border-radius: 20px;
  }

  /* ========================================================
     PHẦN 1: DẠNG 3 BÀI VIẾT TRÊN 1 DÒNG (ẢNH THỨ 1)
     ======================================================== */
  .posts-grid-3cols {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 28px;
  }

  /* Thẻ bài viết (Card) */
  .post-card-item {
      display: flex;
      flex-direction: column;
      background: #ffffff;
      border-radius: 4px;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .post-card-item:hover {
      transform: translateY(-2px);
  }

  /* Tiêu đề bài viết */
  .card-item-title {
      font-size: 15.5px;
      font-weight: 600;
      color: #1e293b;
      margin: 0 0 8px 0;
      line-height: 1.4;
      font-family: Arial, "Helvetica Neue", sans-serif;
      min-height: 44px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
  }

  .card-item-title a {
      color: #1e293b;
      text-decoration: none;
      transition: color 0.2s;
  }

  .card-item-title a:hover {
      color: #0284c7;
  }

  /* Vạch gạch ngang nhỏ trang trí dưới tiêu đề */
  .card-item-divider {
      width: 45px;
      height: 2.5px;
      background-color: #cbd5e1;
      margin-bottom: 12px;
      border-radius: 1px;
  }

  /* Khung hình ảnh Thumbnail */
  .card-item-thumb {
      width: 100%;
      height: 195px;
      overflow: hidden;
      border-radius: 3px;
      background-color: #f1f5f9;
      border: 1px solid #e2e8f0;
      display: block;
      position: relative;
  }

  .card-item-thumb a {
      display: block;
      width: 100%;
      height: 100%;
  }

  .card-item-thumb img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      transition: transform 0.3s ease;
  }

  .post-card-item:hover .card-item-thumb img {
      transform: scale(1.04);
  }

  /* Đoạn mô tả bài viết */
  .card-item-desc {
      font-size: 13.5px;
      color: #475569;
      line-height: 1.6;
      margin-top: 12px;
      margin-bottom: 0;
  }

  /* ========================================================
     PHẦN 2: HÌNH ĐỨNG DẠNG CỘT (ẢNH THỨ 3)
     ======================================================== */
  .vertical-column-layout {
      max-width: 460px;
      display: flex;
      flex-direction: column;
      gap: 32px;
      border-left: 3px solid #0284c7;
      padding-left: 20px;
      margin-top: 10px;
  }

  .vertical-column-layout .card-item-title {
      min-height: auto;
  }

  .vertical-column-layout .card-item-thumb {
      height: 230px;
  }

  /* Đường ngăn cách giữa 2 phần demo */
  .sections-separator {
      border: 0;
      border-top: 1px dashed #cbd5e1;
      margin: 50px 0;
  }

  /* ========================================================
     RESPONSIVE: Tự động rớt dòng thành 1 cột trên màn hình nhỏ
     "Theo như vị trí hiển thị: thì SV hãy cho nó rớt dòng (dạng responsive)
     Như vậy mỗi dòng: 1 bài viết"
     ======================================================== */
  @media (max-width: 820px) {
      .posts-grid-3cols {
          grid-template-columns: 1fr !important; /* Rớt dòng: mỗi dòng 1 bài viết */
          gap: 30px;
          max-width: 500px;
          margin: 0 auto;
      }

      .card-item-thumb {
          height: 220px;
      }
  }
</style>

<main id="site-content">
    <div class="module-pages-wrapper">

        <!-- ========================================================
             1. DẠNG 3 BÀI VIẾT TRÊN 1 DÒNG (THEO ẢNH 1 & ẢNH 2)
             ======================================================== -->
        <section class="module-section">
            <div class="section-header-box">
                <h1 class="section-title">Trang mới nhất</h1>
                <span class="section-badge"></span>
            </div>

            <div class="posts-grid-3cols">
                <?php if ( ! empty( $first_3_posts ) ) : ?>
                    <?php foreach ( $first_3_posts as $post_item ) : 
                        $p_id    = $post_item->ID;
                        $p_title = get_the_title( $p_id );
                        $p_link  = get_permalink( $p_id );
                        $p_img   = nhomf_get_featured_image( $p_id, $p_title );
                        $p_desc  = nhomf_get_clean_excerpt( $post_item );
                    ?>
                        <article class="post-card-item">
                            <h2 class="card-item-title">
                                <a href="<?php echo esc_url( $p_link ); ?>" title="<?php echo esc_attr( $p_title ); ?>">
                                    <?php echo esc_html( $p_title ); ?>
                                </a>
                            </h2>

                            <div class="card-item-divider"></div>

                            <div class="card-item-thumb">
                                <a href="<?php echo esc_url( $p_link ); ?>" aria-label="<?php echo esc_attr( $p_title ); ?>">
                                    <img src="<?php echo esc_url( $p_img ); ?>" 
                                         alt="<?php echo esc_attr( $p_title ); ?>" 
                                         loading="lazy"
                                         onerror="this.src='<?php echo esc_url( $p_img ); ?>';" />
                                </a>
                            </div>

                            <p class="card-item-desc">
                                <?php echo esc_html( $p_desc ); ?>
                            </p>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

        <hr class="sections-separator" />

        <!-- ========================================================
             2. HÌNH ĐỨNG DẠNG CỘT (THEO ĐÚNG ẢNH THỨ 3 CỦA THẦY)
             ======================================================== -->
        <section class="module-section">
            <div class="section-header-box">
                <h2 class="section-title">Trang mới nhất</h2>
                <span class="section-badge" style="background:#fef3c7; color:#92400e;"></span>
            </div>

            <div class="vertical-column-layout">
                <?php if ( ! empty( $first_3_posts ) ) : ?>
                    <?php foreach ( $first_3_posts as $post_item ) : 
                        $p_id    = $post_item->ID;
                        $p_title = get_the_title( $p_id );
                        $p_link  = get_permalink( $p_id );
                        $p_img   = nhomf_get_featured_image( $p_id, $p_title );
                        $p_desc  = nhomf_get_clean_excerpt( $post_item );
                    ?>
                        <article class="post-card-item">
                            <h3 class="card-item-title">
                                <a href="<?php echo esc_url( $p_link ); ?>" title="<?php echo esc_attr( $p_title ); ?>">
                                    <?php echo esc_html( $p_title ); ?>
                                </a>
                            </h3>

                            <div class="card-item-divider"></div>

                            <div class="card-item-thumb">
                                <a href="<?php echo esc_url( $p_link ); ?>" aria-label="<?php echo esc_attr( $p_title ); ?>">
                                    <img src="<?php echo esc_url( $p_img ); ?>" 
                                         alt="<?php echo esc_attr( $p_title ); ?>" 
                                         loading="lazy"
                                         onerror="this.src='<?php echo esc_url( $p_img ); ?>';" />
                                </a>
                            </div>

                            <p class="card-item-desc">
                                <?php echo esc_html( $p_desc ); ?>
                            </p>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>

    </div>
</main>

<?php get_footer(); ?>
