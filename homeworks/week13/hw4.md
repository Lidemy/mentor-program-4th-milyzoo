## Webpack 是做什麼用的？可以不用它嗎？
### Webpack 是做什麼用的？
Webpack 是一個模組打包工具，能將眾多模組與資源打包成一組檔案。

雖然在 ES6 語法中官方已經有提供模組規範（叫做 ES Modules，能夠支援 import 和 export），但仍存在舊瀏覽器不支援新語法的問題，而 Webpack 能解決舊瀏覽器不支援部分新語法的問題，並編譯我們需要預先處理的內容，轉換成瀏覽器看得懂的語言。

功能舉例：
- 打包多個 `.js` 檔案成單一檔案（可以寫模組化的 JavaScript，不再需要在 HTML 中引入所有 JS 檔案）
- 撰寫 JavaScript ES6 或以上的語法（結合 Babel 工具協助轉譯）
- 編譯 Sass/SCSS、Pug 
- 處理圖片與字型我們家

### 可以不用 webpack 嗎？
webpack 較適合用在大型的專案上，因為大型專案需要管理眾多不同類型的檔案，使用 webpack 有利於後續管理及維護，但如果專案規模較小，載入資源不多，不使用 webpack 也是可行的。

## gulp 跟 webpack 有什麼不一樣？
gulp 是任務管理工具，用於自動化耗時且重複的任務，藉此提高開發效率，例如：編譯語法、壓縮檔案、指定任務執行順序等功能。 

webpack 的定位是模組打包工具，主要是透過 loader（載入程式） 和 plugins（插件） 將各種模組與資源打包，並轉換成瀏覽器能使用的程式碼。

雖然 gulp 與 webpack 的定位大不相同，但有些流程與功能兩者均能完成，導致使用者容易將兩者混淆。

## CSS Selector 權重的計算方式為何？
### CSS Selector 的優先權
在談論 CSS Selector 權重的「計算方式」之前，我們先來了解 CSS Selector 的**優先權**，在優先權規則中，從高至低排列分別為：

> Animation（動畫執行期間）> !important > inline style > ID > Class 與屬性選取器 > 元素選擇器 > ＊通用選取器 > 繼承的屬性

### CSS Selector 的類型
#### 1. Animation（動畫執行期間）
關鍵影格（@keyframes）中的 CSS 屬性在「動畫執行期間」擁有絕對的優先權。
#### 2. !important
!important 是 CSS 中的特殊規則，只要在 CSS 屬性後面接上「!important」，將會變成極高的優先權，是人人懼怕的大魔王。

```html
<p class="title">Hello</p>
```
```css
p {
  color: red !important;
  font-size: 20px;
}

.title {
  color: blue;
  font-size: 16px;
}
```
原本 Class 選取器 `.title` 優先於元素 `<p>`，一旦在屬性加上 `!important` 後，最後 Hello 字體呈現的結果會變成：
```css
color: red !important; /* <p> !important 強制優先權 */
font-size: 16px;  /* .title 賦予的屬性 */
```

#### 3. 行內樣式（inline style）
利用 HTML 元素中的 style 屬性將 CSS 樣式寫入，就稱為行內樣式（inline style）。
```html
<p style="color: red;">Hello</p>
```
#### 4. ID 選擇器 `#id`

#### 5. 類別選擇器`.class` 與屬性選取器 `[attr=value]`
Class 選擇器值得一提的是，偽類別 (pseudo-class) ，是由單一一個「:」冒號作為開頭的選取器，本身也是 Class 選擇器的其中之一，讓人容易與「::」作為開頭的偽元素 (pseudo-element) 混淆。

偽類別：`:hover`、`:nth-child`...
偽元素：`::before`、`::after`、`::placeholder`...

#### 6. 元素選擇器
例如：`<p>`、`<head>`、`<div>` ...
#### 7. ＊通用選取器
全域選擇器以星號 * 代表，適用於所有元素

#### 8. 繼承的屬性
如以下範例，雖然 `<p>` 沒有設定文字色彩屬性，但因為 `<p>` 寫在 `<div>` 當中，故 `<p>` 會繼承父層 `<div>` 的文字屬性。
```html
<div>
  <p>內文</p>
</div>
```
```css
div {
  color: red;
}
```
### CSS Selector 的計算方式
![](https://imgpile.com/images/7G2N5g.png)

#### 計算值
- ID 選擇器 = a
- Class 選擇器、屬性選取器、偽類別 = b
- 元素選擇器、偽元素 = c

#### 計算方式
先比較 `a` 的數量，其次比較 `b` 的數量，最後比較 `c` 的數量

#### 範例
| 選擇器                          | 權重值               | 順位      |
| ------------------------------ | ------------------- | -------- |
| #nav > li.active::before       | a = 1, b = 1, c = 2 | 第一     |
| #nav li.active                 | a = 1, b = 1, c = 1 | 第二     |
| div .card.active:hover::before | a = 0, b = 3, c = 2 | 第三     |
| ul > li:hover                  | a = 0, b = 1, c = 2 | 第四     |

如果想知道自己對於 CSS Selector 的**優先權**及**計算方式**的觀念是否正確，非常推薦到 [Specificity Calculator](https://specificity.keegan.st/) 這個網站測試看看。

---

參考：
- [關於 Webpack，它是什麼？能夠做什麼？為什麼？怎麼做？](https://askie.today/what-is-webpack/)
- [Gulp与WebPack有区别吗？如果有，有什么区别？](https://blog.csdn.net/weixin_42881768/article/details/105025095)
- 「金魚都能懂的 CSS 選取器：金魚都能懂了你還怕學不會嗎」書籍內容
- [CSS3 Selectors Specificity](http://www.w3.org/TR/selectors/#specificity)
