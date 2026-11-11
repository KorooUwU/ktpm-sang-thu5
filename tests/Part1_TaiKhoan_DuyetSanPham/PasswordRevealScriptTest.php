<?php
declare(strict_types=1);

namespace Tests\Part1_TaiKhoan_DuyetSanPham;

use PHPUnit\Framework\TestCase;

/**
 * Phần 1 - Tài khoản, phiên đăng nhập và duyệt sản phẩm
 * Thành viên phụ trách: ______________________
 * Đối tượng kiểm thử: includes/password-reveal.php (nút con mắt hiện/ẩn mật khẩu)
 * Loại test: Unit: hàm thuần, không ghi dữ liệu
 * Kiểm tra đoạn HTML/CSS/JS dùng chung cho nút con mắt ở các ô mật khẩu. Hai test đầu là MẪU chạy
 * được ngay.
 *
 * @group part1
 * @group unit
 */
final class PasswordRevealScriptTest extends TestCase
{
    /**
     * @testdox Đoạn script tìm mọi ô input type=password
     */
    public function testRevealScriptTargetsPasswordInputs(): void
    {
        ob_start();
        include PROJECT_ROOT . '/includes/password-reveal.php';
        $html = (string) ob_get_clean();
        $this->assertStringContainsString('<script>', $html);
        $this->assertStringContainsString('input[type="password"]', $html);
    }

    /**
     * @testdox Nút con mắt có thuộc tính trợ năng (aria-pressed)
     */
    public function testRevealButtonIsAccessible(): void
    {
        ob_start();
        include PROJECT_ROOT . '/includes/password-reveal.php';
        $html = (string) ob_get_clean();
        $this->assertStringContainsString('aria-pressed', $html);
    }

    /**
     * @testdox Nhấn nút đổi type giữa password và text
     */
    public function testRevealTogglesBetweenPasswordAndText(): void
    {
        // Gợi ý: Đây là mã JavaScript; kiểm tra chuỗi "text"/"password" trong script hoặc dùng trình
        // duyệt tự động ở mức hệ thống.
        ob_start(); include PROJECT_ROOT . '/includes/password-reveal.php'; $html=(string) ob_get_clean(); $this->assertStringContainsString("input.type = 'text'",$html); $this->assertStringContainsString("input.type = 'password'",$html);
    }
}
