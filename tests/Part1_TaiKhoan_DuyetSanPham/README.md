# Tài liệu kiểm thử Part 1 - Tài khoản và duyệt sản phẩm

## 1. Mục đích

Tài liệu này mô tả cách chuẩn bị dữ liệu, chạy test, đọc kết quả và chèn ảnh
minh chứng cho các chức năng thuộc Part 1. Phạm vi trọng tâm là chức năng
quản trị tài khoản khách hàng:

- Admin xem danh sách tài khoản.
- Admin thêm tài khoản.
- Admin sửa thông tin tài khoản nhưng không đổi vai trò.
- Admin đặt lại mật khẩu.
- Admin khóa tài khoản khách hàng.
- Tài khoản khách hàng bị khóa bị đá khỏi phiên ở request kế tiếp.
- Admin mở khóa tài khoản khách hàng.
- Hệ thống không cho khóa tài khoản admin.

Các nhánh này liên quan đến `admin/users.php` (khối Toggle lock), `includes/db.php`
(`isLoggedIn()`, `kickIfLocked()`) và các yêu cầu FR-18, FR-19 trong phạm vi
chức năng được chọn.

## 2. File được kiểm thử và vai trò của từng file

| File | Vai trò |
|---|---|
| `admin/users.php` | Xử lý thêm, sửa, đặt lại mật khẩu, khóa/mở khóa và hiển thị người dùng. |
| `includes/db.php` | Kiểm tra trạng thái phiên và tài khoản bị khóa. |
| `tests/Part1_TaiKhoan_DuyetSanPham/AdminUsersPageTest.php` | Test HTTP 10 test case của trang quản trị người dùng. |
| `tests/Part1_TaiKhoan_DuyetSanPham/SessionHelpersTest.php` | Test trực tiếp 9 test case cho `isAdmin()`, `isLoggedIn()`, `kickIfLocked()`. |
| `tests/Support/HttpTestCase.php` | Gửi GET/POST, giữ cookie phiên và mô phỏng hai trình duyệt độc lập. |
| `tests/Support/DatabaseTestCase.php` | Mở transaction và rollback dữ liệu sau mỗi test helper. |
| `tests/Support/DatabaseSeeder.php` | Xóa và nạp lại dữ liệu mẫu cho test HTTP. |

## 3. Điều kiện chạy test

### 3.1. Phần mềm cần có

- PHP 8.1 trở lên theo `composer.json`.
- Composer.
- PHPUnit 9.6.
- PHP extensions: `mysqli`, `curl`.
- MySQL/MariaDB đang chạy.

> Nếu máy đang dùng PHP 8.0, PHPUnit hoặc package trong `vendor` có thể phát
> sinh lỗi tương thích. Cần chọn PHP 8.1+ trong PATH trước khi chạy.

### 3.2. Tạo database test

Test có thao tác `UPDATE`, `INSERT`, `DROP TABLE` và nạp lại dữ liệu. Vì vậy
phải dùng database riêng có tên kết thúc bằng `_test`, không dùng database thật.

```text
mysql -u root -p -e "CREATE DATABASE sneaker_shop_test CHARACTER SET utf8mb4"
mysql -u root -p sneaker_shop_test < database/sneaker_shop.sql
```

Kiểm tra các giá trị trong `phpunit.xml`:

```xml
<env name="DB_HOST" value="localhost"/>
<env name="DB_USER" value="root"/>
<env name="DB_PASS" value="mat_khau_mysql"/>
<env name="DB_NAME" value="sneaker_shop_test" force="true"/>
<env name="APP_TEST_URL" value="http://localhost:8000"/>
```

### 3.3. Khởi động website để chạy test HTTP

Mở terminal thứ nhất tại thư mục project:

```text
composer serve
```

Hoặc chạy trực tiếp:

```text
php -S localhost:8000 -t .
```

Mở terminal thứ hai để chạy PHPUnit. Kiểm tra server trước:

```text
curl http://localhost:8000/login.php
```

Nếu website chưa chạy, các test có nhóm `@group http` sẽ bị PHPUnit đánh dấu
`Skipped`, không phải là kết quả kiểm thử nghiệp vụ thành công.

### 3.4. Các lệnh chạy test và chụp ảnh minh chứng

Chạy riêng 10 test quản lý người dùng:

```text
php vendor\phpunit\phpunit\phpunit tests\Part1_TaiKhoan_DuyetSanPham\AdminUsersPageTest.php --no-coverage
```

Chạy riêng 9 test helper phiên:

```text
php vendor\phpunit\phpunit\phpunit tests\Part1_TaiKhoan_DuyetSanPham\SessionHelpersTest.php --no-coverage
```

Chạy riêng test sanitize:

```text
php vendor\phpunit\phpunit\phpunit tests\Part1_TaiKhoan_DuyetSanPham\SanitizeHelperTest.php --no-coverage
```

Chạy toàn bộ Part 1:

```text
php vendor\phpunit\phpunit\phpunit --testsuite Part1 --no-coverage
```

Chạy một test case bằng mã method:

```text
php vendor\phpunit\phpunit\phpunit tests\Part1_TaiKhoan_DuyetSanPham\AdminUsersPageTest.php --filter testLockCustomerChangesStatusToLocked --no-coverage
```

**Cách chèn ảnh minh chứng:**

1. Chạy đúng lệnh test cần minh chứng.
2. Khi terminal hiện `OK`, chọn vùng terminal có lệnh, số test, số assertion và
   dòng `OK`.
3. Chụp màn hình bằng Snipping Tool hoặc `Win + Shift + S`.
4. Lưu ảnh, ví dụ `evidence/ADM-07-lock-customer.png`.
5. Đặt ảnh trong thư mục `tests/Part1_TaiKhoan_DuyetSanPham/evidence/`.
6. Chèn vào đúng vị trí có chú thích `<!-- CHÈN ẢNH ... -->` bằng Markdown:

```markdown
![Minh chứng ADM-07](evidence/ADM-07-lock-customer.png)
```

Ảnh nên gồm cả câu lệnh đã chạy và kết quả `OK`, không chỉ chụp một phần số
test. Không chụp mật khẩu database hoặc thông tin nhạy cảm.

<!-- CHÈN ẢNH TỔNG QUAN:
![Kết quả toàn bộ Part 1](evidence/part1-all-tests.png)
-->

## 4. Dữ liệu đầu vào cần chuẩn bị

Có thể hiểu dữ liệu đầu vào giống ví dụ "test chức năng like bài viết": muốn
test like thì phải có bài viết, tài khoản và trạng thái like ban đầu. Với chức
năng này, dữ liệu tương ứng là **tài khoản, vai trò, trạng thái tài khoản,
phiên đăng nhập và cookie của trình duyệt**.

### 4.1. Dữ liệu tài khoản mẫu

File `database/sneaker_shop.sql` phải có bảng `users` với các trường:

```text
id, username, password, full_name, email, phone,
address, ward, district, city, role, status, created_at
```

Các dòng dữ liệu tối thiểu:

| id | username | Mật khẩu dùng khi test | role | status | Mục đích |
|---:|---|---|---|---|---|
| 1 | `admin` | `password` | `admin` | `active` | Đăng nhập trang quản trị và kiểm tra không được khóa admin. |
| 2 | `nguyenvana` | `password` | `customer` | `active` | Đối tượng chính để khóa, mở khóa và kiểm tra phiên. |
| 3 | `tranthib` | `password` | `customer` | `active` | Dữ liệu khách hàng thứ hai để kiểm tra danh sách/lọc. |
| 4 | `lehoanghung` | `password` | `customer` | `active` | Dữ liệu bổ sung trong danh sách. |
| 5 | `phamminhcuong` | `password` | `customer` | `active` | Dữ liệu bổ sung trong danh sách. |

Mật khẩu trong database là chuỗi hash, không phải chữ `password` nguyên văn.
Test đăng nhập gửi `password`, còn PHP dùng `password_verify()` để đối chiếu.

### 4.2. Dữ liệu request cho từng chức năng

| Chức năng | Request cần có | Dữ liệu cụ thể |
|---|---|---|
| Xem danh sách | `GET admin/users.php` | Cookie phiên admin hợp lệ. |
| Lọc admin | `GET admin/users.php?role=admin` | `role=admin`, cookie admin. |
| Thêm user | `POST admin/users.php` | `action=add`, username mới, password từ 6 ký tự, full name và các trường liên hệ. |
| Username trùng | `POST admin/users.php` | `action=add`, `username=nguyenvana`. |
| Sửa user | `POST admin/users.php` | `action=edit_user`, `user_id=2`, full name/email/phone mới. |
| Đặt mật khẩu | `POST admin/users.php` | `action=reset_password`, `user_id=2`, `new_password=newpass123`. |
| Khóa customer | `GET admin/users.php?toggle=2` | Cookie admin; user id 2 phải là customer active. |
| Đá phiên | Hai cookie độc lập | Cookie khách đã login user 2 và cookie admin đã login user 1. |
| Mở khóa | Gọi toggle lần thứ hai | User id 2 đang có status `locked`. |
| Không khóa admin | `GET admin/users.php?toggle=1` | Cookie admin; user id 1 có role `admin`. |
| `isLoggedIn()` | Biến `$_SESSION` | `user_id=2`, `role=customer`, status trong DB active/locked. |
| `kickIfLocked()` | Biến `$_SESSION` | Session customer và trạng thái DB tương ứng. |

### 4.3. Cách hệ thống làm sạch dữ liệu giữa các test

- `AdminUsersPageTest::setUp()` gọi `DatabaseSeeder::reload()`, vì HTTP chạy
  trong tiến trình website riêng và không thể rollback từ PHPUnit.
- `DatabaseSeeder` chỉ cho phép database có tên kết thúc bằng `_test`.
- `DatabaseTestCase::setUp()` mở transaction.
- `DatabaseTestCase::tearDown()` rollback và xóa `$_SESSION`.
- Test đá phiên tạo hai cookie jar: một cho customer, một cho admin; nếu dùng
  chung cookie thì không chứng minh được hai phiên độc lập.

## 5. Bảng Test Case chi tiết

Quy ước:

- **Expected Result**: kết quả mong đợi trước khi chạy test.
- **Actual Result**: kết quả PHPUnit thực tế sau khi chạy.
- **Pass/Fail**: `Pass` khi mọi assertion trong test đúng; `Fail` khi có ít
  nhất một assertion sai.
- Với bảng dưới đây, kết quả đã xác nhận là `Pass` trong lần chạy thành công:
  `AdminUsersPageTest`: 10 tests, 40 assertions; `SessionHelpersTest`:
  9 tests, 12 assertions.

### 5.1. Test Case quản lý tài khoản - `AdminUsersPageTest.php`

| TestCase # | Chuỗi trạng thái / điều kiện bất thường | Test Case Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|---|---|
| ADM-01 | Admin active; customer active | Hiển thị danh sách tài khoản | 1. Login `admin/password`.<br>2. GET `admin/users.php`.<br>3. Đọc status và HTML. | Admin id 1; customer id 2; email `vana@email.com`. | HTTP 200; HTML có username, email, vai trò và trạng thái `Hoạt động`. | PHPUnit nhận HTTP 200 và tìm thấy `nguyenvana`, `vana@email.com`, `Khách hàng`, `Hoạt động`. | Pass |
| ADM-02 | Có cả admin và customer | Lọc chỉ tài khoản admin | 1. Login admin.<br>2. GET với `role=admin`.<br>3. Đối chiếu HTML. | Query `role=admin`. | Có admin; không hiển thị email customer. | PHPUnit tìm thấy `admin@sneakershop.vn` và không tìm thấy `vana@email.com`. | Pass |
| ADM-03 | Username mới, password hợp lệ | Thêm customer và lưu password hash | 1. Login admin.<br>2. POST `action=add`.<br>3. SELECT username mới.<br>4. `password_verify()`. | `unit_add_user`, `secret123`, role customer, full name và liên hệ hợp lệ. | Tạo đúng một user; role customer; password xác thực được nhưng không lưu plain text. | Bản ghi được tạo; `password_verify('secret123', hash)` trả true; có message thành công. | Pass |
| ADM-04 | Username đã tồn tại | Từ chối user trùng username | 1. Login admin.<br>2. POST username `nguyenvana`.<br>3. Đếm bản ghi. | Username `nguyenvana`, password hợp lệ, email mới. | Không tạo bản ghi thứ hai; hiển thị `Tên đăng nhập đã tồn tại`. | COUNT vẫn bằng 1 và HTML có thông báo lỗi. | Pass |
| ADM-05 | Customer id 2, role customer | Sửa thông tin nhưng không đổi role | 1. Login admin.<br>2. POST `action=edit_user`.<br>3. SELECT lại bản ghi. | `user_id=2`, full name `Nguyễn Văn A (đã sửa)`, email mới, phone mới. | Thông tin liên hệ cập nhật; role vẫn `customer`. | SELECT trả thông tin mới và role vẫn customer. | Pass |
| ADM-06 | Customer active | Đặt lại mật khẩu | 1. Login admin.<br>2. POST `action=reset_password`.<br>3. Đọc hash mới.<br>4. Verify mật khẩu mới/cũ. | `user_id=2`, `new_password=newpass123`. | Password mới đúng; password cũ sai; lưu dưới dạng hash. | `password_verify()` mới true, cũ false. | Pass |
| ADM-07 | Customer active, chưa có phiên cần kiểm tra | Khóa customer | 1. Login admin.<br>2. GET `toggle=2`.<br>3. SELECT `users.status`. | User id 2, role customer, status active. | Status chuyển từ `active` sang `locked`; có message `Đã khóa`. | SELECT trả `locked`, body có `Đã khóa`. | Pass |
| ADM-08 | Customer đang login; admin login bằng cookie khác | Đá customer ở request kế tiếp | 1. Login customer bằng cookie A.<br>2. Login admin bằng cookie B.<br>3. Admin GET `toggle=2`.<br>4. Cookie A GET `profile.php`. | Cookie A: user 2; cookie B: admin 1; customer status active rồi bị locked. | Request tiếp theo của customer bị redirect `login.php`; session bị hủy. | PHPUnit nhận redirect login và body không còn thông tin customer. | Pass |
| ADM-09 | Customer id 2 đang locked | Mở khóa customer | 1. Login admin.<br>2. GET `toggle=2` lần 1.<br>3. GET `toggle=2` lần 2.<br>4. SELECT status. | User id 2; trạng thái ban đầu active. | Sau lần 2 status là active; body có `Đã mở khóa`. | SELECT trả active và body có message mở khóa. | Pass |
| ADM-10 | Target có role admin | Không cho khóa admin | 1. Login admin.<br>2. GET `toggle=1`.<br>3. SELECT status admin. | User id 1, role admin, status active. | Status vẫn active; có cảnh báo chỉ customer mới được khóa/mở khóa. | Status vẫn active và HTML có đúng thông báo cảnh báo. | Pass |

<!-- CHÈN ẢNH MINH CHỨNG CHO ADM-01 ĐẾN ADM-10:
![Kết quả AdminUsersPageTest](evidence/AdminUsersPageTest.png)
-->

### 5.2. Test Case helper phiên - `SessionHelpersTest.php`

| TestCase # | Chuỗi trạng thái / điều kiện bất thường | Test Case Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|---|---|
| SES-01 | Chưa có session | `isLoggedIn()` khi chưa login | 1. Gán `$_SESSION=[]`.<br>2. Gọi `isLoggedIn()`. | Session rỗng. | Trả `false`. | `assertFalse()` đạt. | Pass |
| SES-02 | Customer active | `isLoggedIn()` với customer hợp lệ | 1. SELECT id `nguyenvana`.<br>2. Gán session customer.<br>3. Gọi helper. | `user_id=2`, `role=customer`, DB status active. | Trả `true`; session giữ nguyên. | `assertTrue()` đạt. | Pass |
| SES-03 | Customer locked | `isLoggedIn()` từ chối user bị khóa | 1. UPDATE user 2 thành locked trong transaction.<br>2. Gán session.<br>3. Gọi helper. | DB status locked; session customer id 2. | Trả false và xóa `$_SESSION`. | `assertFalse()` và session `[]` đạt. | Pass |
| SES-04 | User không tồn tại | Từ chối session chứa id không tồn tại | 1. Gán user id 999999.<br>2. Gọi helper. | `user_id=999999`, role customer. | Trả false và xóa session. | Boolean false và session rỗng. | Pass |
| SES-05 | Customer active | `kickIfLocked()` không đá user hợp lệ | 1. Gán session user 2.<br>2. Gọi helper.<br>3. So sánh session trước/sau. | DB status active. | Không redirect; session giữ nguyên. | Mảng session trước/sau giống nhau. | Pass |
| SES-06 | Customer locked | `kickIfLocked()` hủy session và redirect | 1. Đặt user locked.<br>2. Gọi request qua HTTP ở ADM-08. | Customer cookie đang login; DB status locked. | `session_destroy()`, redirect login, request kết thúc. | Được chứng minh end-to-end qua ADM-08; test helper kiểm tra hợp đồng source của nhánh redirect. | Pass |
| SES-07 | Admin role | `isAdmin()` true với admin | 1. Gán session admin.<br>2. Gọi `isAdmin()`. | `user_id=1`, role admin. | Trả true. | `assertTrue()` đạt. | Pass |
| SES-08 | Customer role | `isAdmin()` false với customer | 1. Gán session customer.<br>2. Gọi helper. | `user_id=2`, role customer. | Trả false. | `assertFalse()` đạt. | Pass |
| SES-09 | Session rỗng | `isAdmin()` false khi chưa login | 1. Xóa session.<br>2. Gọi helper. | `$_SESSION=[]`. | Trả false. | `assertFalse()` đạt. | Pass |

<!-- CHÈN ẢNH MINH CHỨNG CHO SES-01 ĐẾN SES-09:
![Kết quả SessionHelpersTest](evidence/SessionHelpersTest.png)
-->

### 5.3. Test Case `sanitize()`

| TestCase # | Chuỗi trạng thái / điều kiện bất thường | Test Case Description | Test Steps | Test Data | Expected Result | Actual Result | Pass/Fail |
|---|---|---|---|---|---|---|---|
| SAN-01 | Có khoảng trắng hai đầu | Cắt whitespace | Gọi `sanitize($conn, "  abc \n")`. | Chuỗi có space và newline. | Trả `abc`. | `assertSame('abc', actual)` đạt. | Pass |
| SAN-02 | Có Unicode tiếng Việt | Giữ ký tự tiếng Việt | Gọi sanitize với tên có dấu. | ` Nguyễn Văn A `. | Trả `Nguyễn Văn A`. | Kết quả thực tế giữ đúng Unicode. | Pass |
| SAN-03 | Có dấu nháy | Escape dấu nháy | Gọi sanitize với `O'Neil`. | `O'Neil`. | Có backslash trước dấu nháy. | Trả `O\\'Neil`. | Pass |
| SAN-04 | Payload injection | Không để payload trở thành điều kiện SQL | Gọi sanitize; kiểm tra hash chuỗi và cấu trúc payload. | `1' OR '1'='1`. | Dấu nháy được escape; không còn cấu trúc injection nguyên bản. | Hai assertion escape và không chứa payload nguyên bản đều đạt. | Pass |

<!-- CHÈN ẢNH MINH CHỨNG CHO SAN-01 ĐẾN SAN-04:
![Kết quả SanitizeHelperTest](evidence/SanitizeHelperTest.png)
-->

## 6. Trích code minh chứng từ file test

Các đoạn dưới đây là những đoạn code đại diện dùng để chứng minh test không chỉ
kiểm tra giao diện mà còn kiểm tra dữ liệu đầu vào, dữ liệu trong database,
cookie phiên và kết quả thực tế.

### 6.1. Code khóa customer và đối chiếu database

Trích từ `AdminUsersPageTest.php`:

```php
// CLI: php vendor/bin/phpunit --filter testLockCustomerChangesStatusToLocked
$this->adminSession();
$id = $this->userId('nguyenvana');
$actual = $this->get('admin/users.php', ['toggle' => $id]);
$this->assertSame(200, $actual['status']);
$this->assertSame('locked', $this->status($id),
    'Expected locked, actual: ' . $this->status($id));
$this->assertStringContainsString('Đã khóa', $actual['body']);
```

**Ý nghĩa:** dữ liệu đầu vào là customer `nguyenvana`; test gọi đúng request
`toggle`; kết quả thực tế được đối chiếu ở cả database (`status=locked`) và
HTML thông báo.

<!-- CHÈN ẢNH CODE ADM-07:
![Code test khóa customer](evidence/code-ADM-07.png)
-->

### 6.2. Code hai phiên độc lập để chứng minh đá phiên

Trích từ `AdminUsersPageTest.php`:

```php
$customerCookie = $this->createCookieJar();
$adminCookie = $this->createCookieJar();
try {
    $customerLogin = $this->requestWithCookieFile($customerCookie, 'POST', 'login.php', [
        'username' => 'nguyenvana',
        'password' => 'password',
    ]);
    $adminLogin = $this->requestWithCookieFile($adminCookie, 'POST', 'admin/login.php', [
        'username' => 'admin',
        'password' => 'password',
    ]);

    $id = $this->userId('nguyenvana');
    $this->requestWithCookieFile($adminCookie, 'GET', 'admin/users.php', [
        'toggle' => $id,
    ]);
    $actual = $this->requestWithCookieFile($customerCookie, 'GET', 'profile.php');

    $this->assertRedirectTo($actual, 'login.php');
} finally {
    $this->deleteCookieJar($customerCookie);
    $this->deleteCookieJar($adminCookie);
}
```

**Ý nghĩa:** cookie customer và cookie admin là hai dữ liệu đầu vào riêng.
Admin khóa customer, sau đó customer dùng lại cookie cũ để gọi request tiếp
theo. Nếu `kickIfLocked()` hoạt động đúng, request bị redirect về login.

<!-- CHÈN ẢNH CODE ADM-08:
![Code test đá phiên](evidence/code-ADM-08.png)
-->

### 6.3. Code `isLoggedIn()` từ chối customer bị khóa

Trích từ `SessionHelpersTest.php`:

```php
// CLI: php vendor/bin/phpunit --filter testIsLoggedInRejectsLockedAccount
$id = (int) $this->fetchValue(
    "SELECT id FROM users WHERE username='nguyenvana'"
);
self::$conn->query("UPDATE users SET status='locked' WHERE id=$id");
$_SESSION = ['user_id' => $id, 'role' => 'customer'];

$this->assertFalse(isLoggedIn(),
    'Tài khoản locked phải bị từ chối.');
$this->assertSame([], $_SESSION,
    'Kết quả thực tế phải xóa dữ liệu phiên.');
```

**Ý nghĩa:** dữ liệu đầu vào gồm database status `locked` và session customer.
Expected result là false và session rỗng; actual result được kiểm tra bởi hai
assertion.

<!-- CHÈN ẢNH CODE SES-03:
![Code test isLoggedIn tài khoản locked](evidence/code-SES-03.png)
-->

### 6.4. Code không cho khóa admin

Trích từ `AdminUsersPageTest.php`:

```php
// CLI: php vendor/bin/phpunit --filter testAdminAccountCannotBeLocked
$this->adminSession();
$id = $this->userId('admin');
$actual = $this->get('admin/users.php', ['toggle' => $id]);

$this->assertSame(200, $actual['status']);
$this->assertSame('active', $this->status($id),
    'Admin không được phép bị khóa.');
$this->assertStringContainsString(
    'Chỉ được khóa hoặc mở khóa tài khoản khách hàng',
    $actual['body']
);
```

**Ý nghĩa:** dữ liệu đầu vào là user có role `admin`, không phải customer.
Expected result là status vẫn active và có cảnh báo; actual result được đọc từ
database và body.

<!-- CHÈN ẢNH CODE ADM-10:
![Code test không khóa admin](evidence/code-ADM-10.png)
-->

## 7. Code nguồn được kiểm chứng

Để đối chiếu với mã nguồn nghiệp vụ:

- Khối Toggle lock: `admin/users.php`, bắt đầu tại phần `// Toggle lock`.
- `isLoggedIn()`: `includes/db.php`.
- `kickIfLocked()`: `includes/db.php`.
- Helper request/cookie: `tests/Support/HttpTestCase.php`.

Các test dùng assertion cụ thể, không dùng `markTestIncomplete`. Khi assertion
không đúng, PHPUnit hiển thị test case bị lỗi, expected result và actual result
để đối chiếu.

## 8. Kết quả chạy mẫu

Lần chạy thành công toàn bộ Part 1:

```text
OK (111 tests, 214 assertions)
```

Kết quả nhóm trọng tâm:

```text
AdminUsersPageTest:  OK (10 tests, 40 assertions)
SessionHelpersTest:  OK (9 tests, 12 assertions)
```

<!-- CHÈN ẢNH KẾT QUẢ CUỐI CÙNG:
![Kết quả chạy toàn bộ Part 1](evidence/part1-all-tests.png)
-->

Nếu kết quả của máy khác với bảng này, ghi actual result thật của lần chạy vào
README và giữ lại ảnh terminal tương ứng. Không tự ghi `Pass` khi test bị
`Skipped`, `Incomplete` hoặc chưa chạy được do thiếu database/server.
