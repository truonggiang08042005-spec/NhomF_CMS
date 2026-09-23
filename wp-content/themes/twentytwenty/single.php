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
  /* Khung chứa bài viết chi tiết */
  .detail-post-container {
      max-width: 900px;
      margin: 40px auto 60px auto;
      padding: 35px 40px;
      background: #ffffff;
      border: 1px solid #e5e7eb;
      border-radius: 6px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
  }

  /* Khung Header: Tiêu đề + Huy hiệu Đồng hồ (Date Badge) */
  .detail-header-wrapper {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: 25px;
      position: relative;
  }

  /* Tiêu đề bài viết */
  .detail-post-title {
      font-size: 28px;
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
      width: 62px;
      height: 62px;
      min-width: 62px;
      background: #f2be1a; /* Màu vàng cam ấm chuẩn như ảnh mẫu */
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

  /* Cụm ngày/tháng phân số + năm */
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
      font-size: 13.5px;
      font-weight: 600;
      line-height: 1;
      padding-bottom: 2px;
      letter-spacing: -0.2px;
  }

  .clock-divider-line {
      width: 17px;
      height: 1.2px;
      background-color: #2b2b2b;
      margin: 1px 0;
  }

  .clock-month {
      font-size: 13.5px;
      font-weight: 600;
      line-height: 1;
      padding-top: 2px;
      letter-spacing: -0.2px;
  }

  .clock-year {
      font-size: 13px;
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
      margin: 25px 0 30px 0;
  }

  .detail-divider::before {
      content: "";
      position: absolute;
      top: -5px;
      left: 50px;
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

  /* Đoạn sapo/excerpt in nghiêng màu xám đậm */
  .detail-excerpt,
  .detail-excerpt p,
  .detail-content.no-excerpt > p:first-of-type {
      font-style: italic;
      color: #4b5563;
      font-size: 16px;
      line-height: 1.7;
      margin-bottom: 22px;
  }

  .detail-content p {
      margin-bottom: 20px;
      text-align: justify;
  }

  .detail-content img {
      max-width: 100%;
      height: auto;
      border-radius: 4px;
      margin: 20px 0;
  }

  /* Responsive Mobile */
  @media (max-width: 768px) {
      .detail-post-container {
          margin: 20px 10px;
          padding: 20px 18px;
      }

      .detail-post-title {
          font-size: 22px;
      }

      .detail-clock-badge {
          width: 52px;
          height: 52px;
          min-width: 52px;
      }

      .clock-day, .clock-month {
          font-size: 11px;
      }

      .clock-divider-line {
          width: 14px;
      }

      .clock-year {
          font-size: 11px;
      }

      .detail-divider::before {
          left: 30px;
      }
  }
</style>

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
                
                ?>
            </article>
        <?php endwhile; ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
