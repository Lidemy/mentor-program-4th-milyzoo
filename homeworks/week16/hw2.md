## hw2：Event Loop + Scope
請說明以下程式碼會輸出什麼，以及盡可能詳細地解釋原因。
```javascript=
for(var i=0; i<5; i++) {
  console.log('i: ' + i)
  setTimeout(() => {
    console.log(i)
  }, i * 1000)
}
```
1. 執行第一行，for 迴圈放入 Call Stack，宣告 `var i=0`，因為 for 迴圈不被任何 function 封裝，所以 `i` 為全域變數，此時 `i` 為 `0`，判斷 `i` 是否小於 `5`，是，進入第一次迴圈。
2. 執行第二行，並代入 `i` 的值，得到 `console.log('i: ' + 0)`，將其放入 Call Stack，印出 `i: 0`，執行結束後 `console.log('i: ' + 0)` 從 Call Stack 中移除。
3. 執行第三行，將 `setTimeout()` 放入 Call Stack，代入 `i = 0`，瀏覽器啟動計時器並計時設定為 `0 * 1000`，`0 * 1000` 得到 `0`，計時為 `0`，計時結束後，將 `setTimeout()` 裡面的 `console.log(i)` 放到 Task Queue（任務佇列）監控並等待執行，此時等待順序為第一順位，因為 `setTimeout()` 已經呼叫，所以 `setTimeout()` 從 Call Stack 中移除。
4. 回去第一行執行 `i++`，此時 `i` 為 `1`。
5. 判斷 `i` 是否小於 `5`，`1 < 5`，是，進入第二次迴圈。
6. 執行第二行，並代入 `i` 的值，得到 `console.log('i: ' + 1)`，將其放入 Call Stack，印出 `i: 1`，執行結束後 `console.log('i: ' + 1)` 從 Call Stack 中移除。
7. 執行第三行，將 `setTimeout()` 放入 Call Stack，代入 `i = 1`，瀏覽器啟動計時器並計時設定為 `1 * 1000`，`1 * 1000` 得到 `1000` 毫秒並開始計時，因為 `setTimeout()` 已經呼叫，所以 `setTimeout()` 從 Call Stack 中移除，程式碼繼續往下執行。
8. 回去第一行執行 `i++`，此時 `i` 為 `2`。
9. 判斷 `i` 是否小於 `5`，`2 < 5`，是，進入第三次迴圈。
10. 執行第二行，並代入 `i` 的值，得到 `console.log('i: ' + 2)`，將其放入 Call Stack，印出 `i: 2`，執行結束後 `console.log('i: ' + 2)` 從 Call Stack 中移除。
11. 執行第三行，將 `setTimeout()` 放入 Call Stack，代入 `i = 2`，瀏覽器啟動計時器並計時設定為 `2 * 1000`，`2 * 1000` 得到 `2000` 毫秒並開始計時，因為 `setTimeout()` 已經呼叫，所以 `setTimeout()` 從 Call Stack 中移除，程式碼繼續往下執行。
12. 回去第一行執行 `i++`，此時 `i` 為 `3`。
13. 判斷 `i` 是否小於 `5`，`3 < 5`，是，進入第三次迴圈。
14. 執行第二行，並代入 `i` 的值，得到 `console.log('i: ' + 3)`，將其放入 Call Stack，印出 `i: 3`，執行結束後 `console.log('i: ' + 3)` 從 Call Stack 中移除。
15. 執行第三行，將 `setTimeout()` 放入 Call Stack，代入 `i = 3`，瀏覽器啟動計時器並計時設定為 `3 * 1000`，`3 * 1000` 得到 `3000` 毫秒並開始計時，因為 `setTimeout()` 已經呼叫，所以 `setTimeout()` 從 Call Stack 中移除，程式碼繼續往下執行。
16. 回去第一行執行 `i++`，此時 `i` 為 `4`。
17. 判斷 `i` 是否小於 `5`，`4 < 5`，是，進入第三次迴圈。
18. 執行第二行，並代入 `i` 的值，得到 `console.log('i: ' + 4)`，將其放入 Call Stack，印出 `i: 4`，執行結束後 `console.log('i: ' + 4)` 從 Call Stack 中移除。
19. 執行第三行，將 `setTimeout()` 放入 Call Stack，代入 `i = 4`，瀏覽器啟動計時器並計時設定為 `4 * 1000`，`4 * 1000` 得到 `4000` 毫秒並開始計時，因為 `setTimeout()` 已經呼叫，所以 `setTimeout()` 從 Call Stack 中移除，程式碼繼續往下執行。
20. 回去第一行執行 `i++`，此時 `i` 為 `5`。
21. 判斷 `i` 是否小於 `5`，`5 < 5`，否，跳出迴圈，for 迴圈從 Call Stack 中移除。
22. 因為 Call Stack 目前是空的狀態，Task Queue（任務佇列）中於步驟 3 放入的第一順位 `console.log(i)` 便可以移至 Call Stack，代入 `i` 的值，因為 `i` 是全域變數，所以得到 `console.log(5)`，印出 `5`，執行結束後 `console.log(5)` 從 Call Stack 中移除。
23. 等待 `1000` 毫秒，於步驟 7 執行的瀏覽器計時完成，`console.log(i)` 放到 Task Queue（任務佇列）監控並等待執行，此時等待順序為第一順位。
24. 因為 Call Stack 目前是空的狀態，Task Queue（任務佇列）中第一順位的 `console.log(i)` 便可以移至 Call Stack，代入 `i` 的值，所以 `console.log(5)`，印出 `5`，執行結束後 `console.log(5)` 從 Call Stack 中移除。
25. 再等待 `1000` 毫秒（因前面已等待 `1000` 毫秒，目前共等待 `2000` 毫秒），於步驟 11 執行的瀏覽器計時完成，`console.log(i)` 放到 Task Queue（任務佇列）監控並等待執行，此時等待順序為第一順位。
26. 因為 Call Stack 目前是空的狀態，Task Queue（任務佇列）中第一順位的 `console.log(i)` 便可以移至 Call Stack，代入 `i` 的值，所以 `console.log(5)`，印出 `5`，執行結束後 `console.log(5)` 從 Call Stack 中移除。
27. 再等待 `1000` 毫秒（因前面已等待 `2000` 毫秒，目前共等待 `3000` 毫秒），於步驟 15 執行的瀏覽器計時完成，`console.log(i)` 放到 Task Queue（任務佇列）監控並等待執行，此時等待順序為第一順位。
28. 因為 Call Stack 目前是空的狀態，Task Queue（任務佇列）中第一順位的 `console.log(i)` 便可以移至 Call Stack，代入 `i` 的值，所以 `console.log(5)`，印出 `5`，執行結束後 `console.log(5)` 從 Call Stack 中移除。
29. 再等待 `1000` 毫秒（因前面已等待 `3000` 毫秒，目前共等待 `4000` 毫秒），於步驟 19 執行的瀏覽器計時完成，`console.log(i)` 放到 Task Queue（任務佇列）監控並等待執行，此時等待順序為第一順位。
30. 因為 Call Stack 目前是空的狀態，Task Queue（任務佇列）中第一順位的 `console.log(i)` 便可以移至 Call Stack，代入 `i` 的值，所以 `console.log(5)`，印出 `5`，執行結束後 `console.log(5)` 從 Call Stack 中移除。

輸出結果為：
```javascript
i: 0
i: 1
i: 2
i: 3
i: 4
5
5
5
5
5
```