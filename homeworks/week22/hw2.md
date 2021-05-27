## 請列出 React 內建的所有 hook，並大概講解功能是什麼
- useState
- useEffect
- useContext
- useReducer
- useRef
- useCallback
- useMemo
- useImperativeHandle
- useLayoutEffect
- useDebugValue

### 1. useState 
useState 用來監控 component 的資料是否有變動，並藉此連動改變畫面。

```javascript
const [state, setState] = useState(initialState);
```

- state：state 的變數名稱，存放著 state 的值，也是要監控的變數。
- setState：改變 state 的函式名稱，可透過 setState 來修改 state。
- initialState：代表第一次 render 時，帶入的資料初始值。
- state 與 setState 可以任意取名。

以計時器作為使用範例：
```javascript
// 步驟一：從 React 物件中引入 useState
import { useState } from 'react';

function App() {
  // 步驟二：宣告一個新的 state 變數，我們稱為 counter，並將初始值設定為 0。
  const [counter, setCounter] = useState(0)

  const handleButtonClick = () => {
    // 步驟三：透過 setCounter 來改變 count 的值
    setCounter(counter + 1)
  }
  return (
    <div className="App">
      counter: {counter}
      <button onClick={handleButtonClick}>increment</button>
    </div>
  );
}
```

### 2. useEffect
useEffect 能用來在瀏覽器畫面渲染完成後才呼叫指定行為。
適合用在初次畫面渲染後和 React 本身無關而需要執行的動作，例如：發送 API 請求資料、localStorage 資料儲存。

```javascript
useEffect(<didUpdate>, [dependencies])
```
- 第一個參數：帶入在「畫面渲染完成」後才呼叫的函式。
- 第二個參數：是一個陣列，用來偵測每次畫面重新渲染後，參數內的元素有沒有改變，如果有改變，useEffect 裡第一個參數的函式才會被呼叫。
- 當第二個參數是 `[]` 時，因為裡面是空的，rerender 後也不會改變，所以只有第一次 render 後會執行 useEffect 內的函式。


![](https://i.imgur.com/pe1zbGp.png)

從 Hook Flow 圖表可以得知在 Update 時有個步驟是 **Cleanup Effects**，在 useEffect 可以 return 一個 function，裡面放的就是在 **Cleanup Effects** 步驟要執行的事情。

```javascript
useEffect(
  () => {
    // Run Effects 步驟，render 後要完成的事
    // Mount 及 Update 階段都會執行
    return () => {
      // Cleanup Effects 步驟，在 effect 被清除前完成的事
      // 只在 Update 或 Unmount 階段執行
    };
  },
  [dependencies],
);
```

### 3. useContext
useContext 能避免 component 需要多層傳遞 props 的問題。

我們可以從以下圖片來了解有沒有使用 useContext 的差別：

（左）使用 useContext 前 / （右）使用 useContext 後
![](https://imgpile.com/images/NnJi1j.png)
（[圖片來源](https://medium.com/hannah-lin/react-hook-%E7%AD%86%E8%A8%98-usecontext-4bc289976847)）

```javascript
const value = useContext(MyContext);
```
接收來自 React.createContext 的回傳值，並回傳該 context 目前的值。Context 目前的值是取決於距離最近的 <MyContext.Provider> 的 value prop。

當距離最近的 <MyContext.Provider> 更新時，便會重新 render，並將最新的 context value 傳送到 MyContext provider。

範例：
```javascript
import React, { createContext, useContext } from 'react';

const themes = {
  light: {
    background: "#eeeeee"
  },
  dark: {
    background: "#222222"
  }
};

const ThemeContext = React.createContext(themes.light);
// STEP 1: 使用 createContext 來建立 context，createContext 裡面的內容為預設值

function App() {
  return (
    <ThemeContext.Provider value={themes.dark}>
    // STEP 2: 使用 Context.Provider 包覆元件並將 value 傳遞至內部的每個元件
      <Toolbar />
    </ThemeContext.Provider>
  );
}

function Toolbar(props) {
  return (
    <div>
      <ThemedButton />
    </div>
  );
}

function ThemedButton() {
  const theme = useContext(ThemeContext);
  // STEP 3: 接收來自 <ThemeContext.Provider> 的 value
  
  return (
    <button style={{ background: theme.background }}>
      I am styled by theme context!
    </button>
  );
}
```

### 4. useReducer
useReducer 可以用來取代 useState，當 state 邏輯較為複雜時，使用 useReducer 管理 state 會比 useState 更適用。

```javascript
const [state, dispatch] = useReducer(reducer, initialArg, init);
```

### 5. useRef
useRef 有兩種使用方式：
1. 可以用來存取 DOM 元素的資訊。
2. 能夠保存數值，並在重新渲染後不會改變其值。

```javascript
const refContainer = useRef(initialValue);
```

使用範例：

```javascript
import { useState, useRef } from 'react';

function App() {
  const inputRef = useRef();

  const handleButtonClick = () => {
    // console.log(inputRef); 如果只用 inputRef 的話回傳的是一個陣列，而不是詳細資訊
    console.log(inputRef.current.value);
    // 所以使用 inputRef.current.value 即可拿到鍵盤在 input 上輸入的值
  }

  return (
    <div className="App">
      <input ref={inputRef} type="text" placeholder="todo" value={value} onChange={handleInputChange} />
    </div>
  );
}
```

### 6. useCallback
useCallback 利用 Memorize 來減少不必要的 render。

```javascript
const memoizedCallback = useCallback(
  () => {
    return doSomething(a, b);
  },
  [a, b],
);

// 簡化後：
const memoizedCallback = useCallback(() => doSomething(a, b), [a, b]);

```
- 第一個參數：callback function。
- 第二個參數：useCallback 依賴的陣列，用來偵測每次畫面重新渲染後，參數內的元素有沒有改變。

只有在 dependencies 改變時，useCallback 才會 return 一個 memoized 的 callback function（換句話說就是 dependencies 沒有改變時，會把 function 先保存起來）。

### 7. useMemo
useMemo 可以避免在每次 render 都要重新進行複雜的運算。

```javascript
const memoizedValue = useMemo(
  () => {
    return computeExpensiveValue(a, b),
  [a, b]
});

// 簡化後：
const memoizedValue = useMemo(() => computeExpensiveValue(a, b), [a, b]);
```
- 第一個參數： “create” function。
- 第二個參數：useMemo 依賴的陣列，用來偵測每次畫面重新渲染後，參數內的元素有沒有改變。如果沒有提供陣列，每次 render 時都會計算新的值。

只有在 dependencies 改變時，useMemo 才會重新計算 memoized 的值。

#### useCallback 和 useMemo 的差別
根據官方文件可以知道 `useCallback(fn, deps)` 相等於 `useMemo(() => fn, deps)`
兩者最大的不同在於：
- useCallback 回傳 callBack function，所以可以傳參數進去。
- useMemo 回傳值。

### 8. useImperativeHandle
useImperativeHandle 可以在使用 ref 時，向父層 component 暴露自定義的 instance 值。

```javascript
useImperativeHandle(ref, createHandle, [deps])
```
- 第一個參數：要使用的 ref。
- 第二個參數：傳給父層 component 的行為。

官方建議在大多數的情況下應避免使用 ref 的命令式代碼。

### 9. useLayoutEffect
useLayoutEffect 與 useEffect 的使用方法相同，但功能卻相反。
- useLayoutEffect 用於瀏覽器畫面渲染完成「前」呼叫指定行為。
- useEffect 用於瀏覽器畫面渲染完成「後」呼叫指定行為。

官方建議盡可能使用標準的 useEffect 來避免阻礙視覺上的更新。

### 10. useDebugValue
useDebugValue 可以用來在 React DevTools 中顯示自訂義 hook 的標籤。
（React DevTools 是由 Facebook 團隊所開發的 chrome 偵錯工具。）

```javascript
useDebugValue(value)
```

## 請列出 class component 的所有 lifecycle 的 method，並大概解釋觸發的時機點
![](https://imgpile.com/images/N1Pmxj.png)
（圖片來源：[React lifecycle methods diagram](https://projects.wojtekmaj.pl/react-lifecycle-methods-diagram/)）

class component 的 lifecycle 可以分為 Mounting、Updating、Unmounting 三個階段：
- Mounting：當 component 被建立且加入 DOM 中時。
- Updating：當 prop 或 state 有變化，component 被重新 render 時。
- Unmounting：當 component 從 DOM 中移除時。

### Mounting
- `constructor()`：會在 mount 之前被呼叫。用於初始化內部 state 或幫 event handler 綁定 instance。換句話說就是如果沒有要初始化 state 也不綁定方法的話，就不需要使用 constructor。
- `static getDerivedStateFromProps()`：會在 component 被 render 前被呼叫。用於回傳一個 object 來更新 state，或回傳 null 表示不需要更新任何 state。這個方法運用在某些少見的例子上，例如：有時 state 會依賴 prop 在一段時間過後所產生的改變。
- `render()`：用來定義 component，會根據 this.props 和 this.state 的變化來回傳 JSX、null 或 false 等等。
- `componentDidMount()`：會在 component 建構完成後後被呼叫。這個 method 只會被呼叫一次，適合用於串接 API。

### Updating
- `static getDerivedStateFromProps()`：會在 component 被 render 前被呼叫。用於回傳一個 object 來更新 state，或回傳 null 表示不需要更新任何 state。這個方法運用在某些少見的例子上，例如：有時 state 會依賴 prop 在一段時間過後所產生的改變。
- `shouldComponentUpdate()`：會在 render 之前被呼叫。用來判斷 props 或 state 是否有改變，如果沒有改變（回傳 false），就不會呼叫 `render()`、`componentDidUpdate()` 和 `UNSAFE_componentWillUpdate()`。
- `render()`：用來定義 component，會根據 this.props 和 this.state 的變化來回傳 JSX、null 或 false 等等。
- `getSnapshotBeforeUpdate()`：會在最新一次 render 的 output 前被呼叫。
- `componentDidUpdate()`：會在 component 更新後被呼叫，但不會在初次 render 時被呼叫。如果 `componentDidUpdate()` 裡有比較 state 或是 props 是否有被改變，就能在裡面呼叫 setState()。

### Unmounting
- `componentWillUnmount()`： 會在 component 被 unmount 和 destroy 後呼叫。可以用來移除先前設置的函式，例如清除 timer、取消 AJAX request、移除 event listener 等。

## 請問 class component 與 function component 的差別是什麼？
### class component
- 利用 ES6 Class 的方式來宣告 Component。
- 有許多 Lifecycle Methods 可以使用。
- 透過 this.props 取得 props。
- 因為 props 和 state 存在 instance 裡面，所以可以直接取到最新的值。
- 程式碼較複雜。

寫法：
```javascript
class Button extends React.Component {
  constructor(props) {
    super(props)
  }
  
  render() {
    const { onClick, children } = this.props;
    return <button onClick={onClick}>{children}</button>
  }
}
```

### function component
- function component 每一次 render 都會重新呼叫 function。
- 沒有 this。
- 接收 props 作為參數來使用。
- state 的值以當下操作所得到值為主，所以不是最新的值。
- 程式碼較簡潔。

寫法：
```javascript
function Button({ onClick, children }) {
  return <button onClick={onClick}>{children}</button>
}
```

## uncontrolled 跟 controlled component 差在哪邊？要用的時候通常都是如何使用？
在 React 中處理表格的方式有兩種，分別是 uncontrolled 及 controlled component，最大的差別在於有沒有受到 React 的控制。在大部分的狀況下，React 官方建議應使用 controlled component。

### uncontrolled component 
- 就像直接使用 HTML 中的表單元素（例如：`<input>`、`<textarea>`、`<select>`）一樣，不受 React 控制，表單的資料是由 DOM 本身所處理的。
- 如果要取得表單的資料需使用 ref 來從 DOM 取得。

假設有個能輸入名字的表單，在送出後會在彈跳視窗中顯示名字，範例：
```javascript
function NameForm () {
  const handleSubmit = (event) => {
    alert('A name was submitted: ' + input.current.value);
    event.preventDefault();
  }

  render() {
    return (
      <form onSubmit={handleSubmit}>
        <label>
          Name:
          <input type="text" ref={input} />
        </label>
        <input type="submit" value="Submit" />
      </form>
    );
  }
}
```

### controlled component
- 表格 element 的值是由 React 來控制的。
- 使用 useState 來保存資料，再透過表單 onChange 事件取得表單的值。

---

參考資料：
- [React 官方網站](https://reactjs.org/)
- [[React Hook 筆記] useContext](https://medium.com/hannah-lin/react-hook-%E7%AD%86%E8%A8%98-usecontext-4bc289976847)
- [[React] React Context API 以及 useContext Hook 的使用](https://pjchender.blogspot.com/2019/07/react-react-context-api.html)
- [[React Hook 筆記] Memorized Hook- useMemo, useCallback](https://medium.com/hannah-lin/react-hook-%E7%AD%86%E8%A8%98-memorized-hook-usememo-usecallback-e08a5e1bc9a2#ceb0)
- [react 生命周期函数及用法](https://zhuanlan.zhihu.com/p/225813191)
- [React 元件生命週期 (Component Lifecycle)](https://www.fooish.com/reactjs/component-lifecycle.html)