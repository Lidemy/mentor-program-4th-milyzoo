## 請簡單解釋什麼是 Single Page Application
![](https://imgpile.com/images/7GzJZM.jpg)

在提到 Single Page Application 之前，我們可以先了解與其相對應關係的 **多頁面應用程式（Multiple Page Application）**。以往製作網頁大多使用 Multiple Page 的設計方式，只要執行一個功能或動作就會重新載入至新的頁面。

而單頁面應用程式（Single Page Application，簡稱 SPA），意思就是網站在同一個頁面下，透過 AJAX 來取得資料，來達到不需跳轉頁面就能執行基本的建立、讀取、修改、刪除資料功能，藉此能達到比較好的使用者體驗。

範例：Gmail、Spotify。

## SPA 的優缺點為何
### 優點
1. 使用者體驗佳，只需「部分」更新頁面內容，改善以往只為了一個小地方就必須重新載入網頁的困擾。
2. 前後端分離，前端負責頁面的呈現，後端只需要處理資料。

### 缺點
1. 需要先下載大量 JavaScript 檔案，隨後才開始渲染畫面，造成進入網站第一畫面時需要等待較長的反應時間。
2. 因為資料皆由 JavaScript 動態產生，伺服器僅提供幾乎是空殼的 HTML，使 SEO（搜尋引擎最佳化）較差。

## 這週這種後端負責提供只輸出資料的 API，前端一律都用 Ajax 串接的寫法，跟之前透過 PHP 直接輸出內容的留言板有什麼不同？
### 透過 PHP 直接輸出內容
- 前端頁面同時參雜 HTML、PHP 語法，程式碼除了閱讀不便，也不好管理。
- Client 端從頁面 A 發出請求後，伺服器會先從後端取得資料，再將資料與前端語法組合，並渲染成畫面 B，最後才回傳到 Client 端，所以每次操作都會跳轉頁面。

### 後端提供 API，前端使用 Ajax 串接
前端透過 AJAX 來取得後端所寫的 API 資料，而伺服器接收後，會將資料以 JSON 格式（或其他格式）回傳，與上者的差別在於 SPA 接收到資料後，畫面是由 JavaScript 動態渲染的，所以畫面不會換頁。

---

參考：
- [SPA 圖片來源](https://lvivity.com/single-page-app-vs-multi-page-app)
- [前後端分離與 SPA](https://blog.techbridge.cc/2017/09/16/frontend-backend-mvc/)
- [單一頁面應用程式](https://mybaseball52.medium.com/%E5%96%AE%E4%B8%80%E9%A0%81%E9%9D%A2%E6%87%89%E7%94%A8%E7%A8%8B%E5%BC%8F-c98c8a17081)