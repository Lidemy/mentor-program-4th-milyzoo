// 漢堡選單
const mobileMenu = document.querySelector('.mobile-menu');
const navbar = document.querySelector('.navbar');
mobileMenu.addEventListener('click', () => {
  navbar.classList.toggle('open');
  mobileMenu.classList.toggle('open');
});

// FAQ
document.querySelector('.question').addEventListener('click', (e) => {
  e.target.closest('.question__item').classList.toggle('question__answer-show');
});
