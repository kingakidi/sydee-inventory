let pLink = document.getElementsByName("p-link");
let show = _("show-item");
let loadIcon = '<i class="fa fa-spinner fa-spin"></i>';
let action = "./control/action.php";
let forms = "./control/forms.php";
pLink.forEach(function (element) {
  let id = element.id;
  element.addEventListener("click", function (event) {
    event.preventDefault();
    show.innerHTML = '<i class="fa fa-spinner fa-spin fa-3x"></i>';
    if (id === "add-category") {
      // SEND FOR ADD CATEGORY FORM
      $.ajax({
        url: "./control/forms.php",
        method: "POST",
        data: {
          addCategoryForm: "addCategoryForm",
        },
        beforeSend: function () {
          show.innerHTML = '<i class="fa fa-spinner fa-spin fa-3x"></i>';
        },
        success: function (data) {
          show.innerHTML = data;
        },
      }).done(function () {
        let cName = _("category-name");
        let cBtn = _("btn-category");
        let fCat = _("category-form");
        let fCatE = _("category-error");
        fCat.addEventListener("submit", function (event) {
          event.preventDefault();

          if (clean(cName) > 0) {
            // SEND AJAX
            $.ajax({
              url: "./control/action.php",
              method: "POST",
              data: {
                cName: cName.value,
                AddCategory: "ADD CATEGORY",
              },
              beforeSend: function () {
                fCatE.innerHTML = '<i class="fa fa-spinner fa-spin fa-2x"></i>';
                fCatE.style.visibility = "visible";
                cBtn.disabled = true;
                cBtn.innerHTML =
                  '<i class="fa fa-spinner fa-spin"></i> Loading';
              },
              success: function (data) {
                fCatE.innerHTML = data;
                fCatE.style.visibility = "visible";
                cBtn.disabled = false;
                cBtn.innerHTML = "Submit";
              },
            });
          } else {
            fCatE.innerHTML =
              "<span class='text-danger'> CATEGORY NAME IS REQUIRED</span>";
            fCatE.style.visibility = "visible";
          }
        });
      });
    } else if (id === "sub-category") {
      // SEND AJAX FOR SUB CATEGORY FORM
      $.ajax({
        url: "./control/forms.php",
        method: "POST",
        data: {
          subCategoryForm: "subCategoryForm",
        },
        beforeSend: function () {
          show.innerHTML = '<i class="fa fa-spinner fa-spin fa-3x"></i>';
        },
        success: function (data) {
          show.innerHTML = data;
        },
      }).done(function () {
        // VARIABLES FOR SUB CATEGORY FORM
        let cName = _("category-name");
        let sCName = _("sub-category-name");
        let sCFE = _("sub-category-error");
        let sCF = _("sub-category-form");
        let bSCF = _("btn-sub-category");

        sCF.addEventListener("submit", function (event) {
          event.preventDefault();

          if (clean(cName) > 0 && clean(sCName) > 0) {
            sCFE.style.visibility = "visible";
            sCFE.innerHTML = loadIcon;

            // ADD SUB CATEGORY REQUEST
            $.ajax({
              url: "./control/action.php",
              method: "POST",
              data: {
                cName: cName.value,
                sCName: sCName.value,
                addSubCategory: "addSubCategory",
              },
              beforeSend: function () {
                bSCF.disabled = true;
                bSCF.innerHTML = `${loadIcon} Adding`;
                sCFE.style.visibility = "visible";
                sCFE.innerHTML = loadIcon;
              },
              success: function (data) {
                sCFE.innerHTML = data;
                sCFE.style.visibility = "visible";
                bSCF.disabled = false;
                bSCF.innerHTML = "Submit";
              },
            });
          } else {
            sCFE.style.visibility = "visible";
            sCFE.innerHTML = error("ALL FIELD(s) REQUIRED");
          }
        });
      });
    }
  });
});

// LINKS USING CLASS
pLinkClass = document.getElementsByClassName("item-link");
for (let index = 0; index < pLinkClass.length; index++) {
  const element = pLinkClass[index];
  element.onclick = function () {
    let id = element.id;
    _(id).style.backgroundColor = "#fff";

    let notLink = document.querySelectorAll(`.item-link:not(#${id})`);
    notLink.forEach(function (el) {
      let id = el.id;
      _(id).style.backgroundColor = "#eee";
    });
  };
}
// END OF LINKS USING CLASS

// EDIT CATEGORY
let editCategory = document.getElementsByName("edit-category");
let popupPage = _("popup-page");
let popupContent = _("show-popup-content");
let popupClose = _("popup-close");
editCategory.forEach(function (el) {
  el.onclick = function () {
    let id = el.id;
    // SEND FOR THIS CATEGORY
    // SHOW THE POPUP
    popupPage.style.display = "block";
    popupContent.innerHTML = loadIcon;

    $.ajax({
      url: forms,
      method: "POST",
      data: {
        editCategoryForm: "editCategoryForm",
        id: id,
      },
      beforeSend: function () {
        popupContent.innerHTML = loadIcon;
      },
      success: function (data) {
        popupContent.innerHTML = data;
      },
    }).done(function () {
      // DECLARE VARIABLES FOR EDIT FORM
      let editForm = _("edit-category-form");
      let cName = _("catName");
      let categoryError = _("edit-category-error");
      let btnEditForm = _("btn-edit-category");

      editForm.onsubmit = function (event) {
        event.preventDefault();

        // CHECK FOR EMPTY FIELDS
        if (clean(cName) > 0) {
          // SEND AJAX
          $.ajax({
            url: action,
            method: "POST",
            data: {
              cName: cName.value,
              cId: id,
              categoryUpdate: "category Update",
            },
            beforeSend: function () {
              btnEditForm.innerHTML = `${loadIcon} Updating..`;
              categoryError.innerHTML = loadIcon;
              categoryError.style.visibility = "visible";
              btnEditForm.disabled = true;
            },
            success: function (data) {
              categoryError.innerHTML = data;
              btnEditForm.disabled = false;
              btnEditForm.innerHTML = "Update";
              console.log(data);
              if (
                data.trim() ===
                "<div class='text-success'>CATEGORY UPDATED SUCCESSFULLY</div>"
              ) {
                btnEditForm.disabled = true;
                cName.disabled = true;
              }
            },
          });
        } else {
          categoryError.innerHTML = error("Category Fields Required");
          categoryError.style.visibility = "visible";
        }
      };
    });
    popupClose.onclick = function () {
      popupPage.style.display = "none";
    };
  };
});
