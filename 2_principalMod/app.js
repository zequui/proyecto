const showBtns = document.querySelectorAll('.dropdown_btn')
const dropdownBtn = document.querySelector('#container__fullname')
const subMenu = document.querySelector('#container__subMenu')

showBtns.forEach(btn => {
    btn.addEventListener('click', e => {
        const incident_information = e.currentTarget.parentElement.parentElement.nextElementSibling;
        const icon = e.currentTarget.children[0];
        incident_information.classList.toggle('incident__information-hidden')
        icon.classList.toggle('active')
    })
});

dropdownBtn.addEventListener('click', e => {
    const icon = e.currentTarget.children[0]
    subMenu.classList.toggle('subMenu-hidden')
    icon.classList.toggle('active')
})