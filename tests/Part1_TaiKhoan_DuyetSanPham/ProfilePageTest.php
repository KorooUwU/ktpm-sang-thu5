<?php
declare(strict_types=1);

namespace Tests\Part1_TaiKhoan_DuyetSanPham;

use Tests\Support\HttpTestCase;

/**
 * Phần 1 - Tài khoản, phiên đăng nhập và duyệt sản phẩm
 * Thành viên phụ trách: ______________________
 * Đối tượng kiểm thử: profile.php (action update_profile, change_password)
 * Loại test: HTTP: gọi trang/API như trình duyệt (cần composer serve)
 * Trang thông tin cá nhân và đổi mật khẩu. Gọi trang qua HttpTestCase (loginAs(), post(), get())
 * rồi kiểm tra mã trạng thái, nội dung trang, chuyển hướng và dữ liệu trong CSDL test.
 *
 * @group part1
 * @group http
 */
final class ProfilePageTest extends HttpTestCase
{
    /**
     * @testdox Chưa đăng nhập mở profile.php bị chuyển về trang đăng nhập
     */
    public function testProfileRequiresLogin(): void
    {
        $this->markTestIncomplete('TODO: Chưa đăng nhập mở profile.php bị chuyển về trang đăng nhập');
    }

    /**
     * @testdox Trang hiển thị đúng họ tên, email, SĐT, địa chỉ hiện tại
     */
    public function testProfileShowsCurrentUserInformation(): void
    {
        $this->markTestIncomplete('TODO: Trang hiển thị đúng họ tên, email, SĐT, địa chỉ hiện tại');
    }

    /**
     * @testdox Cập nhật thông tin hợp lệ được lưu vào CSDL
     */
    public function testUpdateProfileSavesNewInformation(): void
    {
        // Gợi ý: POST action=update_profile rồi SELECT users.
        $this->markTestIncomplete('TODO: Cập nhật thông tin hợp lệ được lưu vào CSDL');
    }

    /**
     * @testdox Cập nhật với SĐT hoặc email sai định dạng bị từ chối
     */
    public function testUpdateProfileRejectsInvalidPhoneOrEmail(): void
    {
        $this->markTestIncomplete('TODO: Cập nhật với SĐT hoặc email sai định dạng bị từ chối');
    }

    /**
     * @testdox Đổi mật khẩu với mật khẩu hiện tại sai bị từ chối
     */
    public function testChangePasswordRejectsWrongCurrentPassword(): void
    {
        // Gợi ý: POST action=change_password.
        $this->markTestIncomplete('TODO: Đổi mật khẩu với mật khẩu hiện tại sai bị từ chối');
    }

    /**
     * @testdox Đổi mật khẩu với xác nhận không khớp bị từ chối
     */
    public function testChangePasswordRejectsMismatchedConfirmation(): void
    {
        $this->markTestIncomplete('TODO: Đổi mật khẩu với xác nhận không khớp bị từ chối');
    }

    /**
     * @testdox Mật khẩu mới tối thiểu 6 ký tự (biên 5, 6, 7)
     * @dataProvider newPasswordProvider
     */
    public function testChangePasswordMinimumLengthBoundary(string $newPassword, bool $accepted): void
    {
        $this->markTestIncomplete('TODO: Mật khẩu mới tối thiểu 6 ký tự (biên 5, 6, 7)');
    }

    /**
     * @testdox Đổi mật khẩu thành công thì lưu băm mới và đăng nhập được bằng mật khẩu mới
     */
    public function testChangePasswordStoresNewBcryptHash(): void
    {
        $this->markTestIncomplete('TODO: Đổi mật khẩu thành công thì lưu băm mới và đăng nhập được bằng mật khẩu mới');
    }

    public static function newPasswordProvider(): array
    {
        return [
            '5 ký tự' => ['12345', false],
            '6 ký tự' => ['123456', true],
            '7 ký tự' => ['1234567', true],
        ];
    }
}
