// Show an alert when the user clicks the 'Claim Offer' button
document.querySelector('.claim-offer').addEventListener('click', function() {
    alert('Congratulations! You have claimed the offer!');
  });

document.querySelector('.login-btn').addEventListener('click', function(event) {
    // Prevent the form from submitting automatically for validation
    event.preventDefault();
  
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const role = document.querySelector('input[name="role"]:checked');
  
    //validation
    if (!username || !password || !role) {
      alert("Please fill in all fields and select a role.");
    } else {
      // If all fields are valid, submit the form 
      alert(`Logging in as ${role.value}`);
      
    }
  });
  
  // logging out
document.querySelector('.logout-btn').addEventListener('click', function() {
    alert("You have logged out.");
    window.location.href = 'index.html'; // Redirect to the homepage after logout
  });
  // Manage Memberships
document.querySelectorAll('.cancel-btn').forEach(button => {
    button.addEventListener('click', function() {
      alert('Membership Cancelled');
      
    });
  });
  
  // Respond to Queries
  document.querySelectorAll('.respond-btn').forEach(button => {
    button.addEventListener('click', function() {
      alert('Response sent to customer');
      
    });
  });

  // Clicking on a membership plan or class
document.querySelectorAll('.membership-card').forEach(card => {
    card.addEventListener('click', function() {
      alert('You selected ' + card.querySelector('h3').textContent + ' membership!');
    });
  });
  
  document.querySelectorAll('.class-card').forEach(card => {
    card.addEventListener('click', function() {
      alert('You selected the ' + card.querySelector('.class-info h3').textContent + ' class!');
    });
  });

// Scroll to Top Button
let mybutton = document.getElementById("scrollTopBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
};

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

// Form Validation for Contact Form
document.getElementById("contactForm").onsubmit = function(event) {
  var name = document.getElementById("name").value;
  var email = document.getElementById("email").value;
  var message = document.getElementById("message").value;

  if (name === "" || email === "" || message === "") {
    alert("Please fill in all fields.");
    event.preventDefault(); // Prevent form submission
  }
};


// Form Validation for Login
function validateLoginForm() {
  var name = document.getElementById("loginName").value;
  var password = document.getElementById("loginPassword").value;

  if (name === "" || password === "") {
    alert("Please fill in both fields.");
    return false; // Prevent form submission
  }
  return true; // Allow form submission
}

// Form Validation for Sign-Up
function validateSignupForm() {
  var name = document.getElementById("signupName").value;
  var password = document.getElementById("signupPassword").value;
  var className = document.getElementById("signupClass").value;

  if (name === "" || password === "" || className === "") {
    alert("Please fill in all fields.");
    return false; // Prevent form submission
  }
  return true; // Allow form submission
}


// Handle the query form submission
function handleSubmitQuery() {
  var query = document.getElementById("query").value;

  // Validate if the query field is empty
  if (query === "") {
    alert("Please enter your query before submitting.");
    return false; // Prevent form submission
  }

  //successful submission
  alert("Your query has been submitted successfully!");
  document.getElementById("queryForm").reset(); // Reset form fields
  return false; 
}


