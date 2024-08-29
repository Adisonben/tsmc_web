const deletePhonenum = document.querySelectorAll(".delete-phonenum-btn");
deletePhonenum.forEach((delPnBtn) => {
    delPnBtn.addEventListener("click", () => {
        const idToDelete = delPnBtn.getAttribute("del-id");
        const apiEndpoint = `/phonenum/delete/${idToDelete}`;
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
