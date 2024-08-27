// Get references to the container and the add button
const groupCardContainer = document.getElementById('groupCardContainer');
const addFormGroupBtn = document.getElementById('addFormGroupBtn');

// Function to create a new card element
function createCard() {
  const newCard = document.createElement('div');
  newCard.classList.add('card', 'my-3');
    const cardCount = groupCardContainer.querySelectorAll('.card').length;
  // Create the rest of the card's HTML structure as a string (for efficiency)
  const cardContent = `
    <div class="card-body">
        <input type="text" class="form-control mb-3 list-group-item" placeholder="ชื่อหมวดหมู่">
        <ol class="list-group-numbered">
            <li class="list-group-item d-flex gap-3">
                <input type="text" class="form-control list-group-item" placeholder="รายการตรวจประเมิน 1">
                <a type="button" onclick="delGroupList(this)"><i class="bi bi-x"></i></a>
            </li>
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
addFormGroupBtn.addEventListener('click', () => {
  const newCardElement = createCard();
  groupCardContainer.appendChild(newCardElement);
});

// Event listener for the delete button (delegated)
groupCardContainer.addEventListener('click', (event) => {
    if (event.target.classList.contains('delete-card-btn')) {
      const cardToDelete = event.target.closest('.card');
      groupCardContainer.removeChild(cardToDelete);
    }
});


import axios from "axios";

const createCheckForm = document.getElementById('createCheckForm');
createCheckForm.addEventListener('submit', (event) => {
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
    formData.append('checkData', cardDatalist);
    console.log(cardDatalist, formData);
    // axios.post('/posts/comment', formData)
    //     .then(response => {
    //         // Handle successful response
    //         console.log('Response:', response);
    //         window.location.reload();
    //         // Swal.fire({
    //         //     title: "Success!",
    //         //     text: "Your comment has been posted.",
    //         //     icon: "success",
    //         // }).then((result) => {
    //         //     if (result.isConfirmed) {
    //         //         window.location.reload();
    //         //     }
    //         // });
    //     })
    //     .catch(error => {
    //         // Handle error
    //         console.error('Error:', error);
    //         Swal.fire({
    //             title: "Sorry!",
    //             text: "Something went wrong!",
    //             icon: "error",
    //         });
    //     });
})
