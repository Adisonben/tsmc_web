// Create car type
const createCartypeBtn = document.querySelector(".create-cartype-btn");
createCartypeBtn.addEventListener("click", async () => {

    const apiEndpoint = `car-types/`;

    const SwalResponse = await Swal.fire({
        title: "เพิ่มประเภทรถ",
        input: "text",
        inputPlaceholder: 'กรุณากรอกประเภทรถ',
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
                    carTypeName: inputValue,
                });

                if (response.status === 200 || response.status === 201) {
                    Swal.fire({
                        title: "Success!",
                        text: "Create car type successfully.",
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
                        text: "Failed to create car type. Please try again.",
                        icon: "error",
                    });
                }
            } catch (error) {
                console.error("Error updating prefix:", error);
                Swal.fire({
                    title: "Error",
                    text: "There was a problem creating car type.",
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


// Update Car type
const updateCartypeBtns = document.querySelectorAll(".update-cartype-btn");
updateCartypeBtns.forEach((updateBtn) => {
    updateBtn.addEventListener("click", async () => {
        const idToUpdate = updateBtn.getAttribute("edit-id");
        const apiEndpoint = `car-types/${idToUpdate}`;

        const SwalResponse = await Swal.fire({
            title: "แก้ไขคำนำหน้า",
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
                        carTypeName: inputValue,
                    });

                    if (response.status === 200 || response.status === 201) {
                        Swal.fire({
                            title: "Success!",
                            text: "Car type updated successfully.",
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
                            text: "Failed to update car type. Please try again.",
                            icon: "error",
                        });
                    }
                } catch (error) {
                    console.error("Error updating car type:", error);
                    Swal.fire({
                        title: "Error",
                        text: "There was a problem updating the car type.",
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
