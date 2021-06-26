import { ADD_TODO, DELETE_TODO, TOGGLE_TODO, CLEAR_COMPLETED_TODO } from "../actionTypes";

let nextTodoId = 0;

const initialState = {
  todos: [],
};

export default function todosReducer(state = initialState, action) {
  switch (action.type) {
    case ADD_TODO: {
      return {
        ...state,
        todos: [
          ...state.todos,
          {
            id: nextTodoId++,
            content: action.payload.content, // payload: 想傳的參數
          },
        ],
      };
    }

    case DELETE_TODO: {
      return {
        ...state,
        todos: state.todos.filter((todo) => todo.id !== action.payload.id),
      };
    }

    case TOGGLE_TODO: {
      return {
        ...state,
        todos: state.todos.map((todo) => {
          if (todo.id !== action.payload.id) return todo; // 如果這個 todo 不是要修改的 todo id 就回傳原本的 todo

          // 回傳原本的東西（...todo）+ 要修改的屬性（isDone: !todo.isDone）
          return {
            ...todo,
            isDone: !todo.isDone,
          };
        }),
      };
    }

    case CLEAR_COMPLETED_TODO: {
      return {
        ...state,
        todos: state.todos.filter((todo) => todo.isDone !== true),
      };
    }

    default: {
      return state;
    }
  }
}
