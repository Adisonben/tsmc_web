// Create license type
const createLictypeBtn = document.querySelector(".create-lictype-btn");
if (createLictypeBtn) {
    createLictypeBtn.addEventListener("click", async () => {

        const apiEndpoint = `driver-license-types/`;

        const SwalResponse = await Swal.fire({
            title: "เพิ่มประเภทใบขับขี่",
            input: "text",
            inputPlaceholder: 'กรุณากรอกประเภทใบขับขี่',
            inputAttributes: {
                autocapitalize: "off",
            },
            showCancelButton: true,
            confirmButtonText: "บันทึก",
            cancelButtonText: "ยกเลิก",
            showLoaderOnConfirm: true,
            preConfirm: async (inputValue) => {
                // Input validation (optional)
                if (!inputValue || inputValue.trim() === "") {
                    return Swal.showValidationMessage("กรุณากรอกประเภทรถ");
                }

                try {
                    const response = await axios.post(apiEndpoint, {
                        licTypeName: inputValue,
                    });

                    if (response.status === 200 || response.status === 201) {
                        Swal.fire({
                            title: "Success!",
                            text: "Create license type successfully.",
                            icon: "success",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });

                        // Update UI or data display here (optional)
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Failed to create license type. Please try again.",
                            icon: "error",
                        });
                    }
                } catch (error) {
                    console.error("Error updating prefix:", error);
                    Swal.fire({
                        title: "Error",
                        text: "There was a problem creating license type.",
                        icon: "error",
                    });
                }
            },
            allowOutsideClick: () => !Swal.isLoading(),
        });

        // Handle cancellation (optional)
        if (!SwalResponse.isConfirmed) {
            console.log("Create cancelled.");
        }
    });
}


// Update License type
const updateLictypeBtns = document.querySelectorAll(".update-lictype-btn");
updateLictypeBtns.forEach((updateBtn) => {
    updateBtn.addEventListener("click", async () => {
        const idToUpdate = updateBtn.getAttribute("edit-id");
        const apiEndpoint = `driver-license-types/${idToUpdate}`;

        const SwalResponse = await Swal.fire({
            title: "แก้ไขประเภทใบขับขี่",
            input: "text",
            inputAttributes: {
                autocapitalize: "off",
            },
            inputValue: updateBtn.getAttribute("edit-value"), // Pre-populate input
            showCancelButton: true,
            confirmButtonText: "บันทึก",
            cancelButtonText: "ยกเลิก",
            showLoaderOnConfirm: true,
            preConfirm: async (inputValue) => {
                // Input validation (optional)
                if (!inputValue || inputValue.trim() === "") {
                    return Swal.showValidationMessage("Please enter a value.");
                }

                try {
                    const response = await axios.put(apiEndpoint, {
                        // Replace "newPrefixValue" with the actual property name to update
                        licTypeName: inputValue,
                    });

                    if (response.status === 200 || response.status === 201) {
                        Swal.fire({
                            title: "Success!",
                            text: "License type updated successfully.",
                            icon: "success",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });

                        // Update UI or data display here (optional)
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Failed to update lic type. Please try again.",
                            icon: "error",
                        });
                    }
                } catch (error) {
                    console.error("Error updating lic type:", error);
                    Swal.fire({
                        title: "Error",
                        text: "There was a problem updating the lic type.",
                        icon: "error",
                    });
                }
            },
            allowOutsideClick: () => !Swal.isLoading(),
        });

        // Handle cancellation (optional)
        if (!SwalResponse.isConfirmed) {
            console.log("Update cancelled.");
        }
    });
});
