import { createGlobalStyle } from "styled-components";

const GlobalCSS = createGlobalStyle`
  body {
    font-family: 'Microsoft JhengHei';
    background-color: #f0f0f0;
  }
  *{
    margin: 0;
    padding: 0;
    list-style: none;
    box-sizing: border-box;
}
  p {
    margin: 0;
  }
`;

export default function GlobalStyle() {
  return <GlobalCSS />;
}
