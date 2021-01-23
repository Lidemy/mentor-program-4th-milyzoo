/* eslint-env jquery */
/* eslint-disable no-useless-escape, no-alert, quote-props, no-shadow, prefer-destructuring */

let siteKey = '';
let apiUrl = '';
let containerElement = null;
let commentDOM = null;
let lastId = null;
let isEnd = false;

const css = `
  body {
    color: #333333;
    background-color: #f2f2f2;
  }
  .add-comment {
    border: 1px solid rgba(0,0,0,.125);
  }
  textarea {
    resize:none;
  }
  #nickname, #content {
    border: 0;
    border: 1px solid transparent;
    transition: 0.5s;
    background-color: #f2f2f2;
  }
  #nickname:focus, #content:focus {
    box-shadow: 0 0 0 0;
    border: 1px solid #6c757d;
  }
`;
const loadMoreButtonHTML = `
<div class="row justify-content-center mt-3">
  <button class="load-more btn btn-dark">載入更多</button>
</div>`;

const formTemplate = `
  <div>
    <div class="add-comment p-4 mb-5 p-3 mb-5 bg-light rounded">        
      <form class="add-comment-form">
        <div class="form-group">
          <label for="nickname">暱稱</label>
          <input type="text" class="form-control rounded-0" name="nickname" id="nickname" required>
        </div>
        <div class="form-group">
          <label for="content">留言內容</label>
          <textarea class="form-control rounded-0" name="content" id="content" rows="4" required></textarea>
        </div>                
        <div class="d-flex">
          <button type="submit" class="btn btn-secondary pl-4 pr-4 rounded-pill mx-auto">送出</button>
        </div>
      </form>
    </div>
  </div>
  <div class="comments">
  </div>
`;

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

function getCommentsAPI(APIsiteKey, before, cb) {
  let url = `${apiUrl}/api_comments.php?site_key=${APIsiteKey}`;
  if (before) {
    url += `&before=${before}`;
  }
  $.ajax({
    url,
  }).done((data) => {
    cb(data);
  });
}

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

    const length = comments.length;
    if (length === 0) {
      isEnd = true;
      $('.load-more').hide();
    } else {
      lastId = comments[length - 1].id;
      $('.comments').append(loadMoreButtonHTML);
    }
  });
}

function init(options) {
  siteKey = options.siteKey;
  apiUrl = options.apiUrl;
  containerElement = $(options.containerSelector);
  containerElement.append(formTemplate);
  const styleElement = document.createElement('style');
  styleElement.type = 'text/css';
  styleElement.appendChild(document.createTextNode(css));
  document.head.appendChild(styleElement);
  commentDOM = $('.comments');
  getComments();

  $('.comments').on('click', '.load-more', () => {
    getComments();
  });

  $('.add-comment-form').submit((e) => {
    e.preventDefault();
    const newCommentData = {
      'site_key': siteKey,
      'nickname': $('input[name=nickname]').val(),
      'content': $('textarea[name=content]').val(),
    };
    $.ajax({
      type: 'POST',
      url: `${apiUrl}/api_add_comments.php`,
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
}

init({
  siteKey: 'Mily',
  apiUrl: 'http://mentor-program.co/mtr04group5/mily/week13/hw2/',
  containerSelector: '.comments-area',
});
