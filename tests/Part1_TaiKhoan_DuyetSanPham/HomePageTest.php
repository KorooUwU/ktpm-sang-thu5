<?php
declare(strict_types=1);

namespace Tests\Part1_TaiKhoan_DuyetSanPham;

use Tests\Support\HttpTestCase;

/**
 * Phần 1 - Tài khoản, phiên đăng nhập và duyệt sản phẩm
 * Thành viên phụ trách: ______________________
 * Đối tượng kiểm thử: index.php, includes/header.php, includes/footer.php
 * Loại test: HTTP: gọi trang/API như trình duyệt (cần composer serve)
 * Trang chủ khách ghé thăm. Gọi trang qua HttpTestCase (loginAs(), post(), get()) rồi kiểm tra mã
 * trạng thái, nội dung trang, chuyển hướng và dữ liệu trong CSDL test.
 *
 * @group part1
 * @group http
 */
final class HomePageTest extends HttpTestCase
{
    /**
     * @testdox Trang chủ mở được khi chưa đăng nhập (HTTP 200)
     */
    public function testHomePageLoadsForGuest(): void
    {
        $this->markTestIncomplete('TODO: Trang chủ mở được khi chưa đăng nhập (HTTP 200)');
    }

    /**
     * @testdox Chỉ hiển thị sản phẩm đang hoạt động
     */
    public function testHomePageShowsOnlyActiveProducts(): void
    {
        // Gợi ý: Đặt một sản phẩm status = inactive rồi kiểm tra không còn trên trang.
        $this->markTestIncomplete('TODO: Chỉ hiển thị sản phẩm đang hoạt động');
    }

    /**
     * @testdox Giá hiển thị đúng định dạng 2.700.000 ₫
     */
    public function testHomePageShowsFormattedPrices(): void
    {
        $this->markTestIncomplete('TODO: Giá hiển thị đúng định dạng 2.700.000 ₫');
    }

    /**
     * @testdox Menu hiện Đăng nhập/Đăng ký cho khách, hiện tên người dùng sau khi đăng nhập
     */
    public function testHeaderShowsLoginLinksForGuestAndNameForCustomer(): void
    {
        $this->markTestIncomplete('TODO: Menu hiện Đăng nhập/Đăng ký cho khách, hiện tên người dùng sau khi đăng nhập');
    }
}
