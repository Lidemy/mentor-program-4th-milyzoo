// -------------------- 手機版 menu 選單 --------------------
document.querySelector('.nav__menu-btn').addEventListener('click', function(e) {
    e.target.closest('.nav').classList.toggle('nav__menu-active');
})

// -------------------- 彈跳出來的互動視窗 (modal) --------------------
let isOpen = false; // 預設 Modal 不打開
// 判斷 modal 視窗有沒有打開（參數一：目標元素；參數二：最外層元素；參數三：要切換的元素）
function checkModal(target, outerElement, toggleElement) {
  if (!isOpen) {
    target.closest(outerElement).classList.add(toggleElement);
  } else {
    target.closest(outerElement).classList.remove(toggleElement);
  }
}

// 執行 modal（參數一：被監聽的元素；參數二：觸發打開 modal 的按鈕）
function modalAction(listener, button) {
  const modalButtons = document.querySelectorAll(button);
  for (let modalButton of modalButtons) {
    document.querySelector(listener).addEventListener('click', function (e) {
      if (e.target === modalButton) {  // 如果點擊到觸發 modal 的按鈕 -> 打開 Modal
        isOpen = true;
        checkModal(e.target, '.modal', 'modal-hide');
      } else if (e.target.classList.contains('modal-box') || 
                e.target.classList.contains('modal__close') || 
                e.target.classList.contains('modal__cancel')) 
      { // 如果點擊到背景 / 關閉按鈕 / 取消按鈕 -> 關閉 Modal
        isOpen = false;
        checkModal(e.target, '.modal', 'modal-hide');
      } // 除了上述三個指定位置以外，其他地方怎麼點擊都不會關掉 Modal
    })
  }
}

// 確認要刪除留言的 modal
modalAction('.comment', '.delete-modal__btn');

// 捨棄編輯留言的 modal
modalAction('.modal', '.board__cancel-edit');