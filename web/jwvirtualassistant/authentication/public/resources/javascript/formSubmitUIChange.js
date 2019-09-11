function formSubmitUIChange(form) {
    const formSubmitButton = document.querySelector(`${_loginFormID} button[type = submit]`);
    const loader = document.querySelector(`${_loginFormID} div.form-submit-loader`);
    form.classList.toggle('form--submitted');
    formSubmitButton.setAttribute('disabled', 'true');
    loader.classList.toggle('lds-ellipsis');
}
