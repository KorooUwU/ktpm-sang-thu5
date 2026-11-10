<?php
declare(strict_types=1);

namespace Tests\Part1_TaiKhoan_DuyetSanPham;

use Tests\Support\HttpTestCase;

/**
 * Phần 1 - Tài khoản, phiên đăng nhập và duyệt sản phẩm
 * Thành viên phụ trách: ______________________
 * Đối tượng kiểm thử: admin/_layout.php
 * Loại test: HTTP: gọi trang/API như trình duyệt (cần composer serve)
 * Khung giao diện chung của trang quản trị. Gọi trang qua HttpTestCase (loginAs(), post(), get())
 * rồi kiểm tra mã trạng thái, nội dung trang, chuyển hướng và dữ liệu trong CSDL test.
 *
 * @group part1
 * @group http
 */
final class AdminLayoutTest extends HttpTestCase
{
    /**
     * @testdox Khách chưa đăng nhập bị chuyển về admin/login.php
     */
    public function testLayoutRedirectsGuestToAdminLogin(): void
    {
        $this->markTestIncomplete('TODO: Khách chưa đăng nhập bị chuyển về admin/login.php');
    }

    /**
     * @testdox Phiên khách hàng không vào được trang quản trị
     */
    public function testLayoutRejectsCustomerSession(): void
    {
        $this->markTestIncomplete('TODO: Phiên khách hàng không vào được trang quản trị');
    }

    /**
     * @testdox Hiển thị tên admin và đủ các mục menu
     */
    public function testLayoutShowsAdminNameAndMenu(): void
    {
        $this->markTestIncomplete('TODO: Hiển thị tên admin và đủ các mục menu');
    }
}
