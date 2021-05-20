## hw4：What is this?
在開始解題前，我們要先了解 this 的幾個重點：
- this 的值與什麼時候被定義無關，與呼叫的方式才有關係。
- this 代表的是 function 執行時所屬的物件，而不是 function 本身。

接著來談談什麼是 `call()`。

#### call()
除了使用 `func()` 來呼叫 function 外，`call()` 也可以做為呼叫 function 的其他方式之一。
```javascript
fun.call(thisArg[, arg1[, arg2[, ...]]])
// thisArg：呼叫 fun 時提供的 this 值。
// arg1, arg2, ...：其他參數。
```
接著我們可以把程式碼轉換成 `call()` 的形式來呼叫 function，把呼叫的 function 的前面東西放進 `call()` 裡面，藉由 `call` 的特性我們可以得知：`call()` 裡面的值是什麼，this 就是什麼。

範例：
```javascript
"use strict";

const obj = {
  a: 123,
  test: function () {
    console.log(tihs);
  },
};

obj.test() // 得到 obj 本身 { a: 123, test: [function: test] }
```
`obj.test()` 可以看成 `obj.test.call(obj)`，所以會得到 obj 自己。


## 程式碼執行流程
請說明以下程式碼會輸出什麼，以及盡可能詳細地解釋原因。
```javascript=
const obj = {
  value: 1,
  hello: function() {
    console.log(this.value)
  },
  inner: {
    value: 2,
    hello: function() {
      console.log(this.value)
    }
  }
}
  
const obj2 = obj.inner
const hello = obj.inner.hello
obj.inner.hello() // ??
obj2.hello() // ??
hello() // ??
```

1. 執行第十六行 `obj.inner.hello()`，可以想成 `obj.inner.hello.call(obj.inner)`，按照 `call()` 的特性，this 的值就是 `obj.inner`。
進入 `obj.inner` 後，執行第九行的 `console.log(this.value)`，而 `this.value` 也就是 `obj.inner.value`，所以會印出 2。

2. 執行第十七行 `obj2.hello()`，從第十四行我們可以得知 `const obj2 = obj.inner`，所以 `obj2.hello()` 也就是 `obj.inner.hello()`，如同上述步驟 1 的內容，也會印出 2。

3. 執行第十八行，`hello()`，可以想成 `hello.call()`，由於沒有任何參數傳入，在不是物件導向的環境下，`this` 依據不同環境呼叫，所得到的值也會不同。
例如：
    - 在 node.js 裡呼叫會得到 `global` 的東西。
    - 在瀏覽器上會得到 `windows` 的東西。
    - 在嚴格模式（`'use strict';`）下執行，this 的值將會是 `undefined`。


這邊先預設已開啟嚴格模式的話，最後輸出結果為：
```javascript
2
2
undefined
```