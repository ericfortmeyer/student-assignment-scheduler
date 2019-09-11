const formSubmitHandler = function (event) {
    const form = event.target;
    event.preventDefault();
    form.removeEventListener('submit', this);
    formSubmitUIChange(form);
    const formData = new FormData(form);
    // using the form data object directly isn't working : (
    const serializedFormData = Array.from(formData.entries()).join("&").replace(/\,+/g, '=');
    fetchToken(serializedFormData)
        .then(response => response.json(), function (reason) {
        
            alert('It looks like there is a problem with this application.  The developers have been'
                + ' notified.  Please allow a few days for them to fix the issue.');
            throw new Error(reason);
        })
        .then(
            res => {
                const authResponseHandlerDeps = {tokenContainerCrypto: tokenContainerCrypto, tokenContainerStore: tokenContainerStore};
                return authResponseHandler.init(authResponseHandlerDeps).handle(res);
            }
        )
        .then(
            // () => location.href = app_url
        )
        .catch(error => {
            console.log(error); // should log this in app
            // location.href = '/auth/400ErrorPage.html';
        });
};
