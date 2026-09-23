<?php
/**
 * The template for displaying all single posts (Detail page)
 * Structure matching wireframe design: Left (Categories) | Center (Detail Content) | Right (Recent Posts)
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

  .recent-posts-white-box ul li::before {
      content: "»";
      color: #2a6fbe;
      font-weight: bold;
      margin-right: 10px;
      font-size: 15px;
  }

  .recent-posts-white-box ul li a {
      color: #334155;
      text-decoration: none;
      font-weight: 500;
      font-size: 13.5px;
      line-height: 1.4;
      transition: color 0.2s ease-in-out;
  }

  .recent-posts-white-box ul li a:hover {
      color: #1d4ed8;
      text-decoration: underline;
  }
</style>

<div class="page-three-column-layout">
    
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

                    <?php 
                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }
                    ?>
                </article>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    

</div>

<?php get_footer(); ?>
