## 什麼是 Ajax？
AJAX 是利用 JavaScript 和伺服器交換資料的一種方式，只要是任何非同步與伺服器交換資料的 JavaScript 都可以稱做 AJAX。全名是 Asynchronous JavaScript and XML（即非同步的 JavaScript 和 XML），全名中的 XML 是因為早期的資料格式都是使用 XML，但現在大多改為使用 JSON 格式。

「非同步」是 AJAX 最大的特點，這代表它可以與伺服溝通、交換資料、以及更新頁面，且不需要重整網頁。最常見的例子：在註冊帳號時，不需刷新頁面就能驗證信箱或用戶名是否已被使用。

## 用 Ajax 與我們用表單送出資料的差別在哪？
在瀏覽器向伺服器發送請求後：
- 使用表單傳送資料的話會跳到另一個網址，並把伺服器回傳的 response 給瀏覽器而直接渲染成新頁面，單純只透過 HTML 的元素來傳送資料，和 JavaScript 毫無關係。比起和伺服器交換資料，更像是帶著參數到指定頁面去。
- 使用 Ajax 來傳送資料，則是將伺服器回傳的 response 給瀏覽器後，再把結果給 JavsScript，此時即可利用 JavsScript 來處理這些資料並呈現出想要的畫面，也不需要刷新頁面。

## JSONP 是什麼？
除了使用上題所提到的 AJAX 和表單來傳送資料以外，JSONP 也是一種交換資料的方式，JSONP 為JSON with Padding 的簡稱，其中的 padding 在這裡是指「填充」的意思。

在 HTML 中有幾個標籤不受同源政策所規範（例如：`<img src="">`、`<script src="">`，跨網域的網址亦能載入），JSONP 就是利用其原理來取得資料。（目前 JSONP 這個方法很少被使用）

簡易實作方法：

利用 `<script>` 標籤載入不同源的資料
```html
<script src="不同源的資料網址"></script>
```
上述的「不同源的資料網址」所拿到的資料格式內容可以是一個 function，裡面有回傳的資料
```json
setData([
  {
   "id": 1,
   "name": "Tom"
  }
])
```
宣告 function 後，即可取得資料
```javascript
<script>
  function setData (response) {
    console.log(response);
  }
</script>
```

## 要如何存取跨網域的 API？
不受 [同源政策](https://developer.mozilla.org/zh-TW/docs/Web/Security/Same-origin_policy) 影響，能直接存取跨網域資料的方法有：
- 使用 node.js
- JSONP

因為瀏覽器受到同源政策的限制，需要使用 [跨來源資源共用](https://developer.mozilla.org/zh-TW/docs/Web/HTTP/CORS)（Cross-Origin Resource Sharing，簡稱 CORS）。

根據規範，想開放跨來源能夠存取資料的話， Server 必須在 Response 的 Header 裡面加上`Access-Control-Allow-Origin`，例如：
![](https://i.imgur.com/laBReDI.jpg)

> `Access-Control-Allow-Origin: *`（此處的 `*` 代表所有的 origin 都可以存取）

換言之，如果該 Server 沒有在 Response 的 Header 裡面加上`Access-Control-Allow-Origin`，其他網域就絕對無法取得 Response。

## 為什麼我們在第四週時沒碰到跨網域的問題，這週卻碰到了？
![](https://i.imgur.com/ZTFCesL.png)

在第四週是使用 node.js 直接發送請求給伺服器，接收到的回應也是直接回傳給 node.js，兩者差別在於這週使用瀏覽器的 JavaScript 發送請求時，中間多了「瀏覽器」幫忙處理，而瀏覽器基於安全性考量受到 [同源政策](https://developer.mozilla.org/zh-TW/docs/Web/Security/Same-origin_policy) 的限制。

同源政策是為了避免不同網域間任意取得資源，跨來源的資料必須在某些特定情況下，或利用 [CORS](https://developer.mozilla.org/zh-TW/docs/Web/HTTP/CORS) 機制，才得以存取跨來源資料。

特別要注意的是，當瀏覽器發送請求給伺服器而受到同源政策的影響，無法把結果回傳給 JavaScript 時，但是「Request 還是有發出去」，瀏覽器也「確實有收到 Response」，只是被擋掉了。

---

參考：
- [輕鬆理解 Ajax 與跨來源請求](https://blog.techbridge.cc/2017/05/20/api-ajax-cors-and-jsonp/)
- [前端基礎 JavaScript篇：網頁與伺服器的溝通](https://medium.com/@hugh_Program_learning_diary_Js/%E5%89%8D%E7%AB%AF%E5%9F%BA%E7%A4%8E-javascript%E7%AF%87-%E7%B6%B2%E9%A0%81%E8%88%87%E4%BC%BA%E6%9C%8D%E5%99%A8%E7%9A%84%E6%BA%9D%E9%80%9A-eb921b02e836)
- [Same Origin Policy 同源政策 ! 一切安全的基礎](https://medium.com/@jaydenlin/same-origin-policy-%E5%90%8C%E6%BA%90%E6%94%BF%E7%AD%96-%E4%B8%80%E5%88%87%E5%AE%89%E5%85%A8%E7%9A%84%E5%9F%BA%E7%A4%8E-36432565a226)