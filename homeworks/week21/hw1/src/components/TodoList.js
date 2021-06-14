import styled from "styled-components";
import clearImg from "../images/clear.svg";
import { useState, useRef, useMemo } from "react";
import SingleTodoItem from "./TodoItem";

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

const UncompletedCount = styled.span`
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
  const [todos, setTodos] = useState([
    { id: 1, content: "已完成", isDone: true }, // 內建第一筆資料
    { id: 2, content: "未完成", isDone: false }, // 內建第二筆資料
  ]);
  const [value, setValue] = useState("");
  const [currentFilter, setCurrentFilter] = useState("all");
  let id = useRef(3); // 已經有內建 id: 2，所以初始值要從 3 開始
  let uncompleteCount = todos.filter((todo) => !todo.isDone).length;

  function SendTodoContent() {
    if (!value) return; // 未輸入文字就不能送出
    setTodos([
      {
        id: id.current,
        content: value,
      },
      ...todos,
    ]);
    setValue(""); // 做完就清空 setValue
    id.current++;
  }
  const handleButtonClick = () => SendTodoContent();
  const handleInputKeyDown = (e) => {
    if (e.keyCode === 13) SendTodoContent();
  };

  const handleInputChange = (e) => setValue(e.target.value);

  const handleDeleteTodo = (id) => {
    setTodos(todos.filter((todo) => todo.id !== id));
    // filter 只會留下符合條件的東西，而 todo.id 一定等於 id，這代表不會留下任何東西，即可達成刪除功能
  };

  const handleToggleIsDone = (id) => {
    setTodos(
      todos.map((todo) => {
        if (todo.id !== id) return todo; // 如果這個 todo 不是要修改的 todo id 就回傳原本的 todo

        // 進入這一行就代表是要修改的 todo.id
        // 回傳原本的東西（...todo）+ 要修改的屬性（isDone: !todo.isDone）
        return {
          ...todo,
          isDone: !todo.isDone,
        };
      })
    );
  };

  const filterAllTodo = () => setCurrentFilter("all");

  const filterUncompeletedTodo = () => setCurrentFilter("uncomplete");

  const filterDoneTodo = () => setCurrentFilter("done");

  const filterTodos = useMemo(() => {
    return todos.filter((todo) => {
      if (currentFilter === "all") return true;
      return currentFilter === "done" ? todo.isDone : !todo.isDone;
    });
  }, [todos, currentFilter]);

  const clearDoneTodo = () =>
    setTodos(todos.filter((todo) => todo.isDone !== true));

  return (
    <TodoListWrapper>
      <FilterWrapper>
        <FilterButton
          onClick={filterAllTodo}
          $isActive={currentFilter === "all"}
        >
          全部
        </FilterButton>
        <FilterButton
          onClick={filterUncompeletedTodo}
          $isActive={currentFilter === "uncomplete"}
        >
          未完成
        </FilterButton>
        <FilterButton
          onClick={filterDoneTodo}
          $isActive={currentFilter === "done"}
        >
          已完成
        </FilterButton>
      </FilterWrapper>
      <TodoItemInfo>
        <p>
          <UncompletedCount>{uncompleteCount}</UncompletedCount>個未完成
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
