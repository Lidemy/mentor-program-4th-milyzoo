import {
  ADD_TODO,
  DELETE_TODO,
  TOGGLE_TODO,
  SET_CURRENT_FILTER,
  CLEAR_COMPLETED_TODO,
} from "./actionTypes";

export function addTodo(content) {
  return {
    type: ADD_TODO,
    payload: {
      content,
    },
  };
}

export function deleteTodo(id) {
  return {
    type: DELETE_TODO,
    payload: {
      id,
    },
  };
}

export function toggleIsDone(id) {
  return {
    type: TOGGLE_TODO,
    payload: {
      id,
    },
  };
}

export function clearCompletedTodo() {
  return {
    type: CLEAR_COMPLETED_TODO,
  };
}

export function setCurrentFilter(filterName) {
  return {
    type: SET_CURRENT_FILTER,
    payload: {
      filterName,
    },
  };
}
