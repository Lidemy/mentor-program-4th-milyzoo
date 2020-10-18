/* eslint prefer-destructuring: ["error", {VariableDeclarator: {object: false}}] */

// 將 HTML 特殊字元轉換成正常字串顯示 (用意 => 使 HTML 格式失效)
function escapeHtml(unsafe) {
  return unsafe
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

// 新增事項
function addList() {
  const value = document.querySelector('.write__input').value;
  const list = document.querySelector('.list');
  const listItem = document.createElement('label');
  const noteEmpty = document.querySelector('.write');

  if (!value) return noteEmpty.classList.add('note_empty-show'); // 如果欄位為空值就顯示提示字
  noteEmpty.classList.remove('note_empty-show'); // 否則就移除提示字

  listItem.innerHTML = `<div class="list__tittle">
        <input class="list__check" type="checkbox">
        <p>${escapeHtml(value)}</p>
    </div>
    <button class="list__delete" type="button" value="delete">
        <span class="note_delete">delete</span>
    </button>`;
  listItem.classList.add('list__item');
  list.append(listItem);

  // 新增完事項就清空剛剛在輸入框寫的字
  document.querySelector('.write__input').value = '';
  return true; // ESlint 強制要加的
}


// 監聽 => 點擊按鈕就新增事項
document.querySelector('.write__add-btn').addEventListener('click', addList);
// 按下 enter 鍵也能新增事項
document.querySelector('.write__input').addEventListener('keydown', (e) => {
  if (e.keyCode === 13) addList();
});

document.querySelector('.list').addEventListener('click', (e) => {
  // 刪除事項
  if (e.target.classList.contains('list__delete')) {
    e.target.parentNode.remove();
  }

  // 偵測 checkbox 狀態是否被勾選來切換 .done 的 class
  if (e.target.classList.contains('list__check')) {
    if (e.target.checked) {
      e.target.parentNode.parentNode.classList.add('done');
    } else {
      e.target.parentNode.parentNode.classList.remove('done');
    }
  }
});
