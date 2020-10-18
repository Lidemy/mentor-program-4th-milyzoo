/* eslint-disable no-restricted-syntax, no-continue, no-alert, no-undef */
document.querySelector('form').addEventListener('submit', (e) => {
  e.preventDefault();
  let hasError = false; // false 代表必填欄位沒有 error
  const values = {}; // 先宣告物件

  const elements = document.querySelectorAll('.required');
  for (element of elements) {
    const radios = element.querySelectorAll('input[type=radio]');
    const input = element.querySelector('input[type=text]');
    let isValid = true; // true => 欄位有填寫

    if (input) { // 找到 input[type=text]
      values[input.name] = input.value; // values 物件裡的 input.name = input 的值
      if (!input.value) { // 如果是空值
        isValid = false; // false => 欄位沒有填寫
      }
    } else if (radios.length) { // 找到 input[type=radio]
      isValid = [...radios].some(radio => radio.checked); // radio 被點擊的狀態是 true
      if (isValid) { // 欄位有填寫
        const radioChecked = element.querySelector('input[type=radio]:checked');
        values[radioChecked.name] = radioChecked.value; // values 物件裡的 radioChecked.name = input 的值
      }
    } else {
      continue;
    }

    if (!isValid) { // 判斷如果欄位未填寫 (isValid = false)
      element.classList.remove('hide-error');
      hasError = true;
    } else {
      element.classList.add('hide-error');
    }
  }

  if (!hasError) {
    alert(JSON.stringify(values));
  }
});
