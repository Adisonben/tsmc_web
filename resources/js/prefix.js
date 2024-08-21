import axios from "axios";
import Swal from "sweetalert2";
window.Swal = Swal;

// Delete function
const deleteBtns = document.querySelectorAll(".delete-data-btn");
deleteBtns.forEach((delBtn) => {
    delBtn.addEventListener("click", () => {
        const idToDelete = delBtn.getAttribute("del-id");
        const deleteTarget = delBtn.getAttribute("del-target");
        const apiEndpoint = `${deleteTarget}/${idToDelete}`;

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .delete(apiEndpoint)
                    .then((res) => {
                        console.log(res.data);
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    })
                    .catch((error) => {
                        console.log("Error deleting data: ", error);
                        Swal.fire({
                            title: "Sorry!",
                            text: "Something went wrong!",
                            icon: "error",
                        });
                    });
            }
        });
    });
});

// Update prefix
const updatePrefixBtns = document.querySelectorAll(".update-prefix-btn");
updatePrefixBtns.forEach((updateBtn) => {
    updateBtn.addEventListener("click", async () => {
        const idToUpdate = updateBtn.getAttribute("edit-id");
        const apiEndpoint = `prefixes/${idToUpdate}`;

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
                        prefixName: inputValue,
                    });

                    if (response.status === 200 || response.status === 201) {
                        Swal.fire({
                            title: "Success!",
                            text: "Prefix updated successfully.",
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
                            text: "Failed to update prefix. Please try again.",
                            icon: "error",
                        });
                    }
                } catch (error) {
                    console.error("Error updating prefix:", error);
                    Swal.fire({
                        title: "Error",
                        text: "There was a problem updating the prefix.",
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
