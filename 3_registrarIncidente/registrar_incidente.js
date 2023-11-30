const errorMsg = document.querySelector("#container__alert");
const bodyElemnts = document.querySelectorAll("body > *");
const submitBtn = document.querySelector("#form__submit");
const ciInput = document.querySelector("input[name='ci']");

bodyElemnts.forEach((element) => {
  element.addEventListener("click", () => {
    errorMsg != null ? errorMsg.remove() : null;
  });
});

submitBtn.addEventListener("click", (e) => {
  if (!checkCI(ciInput.value)) {
    setTimeout(() => ciInput.classList.add("unvalid--input"), 50);
    e.preventDefault();
  }
});

document.querySelectorAll('input, textarea').forEach((input) => {
  input.addEventListener("keydown", (e) => {
    const keyCode = e.key;
    if (keyCode == "<" || keyCode == ">") e.preventDefault();
  });
});

document.querySelectorAll("*").forEach((elemnt) => {
  elemnt.addEventListener("click", () =>
    ciInput.classList.remove("unvalid--input")
  );
});

const checkCI = (ci) => {
  if (ci == 0) return false;
  const inputValues = ci.split("");
  const nums = inputValues.map((num) => Number(num));
  const lastNum = nums.pop();
  let result =
    2 * nums[0] +
    9 * nums[1] +
    8 * nums[2] +
    7 * nums[3] +
    6 * nums[4] +
    3 * nums[5] +
    4 * nums[6];
  result %= 10;
  result = (10 - result) % 10;

  return result == lastNum ? true : false;
};
