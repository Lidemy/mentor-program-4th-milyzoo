## 為什麼我們需要 Redux？
在較為複雜的專案裡，可能會遇到很多 component 都要共用同一組 state 的狀況，當頁面一多時，state 也會散落在各處，變得不易管理。 

另外，雖然 React 現在能使用 useContext 來解決 prop drilling 的問題，可是 useContext 會造成元件強迫重新渲染，造成效能問題，所以不適合用在會頻繁更新的 state。

使用 Redux 可以解決上述問題，並幫助我們追蹤資料的變動與細節，像是為何資料會被更新以及如何被更新等等。

## Redux 是什麼？可以簡介一下 Redux 的各個元件跟資料流嗎？
Redux 是一套狀態管理的函式庫，可以獨立使用，也能與 React 搭配運用，主要由 Action、Reducer、Store 組成。

![](https://imgpile.com/images/NbPVAM.gif)
（圖源：[Redux](https://redux.js.org/tutorials/essentials/part-1-overview-concepts)）

Redux 的流程以上圖為案例：
1. 在畫面 (UI) 上點擊 Deposit 存進 10 元的按鈕，觸發點擊事件。
2. dispatch 一個 action 到 store 裡面的 reducer。
3. reducer 根據 action 傳來的 type 來處理相對應的行為，處理完成後回傳新的 state。
4. 偵測到新的 state 才去更新畫面 (UI)。

### Store
Redux 中只會有一個 store，是負責存放所有資料的地方，結合 **reducer**（用來更新 state）和 **action**（描述發生什麼行為）。

Store Method：
- `getState()`：用於取得 state 的值。
- `dispatch(action)`：用於更新 state。
- `subscribe(listener)`：當 store 改變時會觸發 listener。
- `replaceReducer(nextReducer)`

#### 創建 store
```javascript
import { createStore } from 'redux'

// 定義初始狀態
const initState = { 
  value: 0
};

// step1: 寫一個 reducer
function counterReducer = (state = initState, action) {
  switch(action.type) {
    case 'plus': {
      return {
        value: state.value + 1
      }
    }    
    case 'minus': {
      return {
        value: state.value - 1
      }
    }    
    default: {
      return state
    }
  }  
}

// step2: 把 reducer 託付給 store
const store = createStore(counterReducer)

// step3: 使用 `dispatch()` 來更新 state
store.dispatch({
  type: 'plus'
})

// step4: 可以用 getState() 檢查 state 是否有改變
console.log(store.getState())

// step5: 觸發 listener
subscribe(() => {
  // 當 store 有變化時，就會執行以下動作
  console.log('change!')
})
```


### Reducer
修改 state 的橋樑，負責接收 state 和 action，並於計算後回傳新的 state。
```javascript=
reducer(previousState, action) = newState
```
- previousState：改變前的 state。
- action：要加入的動作。
- newState：計算後回傳的新 state。

要注意 Reducer 沒辦法改變傳入的參數，也不該在 Reducer 執行任何 side effects 的動作。

### Action
- 用於描述一個行為，並用來判斷要啟動 reducer 裡的哪個 action。
- action 是一個物件，裡面一定要包含 `type` 屬性，其他可以自由選擇加入的屬性包含 `error`, `payload`, `meta`，除了上述提及的屬性，其他任何名稱的屬性都是不被允許的。
- 可以藉由 `store.dispatch()` 這個方法把 action 的資訊傳遞到 store，並讓 reducer 接收。

```javascript
export function addTodo(value) {
  return {
    type: add_todo,
    payload: {
      value
    }
  }
}

store.dispatch(addTodo(value))
```

## 該怎麼把 React 跟 Redux 串起來？
可以透過 `react-redux` 套件來結合 React 和 Redux。
實作方法有三種：
- Connect（還沒有出現 hooks 前的用法）
- Redux Hooks（出現 hooks 後的用法）
- Redux Toolkit（目前最新用法）

### 方法一：Connect
先安裝好 redux 和 react-redux，再進行以下操作。

#### Step1. 連結 React 和 Redux
拆出 component
```javascript
// components/AddTodo.js
import { useState, Fragment } from 'react'

export default function AddTodo({ addTodo }) {
  const [value, setValue] = useState('')
  return (
    <>
      <input value={value} onChange={e => setValue(e.target.value)} />
      <button
        onClick={() => {
          addTodo(value);
          setValue('')
        }}
      >
        add todo
      </button>
    </>
  );
}
```

使用 `connect()` 來連結 React 的 component 和 Redux 的 store

`Connect()` 傳入的參數：
- mapStateToProps：回傳想拿到的 state 的 function
- mapDispatchToProps：回傳 action creator 的 function。
- mergeProps（此次範例未用到）
- options（此次範例未用到）

```javascript
// containers/AddTodo.js（開始使用 connect()）
import { connect } from "react-redux";
import { addTodo } from "../redux/actions";
import AddTodo from "../components/AddTodo"; // 載入前面拆出來的 component

// mapStateToProps 可以 return 想拿到的 state，和 useSelector() 概念有點像
const mapStateToProps = (store) => {
  return {
    todos: store.todos
  }
}

const mapDispatchToProps = {
  // 簡化前 addTodo: (payload) => dispatch(addTodo(payload))
  addTodo, // 如果 props 名稱和 action 名稱一樣就可以直接簡化
};

// HOC（component 包 component）
// const connectToStore = connect(mapStateToProps, mapDispatchToProps);
// const ConnectedAddTodo = connectToStore(AddTodo)
// export default ConnectedAddTodo;
// 以上三行可以簡化成：
export default connect(mapStateToProps, mapDispatchToProps)(AddTodo);
```
```javascript
// actionTypes.js
export const ADD_TODO = "add_todo";

// actions.js
import { ADD_TODO } from './actionTypes'

export function addTodo(value) {
  return {
    type: ADD_TODO,
    payload: {
      value
    }
  }
}
```

#### Step2. 加入 Provider
在所有 component 的最外面包一層 Provider，並傳入store，這樣所有被包覆到的 component 都可以使用到 store。
```javascript
// 最外層的 index.js
import React from "react";
import ReactDOM from "react-dom";
import App from "./App";
import reportWebVitals from "./reportWebVitals";
import { Provider } from "react-redux";
import store from './redux/store'

ReactDOM.render(
  // 用 Provider 包住
  <Provider store={store}>
    <App />
  </Provider>,
  document.getElementById("root")
);

reportWebVitals();
```
### 方法二：Redux Hooks 
#### 安裝 redux 和 react-redux
進行以下操作前，需先安裝 redux 和 react-redux。

安裝 redux
```
npm install redux
```
安裝 react-redux
```
npm install react-redux
```

#### 簡易專案結構
```
├── src/
│  ├── components/     # 此次範例沒有抽出 component
│  ├── redux/
│  │  ├── reducers/
│  │  │  │── index.js  # 用來結合數個 reducer
│  │  │  └── todos.js
│  │  ├── actions.js
│  │  ├── actionTypes.js
│  │  ├── selectors.js
│  │  └── store.js
│  ├── hooks/
│  ├── styles/
│  ├── App.js
│  └── index.js
├── package-lock.json
└── package.json
```

#### Step1. 先建立 Store
```javascript
// store.js
import { createStore } from "redux";
import rootReducer from "./reducers";

export default createStore(
  rootReducer,
  window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__()
);
```

#### Step2. 建立 Action（使用 actionTypes 和 action creator）
```javascript
// actionTypes
export const ADD_TODO = "add_todo";
export const DELETE_TODO = "delete_todo";
```

action creator 指的是產生 action 的 function
```javascript
// actions.js
import { ADD_TODO, DELETE_TODO, ADD_USER } from './actionTypes'

export function addTodo(name) {
  return {
    type: ADD_TODO,
    payload: {
      name
    }
  }
}

export function deleteTodo(id) {
  return {
    type: DELETE_TODO,
    payload: {
      id
    }
  }
}
```

#### Step3. 建立 Reducers
```javascript
// todos.js
import { ADD_TODO, DELETE_TODO } from '../actionTypes'

let todoId = 0

// step1-2: 如果沒有 state，通常會給 initialState
const initialState = {
  todos: []
}

// step1: 先寫 Reducer，用來決定狀態怎麼變，（接收 state 和 action 後，回傳新的 state）
// newState = reducer(currentState, action)
export default function todosReducer(state = initialState, action) {
  switch(action.type) {
    case ADD_TODO: {
      return {
        ...state,
        todos: [...state.todos, {
          id: todoId ++,
          name: action.payload.name // payload: 想傳的參數
        }]
      }
    }

    case DELETE_TODO: {
      return {
        ...state,
        todos: state.todos
          .filter(todo => todo.id !== action.payload.id)
      }
    }

    default: {
      return state
    }
  }
}
```

如果有很多個 reducer，可以用 `combineReducers()` 來結合這些 reducer
```javascript
// reducers/index.js
import { combineReducers } from "redux";
import todos from "./todos";
import users from "./users";

export default combineReducers({
  todoState: todos
});
```

#### Step4. 加入 Provider
在所有 component 的最外面包一層 Provider，並傳入store，這樣所有被包覆到的 component 都可以使用到 store。
```javascript
// 最外層的 index.js
import React from "react";
import ReactDOM from "react-dom";
import App from "./App";
import reportWebVitals from "./reportWebVitals";
import { Provider } from "react-redux";
import store from './redux/store'

ReactDOM.render(
  // 用 Provider 包住
  <Provider store={store}>
    <App />
  </Provider>,
  document.getElementById("root")
);

reportWebVitals();
```

#### Step5. 拿 store 裡的資料 & 使用 dispatch
例用 `useSelector()` 這個 hook 拿 store 裡的資料
利用 `useDispatch` 這個 hook 來使用 dispatch
```javascript
// selectors.js
export const selectTodos = (store) => store.todoState.todos;

// App.js
import { useSelector, useDispatch } from 'react-redux';
import { selectTodos } from './redux/selectors'
import { addTodo, deleteTodo } from './redux/actions'

export default function App() {
  const todos = useSelector(store => selectTodos) // 拿資料
  const dispatch = useDispatch()
  return (
    <div>
      <button onClick={() => {
      dispatch(addTodo)
      }}>add todo</button>
      <ul>
        {todos.map((todo) => (
          <li>
            {todo.id} {todo.name}
            <button onClick={() => dispatch(deleteTodo(todo.id))}>delete</button>
          </li>
        ))}
      </ul>
    </div>
  );
}
```

---
參考：
- [為何要使用Redux](https://www.jianshu.com/p/d6614feef303)
- [Redux](https://chentsulin.github.io/redux/index.html)
- [React-redux | 為了瞭解原理，那就來實作一個 React-redux 吧！](https://medium.com/%E6%89%8B%E5%AF%AB%E7%AD%86%E8%A8%98/developing-react-redux-from-zero-to-one-e27eddfbce39)
- [React + React-Redux + Redux-Toolkit 新手教學](https://penueling.com/%E6%8A%80%E8%A1%93%E7%AD%86%E8%A8%98/react-react-redux-redix-toolkit-%E6%96%B0%E6%89%8B%E6%95%99%E5%AD%B8/)
- [[Redux] Redux Basic 基礎](https://pjchender.dev/react/redux-basic/#action-creator)