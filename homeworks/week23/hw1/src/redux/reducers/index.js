import { combineReducers } from "redux";
import todoReducer from "./todos";
import filterReducer from "./filter";

export default combineReducers({
  todos: todoReducer,
  filter: filterReducer,  
});
