const ratingInputs = document.querySelectorAll('.rating input[type="radio"]');
let selectedRatings = {};

ratingInputs.forEach(input => {
  input.addEventListener('change', event => {
    const question = event.target.name;
    const rating = event.target.value;
    selectedRatings[question] = rating;
  });
});


const genderInputs = document.querySelectorAll('input[name="gender"]');
const genderSelection = document.getElementById('gender-selection');

genderInputs.forEach(input => {
  input.addEventListener('change', event => {
    genderSelection.textContent = `You selected ${event.target.value}.`;
  });
});

const majorSelect = document.getElementById('major-select');
const majorDisplay = document.getElementById('major-display');

majorSelect.addEventListener('change', event => {
  const selectedMajor = event.target.value;
  majorDisplay.textContent = selectedMajor;
});

const nationalitySelect = document.getElementById('nationality-select');
const nationalityDisplay = document.getElementById('nationality-display');

nationalitySelect.addEventListener('change', event => {
  const selectedNationality = event.target.value;
  nationalityDisplay.textContent = selectedNationality;
});


// Define variables to hold HTML elements
const editBtn = document.getElementById("edit-btn");
const survey = document.querySelector(".survey");
const questions = document.querySelectorAll(".question");

// Add event listener to edit button
editBtn.addEventListener("click", function () {
  // Create edit button for the whole thing
  const editQuestionBtn = document.createElement("button");
  editQuestionBtn.innerText = "Edit Question";
  editQuestionBtn.classList.add("edit-question-btn");
  container.insertBefore(editQuestionBtn, questions[0]);

  // Add edit functionality to the button
  editQuestionBtn.addEventListener("click", function () {
    // code to edit the questions here
  });
});
    // Add event listener to edit button
    editQuestionBtn.addEventListener("click", function () {
      // Get question and options elements
      const questionTitle = question.querySelector("h3");
      const options = question.querySelector(".options");

      // Create input fields for question title and options
      const questionTitleInput = document.createElement("input");
      questionTitleInput.type = "text";
      questionTitleInput.placeholder = "Enter question title";
      questionTitleInput.value = questionTitle.innerText;
      questionTitleInput.classList.add("question-title-input");

      const optionsInput = document.createElement("input");
      optionsInput.type = "text";
      optionsInput.placeholder = "Enter comma-separated options";
      optionsInput.value = Array.from(options.querySelectorAll("label span")).map(option => option.innerText).join(",");
      optionsInput.classList.add("options-input");

      // Replace question title and options with input fields
      question.replaceChild(questionTitleInput, questionTitle);
      question.replaceChild(optionsInput, options);

      // Create save and cancel buttons
      const saveBtn = document.createElement("button");
      saveBtn.innerText = "Save";
      saveBtn.classList.add("save-btn");

      const cancelBtn = document.createElement("button");
      cancelBtn.innerText = "Cancel";
      cancelBtn.classList.add("cancel-btn");

      // Add event listener to save button
      saveBtn.addEventListener("click", function () {
        // Replace input fields with question title and options
        questionTitle.innerText = questionTitleInput.value;

        // Remove existing options
        Array.from(options.querySelectorAll("label")).forEach(function (label) {
          label.remove();
        });

        // Create new options based on input
        const optionsArray = optionsInput.value.split(",");
        optionsArray.forEach(function (option) {
          const optionLabel = document.createElement("label");
          const optionInput = document.createElement("input");
          optionInput.type = "radio";
          optionInput.name = question.id;
          optionInput.value = option;
          const optionSpan = document.createElement("span");
          optionSpan.innerText = option;
          optionLabel.appendChild(optionInput);
          optionLabel.appendChild(optionSpan);
          options.appendChild(optionLabel);
        });

        // Replace input fields with options
        question.replaceChild(options, optionsInput);
        question.replaceChild(questionTitle, questionTitleInput);

        // Remove save and cancel buttons
        question.removeChild(saveBtn);
        question.removeChild(cancelBtn);
      });

      // Add event listener to cancel button
      cancelBtn.addEventListener("click", function () {
        // Replace input fields with question title and options
        question.replaceChild(options, optionsInput);
        question.replaceChild(questionTitle, questionTitleInput);

        // Remove save and cancel buttons
        question.removeChild(saveBtn);
        question.removeChild(cancelBtn);
      });

      // Append save and cancel buttons
      question.appendChild(saveBtn);
      question.appendChild(cancelBtn);
    });

  // Create add question button
  const addQuestionBtn = document.createElement("button");
  addQuestionBtn.innerText = "Add Question";
  addQuestionBtn.classList.add("add-question-btn");
  survey.appendChild(addQuestionBtn);

  // Add event listener to the button
addQuestionBtn.addEventListener("click", function() {
  // Code to execute when button is clicked
});

    // Create new question element
    const newQuestion = document.createElement("div");
    newQuestion.classList.add("question");

    // Create input fields for question title and options
    const questionTitleInput = document.createElement("input");
    questionTitleInput.type = "text";
    questionTitleInput.placeholder = "Enter question title";
    questionTitleInput.classList.add("question-title-input");

    const optionsInput = document.createElement("input");
    optionsInput.type = "text";
    optionsInput.placeholder = "Enter comma-separated options";
    optionsInput.classList.add("options-input");

    // Create add and cancel buttons
    const addBtn = document.createElement("button");
    addBtn.innerText = "Add";
    addBtn.classList.add("add-btn");

    const cancelBtn = document.createElement("button");
    cancelBtn.innerText = "Cancel";
    cancelBtn.classList.add("cancel-btn");

    // Add event listener to add button
    addBtn.addEventListener("click", function () {
      // Create question title and options
      const questionTitle = document.createElement("h3");
      questionTitle.innerText = questionTitleInput.value;

      const options = document.createElement("div");
      options.classList.add("options");

      const optionsArray = optionsInput.value.split(",");
      optionsArray.forEach(function (option) {
        const optionLabel = document.createElement("label");
        const optionInput = document.createElement("input");
        optionInput.type = "radio";
        optionInput.name = newQuestion.id;
        optionInput.value = option;
        const optionSpan = document.createElement("span");
        optionSpan.innerText = option;
        optionLabel.appendChild(optionInput);
        optionLabel.appendChild(optionSpan);
        options.appendChild(optionLabel);
      });

      // Append question title and options to new question
      newQuestion.appendChild(questionTitle);
      newQuestion.appendChild(options);

      // Replace input fields with question and options
      survey.replaceChild(newQuestion, addQuestionBtn);

      // Remove add and cancel buttons
      newQuestion.removeChild(questionTitleInput);
      newQuestion.removeChild(optionsInput);
      newQuestion.removeChild(addBtn);
      newQuestion.removeChild(cancelBtn);

      // Add edit button to new question
      const editQuestionBtn = document.createElement("button");
      editQuestionBtn.innerText = "Edit Question";
      editQuestionBtn.classList.add("edit-question-btn");
      newQuestion.appendChild(editQuestionBtn);

      // Add event listener to edit button
      editQuestionBtn.addEventListener("click", function () {

        // Get question and options elements
        const questionTitle = newQuestion.querySelector("h3");
        const options = newQuestion.querySelector(".options");

        // Create input fields for question title and options
        const questionTitleInput = document.createElement("input");
        questionTitleInput.type = "text";
        questionTitleInput.placeholder = "Enter question title";
        questionTitleInput.value = questionTitle.innerText;
        questionTitleInput.classList.add("question-title-input");

        const optionsInput = document.createElement("input");
        optionsInput.type = "text";
        optionsInput.placeholder = "Enter comma-separated options";
        optionsInput.value = Array.from(options.querySelectorAll("label span")).map(option => option.innerText).join(",");
        optionsInput.classList.add("options-input");

        // Replace question title and options with input fields
        newQuestion.replaceChild(questionTitleInput, questionTitle);
        newQuestion.replaceChild(optionsInput, options);

        // Create save and cancel buttons
        const saveBtn = document.createElement("button");
        saveBtn.innerText = "Save";
        saveBtn.classList.add("save-btn");

        const cancelBtn = document.createElement("button");
        cancelBtn.innerText = "Cancel";
        cancelBtn.classList.add("cancel-btn");

        // Add event listener to save button
        saveBtn.addEventListener("click", function () {
          // Replace input fields with question title and options
          questionTitle.innerText = questionTitleInput.value;

          // Remove existing options
          Array.from(options.querySelectorAll("label")).forEach(function (label) {
            label.remove();
          });

          // Create new options based on input
          const optionsArray = optionsInput.value.split(",");
          optionsArray.forEach(function (option) {
            const optionLabel = document.createElement("label");
            const optionInput = document.createElement("input");
            optionInput.type = "radio";
            optionInput.name = question.id;
            optionInput.value = option;
            const optionSpan = document.createElement("span");
            optionSpan.innerText = option;
            optionLabel.appendChild(optionInput);
            optionLabel.appendChild(optionSpan);
            options.appendChild(optionLabel);
          });

          // Replace input fields with options
          question.replaceChild(options, optionsInput);
          question.replaceChild(questionTitle, questionTitleInput);

          // Remove save and cancel buttons
          question.removeChild(saveBtn);
          question.removeChild(cancelBtn);
        });
        // Add event listener to cancel button
        cancelBtn.addEventListener("click", function () {
          // Replace input fields with question title and options
          question.replaceChild(options, optionsInput);
          question.replaceChild(questionTitle, questionTitleInput);

          // Remove save and cancel buttons
          question.removeChild(saveBtn);
          question.removeChild(cancelBtn);
        });

        // Append save and cancel buttons
        question.appendChild(saveBtn);
        question.appendChild(cancelBtn);
      }); 
      // Create add question button
const addQuestionBtn = document.createElement("button");
addQuestionBtn.innerText = "Add Question";
addQuestionBtn.classList.add("add-question-btn");
survey.appendChild(addQuestionBtn);

// Add event listener to add question button
addQuestionBtn.addEventListener("click", function() {
// Create new question element
const newQuestion = document.createElement("div");
newQuestion.classList.add("question");
// Create new question title element
const newQuestionTitle = document.createElement("h3");
newQuestionTitle.innerText = "New Question";
newQuestion.appendChild(newQuestionTitle);

// Create new options element
const newOptions = document.createElement("div");
newOptions.classList.add("options");

// Create new option input fields
const newOption1 = document.createElement("label");
const newOption1Input = document.createElement("input");
newOption1Input.type = "radio";
newOption1Input.name = "new";

  // Add event listener to delete button
  deleteBtn.addEventListener("click", function () {
    // Remove question element
    survey.removeChild(question);
  });

  // Append edit and delete buttons to question
  question.appendChild(editBtn);
  question.appendChild(deleteBtn);
});

// Remove add question button
survey.removeChild(addQuestionBtn);
});

