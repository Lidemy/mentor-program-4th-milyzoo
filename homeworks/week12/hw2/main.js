/* eslint-env jquery */
/* eslint-disable no-alert, no-unused-vars */

let id = 1;
let todoCount = 0; // 所有 todo
let unCompleteTodoCount = 0; // 未完成 todo
const todoItemTemplate = `
  <li class="todo-item justify-content-between align-items-center {todoClass} edit-hide" data-number="1">
    <div class="todo-item__body">
      <div class="todo-item__content custom-control custom-checkbox d-flex align-items-center mr-3">
        <input type="checkbox" class="todo-item__check custom-control-input" id="todo-{id}">
        <label class="todo-item__info custom-control-label" for="todo-{id}">{content}</label>
      </div>
      <div class="todo-item__btn d-flex align-items-center">
        <button class="todo-item__edit" aria-hidden="true">
          <i class="far fa-edit"></i>
        </button>
        <button class="todo-item__delete" aria-hidden="true">
          <i class="far fa-trash-alt"></i>
        </button>      
      </div>
    </div>

    <div class="todo-item__edit-content mt-3">
      <div class="d-flex">
        <input type="text" class="form-control edit-content__input" value="">
        <button type="button" class="edit-done btn btn-secondary ml-3">編輯完成</button>
      </div>
    </div>
  </li>`;

const searchParams = new URLSearchParams(window.location.search);
const todoId = searchParams.get('id');

// 跳脫字元
function escapeHtml(unsafe) {
  return unsafe
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

function updateCounter() {
  $('.unComplete-count').text(unCompleteTodoCount);
}

function restoreTodos(todos) {
  if (todos.length === 0) return; // 儲存的資料裡面是空的話就直接 return，不做後續動作
  id = todos[todos.length - 1].id + 1; // 設置成最後一個 todo 的 id + 1
  for (let i = 0; i < todos.length; i += 1) {
    const todo = todos[i];
    $('.todo-list').append(
      todoItemTemplate
        .replace('{content}', escapeHtml(todo.content))
        .replace(/{id}/g, todo.id)
        .replace('{todoClass}', todo.isDone ? 'todo-item__complete' : ''),
    );
    todoCount += 1;
    if (todo.isDone) { // 回傳的 isDone 資料如果是 true 的話
      $(`#todo-${todo.id}`).prop('checked', true); // 就改變 id="todo-{id}" 的 checked 狀態
    }
    if (!todo.isDone) { // 回傳的 isDone 資料如果是 false 的話
      unCompleteTodoCount += 1;
    }
  }
  updateCounter();
}

if (todoId) { // 如果有讀取到 id
  $.getJSON(`http://mentor-program.co/mtr04group5/mily/week12/hw2/get_todo.php?id=${todoId}`, (data) => {
    const todos = JSON.parse(data.data.todo);
    restoreTodos(todos); // 載入儲存的資料
  });
}

function addTodoItem() {
  const todoValue = $('.add-input input').val();
  if (!todoValue) return; // 如果欄位為空值就 return（將不繼續後續動作）

  $('.todo-list').append(
    todoItemTemplate
      .replace('{content}', escapeHtml(todoValue))
      .replace(/{id}/g, id),
  );
  id += 1;
  todoCount += 1;
  unCompleteTodoCount += 1;
  updateCounter();
  $('.add-input input').val(''); // 輸入完清空欄位
}

// 點擊 + 按鈕就新增 todo 事項
$('.add-input__btn').click(() => {
  addTodoItem();
});

// 按下 Enter 鍵就新增 todo 事項
$('.add-input input').keydown((e) => {
  if (e.keyCode === 13) { // 如果用 e.key === 'Enter' 去判斷，輸入中文字會有 bug
    addTodoItem();
  }
});

// 點擊編輯按鈕後
$('.todo-list').on('click', '.todo-item__edit', (e) => {
  const todoItem = $(e.target).closest($('.todo-item'));
  const originalContent = $(e.target).parents('.todo-item__body').find('.todo-item__info').text();
  todoItem.find('.edit-content__input').val(originalContent); // 將文字放入編輯的 input
  if (todoItem.hasClass('edit-show')) {
    todoItem.removeClass('edit-show');
  } else {
    todoItem.addClass('edit-show');
  }
});

// 編輯 todo 事項
$('.todo-list').on('click', '.edit-done', (e) => {
  const todoItem = $(e.target).closest($('.todo-item'));
  const newTodoContent = $(e.target).closest($('.todo-item')).find('.edit-content__input').val();
  todoItem.removeClass('edit-show');
  todoItem.find('.todo-item__info').text(newTodoContent);
});

// 刪除 todo 事項
$('.todo-list').on('click', '.todo-item__delete', (e) => {
  $(e.target).closest($('.todo-item')).remove();
  todoCount -= 1;

  const isChecked = $(e.target).closest('.todo-item').find('.todo-item__check').is(':checked');
  if (!isChecked) {
    unCompleteTodoCount -= 1;
  }
  updateCounter();
});

// checkbox 狀態改變
$('.todo-list').on('change', '.todo-item__content', (e) => {
  const target = $(e.target);
  const isChecked = target.is(':checked');
  if (isChecked) {
    target.parents('.todo-item').addClass('todo-item__complete');
    unCompleteTodoCount -= 1;
  } else {
    target.parents('.todo-item').removeClass('todo-item__complete');
    unCompleteTodoCount += 1;
  }
  updateCounter();
});

// 移除已完成事項
$('.todo-action__clear').click(() => {
  todoCount -= $('.todo-item__complete').length;
  $('.todo-item__complete').remove();
});

// 篩選事項是否完成
$('.todo-action__options').on('click', 'div', (e) => {
  const target = $(e.target);
  const todoItem = $('.todo-item');
  const todoItemDone = $('.todo-item.todo-item__complete');
  if (target.hasClass('filter-all')) { // 全部
    todoItem.show();
    target.addClass('active');
    $('.filter-uncomplete').removeClass('active');
    $('.filter-done').removeClass('active');
  } else if (target.hasClass('filter-uncomplete')) { // 未完成
    todoItem.show();
    todoItemDone.hide();
    $('.filter-all').removeClass('active');
    $('.filter-done').removeClass('active');
    target.addClass('active');
  } else { // 已完成
    todoItem.hide();
    todoItemDone.show();
    $('.filter-all').removeClass('active');
    $('.filter-uncomplete').removeClass('active');
    target.addClass('active');
  }
});

$('.todo-action__save').click(() => {
  const todos = [];
  $('.todo-item').each((i, element) => {
    const input = $(element).find('.todo-item__check');
    const label = $(element).find('.todo-item__info');
    todos.push({ // 把資料放入陣列
      id: input.attr('id').replace('todo-', ''),
      content: label.text(),
      isDone: $(element).hasClass('todo-item__complete'),
    });
  });
  const data = JSON.stringify(todos); // 轉成字串
  $.ajax({
    type: 'POST',
    url: 'http://mentor-program.co/mtr04group5/mily/week12/hw2/add_todo.php',
    data: {
      todo: data,
    },
    success: (resp) => {
      const respId = resp.id;
      $('.save-id').text(respId);
      $('.todolist-save.close').click(() => {
        window.location = `index.html?id=${respId}`;
      });
    },
    error: () => {
      alert('wrong!');
    },
  });
});
