const showBtns = document.querySelectorAll(".dropdown_btn");
const dropdownBtn = document.querySelector("#container__fullname");

const subMenu = document.querySelector("#emergent__subMenu");

const navbarBtns = document.querySelectorAll(".navbar__element");

const incidentesEmergentes = document.querySelector("#incidentesEmergentes");
const incidentesEnCurso = document.querySelector("#incidenteEnCurso");
const contenedorIncidentesEmergentes = document.querySelector(
  "#incidentesEmergentes-container"
);


navbarBtns.forEach((opt) => {
  opt.addEventListener("click", (e) => {
    navbarBtns.forEach((btn) => btn.classList.remove("selected"));
    e.currentTarget.classList.add("selected");

    const elementId = e.currentTarget.getAttribute("id");

    document
      .querySelectorAll(".emergent")
      .forEach((menu) => menu.classList.add("hidden"));
    switch (elementId) {
      case "emergentes":
        incidentesEmergentes.classList.remove("hidden");
        loadEmergentIncidents()
        break;
      case "enCurso":
        incidentesEnCurso.classList.remove("hidden");
        break;
      case "pasados":
        break;
      case "historialIncidentes":
        break;
      default:
        break;
    }
  });
});

showBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => showIncidentsInformation(e));
});

dropdownBtn.addEventListener("click", (e) => {
  const icon = e.currentTarget.children[0];
  subMenu.classList.toggle("subMenu-hidden");
  icon.classList.toggle("active");
});

window.onload = loadEmergentIncidents();

function loadEmergentIncidents() {
  var contenedor = $(contenedorIncidentesEmergentes).load(
    "../controladores/getIncidents.php",
    {
      filter: 0,
    }
  );
  setTimeout(() => {
    contenedor
      .find(".dropdown_btn")
      .on("click", (e) => showIncidentsInformation(e));
    contenedor.find(".startIncident_btn").on("click", e => startIncidentResolution(e));
  }, 500);
}

const showIncidentsInformation = (e) => {
  const incident_information =
    e.currentTarget.parentElement.parentElement.nextElementSibling;
  const icon = e.currentTarget.children[0];
  incident_information.classList.toggle("incident__information-hidden");
  icon.classList.toggle("active");
};

const startIncidentResolution = (e) => {
    const incidentTitle = e.currentTarget.parentElement.parentElement
    const inicident = incidentTitle.parentElement
    if(incidentTitle.classList.contains('incident__title--confirm')){
        inicident.classList.add('incident-active')
        console.log(inicident.getAttribute('id'));
        $('#release').load('../controladores/startIncidentResolution.php', {id_incidente: inicident.getAttribute('id')})
        setTimeout(() => inicident.remove(), 500)
    }else{
        incidentTitle.classList.add('incident__title--confirm')
    }
}