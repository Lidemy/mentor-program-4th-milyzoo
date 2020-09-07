/* eslint-disable no-use-before-define */
/* eslint no-unused-vars: 0 */
const request = require('request');
const process = require('process');

const action = process.argv[2];
const numbering = process.argv[3];
const baseURL = 'https://lidemy-book-store.herokuapp.com';

switch (action) {
  case 'list':
    bookList();
    break;
  case 'read':
    readBook(numbering);
    break;
  case 'delete':
    deleteBook(numbering);
    break;
  case 'create':
    createBook(numbering);
    break;
  case 'update':
    updateBookName(numbering, process.argv[4]);
    break;
  default:
    console.log('請輸入指令：list, read, del, create, update');
}

// 印出前二十本書的 id 與書名
function bookList() {
  request(
    `${baseURL}/books?_limit=20`,
    (error, response, body) => {
      const books = JSON.parse(body);
      if (error) {
        console.log('抓取失敗', error);
        return;
      }
      for (let i = 0; i < books.length; i += 1) {
        console.log(`${books[i].id} ${books[i].name}`);
      }
    },
  );
}

// 輸出 id 為 ${id} 的書籍
function readBook(id) {
  request(
    `${baseURL}/books/${id}`,
    (error, response, body) => {
      if (error) {
        console.log('抓取失敗');
        return;
      }
      if (body === '{}') {
        console.log(`id${id}：目前沒有書籍資料`);
        return;
      }
      const books = JSON.parse(body);
      console.log(books.name);
    },
  );
}

// 刪除 id 為 ${id} 的書籍
function deleteBook(id) {
  request.delete(
    `${baseURL}/books/${id}`,
    (error, response, body) => {
      if (error) {
        console.log('抓取失敗');
        return;
      }
      console.log(`刪除 id${id} 成功`);
    },
  );
}

// 新增一本名為 ${bookName} 的書
function createBook(bookName) {
  request.post(
    {
      url: `${baseURL}/books/`,
      form: {
        name: bookName,
      },
    },
    (error, response, body) => {
      if (error) {
        console.log('新增失敗');
        return;
      }
      console.log(`新增【${bookName}】成功`);
    },
  );
}

// 更新 id 為 1 的書名為 new name
function updateBookName(id, newBookName) {
  request.patch(
    {
      url: `${baseURL}/books/${id}`,
      form: {
        name: newBookName,
      },
    },
    (error, response, body) => {
      if (error) {
        console.log('更新書名失敗');
        return;
      }
      if (body === '{}') {
        console.log(`id${id} 目前沒有書籍資料`);
        return;
      }
      console.log(`id${id} 更新成功`);
    },
  );
}
