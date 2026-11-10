<?php
declare(strict_types=1);

namespace Tests\Part1_TaiKhoan_DuyetSanPham;

use Tests\Support\HttpTestCase;

/**
 * Phần 1 - Tài khoản, phiên đăng nhập và duyệt sản phẩm
 * Thành viên phụ trách: ______________________
 * Đối tượng kiểm thử: category.php
 * Loại test: HTTP: gọi trang/API như trình duyệt (cần composer serve)
 * Danh sách sản phẩm theo danh mục. Gọi trang qua HttpTestCase (loginAs(), post(), get()) rồi kiểm
 * tra mã trạng thái, nội dung trang, chuyển hướng và dữ liệu trong CSDL test.
 *
 * @group part1
 * @group http
 */
final class CategoryPageTest extends HttpTestCase
{
    /**
     * @testdox Chỉ hiển thị sản phẩm thuộc danh mục được chọn
     */
    public function testCategoryPageListsProductsOfThatCategory(): void
    {
        // Gợi ý: Ví dụ danh mục Sneaker Thể Thao có 3 sản phẩm trong dữ liệu mẫu.
        $this->markTestIncomplete('TODO: Chỉ hiển thị sản phẩm thuộc danh mục được chọn');
    }

    /**
     * @testdox Mã danh mục không tồn tại không gây lỗi
     */
    public function testCategoryPageWithUnknownIdHandledGracefully(): void
    {
        $this->markTestIncomplete('TODO: Mã danh mục không tồn tại không gây lỗi');
    }

    /**
     * @testdox Phân trang hoạt động đúng
     */
    public function testCategoryPagePagination(): void
    {
        $this->markTestIncomplete('TODO: Phân trang hoạt động đúng');
    }
}
