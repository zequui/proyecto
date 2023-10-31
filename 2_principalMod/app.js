const showBtns = document.querySelectorAll(".dropdown_btn");
const dropdownBtn = document.querySelector("#container__fullname");

const subMenu = document.querySelectorAll(".emergent__subMenu");

const navbarBtns = document.querySelectorAll(".navbar__element");

const incidentesEmergentes = document.querySelector("#incidentesEmergentes");
const incidentesEnCurso = document.querySelector("#incidenteEnCurso");
const Resoluciones = document.querySelector("#ResolucionesAdm");
const contenedorIncidentesEmergentes = document.querySelector(
  "#incidentesEmergentes-container"
);
const contenedorIncidentesEnCurso = document.querySelector(
  "#onCourse-container"
);

const formularioActividad = document.querySelector("#emergent__activity--form");
const formularioInvolucrado = document.querySelector("#emergent__person--form");
const formularioIncidente = document.querySelector("#emergent__incident--form");
const formularioChoosePersona = document.querySelector(
  "#emergent__choose-person--form"
);

const formActivityBG = document.querySelector(
  "#body__container--activity-form"
);
const formPersonBG = document.querySelector("#body__container--person-form");
const formIncidentBG = document.querySelector(
  "#body__container--incident-form"
);
const formChoosePersonBG = document.querySelector(
  "#body__container--choose-person"
);

const ciSearch = document.querySelector("#CI_search");

const personaActividadBtn = document.querySelector("#addInvolucradoActividad");

const addNewPersonaBtn = document.querySelector('#addInvolucrado')
const submitPersonaBtn = document.querySelector("#form__person--submit");
const submitActividadBtn = document.querySelector("#form__activity--submit");
const submitIncidenteBtn = document.querySelector("#form__incident--submit");
const submitChoosePersonBtn = document.querySelector('#form__choose-person--submit')

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
      case "Resoluciones":
        Resoluciones.classList.remove("hidden");
        break;
      default:
        break;
    }
  });
});

addNewPersonaBtn.addEventListener('click', e => addInvolucrado(e, 'incident'))

formActivityBG.addEventListener("click", () => {
  formularioActividad.classList.add("emergent__activity--hidden");
  formularioInvolucrado.classList.add("emergent__activity--hidden");
  formActivityBG.classList.add("container--form--hidden");
  clearElements();
});
formPersonBG.addEventListener("click", () => {
  formularioInvolucrado.classList.add("emergent__activity--hidden");
  formPersonBG.classList.add("container--form--hidden");
  clearElements();
});
formIncidentBG.addEventListener("click", () => {
  formularioIncidente.classList.add("emergent__activity--hidden");
  formIncidentBG.classList.add("container--form--hidden");
  clearElements();
});
formChoosePersonBG.addEventListener("click", () => {
  formularioChoosePersona.classList.add("emergent__activity--hidden");
  formChoosePersonBG.classList.add("container--form--hidden");
  clearElements();
});

personaActividadBtn.addEventListener("click", (e) =>
  addInvolucrado(e, "activity")
);

submitPersonaBtn.addEventListener("click", () => submitInvolucrado());
submitActividadBtn.addEventListener("click", () => submitActividad());
submitIncidenteBtn.addEventListener("click", () => submitIncidente());
submitChoosePersonBtn.addEventListener('click', () => submitChoosePersona())

AllElmnts.forEach((elemnt) => {
  elemnt.addEventListener("click", () => resetInputs());
});

showBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => showExtraInformation(e));
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
      .on("click", (e) => showExtraInformation(e));
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
      .on("click", (e) => showExtraInformation(e));
    contenedor.find(".addActivity").on("click", (e) => addActivity(e));
    contenedor
      .find(".addInvolucradoIncidente")
      .on("click", (e) => choosePersona(e));
    contenedor.find(".download_action").on("mouseover", (e) => previewImg(e));
    contenedor.find(".download_action").on("mouseout", () => previewImgOut());
    contenedor.find(".download_action").on("mousemove", (e) => followMouse(e));
    contenedor.find(".edit_incident").on("click", (e) => editIncident(e));
    contenedor.find(".edit_activity").on("click", (e) => modActivity(e));
    contenedor.find(".edit_person").on("click", (e) => modInvolucrado(e));
    contenedor
      .find(".unlink_personActivity")
      .on("click", (e) => unLinkPersonaActividad(e));
    contenedor.find(".unlink_personIncident").on("click", (e) => {
      unlinkPersonaIncidente(e);
    });
  }, 500);
}

const showExtraInformation = (e) => {
  const information =
    e.currentTarget.parentElement.parentElement.nextElementSibling;
  const icon = e.currentTarget.children[0];
  information.classList.toggle("incident__information-hidden");
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
      id_incidente: inicident.getAttribute("id").replace("incident_", ""),
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
      id_incidente: inicident.getAttribute("id").replace("incident_", ""),
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
  const id_incidente = e.currentTarget.parentElement.parentElement.parentElement
    .getAttribute("id")
    .replace("incident_", "");
  formActivityBG.classList.remove("container--form--hidden");
  formularioActividad.classList.remove("emergent__activity--hidden");
  formularioActividad.setAttribute("id_incidente", id_incidente);
  formularioActividad.setAttribute("tipoRegistro", "agregar");

  const ActividadForm = $("#PesonasActividades").load(
    "../controladores/getAllPersonas.php"
  );
  setTimeout(() => {
    ActividadForm.find(".checkbox").on("click", (e) => selectPerson(e));
  }, 500);
};

const modActivity = (e) => {
  const activityElement = e.currentTarget.parentElement.parentElement;
  const extraInformation =
    activityElement.nextElementSibling.children[0].children;
  const title = activityElement.children[0].textContent;
  const descripcion = extraInformation[0].children[1].textContent;
  const fecha = extraInformation[1].children[1].textContent;
  const tipo = extraInformation[1].children[3].textContent;

  const id_actividad = activityElement
    .getAttribute("id")
    .replace("activity_", "");
  const id_incidente =
    e.currentTarget.parentElement.parentElement.parentElement.parentElement.parentElement
      .getAttribute("id")
      .replace("incident_", "");

  formActivityBG.classList.remove("container--form--hidden");
  formularioActividad.classList.remove("emergent__activity--hidden");
  formularioActividad.setAttribute("id_actividad", id_actividad);
  formularioActividad.setAttribute("id_incidente", id_incidente);

  formularioActividad.setAttribute("tipoRegistro", "modificar");

  $(formularioActividad).find("input[name = titulo]").val(title);
  $(formularioActividad).find("textarea[name = descripcion]").val(descripcion);
  $(formularioActividad).find("input[name = fecha]").val(fecha);
  $(formularioActividad)
    .find("input[name = tipo][value = '" + tipo + "']")
    .prop("checked", true);

  const ActividadForm = $("#PesonasActividades").load(
    "../controladores/getAllPersonas.php"
  );
  setTimeout(() => {
    ActividadForm.find(".checkbox").on("click", (e) => selectPerson(e));
  }, 500);
};

const addInvolucrado = (e, origen) => {
  formPersonBG.classList.remove("container--form--hidden");
  formularioInvolucrado.classList.remove("emergent__activity--hidden");

  $(formularioInvolucrado).find("input[name = ci]").prop("readonly", false);
  $(formularioInvolucrado)
    .find("input[name = ci]")
    .removeClass("unchanable--input");

  let id_incidente;
  if (origen == "incident")
    id_incidente = formularioChoosePersona.getAttribute('id_incidente')

  if (origen == "activity")
    id_incidente =
      e.currentTarget.parentElement.parentElement.parentElement.parentElement.getAttribute(
        "id_incidente"
      );

  formularioInvolucrado.setAttribute("id_incidente", id_incidente);
  formularioInvolucrado.setAttribute("tipoRegistro", "agregar");
};

function modInvolucrado(e) {
  const personContainer = e.currentTarget.parentElement.parentElement;
  const extraInformation =
    personContainer.nextElementSibling.children[0].children[0].children;

  const name = personContainer.children[0].textContent;
  const surname = extraInformation[1].textContent;
  const ci = extraInformation[3].textContent;
  const phoneNumber = extraInformation[5].textContent;

  formPersonBG.classList.remove("container--form--hidden");
  formularioInvolucrado.classList.remove("emergent__activity--hidden");

  $(formularioInvolucrado).find("input[name = name]").val(name);
  $(formularioInvolucrado).find("input[name = surname]").val(surname);

  $(formularioInvolucrado).find("input[name = ci]").val(ci);
  $(formularioInvolucrado).find("input[name = ci]").prop("readonly", true);
  $(formularioInvolucrado)
    .find("input[name = ci]")
    .addClass("unchanable--input");

  $(formularioInvolucrado).find("input[name = phoneNumber]").val(phoneNumber);

  formularioInvolucrado.setAttribute("tipoRegistro", "modificar");
  formularioInvolucrado.setAttribute(
    "id_incidente",
    e.currentTarget.parentElement.parentElement.classList[1].replace(
      "from_incident-",
      ""
    )
  );
}

function submitInvolucrado() {
  const id_incidente = formularioInvolucrado.getAttribute("id_incidente");

  const name = $(formularioInvolucrado).find("input[name = name]");
  const surname = $(formularioInvolucrado).find("input[name = surname]");
  const ci = $(formularioInvolucrado).find("input[name = ci]");
  const phoneNumber = $(formularioInvolucrado).find(
    "input[name = phoneNumber]"
  );

  const Denunciante = document.querySelector("#incident_" + id_incidente)
  .children[1].children[0].children[2];

  if (
    name.val() &&
    surname.val() &&
    checkCI(ci.val()) &&
    phoneNumber.val().length == 9
  ) {
    if (formularioInvolucrado.getAttribute("tipoRegistro") == "modificar") {
      const formData = new FormData();
      formData.append("name", name.val());
      formData.append("surname", surname.val());
      formData.append("ci", ci.val());
      formData.append("phoneNumber", phoneNumber.val());

      $.ajax({
        url: "../controladores/modPersona.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
      });

      if (ci.val() == Denunciante.children[3].textContent) {
        Denunciante.children[1].textContent = name.val() + " " + surname.val();
        Denunciante.children[5].textContent = phoneNumber.val();
      }
    } else if (
      formularioInvolucrado.getAttribute("tipoRegistro") == "agregar"
    ) {
      const formData = new FormData();
      formData.append('mod', 0)
      formData.append("name", name.val());
      formData.append("surname", surname.val());
      formData.append("ci", ci.val());
      formData.append("phoneNumber", phoneNumber.val());

      $.ajax({
        url: "../controladores/addPersonasIncidente.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
      });
    }

    clearElements();

    formularioInvolucrado.classList.add("emergent__activity--hidden");
    formPersonBG.classList.add("container--form--hidden");

    reloadPersonas(id_incidente);
    reloadListaPersonas()

  } else {
    setTimeout(() => {
      if (!name.val()) name.addClass("uncomplete--input");
      if (!surname.val()) surname.addClass("uncomplete--input");
      if (!checkCI(ci.val())) ci.addClass("uncomplete--input");
      if (phoneNumber.val().length !== 9)
        phoneNumber.addClass("uncomplete--input");
    }, 50);
  }
}

function submitActividad() {
  let id_incidente;

  const titulo = $(formularioActividad).find("input[name = titulo]");
  const descripcion = $(formularioActividad).find(
    "textarea[name = descripcion]"
  );
  const fecha = $(formularioActividad).find("input[name = fecha]");
  const type = $(formularioActividad).find("input[name = tipo]:checked");
  const archivos_relevantes = $(formularioActividad).find(
    "input[name = archivos_relevantes]"
  );
  const ci_personas = $("#PesonasActividades").find(
    ".person--selected > .title__name--2"
  );

  if (
    titulo.val() &&
    descripcion.val() &&
    fecha.val() &&
    type.val() !== undefined
  ) {
    if (formularioActividad.getAttribute("tipoRegistro") == "modificar") {
      const id_actividad = formularioActividad.getAttribute("id_actividad");
      id_incidente = formularioActividad
        .getAttribute("id_incidente")
        .replace("incident_", "");

      const formData = new FormData();
      formData.append("id_actividad", id_actividad);
      formData.append("titulo", titulo.val());
      formData.append("descripcion", descripcion.val());
      formData.append("fecha", fecha.val());
      formData.append("type", type.val());
      for (var i = 0; i < archivos_relevantes.prop("files").length; i++) {
        formData.append(
          "archivos_relevantes[]",
          archivos_relevantes.prop("files")[i]
        );
      }
      for (let i = 0; i < ci_personas.length; i++) {
        formData.append("ci_personas[]", ci_personas[i].getAttribute("ci"));
      }

      $.ajax({
        url: "../controladores/modActividad.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
      });
    } else if (formularioActividad.getAttribute("tipoRegistro") == "agregar") {
      id_incidente = formularioActividad.getAttribute("id_incidente");
      const formData = new FormData();
      formData.append("id_incidente", id_incidente);
      formData.append("titulo", titulo.val());
      formData.append("descripcion", descripcion.val());
      formData.append("fecha", fecha.val());
      formData.append("type", type.val());
      for (var i = 0; i < archivos_relevantes.prop("files").length; i++) {
        formData.append(
          "archivos_relevantes[]",
          archivos_relevantes.prop("files")[i]
        );
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
    }

    formularioActividad.classList.add("emergent__activity--hidden");
    formActivityBG.classList.add("container--form--hidden");

    clearElements();
    reloadActivities(id_incidente);
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

function reloadActivities(id_incidente) {
  setTimeout(() => {
    const contenedor = $("#activity--container_" + id_incidente).load(
      "../controladores/reloadActividadPersonas.php",
      {
        id_incidente: id_incidente,
        mod: 1,
      }
    );
    setTimeout(() => {
      contenedor
        .find(".dropdown_btn")
        .on("click", (e) => showExtraInformation(e));
      contenedor.find(".download_action").on("mouseover", (e) => previewImg(e));
      contenedor.find(".download_action").on("mouseout", () => previewImgOut());
      contenedor
        .find(".download_action")
        .on("mousemove", (e) => followMouse(e));
      contenedor.find(".edit_activity").on("click", (e) => modActivity(e));
      contenedor
        .find(".unlink_personActivity")
        .on("click", (e) => unLinkPersonaActividad(e));
      contenedor.find(".edit_person").on("click", (e) => modInvolucrado(e));
    }, 500);
  }, 50);
}

function reloadPersonas(id_incidente) {
  setTimeout(() => {
    const contenedor = $("#person--container_" + id_incidente).load(
      "../controladores/reloadActividadPersonas.php",
      {
        id_incidente: id_incidente,
        mod: 0,
      }
    );
    setTimeout(() => {
      contenedor
        .find(".dropdown_btn")
        .on("click", (e) => showExtraInformation(e));
      contenedor.find(".edit_person").on("click", (e) => modInvolucrado(e));
      contenedor
        .find(".unlink_personIncident")
        .on("click", (e) => unlinkPersonaIncidente(e));
      reloadActivities(id_incidente);
    }, 500);
  }, 50);
}

function clearElements() {
  document.querySelectorAll("input").forEach((input) => {
    input.value = "";
  });
}

function unLinkPersonaActividad(e) {
  const personHeader = e.currentTarget.parentElement.parentElement;
  const personCi =
    personHeader.nextElementSibling.children[0].children[0].children[3]
      .textContent;

  const activity_id = personHeader.classList[1].replace("from_activity-", "");
  if (personHeader.classList.contains("unlink-person")) {
    personHeader.nextElementSibling.remove();
    personHeader.remove();

    const formData = new FormData();
    formData.append("ci", personCi);
    formData.append("id_actividad", activity_id);

    $.ajax({
      url: "../controladores/unlinkPersonaActividad.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
    });
  }
  personHeader.classList.add("unlink-person");

  setTimeout(() => personHeader.classList.remove("unlink-person"), 5000);
}

function unlinkPersonaIncidente(e) {
  const personHeader = e.currentTarget.parentElement.parentElement;
  const personCi =
    personHeader.nextElementSibling.children[0].children[0].children[3]
      .textContent;

  const id_incidente = personHeader.classList[1].replace("from_incident-", "");

  if (personHeader.classList.contains("unlink-person")) {
    personHeader.parentElement.remove();

    const formData = new FormData();
    formData.append("ci", personCi);
    formData.append("id_incidente", id_incidente);

    $.ajax({
      url: "../controladores/unlinkPersonaIncidente.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
    });
  }

  personHeader.classList.add("unlink-person");

  setTimeout(() => personHeader.classList.remove("unlink-person"), 5000);
}

function editIncident(e) {
  const incidente = e.currentTarget.parentElement.parentElement.parentElement;
  const id_incidente = incidente.getAttribute("id").replace("incident_", "");

  const titulo = incidente.children[0].children[0].textContent;
  const descripcion =
    incidente.children[1].children[0].children[0].children[1].textContent;
  const fecha =
    incidente.children[1].children[0].children[1].children[1].textContent;
  const tipo =
    incidente.children[1].children[0].children[1].children[3].textContent;

  $(formularioIncidente).find("input[name = titulo]").val(titulo);
  $(formularioIncidente).find("textarea[name = descripcion]").val(descripcion);
  $(formularioIncidente).find("input[name = fecha]").val(fecha);
  $(formularioIncidente)
    .find("input[name = tipo][value = '" + tipo + "']")
    .prop("checked", true);

  formularioIncidente.classList.remove("emergent__activity--hidden");
  formularioIncidente.setAttribute("id_incidente", id_incidente);

  formIncidentBG.classList.remove("container--form--hidden");
}

function submitIncidente() {
  const id_incidente = formularioIncidente.getAttribute("id_incidente");
  const titulo = $(formularioIncidente).find("input[name = titulo]");
  const descripcion = $(formularioIncidente).find(
    "textarea[name = descripcion]"
  );
  const fecha = $(formularioIncidente).find("input[name = fecha]");
  const type = $(formularioIncidente).find("input[name = tipo]:checked");
  const archivos_relevantes = $(formularioIncidente).find(
    "input[name = archivos_relevantes]"
  );

  if (
    titulo.val() &&
    descripcion.val() &&
    fecha.val() &&
    type.val() !== undefined
  ) {
    const formData = new FormData();
    formData.append("id_incidente", id_incidente);
    formData.append("titulo", titulo.val());
    formData.append("descripcion", descripcion.val());
    formData.append("fecha", fecha.val());
    formData.append("type", type.val());
    for (var i = 0; i < archivos_relevantes.prop("files").length; i++) {
      formData.append(
        "archivos_relevantes[]",
        archivos_relevantes.prop("files")[i]
      );
    }

    $.ajax({
      url: "../controladores/modIncidente.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
    });
    formularioIncidente.classList.add("emergent__activity--hidden");
    formIncidentBG.classList.add("container--form--hidden");

    reloadIncident(
      id_incidente,
      titulo.val(),
      descripcion.val(),
      fecha.val(),
      type.val()
    );
    clearElements();
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

function reloadIncident(id_incidente, titulo, descripcion, fecha, tipo) {
  const incidente = document.querySelector("#incident_" + id_incidente);

  incidente.children[0].children[0].textContent = titulo;
  incidente.children[1].children[0].children[0].children[1].textContent =
    descripcion;
  incidente.children[1].children[0].children[1].children[1].textContent = fecha;
  incidente.children[1].children[0].children[1].children[3].textContent = tipo;
}

ciSearch.addEventListener("keydown", (e) => {
  const keyCode = e.keyCode;

  if ((keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122)) {
    e.preventDefault();
  }
});
ciSearch.addEventListener("keyup", () => {
  const likeCi = ciSearch.value;
  const container = $("#person--form__result--container").load(
    "../controladores/findPerson.php",
    { ci: likeCi }
  );
  setTimeout(()=>{
    container.find(".checkbox").on("click", (e) => selectPerson(e))
  },50)
});
function choosePersona(e) {
  id_incidente = e.currentTarget.parentElement.parentElement.parentElement
    .getAttribute("id")
    .replace("incident_", "");

  formularioChoosePersona.setAttribute('id_incidente', id_incidente)
  reloadListaPersonas()
  formularioChoosePersona.classList.remove("emergent__activity--hidden");
  formChoosePersonBG.classList.remove("container--form--hidden");

  
}

function submitChoosePersona(){
  const ci_personas = $("#person--form__result--container").find(
    ".person--selected > .title__name--2"
  );

  if(ci_personas){
    const formData = new FormData()
    formData.append('id_incidente', formularioChoosePersona.getAttribute('id_incidente'))
    formData.append('mod', 1)
    for (let i = 0; i < ci_personas.length; i++) {
      formData.append("ci_personas[]", ci_personas[i].getAttribute("ci"));
    }

    $.ajax({
      url: "../controladores/addPersonasIncidente.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
    });

    formularioChoosePersona.classList.add("emergent__activity--hidden");
    formChoosePersonBG.classList.add("container--form--hidden");
    reloadPersonas(id_incidente)
    resetInputs()
  }
}

const reloadListaPersonas = () => {
  const container = $("#person--form__result--container").load(
    "../controladores/getAllPersonas.php"
  );
  setTimeout(()=>{
    container.find(".checkbox").on("click", (e) => selectPerson(e))
  },50)
}