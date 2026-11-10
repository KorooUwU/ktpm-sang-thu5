<?php
declare(strict_types=1);

namespace Tests\Part3_QuanTri_Kho_DonHang;

use PHPUnit\Framework\TestCase;

/**
 * Phần 3 - Quản trị sản phẩm, kho, nhập hàng, đơn hàng và tự động hủy đơn
 * Thành viên phụ trách: ______________________
 * Đối tượng kiểm thử: includes/db.php: getSellPrice(), formatPrice(), generateCode()
 * Loại test: Unit: hàm thuần, không ghi dữ liệu
 * Các hàm tính giá bán, định dạng tiền và sinh mã. Toàn bộ lớp này là MẪU đã viết sẵn (có Data
 * Provider), chạy được ngay.
 *
 * @group part3
 * @group unit
 */
final class PriceFormatHelpersTest extends TestCase
{
    /**
     * @testdox getSellPrice() = giá nhập x (1 + %lợi nhuận / 100)
     * @dataProvider sellPriceProvider
     */
    public function testGetSellPriceAppliesProfitRate(int $importPrice, int $profitRate, float $expected): void
    {
        $this->assertEqualsWithDelta($expected, getSellPrice($importPrice, $profitRate), 0.01);
    }

    /**
     * @testdox formatPrice() định dạng số tiền kiểu Việt Nam kèm ký hiệu ₫
     * @dataProvider formatPriceProvider
     */
    public function testFormatPrice(float|int $price, string $expected): void
    {
        $this->assertSame($expected, formatPrice($price));
    }

    /**
     * @testdox generateCode() = tiền tố + 14 chữ số ngày giờ + 3 chữ số ngẫu nhiên
     */
    public function testGenerateCodeStartsWithPrefixAndHasFixedLength(): void
    {
        $this->assertMatchesRegularExpression('/^PN\d{14}\d{3}$/', generateCode('PN'));
        $this->assertStringStartsWith('DH', generateCode('DH'));
    }

    public static function sellPriceProvider(): array
    {
        return [
            'nhập 2.000.000, lợi nhuận 35%' => [2000000, 35, 2700000.0],
            'lợi nhuận 0%' => [1500000, 0, 1500000.0],
            'lợi nhuận 100%' => [1000000, 100, 2000000.0],
            'giá nhập lẻ' => [554125, 30, 720362.5],
        ];
    }

    public static function formatPriceProvider(): array
    {
        return [
            '2.700.000' => [2700000, '2.700.000 ₫'],
            'số 0' => [0, '0 ₫'],
            'dưới 1000' => [999, '999 ₫'],
            'làm tròn lên' => [1234.5, '1.235 ₫'],
            '1 triệu' => [1000000, '1.000.000 ₫'],
        ];
    }
}
