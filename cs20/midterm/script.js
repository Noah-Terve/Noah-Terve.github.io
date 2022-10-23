function image_hover_listener() {
  img = $(".item > *:not(:hover)");

  $(document).ready(function () {
    img.mouseenter(function () {
      blur_and_display($(".item > *:not(:hover)"));
    });
    img.mouseleave(function () {
      img.removeAttr("style");
    });
  });
}

function blur_and_display(item) {
  item.css({ filter: "blur(4px)" });
}

image_hover_listener();

/* displays message when user subscribes to newsletter */
function newsletterSubscribe() {
  content =  document.getElementById("newsletter");
  email_enter = document.getElementById("email_enter");

  if (email_enter.value == "")
    _ = error("emailError2", "Email is required");
  else {
    clearError("emailError2");
    content.innerHTML =
      "<h2> Thank you for subscribing! </h2><br/><p>&copy; Hain's Bakery 2020</p><br/>";
  }
}

/* verifies all inputs on contact form. displays errors if they exist, if not 
   clears form and displays message */
function submitMessage() {
  errors = 0;
  phonepattern = /^[0-9]{7}|[0,9]{10}$/;

  if (document.contact.name.value == "")
    errors += error("nameError", "Name is required");
  else clearError("nameError");

  if (document.contact.email.value == "")
    errors += error("emailError", "Email is required");
  else clearError("emailError");

  if (document.contact.phone.value == "")
    errors += error("phoneError", "Phone Number is required");
  else if (!phonepattern.test(document.contact.phone.value))
    errors += error("phoneError", "Phone Number is invalid");
  else clearError("phoneError");

  if (document.contact.reason.value == "")
    errors += error("reasonError", "Contact Reason is required");
    else clearError("reasonError");

  if (document.contact.message.value == "")
    errors += error("messageError", "Message is required");
  else clearError("messageError");

  if (errors > 0) return false;
  else { /* clear form and display form submitted message */
    document.getElementById("contact").reset(); 
    document.getElementById("formsubmitted").innerHTML =
      "<h3><em>Your message has been submitted, <br> we will get back to you soon!</em></h3>";
  }
}

/* prints error to appropriate div and returns 1 */
function error(errorId, errorMessage) {
  document.getElementById(errorId).innerHTML = errorMessage;
  return 1;
}

/* clears error div */
function clearError(errorId) {
  document.getElementById(errorId).innerHTML = "&nbsp;";
}
