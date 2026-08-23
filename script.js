function addRecommendation() {
  // Get the message of the new recommendation
  let recommendation = document.getElementById("new_recommendation");
  // If the user has left a recommendation, display a pop-up
  if (recommendation.value != null && recommendation.value.trim() != "") {
    console.log("New recommendation added");
    showPopup(true);
    var element = document.createElement("div");
    element.setAttribute("class","recommendation");
    element.innerHTML = "\<span\>&#8220;\</span\>" + recommendation.value + "\<span\>&#8221;\</span\>";
    // Add this element to the end of the list of recommendations
    document.getElementById("all_recommendations").appendChild(element); 
    
    // Reset the value of the textarea
    recommendation.value = "";
  }
}

function showPopup(bool) {
  if (bool) {
    document.getElementById('popup').style.visibility = 'visible'
  } else {
    document.getElementById('popup').style.visibility = 'hidden'
  }
}


// Contact Form Handler
function handleContactFormSubmit(event) {
  event.preventDefault();
  
  const form = document.getElementById('contactForm');
  const formMessage = document.getElementById('formMessage');
  const submitBtn = form.querySelector('.submit-btn');
  
  // Disable button to prevent multiple submissions
  submitBtn.disabled = true;
  submitBtn.textContent = 'Verzenden...';
  
  // Get form data
  const formData = new FormData(form);
  
  // Send data using fetch
  fetch(form.action, {
    method: form.method,
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      formMessage.textContent = data.message;
      formMessage.className = 'form-message success';
      form.reset();
    } else {
      formMessage.textContent = data.message;
      formMessage.className = 'form-message error';
    }
  })
  .catch(error => {
    formMessage.textContent = 'Er is een fout opgetreden. Probeer het later nog eens.';
    formMessage.className = 'form-message error';
    console.error('Error:', error);
  })
  .finally(() => {
    submitBtn.disabled = false;
    submitBtn.textContent = 'Versturen';
  });
}

// Add event listener when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', handleContactFormSubmit);
  }
});
