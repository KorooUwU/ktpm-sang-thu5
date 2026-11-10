<?php
declare(strict_types=1);

namespace Tests\Part1_TaiKhoan_DuyetSanPham;

use Tests\Support\HttpTestCase;

/**
 * Phần 1 - Tài khoản, phiên đăng nhập và duyệt sản phẩm
 * Thành viên phụ trách: ______________________
 * Đối tượng kiểm thử: search.php (FR-04)
 * Loại test: HTTP: gọi trang/API như trình duyệt (cần composer serve)
 * Tìm kiếm và lọc sản phẩm (từ khóa q, danh mục cat_id, giá từ min_price, giá đến max_price; 4 sản
 * phẩm mỗi trang, sắp xếp theo tên). Gọi trang qua HttpTestCase (loginAs(), post(), get()) rồi
 * kiểm tra mã trạng thái, nội dung trang, chuyển hướng và dữ liệu trong CSDL test.
 *
 * @group part1
 * @group http
 */
final class SearchPageTest extends HttpTestCase
{
    /**
     * @testdox Chưa nhập điều kiện nào thì chỉ hiện form, chưa hiện danh sách
     */
    public function testSearchWithoutConditionsShowsNoResultSection(): void
    {
        $this->markTestIncomplete('TODO: Chưa nhập điều kiện nào thì chỉ hiện form, chưa hiện danh sách');
    }

    /**
     * @testdox Tìm theo từ khóa không phân biệt hoa thường
     */
    public function testSearchByKeywordIsCaseInsensitive(): void
    {
        // Gợi ý: q=Nike và q=nike cho cùng kết quả.
        $this->markTestIncomplete('TODO: Tìm theo từ khóa không phân biệt hoa thường');
    }

    /**
     * @testdox Từ khóa không có kết quả hiện thông báo không tìm thấy
     */
    public function testSearchWithUnknownKeywordShowsNotFoundMessage(): void
    {
        // Gợi ý: q=xyzabc123: 'Tìm thấy 0 sản phẩm'.
        $this->markTestIncomplete('TODO: Từ khóa không có kết quả hiện thông báo không tìm thấy');
    }

    /**
     * @testdox Lọc theo danh mục chỉ trả về sản phẩm của danh mục
     */
    public function testSearchByCategoryOnlyReturnsThatCategory(): void
    {
        $this->markTestIncomplete('TODO: Lọc theo danh mục chỉ trả về sản phẩm của danh mục');
    }

    /**
     * @testdox Lọc khoảng giá tính cả hai đầu mút
     * @dataProvider priceRangeProvider
     */
    public function testSearchPriceRangeBoundaries(int $min, int $max, int $expectedCount): void
    {
        // Gợi ý: Giá từ = giá đến = 2.700.000 phải ra Nike Air Max 270; giá từ lớn hơn giá đến phải ra
        // 0 sản phẩm.
        $this->markTestIncomplete('TODO: Lọc khoảng giá tính cả hai đầu mút');
    }

    /**
     * @testdox Kết hợp từ khóa, danh mục và khoảng giá thì kết quả thỏa đồng thời cả ba
     */
    public function testSearchCombinesKeywordCategoryAndPrice(): void
    {
        $this->markTestIncomplete('TODO: Kết hợp từ khóa, danh mục và khoảng giá thì kết quả thỏa đồng thời cả ba');
    }

    /**
     * @testdox Kết quả sắp xếp theo tên A-Z, 4 sản phẩm mỗi trang
     */
    public function testSearchResultsAreSortedByNameAndPaged(): void
    {
        $this->markTestIncomplete('TODO: Kết quả sắp xếp theo tên A-Z, 4 sản phẩm mỗi trang');
    }

    public static function priceRangeProvider(): array
    {
        return [
            'trùng đúng một giá 2.700.000' => [2700000, 2700000, 1],
            'giá từ lớn hơn giá đến' => [3000000, 2000000, 0],
        ];
    }
}
