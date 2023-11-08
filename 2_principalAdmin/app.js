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
        break;
      case "resoluciones":
        resoluciones.classList.remove("hidden");
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

window.onload = loadEmergentIncidents();

function loadEmergentIncidents() {
  console.log(contenedorIncidentesEmergentes);
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
