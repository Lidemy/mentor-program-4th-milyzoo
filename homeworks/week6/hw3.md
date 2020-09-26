## 請找出三個課程裡面沒提到的 HTML 標籤並一一說明作用。
### `<hr>`
用途為分隔線，但使用 `<hr>` 所呈現的分隔線樣式較陽春且缺乏可變性，一般不太會用於網站切版，大多數運用在網站後台的文字編輯器裡（如下圖）。

![](https://github.com/Lidemy/mentor-program-4th-milyzoo/blob/master/homeworks/week6/note-images/hr.png?raw=true)

### `<optgroup>`
用來將 `<select>` 裡相同性質的 `<option>` 分組。在 `<optgroup>` 中的 `label` 屬性是用來設定該分組的名稱。

範例：

```htmlmixed=
<select name="age">
  <optgroup label="嬰兒">
    <option>0 至 1 歲</option>
    <option>1 至 3 歲</option>
  </optgroup>
  <optgroup label="小孩">
    <option>4 至 10 歲</option>
    <option>10 至 17 歲</option>
  </optgroup>
  <optgroup label="成年人">
    <option>18 至 30 歲</option>
    <option>31 至 40 歲</option>
    <option>41 至 60 歲</option>
  </optgroup>
</select>
```

![](https://github.com/Lidemy/mentor-program-4th-milyzoo/blob/master/homeworks/week6/note-images/optgroup.png?raw=true)

### `<figure>`
`<figure>` 代表一段獨立的內容，任意移動位置時也不會影響網頁整體內容，最常用於圖片，並與 `<figcaption>` 搭配使用，除了放圖片外，亦可使用於其他內容像是圖片、影片或程式碼片段等。

範例：

```htmlmixed=
<figure>
  <img src="images/me.jpg">
  <figcaption>自拍照</figcaption>
</figure>
```

> 裡面也可以包含多個 `＜img＞` 標籤。

## 請問什麼是盒模型（box model）

![](https://github.com/Lidemy/mentor-program-4th-milyzoo/blob/master/homeworks/week6/note-images/box-model.jpg?raw=true)

在 CSS 中，每一個元素皆可視為一個盒子，由內而外分別是由以下屬性組成：元素內容、`padding`、`border`、`margin`。
（打開 Chrome DevTools 時，也能在右下角看到熟悉的 box model。）

- 元素內容：`width` 和 `height`。
- `padding`：內距。
- `border`：邊線。
- `margin`：外距，該元素與其他元素間的邊界距離。

如果把人類比喻成 box model 的話，可以想成「**把自己吃胖後穿上外套，再與其他人隔著一段距離。**」

- 元素內容：自己的身高＆寬度。
- `padding`：增加的脂肪。
- `border`：外套。
- `margin`：與其他人的距離。


## 請問 display: inline, block 跟 inline-block 的差別是什麼？
### 什麼是 `display`？
`display` 是 CSS 中最重要的屬性，HTML 中的每個元素都有一個預設值，大部分元素的 display 預設值通常是
 inline（[行內元素](https://developer.mozilla.org/en-US/docs/Web/HTML/Inline_elements)）或 block（[區塊元素](https://developer.mozilla.org/en-US/docs/Web/HTML/Block-level_elements)）。


### inline（行內元素）
- 元素會在同一行內呈現
- 不可設定 `width`、`height` ，會無作用。
- 設定 `margin`、`padding` 時字仍在行內，其他元素不會受行內元素影響而改變排版。
`margin` ：上下距離無作用，僅能調整左右距離。
`padding` ：雖有作用卻不會造成與其他元素之間的距離變動。

常見標籤：`span`、`a`、`<img>`、`input`、`button`、`label`...
  
### block（區塊元素）
- 元素寬度預設會佔滿容器寬度，因此達到換行效果。
- `width`、`height`、`margin`、`padding` 均能設定，但仍會佔滿整行。

常見標籤：`div`、`ul`、`li`、`form`、`<p>`、`<h1>`...

### inline-block（行內區塊）
綜合 inline 和 block 的特性：
- 讓元素排版呈現水平排列。
- `width`、`height`、`margin`、`padding` 設定均有效。

## 請問 position: static, relative, absolute 跟 fixed 的差別是什麼？
### position 屬性
用來設定元素位置的語法，能夠指定元素要定位在網頁上的哪個位置，若能妥善運用，即能讓網頁上的排版更靈活。

### position: static; 預設值
元素的預設值，如果沒有特別設定 position 的話就是預設 static 屬性。

### position: relative; 相對定位
- 以元素原本的位置為基準點。
- 可以設置 `top`、`bottom`、`left`、`right` 的數值來偏移元素位置，即使元素偏移了也不會影響到其他元素。
- 多數情況會搭配 `position: absolute` 一起排版使用。 

### position: absolute; 絕對定位
- 以參考點的位置為基準點去做定位，會往父層開始找參考點，若父層未設定 relative，就會一路往上找「position 設定不是 static 的元素」來做參考點，若都找不到參考點，就會以 `<body>` 當作定位參考點。
- 會脫離原本的排版，但一樣可以設置 `top`、`bottom`、`left`、`right` 的數值來偏移位置。

### position: fixed; 固定定位
相對於 viewport 做定位，當元素使用這個屬性後，會固定在視窗的某處，就算拉動瀏覽器捲軸也不改變其位置。
最常使用的案例：置頂鈕、導覽列...


---

參考文章：
- [figure 和 figcaption 元素的正确使用方式](https://www.w3cplus.com/html5/quick-tip-the-right-way-to-use-figure-and-figcaption-elements.html)
- [CSS 排版觀念：Box Model](https://jaceju.net/css-box-model/)
- [CSS教學-關於display:inline、block、inline-block的差別](https://medium.com/@wendy199288/css%E6%95%99%E5%AD%B8-%E9%97%9C%E6%96%BCdisplay-inline-inline-block-block%E7%9A%84%E5%B7%AE%E5%88%A5-1034f38eda82)
- [關於 "display" 屬性](https://zh-tw.learnlayout.com/display.html)
