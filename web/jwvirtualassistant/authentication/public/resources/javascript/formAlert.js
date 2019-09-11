function formAlert(message, alertContainer = 'aside#alert', revealClassName = 'show', hideClassName = 'hide') {
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
