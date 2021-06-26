import { createGlobalStyle } from "styled-components";

const GlobalCSS = createGlobalStyle`
  body {
    background-color: #EFF4F6;
    font-family: 'Microsoft JhengHei';
  }
  p {
    margin: 0;
  }
`;

export default function GlobalStyle() {
  return <GlobalCSS />;
}
