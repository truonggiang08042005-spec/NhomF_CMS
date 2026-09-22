<?php
/**
 * The template for displaying all pages (module-Pages)
 *
 * @package WordPress
 * @subpackage Twenty_Twenty
 */

get_header();

// Lấy danh sách các Trang (Pages) trong hệ thống
$all_pages = get_posts( array(
    'post_type'      => 'page',
    'post_status'    => 'publish',
    'posts_per_page' => 12,
    'orderby'        => 'date',
    'order'          => 'ASC',
) );

// Dữ liệu mẫu chuẩn theo ảnh đề bài (dùng làm fallback hoặc ảnh chuẩn)
$sample_pages = array(
    array(
        'title'   => 'Ngành Công Nghệ Thông Tin',
        'desc'    => 'Trang bị cho sinh viên kiến thức và kỹ năng để trở thành nhà phát triển phần mềm chuyên nghiệp.',
        'image'   => get_template_directory_uri() . '/assets/images/page-cntt.svg',
    ),
    array(
        'title'   => 'Ngành Truyền Thông & Mạng Máy Tính',
        'desc'    => 'Sinh viên có khả năng nghiên cứu, thiết kế, phát triển và triển khai các ứng dụng về các công nghệ Mạng máy tính.',
        'image'   => get_template_directory_uri() . '/assets/images/page-network.svg',
    ),
    array(
        'title'   => 'Ngành Thiết Kế Đồ Họa',
        'desc'    => 'Cung cấp các kiến thức về thiết kế đồ họa và công nghệ thông tin đa phương tiện.',
        'image'   => get_template_directory_uri() . '/assets/images/page-graphic-design.svg',
    ),
);
?>

<style>
  /* Khung bọc toàn bộ trang Pages */
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

  /* Lưới 3 cột trên màn hình lớn */
  .pages-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 28px;
  }

  /* Mỗi thẻ Page (Card) */
  .page-card-item {
      display: flex;
      flex-direction: column;
      background: #ffffff;
      border-radius: 4px;
      transition: transform 0.2s ease;
  }

  /* Tiêu đề trang */
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

  /* RESPONSIVE: Màn hình điện thoại/tablet tự động chuyển về "Hình đứng dạng cột" */
  @media (max-width: 820px) {
      .pages-grid {
          grid-template-columns: 1fr; /* Hình đứng dạng cột */
          gap: 30px;
          max-width: 500px;
          margin: 0 auto;
      }

      .page-card-thumb {
          height: 210px;
      }
  }
</style>

<main id="site-content">
    <div class="pages-page-container">
        <!-- Tiêu đề mục: Trang mới nhất -->
        <div class="pages-section-header">
            <h1 class="pages-section-title">Trang mới nhất</h1>
        </div>

        <!-- Lưới các trang (3 cột ngang trên Desktop, hình đứng dạng cột trên Mobile) -->
        <div class="pages-grid">
            <?php 
            // Nếu có các trang trong Database
            $rendered_count = 0;
            if ( ! empty( $all_pages ) ) :
                foreach ( $all_pages as $idx => $page_item ) : 
                    // Bỏ qua trang mẫu rỗng nếu đã có các trang chuyên ngành
                    if ( $page_item->post_name === 'trang-mau' && count( $all_pages ) > 1 ) {
                        continue;
                    }

                    $title = get_the_title( $page_item->ID );
                    $link  = get_permalink( $page_item->ID );
                    $desc  = ! empty( $page_item->post_excerpt ) ? $page_item->post_excerpt : wp_trim_words( $page_item->post_content, 25, '...' );

                    // Chọn ảnh đại diện tương ứng
                    if ( has_post_thumbnail( $page_item->ID ) ) {
                        $img_src = get_the_post_thumbnail_url( $page_item->ID, 'medium_large' );
                    } else {
                        // Gán ảnh minh họa chuẩn theo ngành hoặc ảnh mặc định
                        if ( stripos( $title, 'Thông Tin' ) !== false || stripos( $title, 'CNTT' ) !== false ) {
                            $img_src = $sample_pages[0]['image'];
                        } elseif ( stripos( $title, 'Mạng' ) !== false || stripos( $title, 'Truyền Thông' ) !== false ) {
                            $img_src = $sample_pages[1]['image'];
                        } elseif ( stripos( $title, 'Đồ Họa' ) !== false || stripos( $title, 'Thiết Kế' ) !== false ) {
                            $img_src = $sample_pages[2]['image'];
                        } else {
                            $sample_idx = $rendered_count % count( $sample_pages );
                            $img_src = $sample_pages[$sample_idx]['image'];
                        }
                    }
                    $rendered_count++;
            ?>
                    <article class="page-card-item">
                        <h2 class="page-card-title">
                            <a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $title ); ?></a>
                        </h2>
                        
                        <div class="page-card-divider"></div>

                        <div class="page-card-thumb">
                            <a href="<?php echo esc_url( $link ); ?>" aria-label="<?php echo esc_attr( $title ); ?>">
                                <img src="<?php echo esc_url( $img_src ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy" />
                            </a>
                        </div>

                        <p class="page-card-desc">
                            <?php echo esc_html( $desc ); ?>
                        </p>
                    </article>
            <?php 
                endforeach; 
            endif; 
            
            // Trường hợp chưa có đủ 3 trang, hiển thị bổ sung dữ liệu mẫu theo đúng ảnh
            if ( $rendered_count < 3 ) :
                for ( $i = $rendered_count; $i < 3; $i++ ) : 
                    $sample = $sample_pages[$i];
            ?>
                    <article class="page-card-item">
                        <h2 class="page-card-title">
                            <a href="#"><?php echo esc_html( $sample['title'] ); ?></a>
                        </h2>
                        
                        <div class="page-card-divider"></div>

                        <div class="page-card-thumb">
                            <a href="#" aria-label="<?php echo esc_attr( $sample['title'] ); ?>">
                                <img src="<?php echo esc_url( $sample['image'] ); ?>" alt="<?php echo esc_attr( $sample['title'] ); ?>" loading="lazy" />
                            </a>
                        </div>

                        <p class="page-card-desc">
                            <?php echo esc_html( $sample['desc'] ); ?>
                        </p>
                    </article>
            <?php 
                endfor;
            endif;
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
