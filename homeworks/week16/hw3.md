## hw3：Hoisting
請說明以下程式碼會輸出什麼，以及盡可能詳細地解釋原因。

```javascript=
var a = 1
function fn(){
  console.log(a)
  var a = 5
  console.log(a)
  a++
  var a
  fn2()
  console.log(a)
  function fn2(){
    console.log(a)
    a = 20
    b = 100
  }
}
fn()
console.log(a)
a = 10
console.log(a)
console.log(b)
```

1. 進入程式碼，建立 `Global EC`，初始化 `Global VO` 與 `scope chain`。
```javascript=
globalEC: {
   VO: {
   a: undefined,
   fn: function,
  },
  scopeChain: [globalEC.VO]
}
```

2. 執行第一行，a 賦值為 `1`。
```javascript=
globalEC: {
   VO: {
   a: 1,
   fn: function,
  },
  scopeChain: [globalEC.VO]
}
```

3. 執行第十六行，呼叫 `fn()`，進入第二行的 `fn` 函式，建立 `fn` 函式的 `AO` 及 `scope chain` 並初始化，進入函式後，scope chain 會被初始化成：`[AO, [[Scope]]]`。
（`[[scope]]` 屬性放的是父層 scope chain 的值）
```javascript=
fnEC: {
  AO: {
    a: undefined,
    fn2: function,
  },
  scopeChain: [function fnEC.AO, globalEC.VO]
}
globalEC: {
  VO: {
    a: 1,
    fn: function,
  },
  scopeChain: [globalEC.VO]
}
```
4. 執行第三行 `console.log(a)`，從 `fnEC.AO` 裡面可以找到 a 為 `undefined`，因此印出 `undefined`。
5. 執行第四行，a 賦值為 `5`。
```javascript=
fnEC: {
  AO: {
    a: 5,
    fn2: function,
  },
  scopeChain: [function fnEC.AO, globalEC.VO]
}
globalEC: {
  VO: {
    a: 1,
    fn: function,
  },
  scopeChain: [globalEC.VO]
}
```
6. 執行第五行 `console.log(a)`，從 `fnEC.AO` 裡面可以找到 a 為 `5`，因此印出 `5`。
7. 執行第六行，`a++`，因次目前的 a 值變成 `6`。
```javascript=
fnEC: {
  AO: {
    a: 6,
    fn2: function,
  },
  scopeChain: [function fnEC.AO, globalEC.VO]
}
globalEC: {
  VO: {
    a: 1,
    fn: function,
  },
  scopeChain: [globalEC.VO]
}
```
8. 執行第七行，`var a`，因為 a 先前已經宣告過，所以此行不影響。
9. 執行第八行，呼叫 `fn2()`，進入第十行的 `fn2` 函式，建立 `fn2` 函式的 `AO` 及 `scope chain` 並初始化。
```javascript=
fn2EC: {
  AO: {
  
  },
  scopeChain: [function fn2EC.AO, function fnEC.AO, globalEC.VO]
}
fnEC: {
  AO: {
    a: 6,
    fn2: function,
  },
  scopeChain: [function fnEC.AO, globalEC.VO]
}
globalEC: {
  VO: {
    a: 1,
    fn: function,
  },
  scopeChain: [globalEC.VO]
}
```
10. 執行第十一行 `console.log(a)`，但 `fn2` 函式裡面沒有任何宣告，所以 `fn2EC.AO` 是空的，根據 `fn2EC` 的 `scopeChain` 得知可以往 `function fnEC.AO` 尋找 a，找到 `6`，因此印出 `6`。
7. 執行第十二行，承上述所言，因為 `fn2EC.AO` 是空的，所以往 `function fnEC.AO` 找到 a，並賦值為 `20`。
```javascript=
fn2EC: {
  AO: {
  
  },
  scopeChain: [function fn2EC.AO, function fnEC.AO, globalEC.VO]
}
fnEC: {
  AO: {
    a: 20,
    fn2: function,
  },
  scopeChain: [function fnEC.AO, globalEC.VO]
}
globalEC: {
  VO: {
    a: 1,
    fn: function,
  },
  scopeChain: [globalEC.VO]
}
```
12. 執行第十三行，b 賦值為 `100`，但 `fn2EC.AO` 是空的，往上層 `fnEC.AO` 也找不到變數 b，根據 `fn2EC` 的 `scopeChain` 沿路找到最外層的 `globalEC.VO` 仍找不到，最後只好在 `globalEC.VO` 宣告 b 並賦值為 `100`。
```javascript=
fn2EC: {
  AO: {
  
  },
  scopeChain: [function fn2EC.AO, function fnEC.AO, globalEC.VO]
}
fnEC: {
  AO: {
    a: 20,
    fn2: function,
  },
  scopeChain: [function fnEC.AO, globalEC.VO]
}
globalEC: {
  VO: {
    a: 1,
    b: 100,
    fn: function,
  },
  scopeChain: [globalEC.VO]
}
```
13. 執行第十四行，跳出 `fn2()`，移除 `fn2EC`。
```javascript=
fnEC: {
  AO: {
    a: 20,
    fn2: function,
  },
  scopeChain: [function fnEC.AO, globalEC.VO]
}
globalEC: {
  VO: {
    a: 1,
    b: 100,
    fn: function,
  },
  scopeChain: [globalEC.VO]
}
```
14. 執行第九行 `console.log(a)`，從 `fnEC.AO` 裡面可以找到 a 為 `20`，因此印出 `20`。
15. 執行第十五行，跳出 `fn()`，移除 `fnEC`。
```javascript=
globalEC: {
  VO: {
    a: 1,
    b: 100,
    fn: function,
  },
  scopeChain: [globalEC.VO]
}
```
16. 執行第十七行 `console.log(a)`，從 `globalEC.VO` 裡面可以找到 a 為 `1`，因此印出 `1`。
17. 執行第十八行，a 賦值為 `10`。
```javascript=
globalEC: {
  VO: {
    a: 10,
    b: 100,
    fn: function,
  },
  scopeChain: [globalEC.VO]
}
```
18. 執行第十九行 `console.log(a)`，從 `globalEC.VO` 裡面可以找到 a 為 `10`，因此印出 `10`。
19. 執行第二十行 `console.log(b)`，從 `globalEC.VO` 裡面可以找到 b 為 `100`，因此印出 `100`。

輸出結果為：
```javascript
undefined
5
6
20
1
10
100
```