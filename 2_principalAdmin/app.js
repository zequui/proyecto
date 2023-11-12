const showBtns = document.querySelectorAll(".dropdown_btn");
const dropdownBtn = document.querySelector("#container__fullname");

const subMenu = document.querySelectorAll(".emergent__subMenu");

const navbarBtns = document.querySelectorAll(".navbar__element");

const incidentesEmergentes = document.querySelector("#incidentesEmergentes");
const incidentesEnCurso = document.querySelector("#incidenteEnCurso");
const resoluciones = document.querySelector("#incidenteResoluciones");
const moderadores = document.querySelector("#incidenteModeradores");
const contenedorIncidentesEmergentes = document.querySelector(
  "#incidentesEmergentes-container"
);

const passwordInputs = Array.from(document.querySelectorAll(".password"));
const seekingBtns = document.querySelectorAll("#seekingBtn");

const formularioModerador = document.querySelector(".mod__form");
const moderadorSubmitBtn = document.querySelector(".mod__form > .mod__button");
const ciInput = $(formularioModerador).find("input[name = ci]");

const resolucionForm = document.querySelector("#emergent__resolution--form");
const resolucionFormBG = document.querySelector(
  "#resolution__container--backgroud"
);

const acceptResolutionBtn = document.querySelector("#form__resolution-accept");
const modifyResolutionBtn = document.querySelector("#form__resolution-modify");
const reviseResolutionBtn = document.querySelector("#form__resolution-revise");

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
      case "resoluciones":
        resoluciones.classList.remove("hidden");
        loadResoluciones();
        break;
      case "moderadores":
        moderadores.classList.remove("hidden");
        loadModeradores();
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
  subMenu.forEach((subMenu) => subMenu.classList.toggle("subMenu-hidden"));
  icon.classList.toggle("active");
});

acceptResolutionBtn.addEventListener("click", () => acceptResolution());
modifyResolutionBtn.addEventListener("click", () => modifyResolution());
reviseResolutionBtn.addEventListener("click", () => reviseResolution());

resolucionFormBG.addEventListener("click", () => hideResoluciones());

window.onload = loadEmergentIncidents();

async function loadEmergentIncidents() {
  const response = await $.get("../controladores/getIncidents.php", {
    filter: 0,
  });
  const contenedor = $(contenedorIncidentesEmergentes).html(response);
  console.log(contenedor);

  contenedor.find(".dropdown_btn").on("click", (e) => showExtraInformation(e));
  contenedor
    .find(".startIncident_btn")
    .on("click", (e) => startIncidentResolution(e));
  contenedor.find(".reject-incident").on("click", (e) => rejectIncident(e));
  contenedor.find(".download_action").on("mouseover", (e) => previewImg(e));
  contenedor.find(".download_action").on("mouseout", () => previewImgOut());
  contenedor.find(".download_action").on("mousemove", (e) => followMouse(e));
}

async function loadIncourseIncidents() {
  const response = await $.get("../controladores/getIncidents.php", {
    filter: 1,
    admin_opt: true,
  });
  const contenedor = $("#onCourse-container").html(response);

  contenedor.find(".dropdown_btn").on("click", (e) => showExtraInformation(e));
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
  contenedor.find(".erase_activity--btn").on("click", (e) => eraseActivity(e));
  contenedor.find(".desestimar_btn").on("click", (e) => desestimarIncidente(e));
  contenedor
    .find(".submitResolution_btn")
    .on("click", (e) => startResolution(e));
}

async function loadResoluciones() {
  const response = await $.get("../controladores/getIncidents.php", {
    filter: 2,
  });
  const container = $("#resolution-container").html(response);

  container.find(".dropdown_btn").on("click", (e) => showExtraInformation(e));
  container
    .find(".displayResolution_btn")
    .on("click", (e) => displayResolution(e));
}

const showExtraInformation = (e) => {
  const information =
    e.currentTarget.parentElement.parentElement.nextElementSibling;
  const icon = e.currentTarget.children[0];
  information.classList.toggle("incident__information-hidden");
  icon.classList.toggle("active");
};

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

function togglePassword(eye, passwordInput) {
  eye.classList.toggle("fa-eye");
  eye.classList.toggle("fa-eye-slash");
  passwordInput.type = passwordInput.type === "password" ? "text" : "password";
}

seekingBtns.forEach((seekingBtn) => {
  seekingBtn.addEventListener("click", (e) => {
    const actualEye = e.currentTarget;
    const actualPasswordId = actualEye.previousElementSibling.id;
    const passwordInput = passwordInputs.find(
      (input) => input.id === actualPasswordId
    );
    togglePassword(actualEye, passwordInput);
  });
});

async function loadModeradores() {
  const response = await $.get("../controladores/getModeradores.php");
  const container = $(".container").html(response);

  container
    .find(".dropdown_btn")
    .on("click", (e) => showIncidentsInformation(e));
  container.find(".editMod_btn").on("click", (e) => editModerador(e));
  container.find(".deleteMod_btn").on("click", (e) => deleteModerador(e));
}

moderadorSubmitBtn.addEventListener("click", (e) => {
  e.preventDefault();
  const inputs = $(formularioModerador).find("input");

  let name = inputs[0].value;
  let surname = inputs[1].value;
  let email = inputs[2].value;
  let ci = inputs[3].value;
  let password = inputs[4].value;

  if (name && surname && email && checkCI(ci) && password) {
    if (passwordInputs[0].value !== passwordInputs[1].value) {
      alert("las contraseñas no coinciden");
    } else if (passwordInputs[0].value.length < 5) {
      alert("La contraseña debe tener mas de 5 caracteres");
      /*alertPassword.classList.remove("hidden");
      alertPassword.innerHTML = "La contraseña debe tener mas de 5 caracteres"; */
    } else {
      const formData = new FormData();
      formData.append("ci", ci);
      formData.append("name", name);
      formData.append("surname", surname);
      formData.append("email", email);
      formData.append("password", password);

      if (formularioModerador.getAttribute("mod") == "modificar") {
        $.ajax({
          url: "../controladores/updateModerador.php",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
        });

        formularioModerador.setAttribute("mod", "");
        ciInput.removeClass("unchanable--input");
        ciInput.prop("readonly", true);
      } else {
        $.ajax({
          url: "../controladores/setModerador.php",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
        });
      }

      inputs.each((i, input) => (input.value = ""));
      setTimeout(() => {
        loadModeradores();
      }, 50);
    }
  } else {
    setTimeout(() => {
      if (!checkCI(ci))
        $(formularioModerador)
          .find("input[name = ci]")
          .addClass("uncomplete--input");
      if (!name)
        $(formularioModerador)
          .find("input[name = name]")
          .addClass("uncomplete--input");
      if (!surname)
        $(formularioModerador)
          .find("input[name = surname]")
          .addClass("uncomplete--input");
      if (!email)
        $(formularioModerador)
          .find("input[name = email]")
          .addClass("uncomplete--input");
      if (!password)
        $(formularioModerador)
          .find("input[name = password]")
          .addClass("uncomplete--input");
      document
        .querySelector("#passwordCheck-signin")
        .classList.add("uncomplete--input");
    }, 50);
  }
});

function editModerador(e) {
  const modElement = e.currentTarget.parentElement.parentElement.parentElement;
  formularioModerador.setAttribute("mod", "modificar");

  const inputs = $(formularioModerador).find("input");

  inputs[0].value = modElement.children[0].children[0].textContent;
  inputs[1].value =
    modElement.children[1].children[0].children[0].children[1].textContent;
  inputs[2].value =
    modElement.children[1].children[0].children[1].children[1].textContent;
  inputs[3].value =
    modElement.children[1].children[0].children[0].children[3].textContent;
  inputs[4].value =
    modElement.children[1].children[0].children[1].children[3].textContent;
  inputs[5].value =
    modElement.children[1].children[0].children[1].children[3].textContent;

  ciInput.addClass("unchanable--input");
  ciInput.prop("readonly", true);
}

document.querySelectorAll("*").forEach((elemnt) => {
  elemnt.addEventListener("click", () => {
    document
      .querySelectorAll("input")
      .forEach((input) => input.classList.remove("uncomplete--input"));
  });
});

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

function deleteModerador(e) {
  const moderador_element =
    e.currentTarget.parentElement.parentElement.parentElement;
  const header = moderador_element.children[0];
  const ci_moderador = moderador_element.getAttribute("ci_moderador");

  if (header.classList.contains("unlink-mod")) {
    $.ajax({
      url: "../controladores/deleteMod.php",
      type: "POST",
      data: { ci: ci_moderador },
    });

    moderador_element.classList.add("delete-mod");
    setTimeout(() => {
      moderador_element.remove();
    }, 500);
  }
  header.classList.add("unlink-mod");
  setTimeout(() => {
    header.classList.remove("unlink-mod");
  }, 2500);
}

function displayResolution(e) {
  const incident_element =
    e.currentTarget.parentElement.parentElement.parentElement;
  const id_incidente = incident_element
    .getAttribute("id")
    .replace("incident_", "");

  resolucionFormBG.classList.remove("container--form--hidden");
  resolucionForm.classList.remove("emergent__activity--hidden");

  resolucionForm.setAttribute("id_incidente", id_incidente);

  $(resolucionForm)
    .find("#resolution-description")
    .load("../controladores/getResolution.php", {
      id_incidente: id_incidente,
      mod: "descripcion",
    });

  $(resolucionForm).find("#resolution-type").removeClass("lista");
  $(resolucionForm)
    .find("#resolution-type")
    .load("../controladores/getResolution.php", {
      id_incidente: id_incidente,
      mod: "tipo",
    });
}

function acceptResolution() {
  const id_incidente = resolucionForm.getAttribute("id_incidente");
  const incident_element = document.querySelector("#incident_" + id_incidente);
  $.ajax({
    url: "../controladores/changeIncidentStatus.php",
    type: "REQUEST",
    data: { id_incidente: id_incidente, new_estado: 5 },
  });

  hideResoluciones();
  setTimeout(() => {
    incident_element.classList.add("incident-active");
    setTimeout(() => {
      incident_element.remove();
    }, 500);
  }, 500);
}

function modifyResolution() {
  const id_incidente = resolucionForm.getAttribute("id_incidente");
  const incident_element = document.querySelector("#incident_" + id_incidente);

  const descripcion_element = $(resolucionForm).find("#resolution-description");
  const tipoResolucion = $(resolucionForm).find("#resolution-type");

  if (modifyResolutionBtn.classList.contains("lightup")) {
    $.ajax({
      url: "../controladores/updateResolution.php",
      type: "POST",
      data: {
        id_incidente: id_incidente,
        descripcion: descripcion_element.text().trim(),
        tipo: tipoResolucion.find("input[name=tipo]:checked").val(),
      },
    });
    hideResoluciones();
    return;
  }
  acceptResolutionBtn.setAttribute("disabled", true);
  reviseResolutionBtn.setAttribute("disabled", true);

  modifyResolutionBtn.classList.add("lightup");
  modifyResolutionBtn.innerHTML = "Enviar";

  if (!tipoResolucion.hasClass("lista")) {
    const tipoResolucionContent = tipoResolucion.text().trim();

    tipoResolucion.replaceWith(`
    <div class="lista contenedor__type" id="resolution-type">
    <div class="contenedor">
        <input type="radio" name="tipo" value="Suspension">Suspencion</input>
    </div>
    <div class="contenedor">
        <input type="radio" name="tipo" value="Trabajo comunitario">Trabajo comunitario</input>
    </div>
    <div class="contenedor">
        <input type="radio" name="tipo" value="cambio de institucion">cambio de institucion</input>
    </div>
    <div class="contenedor">
        <input type="radio" name="tipo" value="otros">otros</input>
    </div>
  </div>
    `);
    $(resolucionForm)
      .find("input[value = '" + tipoResolucionContent + "']")
      .prop("checked", true);
  }
  descripcion_element.attr("contentEditable", "true");
  lightupElement(descripcion_element);
}
function reviseResolution() {}

function hideResoluciones() {
  resolucionFormBG.classList.add("container--form--hidden");
  resolucionForm.classList.add("emergent__activity--hidden");
  resolucionForm.setAttribute("id_incidente", "");

  acceptResolutionBtn.removeAttribute("disabled");

  modifyResolutionBtn.removeAttribute("disabled");
  modifyResolutionBtn.innerHTML = "Modificar";

  reviseResolutionBtn.removeAttribute("disabled");
  modifyResolutionBtn.classList.remove("lightup");
}

function lightupElement(elemnt) {
  elemnt.addClass("lightup");
  setTimeout(() => {
    elemnt.removeClass("lightup");
  }, 1000);
}
