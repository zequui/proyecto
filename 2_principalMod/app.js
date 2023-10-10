const showBtns = document.querySelectorAll('.dropdown_btn')
const dropdownBtn = document.querySelector('#container__fullname')
const subMenu = document.querySelector('#emergent__subMenu')
const navbarBtns = document.querySelectorAll(".navbar__element");
const incidentesEmergentes = document.querySelector('#incidentesEmergentes')
const incidentesEnCurso = document.querySelector('#incidenteEnCurso')

navbarBtns.forEach((opt) => {
  opt.addEventListener("click", (e) => {
    navbarBtns.forEach(btn => btn.classList.remove('selected'))
    e.currentTarget.classList.add("selected");

    const elementId = e.currentTarget.getAttribute('id')
    document.querySelectorAll('.emergent').forEach(menu => menu.classList.add('hidden'))
    switch (elementId) {
        case 'emergentes':
            incidentesEmergentes.classList.remove('hidden')
            break;
        case 'enCurso':
            incidentesEnCurso.classList.remove('hidden')
        break;
        case 'pasados':
        
        break;
        case 'historialIncidentes':
        
        break;
        default:
            break;
    }
  });
});

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