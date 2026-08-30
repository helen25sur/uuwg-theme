const fluentform1 = document.getElementById('fluentform_1');
const inputFullName = document.getElementById('ff_1_full_name_first_name_');
const inputEmail = document.getElementById('ff_1_email');
const textareaMessage = document.getElementById('ff_1_message');

const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

if (fluentform1) {

  // Validate input of full name
  inputFullName.addEventListener('blur', (evt) => {
    let errorMsg = '';
    const existErr = fluentform1.querySelector('.ff-el-group:has(#ff_1_full_name_first_name_) .error-message');

    if (!evt.target.value.trim() || evt.target.value.trim().length < 3) {
      errorMsg = 'Enter your full name';
    }

    let elementErrMsg;
    if (errorMsg) {
      elementErrMsg = document.createElement('span');
      elementErrMsg.innerText = errorMsg;
      elementErrMsg.classList.add('error-message');
      if (!existErr) {
        fluentform1.querySelector('.ff-el-group:has(#ff_1_full_name_first_name_)').append(elementErrMsg);
      }
    }
  });

  inputFullName.addEventListener('input', (evt) => {
    const existErr = fluentform1.querySelector('.ff-el-group:has(#ff_1_full_name_first_name_) .error-message');

    if (existErr) {
      if (evt.target.value.trim() && evt.target.value.trim().length >= 3) {
        existErr.remove();
      }
    }
  });

  // Validate input of email
  inputEmail.addEventListener('blur', (evt) => {
    let errorMsg = '';
    const existErr = fluentform1.querySelector('.ff-el-group:has(#ff_1_email) .error-message');

    if (!evt.target.value.trim()) {
      errorMsg = 'Enter an email';
    } else if (!emailRegex.test(evt.target.value.trim())) {
      errorMsg = 'Enter a valid email';
    }

    let elementErrMsg;
    if (errorMsg) {
      elementErrMsg = document.createElement('span');
      elementErrMsg.innerText = errorMsg;
      elementErrMsg.classList.add('error-message');
      if (!existErr) {
        fluentform1.querySelector('.ff-el-group:has(#ff_1_email)').append(elementErrMsg);
      }
    }
  });

  inputEmail.addEventListener('input', (evt) => {
    const existErr = fluentform1.querySelector('.ff-el-group:has(#ff_1_email) .error-message');

    if (existErr) {
      if (evt.target.value.trim() && emailRegex.test(evt.target.value.trim())) {
        existErr.remove();
      }
    }
  });

  // Validate textarea
  textareaMessage.addEventListener('blur', (evt) => {
    let errorMsg = '';
    const existErr = fluentform1.querySelector('.ff-el-group:has(#ff_1_message) .error-message');

    if (!evt.target.value.trim()) {
      errorMsg = 'Enter your message';
    } else if (evt.target.value.trim().length < 10) {
      errorMsg = 'Message is too short';
    } else if (evt.target.value.trim().length > 1000) {
      errorMsg = 'Message is too long';
    }

    if (errorMsg) {
      if (existErr) {
        existErr.innerText = errorMsg;
      } else {
        const elementErrMsg = document.createElement('span');
        elementErrMsg.innerText = errorMsg;
        elementErrMsg.classList.add('error-message');

        fluentform1
          .querySelector('.ff-el-group:has(#ff_1_message)')
          .append(elementErrMsg);
      }
    }

  });

  textareaMessage.addEventListener('input', (evt) => {
    const existErr = fluentform1.querySelector('.ff-el-group:has(#ff_1_message) .error-message');

    if (existErr) {
      if (evt.target.value.trim().length >= 10 && evt.target.value.trim().length <= 1000) {
        existErr.remove();
      }
    }
  });


  fluentform1.addEventListener('submit', (evt) => {
    if (textareaMessage.value.trim().length < 10) {
      evt.preventDefault();
    }
  })

}