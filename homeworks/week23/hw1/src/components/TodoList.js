import styled from "styled-components";
import clearImg from "../images/clear.svg";
import { useState, useMemo } from "react";
import SingleTodoItem from "./TodoItem";
import { useSelector, useDispatch } from "react-redux";
import {
  addTodo,
  deleteTodo,
  toggleIsDone,
  clearCompletedTodo,
  setCurrentFilter,
} from "../redux/actions";
import { FILTER } from "../constants/filter";

const TodoListWrapper = styled.section`
  width: 100%;
  background-color: #fff;
  box-shadow: 0 0 50px rgba(135, 135, 135, 0.1);
`;

const FilterWrapper = styled.div`
  display: flex;
`;

const FilterButton = styled.div`
  width: calc(100% / 3);
  line-height: 50px;
  text-align: center;
  color: #555555;
  background: ${(props) => (props.$isActive ? "#fff" : "#f9f9f9")};
  border-bottom: 1px solid
    ${(props) => (props.$isActive ? "transparent" : "#ececec")};
  transition: 0.3s;
  cursor: pointer;

  & + & {
    border-left: 1px solid #ececec;
  }

  &:hover {
    background-color: #fff;
  }
`;

const TodoItemInfo = styled.div`
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 45px;
  height: 75px;
  font-size: 15px;
  color: #858585;
`;

const IncompletedCount = styled.span`
  margin-right: 5px;
`;

const ClearButton = styled.div`
  display: flex;
  align-items: center;
  padding: 5px 10px;
  border: 1px solid #e1e1e1;
  border-radius: 30px;
  cursor: pointer;
  transition: 0.3s;

  &:hover {
    background-color: #f9f9f9;
  }

  img {
    margin-right: 5px;
    width: 15px;
    height: 15px;
  }
`;

const TodoItemWrapper = styled.ul`
  margin: 0;
  padding: 0;
  max-height: 260px;
  overflow-y: auto;

  &::-webkit-scrollbar {
    width: 10px;
  }

  &::-webkit-scrollbar-thumb {
    background-color: #e3e3e3;
    border-radius: 20px;
  }
`;

const TodoItemInputField = styled.div`
  display: flex;
  border-top: 1px solid #ececec;
`;

const TodoItemTextField = styled.input`
  padding: 0 25px;
  width: calc(100% - 60px);
  border: transparent;
  outline: none;
  font-size: 20px;
  color: #555555;

  ::placeholder {
    font-size: 20px;
    color: #dcdcdc;
  }
`;
const AddButton = styled.button`
  width: 60px;
  height: 60px;
  border: transparent;
  border-left: 1px solid #ececec;
  background-color: transparent;
  color: #555555;
  font-family: "Microsoft JhengHei";
  font-size: 30px;
  outline: none;
  cursor: pointer;
  transition: 0.3s;

  &:hover {
    background-color: #f9f9f9;
  }
`;

export default function TodoList() {
  const dispatch = useDispatch();
  const todos = useSelector((store) => store.todos.todos);
  const currentFilter = useSelector((store) => store.filter);
  const [value, setValue] = useState("");
  let incompleteCount = todos.filter((todo) => !todo.isDone).length;

  function SendTodoContent() {
    if (!value) return;
    dispatch(addTodo(value));
    setValue(""); // 做完就清空 setValue
  }
  const handleButtonClick = () => SendTodoContent();
  const handleInputKeyDown = (e) => {
    if (e.keyCode === 13) SendTodoContent();
  };

  const handleInputChange = (e) => setValue(e.target.value);

  const handleDeleteTodo = (id) => {
    dispatch(deleteTodo(id));
  };

  const handleToggleIsDone = (id) => {
    dispatch(toggleIsDone(id));
  };

  const filterAllTodo = () => dispatch(setCurrentFilter(FILTER.ALL));

  const filterUncompeletedTodo = () =>
    dispatch(setCurrentFilter(FILTER.INCOMPLETE));

  const filterDoneTodo = () => dispatch(setCurrentFilter(FILTER.COMPLETED));

  const filterTodos = useMemo(() => {
    if (currentFilter === FILTER.ALL) return todos;
    return todos.filter((todo) =>
      currentFilter === FILTER.COMPLETED ? todo.isDone : !todo.isDone
    );
  }, [todos, currentFilter]);

  const clearDoneTodo = () => {
    dispatch(clearCompletedTodo());
  };

  return (
    <TodoListWrapper>
      <FilterWrapper>
        <FilterButton
          onClick={filterAllTodo}
          $isActive={currentFilter === FILTER.ALL}
        >
          全部
        </FilterButton>
        <FilterButton
          onClick={filterUncompeletedTodo}
          $isActive={currentFilter === FILTER.INCOMPLETE}
        >
          未完成
        </FilterButton>
        <FilterButton
          onClick={filterDoneTodo}
          $isActive={currentFilter === FILTER.COMPLETED}
        >
          已完成
        </FilterButton>
      </FilterWrapper>
      <TodoItemInfo>
        <p>
          <IncompletedCount>{incompleteCount}</IncompletedCount>個未完成
        </p>
        <ClearButton onClick={clearDoneTodo}>
          <img src={clearImg} alt="" />
          移除已完成事項
        </ClearButton>
      </TodoItemInfo>
      <TodoItemWrapper>
        {filterTodos.map((todo) => (
          <SingleTodoItem
            key={todo.id}
            todo={todo}
            handleDeleteTodo={handleDeleteTodo}
            handleToggleIsDone={handleToggleIsDone}
          />
        ))}
      </TodoItemWrapper>
      <TodoItemInputField>
        <TodoItemTextField
          type="text"
          placeholder="Add something to do here?"
          value={value}
          onChange={handleInputChange}
          onKeyDown={handleInputKeyDown}
        />
        <AddButton onClick={handleButtonClick}>+</AddButton>
      </TodoItemInputField>
    </TodoListWrapper>
  );
}
