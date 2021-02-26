let userTools = document.getElementsByName('user-tools');
let loadIcon = '<i class="fa fa-spinner fa-spin"></i>'

userTools.forEach(function (element) {
    element.addEventListener('change', function () {
        let value = this.value;
        let id = this.id;
        if (value === 'assign') {
            // SHOW THE MODAL FOR MORE ACTIONS 
            let pPage = _('popup-page');
            let pContent = _('popup-content');
            let pSContent = _('show-popup-content');
            let btnPClose = _('popup-close');
            pPage.style.display = "block";
            // CLOSING BUTTON POPUPAGE 
            btnPClose.onclick  = function () {
                pPage.style.display = "none";
                location.reload();
            }

            // SEND FOR ASSIGN AJAX 
            $.ajax({
                url: "./control/forms.php", 
                method: "POST", 
                data: {
                    userAssign: "userAssign"
                }, 
                beforeSend: function () {
                    pSContent.innerHTML = '<div class="text-center m-2" > <i class="fa fa-spinner fa-spin fa-3x"></i> </div>';
                }, 
                success: function (data) {
                    pSContent.innerHTML = data;
                }
            }).done(
                function () {
                    // DECLARE ASSIGN VARIABLES 
                    let assignForm = _('assign-form');
                    let action = _('action')
                    let showAssign = _('show-assign');
                    action.addEventListener('change', function () {
                        // SHOW ACTION VALUE 
                        if (this.value.toLowerCase() === 'assignbranch') {
                            // SEND AJAX BRANCH 
                            $.ajax({
                                url: "./control/forms.php", 
                                method: "POST",
                                data: {
                                    assignBranchForm: "assignBranchForm"
                                },
                                beforeSend: function () {
                                    showAssign.innerHTML = '<div class="text-center m-2" > <i class="fa fa-spinner fa-spin fa-2x"></i> </div>';
                                }, 
                                success: function (data) {
                                    showAssign.innerHTML = data;
                                }
                            }).done(

                                function () {
                                    let password = _('password');
                                    let branch = _('branch-name');
                                    let abError = _('branch-form-error')
                                    assignForm.addEventListener('submit', function (event) {
                                        event.preventDefault();
                                        // CHECK FOR EMPTY FIELDS 
                                        if (clean(password) > 0 && clean(branch) > 0) {
                                          
                                            abError.style.visibility = loadIcon;
                                            // SEND AJAX TO FORM SUBMIT 
                                            $.ajax({
                                                url: './control/action.php',
                                                method: 'POST', 
                                                data: {
                                                    password: password.value, 
                                                    branch: branch.value,
                                                    userId: id, 
                                                    assingBranchUser: "assignBranchUser"
                                                }, 
                                                beforeSend: function () {
                                                    
                                                }, 
                                                success: function (data) {
                                                    abError.innerHTML = data;
                                                    abError.style.visibility = "visible"
                                                }
                                            })
                                        }else{
                                            abError.innerHTML = "<span class='text-danger'> ALL FIELDS REQUIRED </span>";
                                            abError.style.visibility = "visible";
                                        }
                                    })
                                }
                            )
                        }else if(this.value.toLowerCase() === 'assignsection'){
                            showAssign.innerHTML = '<div class="text-center m-2" > <i class="fa fa-spinner fa-spin fa-2x"></i> </div>';
                        }

                        
                        
                    })
                }
            )
           
           

        }
    })
})