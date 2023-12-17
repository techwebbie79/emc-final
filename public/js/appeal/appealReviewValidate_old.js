"use strict";

// Class definition
var KTProjectsAdd = (function () {
    // Base elements
    var _wizardEl;
    var _formEl;
    var _wizardObj;
    var fv;
    var _validations = [];

    // Private functions to form Wizard
    var _initWizard = function () {
        // Initialize form wizard
        _wizardObj = new KTWizard(_wizardEl, {
            startStep: 1, // initial active step number
            clickableSteps: false, // allow step clicking
        });

        // Validation before going to next page
        _wizardObj.on("change", function (wizard) {
            if (wizard.getStep() > wizard.getNewStep()) {
                return; // Skip if stepped back
            }

            // Validate form before change wizard step
            var validator = _validations[wizard.getStep() - 1]; // get validator for current step

            if (validator) {
                validator.validate().then(function (status) {
                    if (status == "Valid") {
                        // dynamic working to victim section (skip or set)
                        const typeID = document.getElementById("kt").value;
                        if (typeID == 1) {
                            wizard.goTo(wizard.getNewStep());
                        } else {
                            if (wizard.getStep() == 2) {
                                wizard.goTo(4);
                            }else {
                                wizard.goTo(wizard.getNewStep());
                            }
                        }
                        // when back, if victim not set, when skip victim
                        document.getElementById("wizardBack").addEventListener("click", function () {
                            var wizardBack = $("#victim_wizard").attr("wizardVal");
                            if (wizard.getStep() == 3 && (wizardBack != 2)) {
                                wizard.goTo(2);
                            };
                        });

                        KTUtil.scrollTop();
                    }
                });
            }

            return false; // Do not change wizard step, further action will be handled by he validator
        });

        // Change event
        _wizardObj.on("changed", function (wizard) {
            KTUtil.scrollTop();
        });

        // Submit event
        _wizardObj.on("submit", function (wizard) {

            var validator = _validations[wizard.getStep() - 1]; // get validator for currnt step
            if (validator) {
                validator.validate().then(function (status) {
                    if (status == "Valid") {
                        Swal.fire({
                            text: "আপনি কি সংরক্ষণ করতে চান?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "হ্যাঁ",
                            cancelButtonText: "না",
                        }).then(function (result) {
                            if (result.value) {
                                _formEl.submit(); // Submit form
                                KTApp.blockPage({
                                    // overlayColor: '#1bc5bd',
                                    overlayColor: "black",
                                    opacity: 0.2,
                                    // size: 'sm',
                                    message: "Please wait...",
                                    state: "danger", // a bootstrap color
                                });
                                Swal.fire({
                                    position: "top-right",
                                    icon: "success",
                                    title: "সফলভাবে সাবমিট করা হয়েছে!",
                                    showConfirmButton: false,
                                    timer: 1500,
                                });
                            } else if (result.dismiss === "cancel") {
                                return;
                            }
                        });
                    }
                });
            }
            return false; // Do not submit, further action will be handled by he validator
        });
    };

    // form validation start
    var _initValidation = function () {
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        // Step 1 start
        
        // step 1 end

        // step 2 start
        
        // step 2 end


        // victim section ========================= start ====================
        
        // victim section ========================= end ====================

       

        // Step 3 start
        

        // step 3 end

        // step 4 start
       
        const witnessPresentAddressValidators = {
            validators: {
                notEmpty: {
                    message: "This is required",
                },
            },
        };
        const witnessNIDValidators = {
            validators: {
                notEmpty: {
                    message: "This is required",
                },
            },
        };

        const witnessPhoneValidators = {
            validators: {
                notEmpty: {
                    message: "Phone is required",
                },
                regexp: {
                    // regexp: /^([3-9]\d{8})$/,
                    regexp:  "(^(01){1}[3456789]{1}(\\d){8})$",
                    message: "The input is not valid Phone number",
                },
            },
        };

        const fv2 = FormValidation.formValidation(_formEl, {
            fields: {
                "witness[phn][0]": witnessPhoneValidators,
                "witness[presentAddress][0]": witnessPresentAddressValidators,
                "witness[nid][0]": witnessNIDValidators,
                
            },
            plugins: {
                submitButton: new FormValidation.plugins.SubmitButton(),
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap({
                    //eleInvalidClass: '',
                    eleValidClass: "",
                }),
                icon: new FormValidation.plugins.Icon({
                    valid: "fa fa-check",
                    invalid: "fa fa-times",
                    validating: "fa fa-refresh",
                }),
            },
        });

        // remove template
        const removeWitnessRow = function (rownewIndex) {
            
            const witnessRow = document.getElementById("witnessRemove").value;
            if (parseInt(witnessRow) >= 1 || rownewIndex >= 1) {
                Swal.fire({
                    title: "আপনি কি মুছে ফেলতে চান?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "হ্যাঁ",
                    cancelButtonText: "না",
                }).then(function (result) {
                    if (result.value) {
                        const rownew = _formEl.querySelector('[data-row-withnessindex="' + rownewIndex + '"]');
                        // Remove field
                        fv2.removeField("witness[phn][" + rownewIndex + "]", witnessPhoneValidators)
                            .removeField("witness[presentAddress][" + rownewIndex + "]", witnessPresentAddressValidators)
                            .removeField("witness[nid][" + rownewIndex + "]", witnessNIDValidators);

                        // Remove row
                        document.getElementById("witnessAdd").value = parseInt(parseInt(rownewIndex) - 1);
                        document.getElementById("witnessRemove").value = parseInt(parseInt(rownewIndex) - 1);
                        rownew.parentNode.removeChild(rownew);

                        Swal.fire({
                            position: "top-right",
                            icon: "success",
                            title: "সফলভাবে মুছে ফেলা হয়েছে!",
                            showConfirmButton: false,
                            timer: 1500,
                        });
                    }
                });
            } else {
                Swal.fire({
                    position: "top-right",
                    icon: "error",
                    title: "আবেদনকারীর তথ্য সর্বনিম্ম একটি থাকতে হবে",
                    showConfirmButton: false,
                    timer: 1500,
                });
            }
        };

        const witnessTemplate = document.getElementById("witnessTemplate");
        let witnessRowIndex = 0;
        document.getElementById("witnessAdd").addEventListener("click", function () {
            witnessRowIndex = document.getElementById("witnessAdd").value;
            witnessRowIndex = parseInt(parseInt(witnessRowIndex) + 1);

            const clone = witnessTemplate.cloneNode(true);
            clone.removeAttribute("id");

            // Show the row
            clone.style.display = "block";
            clone.setAttribute("data-row-withnessindex", witnessRowIndex);

            clone.querySelector('[data-name="witness.info"]').textContent = "সাক্ষীর তথ্য (" + parseInt(witnessRowIndex + 1) + ")";
            clone.removeAttribute("data-name");

            // Insert before the template
            witnessTemplate.before(clone);

            clone.querySelector('[data-name="witness.NIDNumber"]').setAttribute("data-rownew-index", ""+witnessRowIndex+"");
            clone.querySelector('[data-name="witness.NIDNumber"]').setAttribute("id", "witness_nid_input_"+witnessRowIndex+"");

            clone.querySelector('[data-name="witness.DOBNumber"]').setAttribute("data-rownew-index", ""+witnessRowIndex+"");
            clone.querySelector('[data-name="witness.DOBNumber"]').setAttribute("id", "witness_dob_input_"+witnessRowIndex+"");

            clone.querySelector('[data-name="witness.NIDCheckButton"]').setAttribute("data-rownew-index", ""+witnessRowIndex+"");
            clone.querySelector('[data-name="witness.NIDCheckButton"]').setAttribute("id", "witness_nid_"+witnessRowIndex+"");


            var defaulterBuutonNIDCHECKID="witness_nid_"+witnessRowIndex;
            clone.querySelector('[data-name="witness.NIDCheckButton"]').setAttribute("onclick", "NIDCHECKwitness('"+defaulterBuutonNIDCHECKID+"')");

            clone.querySelector('[data-name="witness.name"]').setAttribute("name", "witness[name][" + witnessRowIndex + "]");
            clone.querySelector('[data-name="witness.type"]').setAttribute("name", "witness[type][" + witnessRowIndex + "]");
            clone.querySelector('[data-name="witness.id"]').setAttribute("name", "witness[id][" + witnessRowIndex + "]");
            clone.querySelector('[data-name="witness.thana"]').setAttribute("name", "witness[thana][" + witnessRowIndex + "]");
            clone.querySelector('[data-name="witness.upazilla"]').setAttribute("name", "witness[upazilla][" + witnessRowIndex + "]");
            clone.querySelector('[data-name="witness.designation"]').setAttribute("name", "witness[designation][" + witnessRowIndex + "]");
            clone.querySelector('[data-name="witness.organization"]').setAttribute("name", "witness[organization][" + witnessRowIndex + "]");
            clone.querySelector('[data-name="witness.gender"]').setAttribute("name", "witness[gender][" + witnessRowIndex + "]");
            clone.querySelector('[data-name="witness.father"]').setAttribute("name", "witness[father][" + witnessRowIndex + "]");
            clone.querySelector('[data-name="witness.phn"]').setAttribute("name","witness[phn][" + witnessRowIndex + "]");
            clone.querySelector('[data-name="witness.presentAddress"]').setAttribute("name","witness[presentAddress][" + witnessRowIndex + "]");
            clone.querySelector('[data-name="witness.nid"]').setAttribute("name","witness[nid][" + witnessRowIndex + "]");


            // Add new fields
            // Note that we also pass the validator rules for new field as the third parameter
            fv2.addField("witness[phn][" + witnessRowIndex + "]", witnessPhoneValidators)
                .addField("witness[presentAddress][" + witnessRowIndex + "]", witnessPresentAddressValidators)
                .addField("witness[nid][" + witnessRowIndex + "]", witnessNIDValidators);

            // Handle the click event of removeButton
            document.getElementById("witnessAdd").value = witnessRowIndex;
            document.getElementById("witnessRemove").value = witnessRowIndex;
            document.getElementById("witnessRemove").onclick = function (e) {
                // Get the row index
                const index = e.target.value;
                removeWitnessRow(index);
            };
        });

        _validations.push(fv2);
        // step 4 end

        // step 5 start
        _validations.push(
            FormValidation.formValidation(_formEl, {
                fields: {
                    "lawyer[phn]": {
                        validators: {
                            notEmpty: {
                                message: "This is required",
                            },
                            regexp: {
                                // regexp: /^([3-9]\d{8})$/,w
                                regexp:  "(^(01){1}[3456789]{1}(\\d){8})$",
                                message: "The input is not valid Phone number",
                            },
                        },
                    },
                    "lawyer[email]": {
                        validators: {
                            emailAddress: {
                                message:
                                    "The value is not a valid email address",
                            },
                        },
                    },
                    "lawyer[nid]":{
                        validators: {
                            notEmpty: {
                                message: "This is required",
                            },
                        },
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap({
                        //eleInvalidClass: '',
                        eleValidClass: "",
                    }),
                    icon: new FormValidation.plugins.Icon({
                        valid: "fa fa-check",
                        invalid: "fa fa-times",
                        validating: "fa fa-refresh",
                    }),
                },
            })
        );
        // step 5 end

    };


    return {
        // public functions
        init: function () {
            _wizardEl = KTUtil.getById("appealWizard");
            _formEl = KTUtil.getById("appealCase");

            _initWizard();
            _initValidation();
        },
    };
})();

jQuery(document).ready(function () {
    KTProjectsAdd.init();
});
