<?php
declare(strict_types=1);

namespace Tests\Part3_QuanTri_Kho_DonHang;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * Phần 3 - Quản trị sản phẩm, kho, đơn hàng và tự động hủy đơn
 * Đối tượng kiểm thử: includes/db.php: getSellPrice(), formatPrice(), generateCode()
 * Loại test: Unit - chỉ kiểm tra hàm thuần, không truy cập CSDL hay HTTP.
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
    public function testGetSellPriceAppliesProfitRate(int $importPrice, float $profitRate, float $expected): void
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
        $code = generateCode('PN');

        $this->assertMatchesRegularExpression('/^PN\d{14}\d{3}$/', $code);
        $this->assertSame(19, strlen($code));
        $this->assertSame('DH', substr(generateCode('DH'), 0, 2));

        $datePart = substr($code, 2, 14);
        $date = DateTimeImmutable::createFromFormat('!YmdHis', $datePart);
        $this->assertNotFalse($date, 'Phần ngày giờ phải đúng định dạng YmdHis.');
        $this->assertSame($datePart, $date->format('YmdHis'));

        $randomPart = (int) substr($code, -3);
        $this->assertGreaterThanOrEqual(100, $randomPart);
        $this->assertLessThanOrEqual(999, $randomPart);
    }

    public static function sellPriceProvider(): array
    {
        return [
            'nhập 2.000.000, lợi nhuận 35%' => [2000000, 35.0, 2700000.0],
            'lợi nhuận 0%' => [1500000, 0.0, 1500000.0],
            'lợi nhuận 100%' => [1000000, 100.0, 2000000.0],
            'giá nhập lẻ' => [554125, 30.0, 720362.5],
            'giá nhập bằng 0' => [0, 35.0, 0.0],
            'tỷ lệ lợi nhuận thập phân' => [800000, 12.5, 900000.0],
        ];
    }

    public static function formatPriceProvider(): array
    {
        return [
            '2.700.000' => [2700000, '2.700.000 ₫'],
            'số 0' => [0, '0 ₫'],
            'dưới 1000' => [999, '999 ₫'],
            'làm tròn lên' => [1234.5, '1.235 ₫'],
            'làm tròn xuống' => [1234.4, '1.234 ₫'],
            'số âm' => [-1234.5, '-1.235 ₫'],
            '1 triệu' => [1000000, '1.000.000 ₫'],
        ];
    }
}
