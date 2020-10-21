## 什麼是 DOM？
DOM 的全名為 Document Object Model（中文翻譯為**文件物件模型**），可以理解成「把 Document 轉換成 Object」。

Document 代表整份 HTML 文件，而底下的各種標籤及其屬性可以定義成物件 （Object），每個物件就像一個節點，最後組織成樹狀架構。

![](https://i.imgur.com/qGLvVrl.png)

（圖片來源：[維基百科](https://zh.wikipedia.org/wiki/DOM)）

## 事件傳遞機制的順序是什麼；什麼是冒泡，什麼又是捕獲？
當 DOM 的事件觸發後，傳遞機制共有三個階段。

事件捕獲階段 -> 事件目標階段 -> 事件冒泡階段
（口訣：先捕獲再冒泡。）

![](https://i.imgur.com/epAbe0K.png)

（圖片來源：[W3C](https://www.w3.org/TR/DOM-Level-3-Events/#event-flow)）

#### 事件捕獲階段（Capturing phase）
事件從最外層根節點（Window）開始發生，直到傳遞至觸發的目標為止。

#### 事件目標階段（Target phase）
被觸發的元素，如圖中的 `<td>`

#### 事件冒泡階段（Bubbling phase）
事件冒泡就像把石頭丟入水中，泡泡會從水中冒出水面一樣，所以事件會從最內層的元素開始往上傳遞，直到傳回根節點（Window）。


## 什麼是 event delegation，為什麼我們需要它？
#### Event Delegation（事件委派，亦稱事件代理）
利用事件冒泡的特性，只需要把監聽事件綁定在最外層的節點，就能同時控制底下的多組節點，進而減少監聽數目的方法。

#### 為什麼我們需要 event delegation？
假設網頁中有好幾個按鈕，我們想控制這些按鈕的話，可以透過監聽 click 事件來控制，萬一按鈕的數目是一百個呢？這樣就要重複一百個 click 事件了。

就好比全班同學在課堂上交作業給老師時，一個個交作業的方式不僅沒效率，還耗費時間，如果能由班長統一管理，這樣以後老師只要把事情交辦給班長就好。

## event.preventDefault() 跟 event.stopPropagation() 差在哪裡，可以舉個範例嗎？

#### event.preventDefault()
阻止元素預設的行為。但不會影響事件的傳遞，因此執行後的效果仍會繼續向上傳遞（事件冒泡）。

例如：
使用 `event.preventDefault()` 後，點擊 `<a>` 連結將不會跳到指定網址、按下表單中的 `submit` 按鈕也無法送出表單。

#### event.stopPropagation()
阻擋事件冒泡傳遞。目標使用 `event.stopPropagation()` 後，事件就止於目標階段，而不再進入冒泡階段。

參考：
- [深入理解網頁架構：DOM](https://ithelp.ithome.com.tw/articles/10202689)
- [重新認識 JavaScript: Day 15 隱藏在 "事件" 之中的秘密](https://ithelp.ithome.com.tw/articles/10192015)
- [Event Delegation — 事件委派介紹 與 觸發委派的回呼函數](https://medium.com/@realdennis/event-delegation-%E4%BA%8B%E4%BB%B6%E5%A7%94%E6%B4%BE%E4%BB%8B%E7%B4%B9-%E8%88%87-%E8%A7%B8%E7%99%BC%E5%A7%94%E6%B4%BE%E7%9A%84%E5%9B%9E%E5%91%BC%E5%87%BD%E6%95%B8-2990921a5ba2)
- [Event Delegation 事件委派](https://cythilya.github.io/2015/07/08/javascript-event-delegation/)
- [DOM 的事件傳遞機制：捕獲與冒泡](https://static.coderbridge.com/img/techbridge/images/huli/event/eventflow.png)
- [你真的理解 事件冒泡 和 事件捕获 吗？](https://juejin.im/post/6844903834075021326)