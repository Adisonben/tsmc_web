import axios from "axios";


// Get references to the container and the add button
const groupCardContainer = document.getElementById('groupCardContainer');
const addFormGroupBtn = document.getElementById('addFormGroupBtn');
const addImgGroupBtn = document.getElementById('addImgGroupBtn');

// Function to create a new card element
function createCard() {
  const newCard = document.createElement('div');
  newCard.classList.add('card', 'my-3', 'checkCard');
    const cardCount = groupCardContainer.querySelectorAll('.card').length;
  // Create the rest of the card's HTML structure as a string (for efficiency)
  const cardContent = `
    <div class="card-body">
        <input type="text" class="form-control mb-3 groupName" placeholder="ชื่อหมวดหมู่">
        <input type="hidden" class="form-control mb-3 groupType" value="check">
        <ol class="list-group-numbered">

        </ol>
    </div>
    <div class="card-footer">
        <button type="button" class="btn btn-sm btn-success" onclick="addGroupList(this)">เพิ่มรายการตรวจประเมิน</button>
        <button type="button" class="btn btn-sm btn-danger delete-card-btn">ลบหมวดหมู่</button>
    </div>
  `;
  newCard.innerHTML = cardContent;

  return newCard;
}

function createImgCard() {
    const newCard = document.createElement('div');
    newCard.classList.add('card', 'my-3', 'checkCard');
      const cardCount = groupCardContainer.querySelectorAll('.card').length;
    // Create the rest of the card's HTML structure as a string (for efficiency)
    const cardContent = `
        <div class="card-body">
            <div class="d-flex gap-2 flex-wrap flex-md-nowrap">
                <input type="text" class="form-control mb-3 groupName" placeholder="ชื่อภาพ">
                <input type="file" class="form-control mb-3 groupContent" placeholder="ชื่อภาพ">
            </div>
            <input type="hidden" class="form-control mb-3 groupType" value="image">
            <ol class="list-group-numbered">

            </ol>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-sm btn-danger delete-card-btn">ลบหมวดหมู่</button>
        </div>
    `;
    newCard.innerHTML = cardContent;

    return newCard;
  }

// Event listener for the add button
if (addFormGroupBtn) {
    addFormGroupBtn.addEventListener('click', () => {
        const newCardElement = createCard();
        groupCardContainer.appendChild(newCardElement);
    });
}
if (addImgGroupBtn) {
    addImgGroupBtn.addEventListener('click', () => {
        const newCardElement = createImgCard();
        groupCardContainer.appendChild(newCardElement);
    });
}

// Event listener for the delete button (delegated)
if (groupCardContainer) {
    groupCardContainer.addEventListener('click', (event) => {
        if (event.target.classList.contains('delete-card-btn')) {
          const cardToDelete = event.target.closest('.card');
          groupCardContainer.removeChild(cardToDelete);
        }
    });
}


const createCheckForm = document.getElementById('createCheckForm');
if (createCheckForm) {
    createCheckForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        const cards = createCheckForm.querySelectorAll('.checkCard');
        const formData = new FormData(createCheckForm);
        let cardDatalist = [];
        cards.forEach((ccard) => {
            const groupNameInput = ccard.querySelector('.groupName');
            const checkLis = ccard.querySelectorAll('.checkLi');
            let checkDataList = [];
            checkLis.forEach((checkLi) => {
                const groupSubText = checkLi.querySelector('.groupSubText');
                const optType = checkLi.querySelector('.selectOptType');
                let getOptions = [];
                if (optType.value == "custom") {
                    const optionContainer = checkLi.querySelector('.optionContainer');
                    const optionsCustom = optionContainer.querySelectorAll('.optionLi');
                    optionsCustom.forEach((option) => {
                        getOptions.push({
                            optionText : option.querySelector('.optTitle').value,
                            optionScore: option.querySelector('.optScore').value ? option.querySelector('.optScore').value : 1,
                        });
                    })
                }
                checkDataList.push({
                    checktTitle : groupSubText.value,
                    optType: optType.value,
                    optionList : getOptions
                });
            })

            const cardData = {
                groupName: groupNameInput.value,
                checkList: checkDataList,
            };
            cardDatalist.push(cardData);
        });
        // console.log(cardDatalist)
        formData.append('checkData', JSON.stringify(cardDatalist));
        console.log(cardDatalist, formData);
        await axios.post('/forms', formData)
            .then(response => {
                // Handle successful response
                console.log('Response:', response.data);
                // window.location.reload();
                Swal.fire({
                    title: "Success!",
                    text: "Your form has been saved.",
                    icon: "success",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
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
    });
}


const updateCheckForm = document.getElementById('updateCheckForm');
if (updateCheckForm) {
    updateCheckForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        const cards = updateCheckForm.querySelectorAll('.checkCard');
        const formId = updateCheckForm.getAttribute('form-id');
        const updateformData = new FormData(updateCheckForm);
        let cardDatalist = [];
        cards.forEach((ccard) => {
            const groupNameInput = ccard.querySelector('.groupName');
            const checkLis = ccard.querySelectorAll('.checkLi');
            let checkDataList = [];
            checkLis.forEach((checkLi) => {
                const groupSubText = checkLi.querySelector('.groupSubText');
                const optType = checkLi.querySelector('.selectOptType');
                let getOptions = [];
                if (optType.value == "custom") {
                    const optionContainer = checkLi.querySelector('.optionContainer');
                    const optionsCustom = optionContainer.querySelectorAll('.optionLi');
                    optionsCustom.forEach((option) => {
                        getOptions.push({
                            optionText : option.querySelector('.optTitle').value,
                            optionScore: option.querySelector('.optScore').value ? option.querySelector('.optScore').value : 1,
                        });
                    })
                }
                checkDataList.push({
                    checktTitle : groupSubText.value,
                    optType: optType.value,
                    optionList : getOptions
                });
            })

            const cardData = {
                groupName: groupNameInput.value,
                checkList: checkDataList,
            };
            cardDatalist.push(cardData);
        });
        // console.log(cardDatalist, updateformData);
        updateformData.append('checkData', JSON.stringify(cardDatalist));
        await axios.post(`/forms/update/${formId}`, updateformData)
            .then(response => {
                // Handle successful response
                console.log('Response:', response.data);
                // window.location.reload();
                Swal.fire({
                    title: "Success!",
                    text: "Your form has been updated.",
                    icon: "success",
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
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
}

// Verify function
const verifyBtns = document.querySelectorAll(".verify-form-btn");
verifyBtns.forEach((verifyBtn) => {
    verifyBtn.addEventListener("click", () => {
        const idToverify = verifyBtn.getAttribute("formres-id");
        const apiEndpoint = `/form/approve/${idToverify}`;
        Swal.fire({
            title: "ผลการตรวจสอบเอกสาร?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "ผ่าน",
            denyButtonText: `ไม่ผ่าน`
          }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                axios
                    .get(apiEndpoint + "/1")
                    .then((res) => {
                        console.log(res.data);
                        Swal.fire({
                            title: "บันทึกสำเร็จ!",
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
            } else if (result.isDenied) {
                axios
                    .get(apiEndpoint + "/0")
                    .then((res) => {
                        console.log(res.data);
                        Swal.fire({
                            title: "บันทึกสำเร็จ!",
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
