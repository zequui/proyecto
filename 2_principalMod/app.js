const showBtns = document.querySelectorAll('.dropdown_btn')

showBtns.forEach(btn => {
    btn.addEventListener('click', e => {
        const incident_information = e.currentTarget.parentElement.parentElement.nextElementSibling;
        const icon = e.currentTarget.children[0];
        incident_information.classList.toggle('hidden')
        icon.classList.toggle('fa-arrow-down-long')
        icon.classList.toggle('fa-arrow-up-long')
    })
});