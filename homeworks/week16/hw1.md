## hw1：Event Loop
在開始看程式碼之前，需要先理解圖中所出現的幾個名詞。
![](https://imgpile.com/images/7Xyyuu.png)

### Call Stack（呼叫堆疊）
Stack（堆疊）是一種抽象資料型別，呼叫函式時會形成一個 frame 的 Stack（堆疊），遵循著**後進先出**的原則。後進先出可以把函式想像書本一本本疊起來的動作，最早放入的書本在最底層，如果想拿取最底層的書，就需等上層的書依序拿走，才能拿到最底層的那本書。

Call Stack 是追蹤函式執行的一種機制，假設有段程式碼是 `a` function 裡面再呼叫 `b` function，Call Stack 就會把 `a` function 放在最底層，再放入 `b` function 於 `a` function 的上方。 

### Web API
瀏覽器另外提供的 API，例如：DOM、AJAX、`setTimeout()`，讓我們可以同時處理多項任務，而不會造成網頁阻塞。

### Task Queue（任務佇列）
當有非同步的操作（包含 Web API）時，會先放到 Task Queue，再由 Event Loop 機制來監控 Call Stack 裡面是否還有需要執行的項目，如果 Call Stack 裡沒有任務，就會將 Task Queue 裡面的任務拉進 Call Stack 並執行。

### Event Loop（事件循環）
Javascript 是單執行緒（single-thread）的程式語言，簡單來說就是一次只能執行一件事情，如果安排很多要執行的任務，Javascript 就會讓這些任務排隊，並依序完成。
在沒有 Event Loop 的狀況下，如果遇到某段程式碼需要執行五秒鐘，網頁就會因此停住五秒不動，使用者只能跟著乾等，造成使用體驗不佳，為了避免這樣的狀況，因此需要 Event Loop。

Event Loop 負責的事情就像這張流程圖一樣：
![7XgsAh.png](https://imgpile.com/images/7XgsAh.png)
（[圖片來源](https://ithelp.ithome.com.tw/articles/10214017)）

1. 執行堆疊
2. 堆疊執行完成後，判斷堆疊是否為空？
    - 是，將 Task Queue 裡面的任務拉進 Stack 並執行。
    - 否，繼續執行堆疊。

我們可以把 Event Loop 想像成每分每秒都在重複上述過程，也因為「不斷重複」執行這些過程，所以被稱為 Event Loop（事件循環）。

### 程式碼執行流程
在 JavaScript 裡面，一個很重要的概念就是 Event Loop，是 JavaScript 底層在執行程式碼時的運作方式。請你說明以下程式碼會輸出什麼，以及盡可能詳細地解釋原因。
```javascript=
console.log(1)
setTimeout(() => {
  console.log(2)
}, 0)
console.log(3)
setTimeout(() => {
  console.log(4)
}, 0)
console.log(5)
```

1. 將第一行 `console.log(1)` 放入 Call Stack，印出 1，執行結束後 `console.log(1)` 從 Call Stack 中移除。
2. 將第二行 `setTimeout()`  放入 Call Stack，而 `setTimeout()` 是瀏覽器提供的 API，所以瀏覽器啟動計時器並計時設定為 0，計時結束後，將 `setTimeout()` 裡面的 `console.log(2)` 放到 Task Queue（任務佇列）監控並等待執行，此時等待順序為第一順位，最後 `setTimeout()` 從 Call Stack 中移除。
3. 將第五行 `console.log(3)` 放入 Call Stack，印出 3，執行結束後 `console.log(3)` 從 Call Stack 中移除。
4. 將第六行 `setTimeout()` 放入 Call Stack，瀏覽器啟動計時器並計時設定為 `0`，計時結束後，將 `setTimeout()` 裡面的 `console.log(4)` 放到 Task Queue（任務佇列）監控並等待執行，此時等待順序為第二順位，最後 `setTimeout()` 從 Call Stack 中移除。
5. 將第九行 `console.log(5)` 放入 Call Stack，印出 5，執行結束後 `console.log(5)` 從 Call Stack 中移除。
6. 此時 Call Stack 中已經沒有其他需要執行的任務，Task Queue（任務佇列）（任務佇列）（任務佇列）（任務佇列）   中第一順位的 `console.log(2)` 將移至 Call Stack 執行，印出 2，執行結束後 `console.log(2)` 從 Call Stack 中移除。
7. 在 Task Queue（任務佇列）等待執行的 `console.log(4)` 等待順序變成第一順位。
8. 此時 Call Stack 中已經沒有其他需要呼叫的堆疊，Task Queue 中第一順位的 `console.log(4)` 將移至 Call Stack 執行，印出 4，執行結束後 `console.log(4)` 從 Call Stack 中移除。

輸出結果為：
```javascript
1
3
5
2
4
```