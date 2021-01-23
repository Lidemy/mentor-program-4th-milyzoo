/* eslint-env jquery */
/* eslint-disable no-useless-escape, no-alert, quote-props */

// 預防 XSS 攻擊（轉換純文字）
function escape(toOutput) {
  return toOutput.replace(/\&/g, '&amp;')
    .replace(/\</g, '&lt;')
    .replace(/\>/g, '&gt;')
    .replace(/\"/g, '&quot;')
    .replace(/\'/g, '&#x27')
    .replace(/\//g, '&#x2F');
}

function appendCommentToDOM(container, comment, isPrepend) {
  const html = `
    <div class="card bg-light mb-3">
        <div class="card-header">${escape(comment.nickname)}</div>
        <div class="card-body">
            <p class="card-text">${escape(comment.content)}</p>
        </div>
    </div>
  `;
  // 判斷讓留言要不要顯示在最上方
  if (isPrepend) {
    container.prepend(html);
  } else {
    container.append(html);
  }
}

function getCommentsAPI(siteKey, before, cb) {
  let url = `http://mentor-program.co/mtr04group5/mily/week12/hw1/api_comments.php?site_key=${siteKey}`;
  if (before) {
    url += `&before=${before}`;
  }
  $.ajax({
    url,
  }).done((data) => {
    cb(data);
  });
}

const siteKey = 'mily';
const loadMoreButtonHTML = `
  <div class="row justify-content-center mt-3">
    <button class="load-more btn btn-dark">載入更多</button>
  </div>
  `;
let lastId = null;
let isEnd = false;

function getComments() {
  const commentDOM = $('.comments');
  $('.load-more').hide();
  if (isEnd) {
    return;
  }
  getCommentsAPI(siteKey, lastId, (data) => {
    if (!data.ok) {
      alert(data.message);
      return;
    }

    const comments = data.discussions;
    comments.forEach(comment => appendCommentToDOM(commentDOM, comment));
    // 下面是原寫法使用 for...of，因 ESlint 改用 forEach 來寫
    // for (let comment of comments) {
    //   appendCommentToDOM(commentDOM, comment);
    // }

    if (comments.length === 0) {
      isEnd = true;
      $('.load-more').hide();
    } else {
      lastId = comments[comments.length - 1].id;
      $('.comments').append(loadMoreButtonHTML);
    }
  });
}

$(document).ready(() => {
  const commentDOM = $('.comments');
  getComments();

  $('.comments').on('click', '.load-more', () => {
    getComments();
  });

  $('.add-comment-form').submit((e) => {
    e.preventDefault();
    const newCommentData = {
      'site_key': 'mily',
      'nickname': $('input[name=nickname]').val(),
      'content': $('textarea[name=content]').val(),
    };
    $.ajax({
      type: 'POST',
      url: 'http://mentor-program.co/mtr04group5/mily/week12/hw1/api_add_comments.php',
      data: newCommentData,
    }).done((data) => {
      if (!data.ok) {
        alert(data.message);
        return;
      }
      $('input[name=nickname]').val(''); // 送出留言後清空輸入欄
      $('textarea[name=content]').val(''); // 送出留言後清空輸入欄
      appendCommentToDOM(commentDOM, newCommentData, true);
    });
  });
});
