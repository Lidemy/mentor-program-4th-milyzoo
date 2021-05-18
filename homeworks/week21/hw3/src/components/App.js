import styled from "styled-components";
import GlobalStyle from "./GlobalStyle";
import FormItems from "./FormItems";

const Footer = styled.p`
  background-color: #000000;
  color: #999999;
  line-height: 60px;
  text-align: center;
  font-size: 13px;
`;

function App() {
  return (
    <div className="App">
      <GlobalStyle />
      <FormItems />
      <Footer>© 2020 Copyright. All rights Reserved.</Footer>
    </div>
  );
}

export default App;
