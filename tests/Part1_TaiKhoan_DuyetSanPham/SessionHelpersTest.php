<?php
declare(strict_types=1);

namespace Tests\Part1_TaiKhoan_DuyetSanPham;

use Tests\Support\DatabaseTestCase;

/**
 * Phần 1 - Tài khoản, phiên đăng nhập và duyệt sản phẩm
 * Thành viên phụ trách: ______________________
 * Đối tượng kiểm thử: includes/db.php: isAdmin(), isLoggedIn(), kickIfLocked(), redirect()
 * Loại test: Integration: hàm có dùng CSDL test (tự rollback)
 * Kiểm tra các hàm phiên đăng nhập. Ba test đầu là MẪU đã viết sẵn, chạy được ngay để kiểm tra môi
 * trường.
 *
 * @group part1
 * @group integration
 */
final class SessionHelpersTest extends DatabaseTestCase
{
    /**
     * @testdox isAdmin() trả về true khi phiên có role = admin
     */
    public function testIsAdminReturnsTrueForAdminRole(): void
    {
        $_SESSION = ['user_id' => 1, 'role' => 'admin'];
        $this->assertTrue(isAdmin());
    }

    /**
     * @testdox isAdmin() trả về false khi role = customer
     */
    public function testIsAdminReturnsFalseForCustomerRole(): void
    {
        $_SESSION = ['user_id' => 2, 'role' => 'customer'];
        $this->assertFalse(isAdmin());
    }

    /**
     * @testdox isAdmin() trả về false khi chưa đăng nhập
     */
    public function testIsAdminReturnsFalseWhenSessionIsEmpty(): void
    {
        $_SESSION = [];
        $this->assertFalse(isAdmin());
    }

    /**
     * @testdox isLoggedIn() trả về false khi chưa có phiên
     */
    public function testIsLoggedInReturnsFalseWhenNoSession(): void
    {
        // Gợi ý: Để $_SESSION rỗng rồi gọi isLoggedIn().
        $this->markTestIncomplete('TODO: isLoggedIn() trả về false khi chưa có phiên');
    }

    /**
     * @testdox isLoggedIn() trả về true với khách hàng đang hoạt động
     */
    public function testIsLoggedInReturnsTrueForActiveCustomer(): void
    {
        // Gợi ý: Đặt $_SESSION['user_id'] = id của nguyenvana (đọc từ bảng users).
        $this->markTestIncomplete('TODO: isLoggedIn() trả về true với khách hàng đang hoạt động');
    }

    /**
     * @testdox isLoggedIn() từ chối tài khoản đã bị khóa
     */
    public function testIsLoggedInRejectsLockedAccount(): void
    {
        // Gợi ý: Cập nhật users.status = 'locked' trong transaction rồi gọi hàm.
        $this->markTestIncomplete('TODO: isLoggedIn() từ chối tài khoản đã bị khóa');
    }

    /**
     * @testdox isLoggedIn() từ chối phiên của tài khoản không còn tồn tại
     */
    public function testIsLoggedInRejectsDeletedAccount(): void
    {
        // Gợi ý: Dùng user_id không có trong bảng users.
        $this->markTestIncomplete('TODO: isLoggedIn() từ chối phiên của tài khoản không còn tồn tại');
    }

    /**
     * @testdox kickIfLocked() giữ nguyên phiên của khách hàng đang hoạt động
     */
    public function testKickIfLockedKeepsActiveCustomerSession(): void
    {
        // Gợi ý: Gọi hàm và kiểm tra $_SESSION còn nguyên.
        $this->markTestIncomplete('TODO: kickIfLocked() giữ nguyên phiên của khách hàng đang hoạt động');
    }

    /**
     * @testdox kickIfLocked() hủy phiên và chuyển về trang đăng nhập khi tài khoản bị khóa
     */
    public function testKickIfLockedDestroysSessionOfLockedCustomer(): void
    {
        // Gợi ý: Hàm gọi redirect() và exit nên không chạy trực tiếp được trong PHPUnit: kiểm tra qua
        // HTTP trong AdminUsersPageTest (khóa xong, khách đang đăng nhập bị đá ra).
        $this->markTestIncomplete('TODO: kickIfLocked() hủy phiên và chuyển về trang đăng nhập khi tài khoản bị khóa');
    }
}
