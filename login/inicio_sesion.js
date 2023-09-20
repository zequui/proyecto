const passwordInput = document.querySelector('#container__password')
const seekingBtn = document.querySelector('#container__seekingBtn')
const errorMsg = document.querySelector('#container--error__error')
const bodyElemnts = document.querySelectorAll('body > *')

bodyElemnts.forEach(element => {
    element.addEventListener('click', ()=> {
        errorMsg != null ? errorMsg.remove() : null
    })
});

seekingBtn.addEventListener('click', () => {
    seekingBtn.classList.toggle('fa-eye-slash')
    seekingBtn.classList.toggle('fa-eye')
    passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password'
})


console.log(seekingBtn);