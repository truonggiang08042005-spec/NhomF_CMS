<?php
/**
 * The template for displaying all pages (module-Pages / Module số 13)
 *
 * Yêu cầu Module 13:
 * - Theo hình chụp: 3 bài viết trên 1 dòng
 * - Vị trí hiển thị: cho nó rớt dòng dạng responsive (mỗi dòng: 1 bài viết)
 * - Dữ liệu: Lấy trực tiếp từ file (không tạo thêm bài trong Database, giữ nguyên bài có sẵn)
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 */

get_header();

// 1. Dữ liệu bài viết lấy trực tiếp từ file (theo đúng hình chụp đề bài)
$file_posts = array(
    array(
        'title' => 'Ngành Công Nghệ Thông Tin',
        'desc'  => 'Trang bị cho sinh viên kiến thức và kỹ năng để trở thành nhà phát triển phần mềm chuyên nghiệp.',
        'image' => get_template_directory_uri() . '/assets/images/page-cntt.svg',
        'link'  => '#',
    ),
    array(
        'title' => 'Ngành Truyền Thông & Mạng Máy Tính',
        'desc'  => 'Sinh viên có khả năng nghiên cứu, thiết kế, phát triển và triển khai các ứng dụng về các công nghệ Mạng máy tính.',
        'image' => get_template_directory_uri() . '/assets/images/page-network.svg',
        'link'  => '#',
    ),
    array(
        'title' => 'Ngành Thiết Kế Đồ Họa',
        'desc'  => 'Cung cấp các kiến thức về thiết kế đồ họa và công nghệ thông tin đa phương tiện.',
        'image' => get_template_directory_uri() . '/assets/images/page-graphic-design.svg',
        'link'  => '#',
    ),
);

// 2. Tùy chọn: Nếu muốn lấy từ những bài viết có sẵn của bạn trong Database (không tạo thêm bài mới)
// Đặt $use_existing_db_posts = true nếu muốn hiển thị bài viết sẵn có (Laptop, Máy giặt, PC, Đồng hồ...)
$use_existing_db_posts = false;

if ( $use_existing_db_posts ) {
    $db_posts = get_posts( array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 3,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ) );

    if ( ! empty( $db_posts ) ) {
        $display_items = array();
        foreach ( $db_posts as $idx => $p ) {
            $img = has_post_thumbnail( $p->ID ) ? get_the_post_thumbnail_url( $p->ID, 'medium_large' ) : $file_posts[$idx % count($file_posts)]['image'];
            $excerpt = ! empty( $p->post_excerpt ) ? $p->post_excerpt : wp_trim_words( $p->post_content, 22, '...' );
            $display_items[] = array(
                'title' => get_the_title( $p->ID ),
                'desc'  => $excerpt,
                'image' => $img,
                'link'  => get_permalink( $p->ID ),
            );
        }
    } else {
        $display_items = $file_posts;
    }
} else {
    // Mặc định: Lấy 3 bài viết chuẩn từ file theo đúng ảnh đề bài
    $display_items = $file_posts;
}
?>

<style>
  /* Khung bọc toàn bộ module 13 */
  .pages-page-container {
      max-width: 1100px;
      margin: 40px auto 60px auto;
      padding: 0 15px;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  /* Tiêu đề "Trang mới nhất" */
  .pages-section-header {
      margin-bottom: 25px;
      padding-bottom: 10px;
      border-bottom: 1px solid #e5e7eb;
  }

  .pages-section-title {
      font-size: 22px;
      font-weight: 700;
      color: #0284c7; /* Màu xanh dương hiện đại theo mẫu */
      margin: 0;
      font-family: Arial, "Helvetica Neue", sans-serif;
  }

  /* Theo hình chụp là: 3 bài viết trên 1 dòng (Desktop) */
  .pages-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 28px;
  }

  /* Mỗi thẻ bài viết (Card) */
  .page-card-item {
      display: flex;
      flex-direction: column;
      background: #ffffff;
      border-radius: 4px;
      transition: transform 0.2s ease;
  }

  /* Tiêu đề bài viết */
  .page-card-title {
      font-size: 16.5px;
      font-weight: 600;
      color: #1e293b;
      margin: 0 0 8px 0;
      line-height: 1.35;
      font-family: Arial, "Helvetica Neue", sans-serif;
  }

  .page-card-title a {
      color: #1e293b;
      text-decoration: none;
      transition: color 0.2s;
  }

  .page-card-title a:hover {
      color: #0284c7;
  }

  /* Vạch gạch trang trí nhỏ dưới tiêu đề */
  .page-card-divider {
      width: 45px;
      height: 2.5px;
      background-color: #cbd5e1;
      margin-bottom: 14px;
      border-radius: 1px;
  }

  /* Ảnh đại diện (Thumbnail) */
  .page-card-thumb {
      width: 100%;
      height: 190px;
      overflow: hidden;
      border-radius: 3px;
      background-color: #f1f5f9;
      border: 1px solid #e2e8f0;
      display: block;
  }

  .page-card-thumb a {
      display: block;
      width: 100%;
      height: 100%;
  }

  .page-card-thumb img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      transition: transform 0.3s ease;
  }

  .page-card-item:hover .page-card-thumb img {
      transform: scale(1.04);
  }

  /* Đoạn mô tả / tóm tắt nội dung */
  .page-card-desc {
      font-size: 13.5px;
      color: #475569;
      line-height: 1.6;
      margin-top: 12px;
      margin-bottom: 0;
  }

  /* ========================================================
     RESPONSIVE (Theo yêu cầu đề bài):
     "Theo như vị trí hiển thị: thì SV hãy cho nó rớt dòng (dạng reponsive)
     Như vậy mỗi dòng: 1 bài viết"
     ======================================================== */
  @media (max-width: 820px) {
      .pages-grid {
          grid-template-columns: 1fr !important; /* Rớt dòng: mỗi dòng 1 bài viết */
          gap: 30px;
          max-width: 520px;
          margin: 0 auto;
      }

      .page-card-thumb {
          height: 220px;
      }
  }
</style>

<main id="site-content">
    <div class="pages-page-container">
        <!-- Tiêu đề mục: Trang mới nhất -->
        <div class="pages-section-header">
            <h1 class="pages-section-title">Trang mới nhất</h1>
        </div>

        <!-- Lưới bài viết (3 bài viết trên 1 dòng, rớt dòng mỗi dòng 1 bài khi responsive) -->
        <div class="pages-grid">
            <?php foreach ( $display_items as $item ) : ?>
                <article class="page-card-item">
                    <h2 class="page-card-title">
                        <a href="<?php echo esc_url( $item['link'] ); ?>"><?php echo esc_html( $item['title'] ); ?></a>
                    </h2>
                    
                    <div class="page-card-divider"></div>

                    <div class="page-card-thumb">
                        <a href="<?php echo esc_url( $item['link'] ); ?>" aria-label="<?php echo esc_attr( $item['title'] ); ?>">
                            <img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?>" loading="lazy" />
                        </a>
                    </div>

                    <p class="page-card-desc">
                        <?php echo esc_html( $item['desc'] ); ?>
                    </p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
