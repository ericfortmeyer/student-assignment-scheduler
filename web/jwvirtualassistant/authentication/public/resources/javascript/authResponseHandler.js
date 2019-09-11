const authResponseHandler = {
    _deps: {},
    init: function (deps) {
        this._deps = deps;
        return this;
    },
    validateResponse: function (arg) {
        const isNotAnObject = typeof arg != 'object';
        const requiredPropsForTokenContainer = ['access_token', 'refresh_token', 'token_type', 'expires_in'];
        const requiredPropsForJsonError = ['status', 'detail'];
        const hasRequiredProps = (requiredProps, object) => {
            const props = Object.getOwnPropertyNames(object);
            return requiredProps.filter(
                (requiredProp) => props.includes(requiredProp)
            ).length == requiredProps.length;
        };
        const hasTokenContainerRequiedProps = hasRequiredProps(requiredPropsForTokenContainer, arg);
        const hasJsonErrorRequiredProps = hasRequiredProps(requiredPropsForJsonError, arg);
        const doesNotHaveRequiredProps = ! (hasTokenContainerRequiedProps || hasJsonErrorRequiredProps);
        switch (true) {
            case (isNotAnObject):
                throw new Error('Missing argument: argument must be a request object');
            case (doesNotHaveRequiredProps):
                throw new Error('Invalid argument: given object does not have required properies')
            default:
                // pass through;
        }
    },
    handle: function (res) {
        this.validateResponse(res);
        switch (res.status) {
            case 401:
                this._invalidCredentialsAction(res);
                throw res.detail;
            case 404:
                this._notFoundAction(res);
                throw res.detail;
            case 403:
            case 400:
                this._badRequestAction(res);
                throw res.detail;
            case 500:
                this._serverFailure(res);
                throw new Error(res.status)
            default:
                return this._successfulRequestAction(res);
        }

    },
    _successfulRequestAction: function (res) {
        importKey().then(
            key => this._deps.tokenContainerCrypto.encrypt(key, new TokenContainer(res))
        ).then(
            encrypted => this._deps.tokenContainerStore.store(name, encrypted)
        );
    },
    _invalidCredentialsAction: function (res) {
        // _showFormAlert(res.detail);
    },
    _notFoundAction: function () {
        //app is broken
        //should email contributors
        let message = 'It looks like there is a problem with this application.  The developers have been'
            + ' notified.  Please allow a few days for them to fix the issue.';
        _showFormAlert(message);
    },
    _badRequestAction: function () {
        //should not happen
        let message = 'It looks like there is a problem with this application.  The developers have been'
            + ' notified.  Please allow a few days for them to fix the issue.';
        _showFormAlert(message);
    },
    _serverFailure: function () {
        //retry??
        //should email contributors
        let message = 'It looks like there is a problem with logging in to the website.  Please try again'
            + ' in a few minutes.';
        _showFormAlert(message);
    }
};

function _showFormAlert(message, alertContainer = 'aside#alert', revealClassName = 'show', hideClassName = 'hide') {
    const alert = document.querySelector(alertContainer);
    const alertDuration = 10000;
    alert.classList.toggle(revealClassName);
    alert.appendChild(document.createTextNode(message));
    setTimeout(
        () => {
            [revealClassName, hideClassName].map(
                className => alert.classList.toggle(className)
            )
        },
        alertDuration
    );
}
