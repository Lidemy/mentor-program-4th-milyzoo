## 為什麼我們需要 React？可以不用嗎？

### 為什麼我們需要 React？

#### 1. 更容易管理前端專案

在還沒有使用 React 以前，若想處理互動內容，就需要把 HTML 寫進 JavaScript，如此一來，當專案的架構越來越大時，程式碼就變得不易管理，也難以維護。

#### 2. 元件模組化

將可以重複使用的 Component 模組化，除了維護性佳，也能提升開發效率。

#### 3. 分離畫面與資料

以往將畫面（UI）與資料綁在一起，是同時更改畫面及資料的做法，只要其中一邊出錯，就會導致資料與畫面不一致。而 React 的核心概念是**由 state 產生畫面**，可以確保資料與畫面永遠是一致的。

### 可以不用 React 嗎？

依照專案難度而定，假設產品規模較小或是靜態網站，也沒有上述所提及的需求時，就不一定需要使用 React。

## React 的思考模式跟以前的思考模式有什麼不一樣？

### 以前的思考模式

- 無論使用原生 JavaScript 還是使用 jQuery 函式庫，都需要直接操作 DOM。
- 透過畫面去改變資料的作法，容易產生資料與畫面不一致的情況。

### React 的思考模式

- 透過 Virtual DOM 來連動資料與畫面。
- 只要專注於「資料」的處理，當資料有所更動，畫面就會重新渲染。
- 利用 Component 拆分出獨立的元件，透過 props 將資料傳遞進去，有效提高元件的重用性。

## state 跟 props 的差別在哪裡？

state 和 props 都是 JavaScript object，當兩者的資訊改變時也都會重新渲染畫面，但最大的差別在於：

### state

在 component 內部可以管理自己的 state，類似 function 中宣告的變數一樣，是私有 (private) 的，所以只有 component 能使用自己的 state。

### props

props 是被傳遞進 component 的，可以想成類似 function 的參數，所以 props 的值是不可以改變的，若想改變 props 的話，只能從 parent 層去改變。

---

參考：

- [17. [FE] 為什麼現在的前端都在用「框架」？](https://ithelp.ithome.com.tw/articles/10224417)
- [[筆記] Why React?](https://medium.com/%E9%BA%A5%E5%85%8B%E7%9A%84%E5%8D%8A%E8%B7%AF%E5%87%BA%E5%AE%B6%E7%AD%86%E8%A8%98/%E7%AD%86%E8%A8%98-why-react-424f2abaf9a2)
- [官方文件：Component State](https://zh-hant.reactjs.org/docs/faq-state.html)
- [props vs state](https://github.com/uberVU/react-guide/blob/master/props-vs-state.md)
