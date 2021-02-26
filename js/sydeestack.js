function _(x) {
  return document.getElementById(x);
}

function clean(x) {
  return x.value.trim().length;
}

function error(text) {
  return `<div class='text-danger'>${text}</div>`;
}

// INFO PRINTING FUNCTION
function info(text) {
  return `<div class='text-info'>${text}</div>`;
}

// SUCCESS PRINTING FUNCTION
function success(text) {
  return `<div class='text-success'${text}</div>`;
}
