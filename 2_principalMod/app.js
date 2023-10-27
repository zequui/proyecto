const showBtns = document.querySelectorAll(".dropdown_btn");
const dropdownBtn = document.querySelector("#container__fullname");

const subMenu = document.querySelectorAll(".emergent__subMenu");

const navbarBtns = document.querySelectorAll(".navbar__element");

const incidentesEmergentes = document.querySelector("#incidentesEmergentes");
const incidentesEnCurso = document.querySelector("#incidenteEnCurso");
const contenedorIncidentesEmergentes = document.querySelector(
  "#incidentesEmergentes-container"
);
const contenedorIncidentesEnCurso = document.querySelector(
  "#onCourse-container"
);

const formularioActividad = document.querySelector(".emergent__activity--form");
const formularioInvolucrado = document.querySelector(".emergent__person--form");
const formActivityBG = document.querySelector(
  "#body__container--activity-form"
);
const formPersonBG = document.querySelector("#body__container--person-form");

const personaActividadBtn = document.querySelector("#addInvolucradoActividad");

const submitPersonaBtn = document.querySelector("#form__person--submit");
const submitActividadBtn = document.querySelector("#form__activity--submit");

const AllElmnts = document.querySelectorAll("*");

navbarBtns.forEach((opt) => {
  opt.addEventListener("click", (e) => {
    navbarBtns.forEach((btn) => btn.classList.remove("selected"));
    e.currentTarget.classList.add("selected");

    const elementId = e.currentTarget.getAttribute("id");

    document
      .querySelectorAll(".emergent")
      .forEach((menu) => menu.classList.add("hidden"));

    subMenuHide();

    switch (elementId) {
      case "emergentes":
        incidentesEmergentes.classList.remove("hidden");
        loadEmergentIncidents();
        break;
      case "enCurso":
        incidentesEnCurso.classList.remove("hidden");
        loadIncourseIncidents();
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

formActivityBG.addEventListener("click", () => {
  formularioActividad.classList.add("emergent__activity--hidden");
  formularioInvolucrado.classList.add("emergent__activity--hidden");
  formActivityBG.classList.add("container--form--hidden");
});
formPersonBG.addEventListener("click", () => {
  formularioInvolucrado.classList.add("emergent__activity--hidden");
  formPersonBG.classList.add("container--form--hidden");
});

personaActividadBtn.addEventListener("click", (e) =>
  addInvolucrado(e, "activity")
);

submitPersonaBtn.addEventListener("click", (e) => submitInvolucrado());
submitActividadBtn.addEventListener("click", (e) => submitActividad());

AllElmnts.forEach((elemnt) => {
  elemnt.addEventListener("click", () => resetInputs());
});

showBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => showIncidentsInformation(e));
});

dropdownBtn.addEventListener("click", (e) => {
  const icon = e.currentTarget.children[0];
  subMenu.forEach((subMenu) => subMenu.classList.toggle("subMenu-hidden"));
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
    contenedor
      .find(".startIncident_btn")
      .on("click", (e) => startIncidentResolution(e));
    contenedor.find(".reject-incident").on("click", (e) => rejectIncident(e));
    contenedor.find(".download_action").on("mouseover", (e) => previewImg(e));
    contenedor.find(".download_action").on("mouseout", () => previewImgOut());
    contenedor.find(".download_action").on("mousemove", (e) => followMouse(e));
  }, 500);
}
function loadIncourseIncidents() {
  var contenedor = $(contenedorIncidentesEnCurso).load(
    "../controladores/getIncidents.php",
    { filter: 1 }
  );
  setTimeout(() => {
    contenedor
      .find(".dropdown_btn")
      .on("click", (e) => showIncidentsInformation(e));
    contenedor.find(".addActivity").on("click", (e) => addActivity(e));
    contenedor
      .find(".addInvolucradoIncidente")
      .on("click", (e) => addInvolucrado(e, "incident"));
    contenedor.find(".download_action").on("mouseover", (e) => previewImg(e));
    contenedor.find(".download_action").on("mouseout", () => previewImgOut());
    contenedor.find(".download_action").on("mousemove", (e) => followMouse(e));
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
  const incidentTitle = e.currentTarget.parentElement.parentElement;
  const inicident = incidentTitle.parentElement;

  if (incidentTitle.classList.contains("incident__title--cancel")) {
    incidentTitle.classList.remove("incident__title--cancel");
    return;
  }
  if (incidentTitle.classList.contains("incident__title--confirm")) {
    inicident.classList.add("incident-active");

    $("#release").load("../controladores/changeIncidentStatus.php", {
      id_incidente: inicident.getAttribute("id"),
      new_estado: 1,
    });
    setTimeout(() => inicident.remove(), 500);
  } else {
    incidentTitle.classList.add("incident__title--confirm");
  }
};

const rejectIncident = (e) => {
  const incidentTitle = e.currentTarget.parentElement.parentElement;
  const inicident = incidentTitle.parentElement;

  if (incidentTitle.classList.contains("incident__title--confirm")) {
    incidentTitle.classList.remove("incident__title--confirm");
    return;
  }
  if (incidentTitle.classList.contains("incident__title--cancel")) {
    inicident.classList.add("incident-rejected");

    $("#release").load("../controladores/changeIncidentStatus.php", {
      id_incidente: inicident.getAttribute("id"),
      new_estado: 3,
    });
    setTimeout(() => inicident.remove(), 500);
  } else {
    incidentTitle.classList.add("incident__title--cancel");
  }
};

const previewImg = (e) => {
  const fileName = e.currentTarget.getAttribute("fileName");

  $("#body__imgContainer").load("../controladores/displayImages.php", {
    fileName: fileName,
  });
};
const previewImgOut = () => {
  $("#body__imgContainer").load("../controladores/hideImages.php");
};

const followMouse = (e) => {
  const mouseY = e.clientY;
  const mouseX = e.clientX;

  const elemnt = "#imgContainer__imgPreview";
  $(elemnt).css("top", mouseY - 75 + "px");
  $(elemnt).css("left", mouseX - 200 + "px");
  $(elemnt).removeClass("imgContainer__imgPreview--hidden");
};

const subMenuHide = () => {
  subMenu.forEach((subMenu) => subMenu.classList.add("subMenu-hidden"));
  dropdownBtn.children[0].classList.remove("active");
};

const addActivity = (e) => {
  const id_incidente =
    e.currentTarget.parentElement.parentElement.parentElement.getAttribute(
      "id"
    );
  formActivityBG.classList.remove("container--form--hidden");
  formularioActividad.classList.remove("emergent__activity--hidden");
  formularioActividad.setAttribute("id", id_incidente);

  const ActividadForm = $("#PesonasActividades").load(
    "../controladores/getAllPersonas.php"
  );
  setTimeout(() => {
    ActividadForm.find(".checkbox").on("click", (e) => selectPerson(e));
  }, 500);
};

const addInvolucrado = (e, mod) => {
  formPersonBG.classList.remove("container--form--hidden");
  formularioInvolucrado.classList.remove("emergent__activity--hidden");

  let id_incidente;
  if (mod == "incident")
    id_incidente =
      e.currentTarget.parentElement.parentElement.parentElement.getAttribute(
        "id"
      );

  if (mod == "activity")
    id_incidente =
      e.currentTarget.parentElement.parentElement.parentElement.parentElement.getAttribute(
        "id"
      );
  formularioInvolucrado.setAttribute("id", id_incidente);
};

function submitInvolucrado() {
  const id_incidente = formularioInvolucrado.getAttribute("id");

  const name = $(formularioInvolucrado).find("input[name = name]");
  const surname = $(formularioInvolucrado).find("input[name = surname]");
  const ci = $(formularioInvolucrado).find("input[name = ci]");
  const phoneNumber = $(formularioInvolucrado).find(
    "input[name = phoneNumber]"
  );

  if (name.val() && surname.val() && checkCI(ci.val()) && phoneNumber.val()) {
    $("#release").load("../controladores/addPersona.php", {
      id_incidente: id_incidente,
      name: name.val(),
      surname: surname.val(),
      ci: ci.val(),
      number: phoneNumber.val(),
    });

    name.val("");
    surname.val("");
    ci.val("");
    phoneNumber.val("");

    formularioInvolucrado.classList.add("emergent__activity--hidden");
    formPersonBG.classList.add("container--form--hidden");
    loadIncourseIncidents();
  } else {
    setTimeout(() => {
      if (!name.val()) name.addClass("uncomplete--input");
      if (!surname.val()) surname.addClass("uncomplete--input");
      if (!checkCI(ci.val())) ci.addClass("uncomplete--input");
      if (!phoneNumber.val()) phoneNumber.addClass("uncomplete--input");
    }, 50);
  }
}

function submitActividad() {
  const id_incidente = formularioActividad.getAttribute("id");

  const titulo = $(formularioActividad).find("input[name = titulo]");
  const descripcion = $(formularioActividad).find(
    "textarea[name = descripcion]"
  );
  const fecha = $(formularioActividad).find("input[name = fecha]");
  const type = $(formularioActividad).find("input[name = tipo]:checked");
  const archivos_relevantes = document.querySelector(
    "input[name = archivos_relevantes"
  );
  const ci_personas = $("#PesonasActividades").find(
    ".person--selected > .title__name--2"
  );

  if (titulo.val() && descripcion.val() && fecha.val() && type.val() !== undefined) {
    const formData = new FormData();
    formData.append("id_incidente", id_incidente);
    formData.append("titulo", titulo.val());
    formData.append("descripcion", descripcion.val());
    formData.append("fecha", fecha.val());
    formData.append("type", type.val());
    for (var i = 0; i < archivos_relevantes.files.length; i++) {
      formData.append("archivos_relevantes[]", archivos_relevantes.files[i]);
    }
    for (let i = 0; i < ci_personas.length; i++) {
      formData.append("ci_personas[]", ci_personas[i].getAttribute("ci"));
    }

    $.ajax({
      url: "../controladores/saveActivity.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
    });

    titulo.val("");
    descripcion.val("");
    fecha.val("");
    type.prop("checked", false);
    archivos_relevantes.value = "";

    formularioActividad.classList.add("emergent__activity--hidden");
    formActivityBG.classList.add("container--form--hidden");
    loadIncourseIncidents();
  } else {
    setTimeout(() => {
      if (!titulo.val()) titulo.addClass("uncomplete--input");
      if (!descripcion.val()) descripcion.addClass("uncomplete--input");
      if (!fecha.val()) fecha.addClass("uncomplete--input");
      if (type.val() == undefined)
        $(formularioActividad)
          .find("input[name = tipo]")
          .parent()
          .parent()
          .addClass("uncomplete--input");
    }, 50);
  }
}

function selectPerson(e) {
  const icon = e.currentTarget.children[0];
  icon.classList.toggle("fa-square");
  icon.classList.toggle("fa-square-check");

  const container = e.currentTarget.parentElement.parentElement;
  container.classList.toggle("person--selected");
}

const resetInputs = () => {
  document
    .querySelectorAll("input, textarea, .lista")
    .forEach((input) => input.classList.remove("uncomplete--input"));
};

const checkCI = (ci) => {
  if (ci == 0 || ci.length !== 8) return false;
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