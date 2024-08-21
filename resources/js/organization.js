// Delete function
const deleteOrgBtns = document.querySelectorAll(".delete-orgdata-btn");
deleteOrgBtns.forEach((delBrnBtn) => {
    delBrnBtn.addEventListener("click", () => {
        const idToDelete = delBrnBtn.getAttribute("del-id");
        const deleteTarget = delBrnBtn.getAttribute("del-target");
        const apiEndpoint = `/organizations/delete/${deleteTarget}/${idToDelete}`;
        console.log("delete brn btn at ", apiEndpoint);
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
                            text: "Your data has been deleted.",
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
