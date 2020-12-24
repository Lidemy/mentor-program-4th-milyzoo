## 請說明雜湊跟加密的差別在哪裡，為什麼密碼要雜湊過後才存入資料庫
### 雜湊跟加密的差別
| 加密 (Encryption) | 雜湊 (Hash) |
| -------- | -------- |
| 可逆     | 不可逆      |
| 可以解密  | 無法還原密碼 |

#### 加密 (Encryption)
加密是將明文資訊改變為難以讀取的密文內容，使之不可讀的過程。只有擁有解密方法的物件，經由解密過程，才能將密文還原為正常可讀的內容。

加密的「一對一關係」：
> 明文 aaa => 進行加密 => 變成密文 bbb

因為加密是可逆的，所以可以解密並回推原本的密碼。
> 密文 bbb => 進行解密 => 得到明文 aaa

#### 雜湊 (Hash)
雜湊和加密一樣都能將明文資訊改變成難以讀取的密文內容，差別在於雜湊「多對一關係」，無法回推出原始的內容。

雜湊的「多對一關係」：

假設現在有三組密碼 `aaa`、`bbb`、`ccc`，經過雜湊演算法後，`aaa` 和 `ccc` 都得到了一樣的雜湊值，卻沒辦法從結果來回推最初的明文是什麼了。
> 明文 aaa => 雜湊 => 5u8ef4w
> 明文 bbb => 雜湊 => s2u8a0y
> 明文 ccc => 雜湊 => 5u8ef4w

## `include`、`require`、`include_once`、`require_once` 的差別
| `include` | `include_once` |
| -------- | -------- | -------- |
| 無法避免檔案重複引入 | 可以避免檔案重複引入 |
| 即使找不到該檔案，程式仍會執行 | 即使找不到該檔案，程式仍會執行 |

| `require` | `require_once` |
| -------- | -------- | -------- |
| 無法避免檔案重複引入 | 可以避免檔案重複引入 |
| 找不到該檔案，程式就會停止執行 | 找不到該檔案，程式就會停止執行 |

若專案較小時不建議使用引入語法，因為比起直接寫入來說，使用引入語法會更消耗系統資源。

## 請說明 SQL Injection 的攻擊原理以及防範方法
### SQL Injection 攻擊原理
SQL Injection（SQL 注入，也稱 SQL 隱碼或 SQL注碼），攻擊者利用網站安全漏洞，在輸入的字串中夾帶 SQL 指令，藉此改變語意，因而達成任意竊取、竄改或破壞資料之目的。

#### 攻擊範例
以網站登入為範例，原本 SQL 的指令為：
```php
sql = printf(
  "SELECT * FROM users WHERE username = '%s' AND ，password 欄位輸入 = '%s'",
  $username,
  $password
); // printf()：格式化字串
```
攻擊者在 username 欄位輸入 `aaa'#`，password 欄位隨意輸入 `bbb` 後，SQL 指令會變成：
```php
sql = "SELECT * FROM users WHERE username = 'aaa'#' AND password = 'bbb'";
```
而上述中的 `#` 在 SQL 語法中代表「註解」的意思，所以 `#` 後面的指令都會被省略。
所以即使密碼不正確，但只要帳號正確也能登入網站，因為 SQL 指令被竄改後，實際指令已變成：
```php
sql = "SELECT * FROM users WHERE username = 'aaa'
```
同理，就算不知道帳號或密碼，也能用 SQL Injection 類似手法來冒充他人。

### SQL Injection 防範方法
使用 Prepared Statement（參數化查詢）的方法，是目前最有效預防 SQL Injection 攻擊手法的防禦方式

#### 什麼是 Prepared Statement？
Prepared Statement（參數化查詢）是指在需要使用者填入資料或數值的地方，使用參數來傳入數值，讓輸入數值都能變成「純文字」來處理。

```php
$sql = "SELECT * FROM users WHERE username=? AND password=?"; // 原本的指令
$stmt = $conn->prepare($sql); // 把值傳入 prepare()
$stmt->bind_param("ss", $username, $password); // 將參數放進去，組成完整指令
// ss 指有兩個字，s 代表 string，如果要放整數就寫 i，代表 int
$result = $stmt->execute(); // 執行 query

if(!$result) {
  die($conn->error);
} 
$result = $stmt->get_result(); // 如果執行成功就把 query 拿回來
```

##  請說明 XSS 的攻擊原理以及防範方法
XSS（Cross-Site Scripting），中文是「跨網站指令碼」，和 SQL Injection 原理有點雷同，都是利用網站安全漏洞，攻擊者在能夠輸入資料的欄位，將程式碼注入到網頁上，藉此獲取網站內的敏感資訊，或造成網站癱瘓，不同於 SQL Injection 只針對 SQL 指令，XSS 攻擊則包含注入 JavaScript、HTML⋯等等數種方式。

#### 攻擊範例
沒有做 XXS 防範時，顯示內容的地方的結構是：
```html
<p class='nickname'><?php echo $row['nickname']; ?><p>
```
如果此時有攻擊者在輸入欄位填寫 `<script>alert("hacked!")</script>`，瀏覽器就會把文字解讀成程式碼，而不是解讀成文字。

### XSS 防範方法
在上述有提到瀏覽器會把文字解讀成程式碼，所以防範方法就是讓瀏覽器知道這段內容是「純文字」，而不是程式碼就好了。

以 PHP 為例，可以使用內建的 `htmlspecialchars` 函式來達成跳脫字元（escape character），瀏覽器將會把剛剛的 `<script>alert("hacked!")</script>` 編碼成 `&lt;script&gtalert(&quot;,hacked!&quot;,)&lt;/scrip&gt;`

## 請說明 CSRF 的攻擊原理以及防範方法
### CSRF 攻擊原理
跨站請求偽造（CSRF，全名是 Cross-site request forgery），簡單來說是「欺騙使用者的瀏覽器，讓其以使用者的名義執行某些操作」，由於瀏覽器曾經認證過，所以被存取的網站會認為是真正的使用者操作而去執行一些操作（例如：發郵件、訊息，甚至轉帳或購買商品）。

#### 攻擊範例
假設有間銀行網站執行轉帳的 URL 位址是 `https://bank.example.com/withdraw?account=AccoutName&amount=1000&for=PayeeName`

惡意攻擊者如果故意製作出一個假的心理測驗網站，並在按鈕設置程式碼為：
```html
<img src='https://bank.example.com/withdraw?account=Alice&amount=100&for=Badman' width='0' height='0' />
<a href='/test'>開始心理測驗</a>
```
如果使用者剛從銀行網站認證過不久，登入資訊尚未過期，這時使用者點擊心理測驗按鈕，將會被扣款成功，這樣的狀況即是使用者在不知情的狀況下從 B 網站操作 A 網站的行為。

### CSRF 防範方法
防範 CSRF 攻擊的本質就是 **要求網站能夠識別出哪些請求是非正常使用者主動發起的**，目前防範的方法有很多種，以下列舉幾種：
#### 1. 加上圖形驗證碼、簡訊驗證碼
雖然這個做法安全，但缺點是很麻煩，較適合使用在金流網站。

（麻煩原因例如：操作部落格時，每刪除一篇文章都要驗證一次，使用者會沒有耐心）

#### 2. 加上 CSRF token（權杖同步模式）
權杖同步模式（Synchronizer token pattern，簡稱STP），原理是確保有些資訊只有使用者知道，並在使用者自願發出請求時，才會附上 CSRF token。
方法：在表格內新增一個隱藏的欄位，叫做 `csrftoken`，裡面的值由 server 隨機產生，並且存在 server 的 session 中。
```html
<input type="hidden" name="csrftoken" value="fj1iro2jro12ijoi1"/>
```
如此一來，在表單送出後，server 會比對表單中的 `csrftoken` 與自己 session 裡面存的是不是一樣的，藉此驗證是否為本人發出的 request。

雖然這個方法看似安全，但還是有其他漏洞，假設這個 server 支持跨來源的 request 時，惡意攻擊者就可以先發起一個 request 來取得 csrftoken，這樣就能進行攻擊了。

#### 3. 瀏覽器的防禦：SameSite cookie
目前 Chrome 與 Opera 上加入了這個功能：SameSite cookie，簡單來說，就是在跨站請求時，讓伺服端無法從 cookie 中取得 session Id。

使用方式：

原本設置 Cookie 的 header 長這樣
```php
Set-Cookie: session_id=ewfewjf23o1;
```
只要在後面多加一個 SameSite 即可
```php
Set-Cookie: session_id=ewfewjf23o1; SameSite
```


SameSite 有兩種模式：`Lax`、`Strict`

**Strict（默認模式）：**`Set-Cookie: foo=bar; SameSite=Lax`
代表這個 cookie 只允許 same site 使用，不應該在任何的 cross site request 被加上去，所以剛剛有提到的 `<a href="">`、`<form>`、`new XMLHttpRequest`，只要是瀏覽器驗證不是在同一個 site 底下發出的 request，全部都不會帶上這個 cookie。

因為這個模式較為嚴謹，連 `<a href="..."` 都不會帶上 cookie 的話，當我們從 Google 搜尋結果或其他地方點進的連結時，那個網站就會變成是登出狀態，造成使用者體驗非常不好。

**Lax：**`Set-Cookie: session_id=ewfewjf23o1; SameSite=Strict`
Lax 模式則放寬了一些限制，例如 `<a>`、`<link rel="prerender">`、`<form method="GET">` 這些標籤都會帶上 cookie，但是 POST 方法的 form，或只要是 POST, PUT, DELETE 這些方法，就不會帶上 cookie。
相對 Strict 模式來說較有彈性，即使從其他網站連進你的網站時，仍可維持登入狀態，也能防範 CSRF 攻擊。（特別要注意的是：Lax 模式之下就沒辦法擋掉 GET 形式的 CSRF 攻擊）

---

參考資料：
- [一次看懂 SQL Injection 的攻擊原理](https://medium.com/%E7%A8%8B%E5%BC%8F%E7%8C%BF%E5%90%83%E9%A6%99%E8%95%89/%E6%B7%BA%E8%AB%87%E9%A7%AD%E5%AE%A2%E6%94%BB%E6%93%8A-%E7%B6%B2%E7%AB%99%E5%AE%89%E5%85%A8-%E4%B8%80%E6%AC%A1%E7%9C%8B%E6%87%82-sql-injection-%E7%9A%84%E6%94%BB%E6%93%8A%E5%8E%9F%E7%90%86-b1994fd2392a)
- [加密 - 維基百科，自由的百科全書](https://zh.wikipedia.org/wiki/%E5%8A%A0%E5%AF%86)
- [parameterized statement - 維基百科，自由的百科全書](https://zh.wikipedia.org/wiki/%E5%8F%83%E6%95%B8%E5%8C%96%E6%9F%A5%E8%A9%A2)
- [跨站請求偽造 - 維基百科，自由的百科全書](https://zh.wikipedia.org/wiki/%E8%B7%A8%E7%AB%99%E8%AF%B7%E6%B1%82%E4%BC%AA%E9%80%A0)
- [讓我們來談談 CSRF](https://blog.techbridge.cc/2017/02/25/csrf-introduction/)
- [程式猿必讀-防範CSRF跨站請求偽造](https://codertw.com/%E7%A8%8B%E5%BC%8F%E8%AA%9E%E8%A8%80/109775/)