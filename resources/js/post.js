import axios from "axios";

const commentFormbtns = document.querySelectorAll('.commentForm');
commentFormbtns.forEach((commentForm) => {
    commentForm.addEventListener('submit', (event) => {
        event.preventDefault();
        const formData = new FormData(commentForm);

        axios.post('/posts/comment', formData)
            .then(response => {
                // Handle successful response
                console.log('Response:', response);
                window.location.reload();
                // Swal.fire({
                //     title: "Success!",
                //     text: "Your comment has been posted.",
                //     icon: "success",
                // }).then((result) => {
                //     if (result.isConfirmed) {
                //         window.location.reload();
                //     }
                // });
            })
            .catch(error => {
                // Handle error
                console.error('Error:', error);
                Swal.fire({
                    title: "Sorry!",
                    text: "Something went wrong!",
                    icon: "error",
                });
            });
    })
})

// Delete comment function
const deleteCommentBtns = document.querySelectorAll(".delete-comment-btn");
deleteCommentBtns.forEach((delBtn) => {
    delBtn.addEventListener("click", () => {
        const idToDelete = delBtn.getAttribute("del-id");
        const apiEndpoint = `/posts/comment/${idToDelete}`;

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
