import axios from "axios";


// Get references to the container and the add button
const groupCardContainer = document.getElementById('groupCardContainer');
const addFormGroupBtn = document.getElementById('addFormGroupBtn');

// Function to create a new card element
function createCard() {
  const newCard = document.createElement('div');
  newCard.classList.add('card', 'my-3', 'checkCard');
    const cardCount = groupCardContainer.querySelectorAll('.card').length;
  // Create the rest of the card's HTML structure as a string (for efficiency)
  const cardContent = `
    <div class="card-body">
        <input type="text" class="form-control mb-3 list-group-item groupName" placeholder="ชื่อหมวดหมู่">
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

// Event listener for the add button
if (addFormGroupBtn) {
    addFormGroupBtn.addEventListener('click', () => {
        const newCardElement = createCard();
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
            const groupSubTextInputs = ccard.querySelectorAll('.groupSubText');

            const cardData = {
                groupName: groupNameInput.value,
                groupSubText: Array.from(groupSubTextInputs).map(input => input.value)
            };
            cardDatalist.push(cardData);
        });
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
            const groupSubTextInputs = ccard.querySelectorAll('.groupSubText');

            const cardData = {
                groupName: groupNameInput.value,
                groupSubText: Array.from(groupSubTextInputs).map(input => input.value)
            };
            cardDatalist.push(cardData);
        });
        updateformData.append('checkData', JSON.stringify(cardDatalist));
        console.log(cardDatalist, updateformData);
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
