import React from "react";
import styled from "styled-components";
import TodoList from "./TodoList";
import GlobalStyle from "./GlobalStyle";

const Wrapper = styled.div`
  margin: 100px auto 0 auto;
  max-width: 550px;

  @media screen and (max-width: 768px) {
    width: 90%;
  }
`;

function App() {
  return (
    <Wrapper>
      <GlobalStyle />
      <TodoList />
    </Wrapper>
  );
}

export default App;
