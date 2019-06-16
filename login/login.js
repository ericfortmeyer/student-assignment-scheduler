require("dotenv").config();
const loginForm = document.querySelector("#loginForm");

loginForm.addEventListener("submit", function (event) {
    const oauth_url = process.env.DEV_OAUTH_HOST;
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    form.removeEventListener("submit", this);
    fetch(oauth_url, {
        method: "POST",
        body: formData,
        mode: "cors",
    })
    .then(response => response.json(), function (reason) {
        alert("It looks like there is a problem with this application.  The developers have been"
            + " notified.  Please allow a few days for them to fix the issue.");
        throw new Error(reason);
    })
    .then(
        function (res) {
            const successfulRequestAction = function (res) {
                return JSON.stringify(res);
            };
            const invalidCredentialsAction = function (res) {
                alert(res.detail);
                //redirect
            };
            const notFoundAction = function (res) {
                //app is broken
                //should email message to contributors
                // JSON.stringify(res);
                alert("It looks like there is a problem with this application.  The developers have been"
                    + " notified.  Please allow a few days for them to fix the issue.");
            };
            const badRequestAction = function (res) {
                //should not happen
                // JSON.stringify(res);
                alert("It looks like there is a problem with this application.  The developers have been"
                    + " notified.  Please allow a few days for them to fix the issue.");
            }
            const serverFailure = function (res) {
                //should email contributors
                // JSON.stringify(res);
                alert("It looks like there is a problem with logging in to the website.  Please try again"
                    + " in a few minutes.");
            };
            switch (res.status) {
                case 401:
                    invalidCredentialsAction(res);
                    break;
                case 404:
                    notFoundAction(res);
                    break;
                case 403:
                    badRequestAction(res);
                    break;
                case 500:
                    serverFailure(res);
                    break;
                default:
                    return successfulRequestAction(res);
            }
        }
    )
    .then(jsonString => console.log(jsonString))
    .catch(error => console.log(error));
});

