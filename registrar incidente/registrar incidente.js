const errorMsg = document.querySelector('#container__alert')
const bodyElemnts = document.querySelectorAll('body > *')

bodyElemnts.forEach(element => {
    element.addEventListener('click', ()=> {
        errorMsg != null ? errorMsg.remove() : null
    })
});