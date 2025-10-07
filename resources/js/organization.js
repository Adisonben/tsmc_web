// Delete function
const deleteOrgBtns = document.querySelectorAll(".delete-orgdata-btn");
deleteOrgBtns.forEach((delBrnBtn) => {
    delBrnBtn.addEventListener("click", () => {
        const idToDelete = delBrnBtn.getAttribute("del-id");
        const deleteTarget = delBrnBtn.getAttribute("del-target");
        let  apiEndpoint = '';
        if (deleteTarget) {
            apiEndpoint = `/organizations/delete/${deleteTarget}/${idToDelete}`;
        } else {
            apiEndpoint = `/organizations/delete/${idToDelete}`;
        }
        console.log("delete brn btn at ", apiEndpoint);
        Swal.fire({
            title: "คุณแน่ใจหรือไม่?",
            text: "คุณจะไม่สามารถย้อนกลับสิ่งนี้ได้!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "ลบเลย!",
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .delete(apiEndpoint)
                    .then((res) => {
                        console.log(res.data);
                        Swal.fire({
                            title: "ลบสำเร็จ!",
                            text: "ข้อมูลของคุณถูกลบแล้ว",
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
                            title: "ไม่สำเร็จ!",
                            text: "ขออภัย มีบางอย่างผิดพลาดเกิดขึ้น!",
                            icon: "error",
                        });
                    });
            }
        });
    });
});
