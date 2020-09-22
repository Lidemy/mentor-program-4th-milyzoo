# [Week6] 作業筆記
雖然加入計畫前沒多久才剛學完 HTML/CSS，但基礎觀念不好，經常切不出想要的畫面，也時常找不到符合需求的參考資料，透過這週的練習來嘗試很多以前不會寫的東西，這樣以後就不用再到網路上剪剪貼貼別人的寫法了！

因為擔心過一段時間就會喪失記憶寫不出來，在這邊紀錄一下這次作業的切版筆記。

## container 的迷思

![](https://github.com/Lidemy/mentor-program-4th-milyzoo/blob/master/homeworks/week6/note-images/container.png?raw=true)

`.container` 是網站中共用的 css 設定，`.content` 裡的內容是水平排列的，而 `<footer>` 裡的內容則是垂直排列的

> 問題：該用什麼樣的方式才是比較好的寫法？

我想到兩種方式排版方式，第一種是「個別設定」：
```
.content .container { ... }
footer .container { ... }
```
第二種方式是「多寫一個共用的 class」：

那個 class 裡面就只有 display: flex;，看哪邊需要水平排列 就在 html 多加那個 class 就好

### 以下是詢問 yakim 助教後得到的建議：

假設 `.content` & `.footer` 都確定 max width 是 1280px，那我就會把 `.container` 拉到外面去

因為寬度這種樣式盡量是由最外層 parent 去決定，然後 children 撐滿 100%，而不是讓 children 設共同 class

```css
<style>
  .container {
    max-width: 1280px;
    // 左右兩邊的間距，padding or margin 都可以，看設計稿，我習慣這樣寫～
    margin: 0 20px; 
  }
  .content {
    disaplay: flex;
  }
  .section {
    // ... 放 content & footer 共用的樣式  
  }
</style>
```
```html
<div class='container'>
  <main class='content section'>...</main>
  <footer class='footer section'>...</footer>
</div> 
```

所以 flex 是直接下在 `.content` 上面，或是也可以像類似 boostrap 的寫法，寫好一個 flex  的 className，然後再想要的 `div` 加上 `.flex`

```css
.flex {
  display: flex;
}
```
```html
<div class='content flex'><div> 
```

（感謝助教，讚嘆助教！）

## 手機版漢堡選單
首先製作漢堡選單圖標

![](https://github.com/Lidemy/mentor-program-4th-milyzoo/blob/master/homeworks/week6/note-images/menu-icon.png?raw=true)

```html
<div class="mobile-menu">
  <span class="mobile-menu__line"></span>
</div>
```
```css
.mobile-menu {
  position: relative;
  width: 35px;
  height: 25px;
  cursor: pointer;
  z-index: 1;
}
.mobile-menu__line,
.mobile-menu::before,
.mobile-menu::after {
  position: absolute;
  width: 100%;
  height: 4px;
  background-color: #010101;
}

/* 漢堡選單中間橫槓 */
.mobile-menu__line {
  top: 50%;
  transform: translateY(-50%);
}

/* 漢堡選單上面橫槓 */
.mobile-menu::before {
  content: '';
  top: 0;
}

/* 漢堡選單下面橫槓 */
.mobile-menu::after {
  content: '';
  bottom: 0;
}
```

調整手機版選單介面

![](https://github.com/Lidemy/mentor-program-4th-milyzoo/blob/master/homeworks/week6/note-images/navbar-layout.png?raw=true)

手機版畫面自由調整成需要的畫面即可，我這次使用定位的方式讓畫面滿版呈現

```css
@media (max-width: 768px) {
header {
  position: relative;
}
.navbar {
  position: absolute;
  top: 0;
  left: 0;
  flex-direction: column;
  width: 100%;
  height: 0;
  /* 先把高度設 0 使選單隱藏 */
  overflow: hidden;
  background-color: #fff;
  text-align: center;
  z-index: 1;
}
.open.navbar {
  /* 偵測到 click 事件才會顯示高度 */
  height: 100vh;
}

```

加入 JavaScript
```javascript
const mobileMenu = document.querySelector('.mobile-menu')
const navbar = document.querySelector('.navbar')
  mobileMenu.addEventListener('click', function (){
  navbar.classList.toggle('open')
})
```

這樣即可完成基本的漢堡選單

![](https://github.com/Lidemy/mentor-program-4th-milyzoo/blob/master/homeworks/week6/note-images/mobile-menu.gif?raw=true)

接下來可以加入一些更符使用者體驗的小動畫
```css
.open .mobile-menu__line {
/* 點擊後圖標中間橫線消失 */
  display: none;
}

/* 以下設定為點擊後上下橫線旋轉位移 */
.open.mobile-menu::before,
.open.mobile-menu::after {
  top: 50%;
  transform: translateY(-50%);
}

.open.mobile-menu::before {
  transform: rotate(45deg);
}

.open.mobile-menu::after {
  transform: rotate(-45deg);
}
```
記得最後在適當的位置設定好 `transition`，就大功告成囉！

![](https://github.com/Lidemy/mentor-program-4th-milyzoo/blob/master/homeworks/week6/note-images/mobile-menu-finish.gif?raw=true)

## Banner 設計

#### 1.尺寸問題
因為網頁版圖片轉換成手機版時，圖片會太扁，導致圖片主體看不清楚
解法：把各裝置的 Banner 圖片分開設定

![](https://github.com/Lidemy/mentor-program-4th-milyzoo/blob/master/homeworks/week6/note-images/banner-size.png?raw=true)
```htmlmixed
<section class="banner">
   <h1>咬一口廚房</h1>
</section>
```
```css
.banner {
  width: 100%;
  height: 580px;
  background-image: url("../images/banner-big.jpg");
  background-size: cover; /* 使圖片大小自動延伸擴展 */
  background-repeat: no-repeat;
  background-position: center center; /* 背景圖片定位的位置 */
}

@media (max-width: 768px){
  .banner {
    background-image: url("../images/banner-small.jpg");
  }
}
@media (max-width: 568px){
  .banner {
    height: 305px;
  }
}
```

#### 2. 加上黑色半透明遮罩
##### 作法一
在 `.banner` 加上偽元素 `::after`，可以達到效果。
> 小缺點：CSS 程式碼會變得冗長，因為 `<h1>` 會被蓋到偽元素下面，這樣還要再另外幫 `<h1>` 設定位點。

##### 作法二
一開始我直接加上 `background-color: rgba(0, 0, 0, 0.25);` 去寫，但無論怎麼測試（寫在一起、分開寫、前後順序調換）都無效，背景顏色 (`background-color`) 總是被壓在背景圖片 (`background-image`) 底下。

參考 [文章](https://segmentfault.com/q/1010000004611696) 後，找到解法：
因為漸變色的屬性是 `<image>`，所以能使用 [CSS 多重背景](https://developer.mozilla.org/zh-TW/docs/Web/CSS/CSS_Background_and_Borders/Using_CSS_multiple_backgrounds) 的原理來解決問題。
```css=
.banner {
  background-image: linear-gradient(rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.25)), url('../images/banner-big.jpg');
}
```

## 滑鼠移入圖片出現效果

![](https://github.com/Lidemy/mentor-program-4th-milyzoo/blob/master/homeworks/week6/note-images/menu-photo.gif?raw=true)

```htmlmixed=
<div class="menu__photo">
  <a href="">
    <img src="images/menu-food-01.png">
    <p>沙拉</p>
  </a>
</div>
```
```css=
.menu__photo a {
  position: relative;
  width: 25%;
  overflow: hidden;
  transition: 0.5s;
}

/* 滑鼠移入圖片後照片變暗 */
.menu__photo a::after {
  position: absolute;
  content: '';
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: #000;
  opacity: 0;
  transition: 0.3s;
}
.menu__photo a:hover::after {
  opacity: 0.3;
}

/* 滑鼠移入後圖片會放大 */
.menu__photo a:hover img {
  transform: scale(1.1);
}

/* 滑鼠移入後會顯示產品名稱 */
.menu__photo a:hover p {
  opacity: 1;
}
.menu__photo a img {
  display: block;
  width: 100%;
  transform: scale(1);
  transition: 0.5s;
}
.menu__photo a p {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  margin: 0;
  font-size: 36px;
  color: #ffffff;
  opacity: 0;
  transition: 0.3s;
  z-index: 1;
}
```