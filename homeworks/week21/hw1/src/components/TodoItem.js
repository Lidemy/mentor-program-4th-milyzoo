import styled from "styled-components";
import DeleteImg from "../images/delete.svg";
import PropTypes from "prop-types";

const TodoItem = styled.li`
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px 45px;
  transition: 0.3s;

  &:hover {
    background-color: #f6f6f6;
  }
  &:hover Button {
    opacity: 1;
  }
`;

const TodoItemContent = styled.div`
  display: flex;
  align-items: center;
  width: calc(100% - 40px);
  height: 100%;
  color: #555555;
`;

const TodoItemText = styled.label`
  display: flex;
  align-items: center;
  width: 100%;
  height: 100%;
  cursor: pointer;
  transition: 0.3s;

  input {
    margin-right: 15px;
  }

  ${(props) =>
    props.$isDone &&
    `
    text-decoration: line-through;
    color: #E1E1E1;
  `}
`;

const TodoCheckbox = styled.div`
  position: relative;
  margin-right: 20px;
  height: 10px;
  width: 10px;
  border: 1px solid #bbbbbb;
  border-radius: 50%;
  transition: 0.3s;

  &::before {
    content: "";
    position: absolute;
    left: 0.5px;
    bottom: 4px;
    transform: rotate(-50deg);
    width: 15px;
    height: 2px;
    background-color: #858585;
    opacity: 0;
    transition: 0.3s;
  }
  &::after {
    content: "";
    position: absolute;
    left: -2px;
    bottom: 2px;
    transform: rotate(45deg);
    width: 7px;
    height: 2px;
    background-color: #858585;
    opacity: 0;
    transition: 0.3s;
  }
  ${(props) =>
    props.$isDone &&
    `
    border: 1px solid transparent;

    &::before {
      opacity: 1;
    }
    
    &::after {
      opacity: 1;
    }
  `}
`;

const TodoContent = styled.p`
  word-break: break-word;
  width: calc(100% - 32px);
`;

const TodoButtonWrapper = styled.div`
  display: flex;
`;

const Button = styled.button`
  display: flex;
  align-items: center;
  justify-content: center;
  width: 16px;
  height: 16px;
  outline: none;
  border: transparent;
  background-color: transparent;
  opacity: 0;
  transition: 0.3s;
  cursor: pointer;

  img {
    width: 16px;
    height: 16px;
  }

  & + & {
    margin-left: 20px;
  }

  @media screen and (max-width: 768px) {
    opacity: 1;
  }
`;

export default function SingleTodoItem({
  todo,
  handleDeleteTodo,
  handleToggleIsDone,
}) {
  const handleToggleClick = () => {
    handleToggleIsDone(todo.id);
  };

  const handleDeleteClick = () => {
    handleDeleteTodo(todo.id);
  };

  return (
    <TodoItem data-todo-id={todo.id}>
      <TodoItemContent>
        <TodoItemText $isDone={todo.isDone} onClick={handleToggleClick}>
          <TodoCheckbox $isDone={todo.isDone} />
          <TodoContent>{todo.content}</TodoContent>
        </TodoItemText>
      </TodoItemContent>
      <TodoButtonWrapper>
        <Button onClick={handleDeleteClick}>
          <img src={DeleteImg} alt="" />
        </Button>
      </TodoButtonWrapper>
    </TodoItem>
  );
}

SingleTodoItem.propTypes = {
  todo: PropTypes.shape({
    id: PropTypes.number,
    isDone: PropTypes.bool,
    content: PropTypes.string,
  }),
  handleDeleteTodo: PropTypes.func,
  handleToggleIsDone: PropTypes.func,
};
