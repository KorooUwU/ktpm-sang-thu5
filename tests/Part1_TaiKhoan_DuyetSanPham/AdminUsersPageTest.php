<?php
declare(strict_types=1);

namespace Tests\Part1_TaiKhoan_DuyetSanPham;

use Tests\Support\HttpTestCase;

/**
 * Phần 1 - Tài khoản, phiên đăng nhập và duyệt sản phẩm
 * Thành viên phụ trách: ______________________
 * Đối tượng kiểm thử: admin/users.php (FR-28, FR-29)
 * Loại test: HTTP: gọi trang/API như trình duyệt (cần composer serve)
 * Quản lý người dùng: khóa, mở khóa, thêm, sửa, đặt lại mật khẩu. Hệ thống KHÔNG cho đổi vai trò
 * tài khoản đã tạo. Gọi trang qua HttpTestCase (loginAs(), post(), get()) rồi kiểm tra mã trạng
 * thái, nội dung trang, chuyển hướng và dữ liệu trong CSDL test.
 *
 * @group part1
 * @group http
 */
final class AdminUsersPageTest extends HttpTestCase
{
    /**
     * @testdox Danh sách hiển thị tên, email, vai trò và trạng thái
     */
    public function testUsersPageListsAccountsWithRoleAndStatus(): void
    {
        $this->markTestIncomplete('TODO: Danh sách hiển thị tên, email, vai trò và trạng thái');
    }

    /**
     * @testdox Lọc theo vai trò Khách hàng / Admin
     */
    public function testUsersPageFiltersByRole(): void
    {
        $this->markTestIncomplete('TODO: Lọc theo vai trò Khách hàng / Admin');
    }

    /**
     * @testdox Thêm người dùng mới (action=add) lưu mật khẩu băm
     */
    public function testAddUserCreatesAccountWithHashedPassword(): void
    {
        $this->markTestIncomplete('TODO: Thêm người dùng mới (action=add) lưu mật khẩu băm');
    }

    /**
     * @testdox Thêm người dùng trùng tên đăng nhập bị từ chối
     */
    public function testAddUserRejectsDuplicateUsername(): void
    {
        $this->markTestIncomplete('TODO: Thêm người dùng trùng tên đăng nhập bị từ chối');
    }

    /**
     * @testdox Sửa thông tin (action=edit_user) không làm đổi vai trò
     */
    public function testEditUserUpdatesInformationButNotRole(): void
    {
        // Gợi ý: Form sửa không có ô vai trò; sau khi sửa SELECT users.role vẫn như cũ.
        $this->markTestIncomplete('TODO: Sửa thông tin (action=edit_user) không làm đổi vai trò');
    }

    /**
     * @testdox Đặt lại mật khẩu (action=reset_password) rồi đăng nhập được bằng mật khẩu mới
     */
    public function testResetPasswordLetsUserLoginWithNewPassword(): void
    {
        $this->markTestIncomplete('TODO: Đặt lại mật khẩu (action=reset_password) rồi đăng nhập được bằng mật khẩu mới');
    }

    /**
     * @testdox Khóa tài khoản khách hàng chuyển status sang locked
     */
    public function testLockCustomerChangesStatusToLocked(): void
    {
        $this->markTestIncomplete('TODO: Khóa tài khoản khách hàng chuyển status sang locked');
    }

    /**
     * @testdox Khách đang đăng nhập bị đá ra ở yêu cầu kế tiếp sau khi bị khóa
     */
    public function testLockedCustomerIsKickedOnNextRequest(): void
    {
        // Gợi ý: Hai cookie jar: một của khách, một của admin (kiểm chứng kickIfLocked()).
        $this->markTestIncomplete('TODO: Khách đang đăng nhập bị đá ra ở yêu cầu kế tiếp sau khi bị khóa');
    }

    /**
     * @testdox Mở khóa xong khách đăng nhập lại được
     */
    public function testUnlockCustomerAllowsLoginAgain(): void
    {
        $this->markTestIncomplete('TODO: Mở khóa xong khách đăng nhập lại được');
    }

    /**
     * @testdox Không khóa được tài khoản quản trị viên
     */
    public function testAdminAccountCannotBeLocked(): void
    {
        $this->markTestIncomplete('TODO: Không khóa được tài khoản quản trị viên');
    }
}
