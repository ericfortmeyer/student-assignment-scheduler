function fetchToken(formData) {
    const XSRF_TOKEN = document.cookie.replace(/(?:(?:^|.*;\s*)XSRF_TOKEN\s*\=\s*([^;]*).*$)|^.*$/, '$1');
    const what = JSON.stringify(formData);
    return fetch(auth_proxy_url, {
        method: 'POST',
        mode: 'cors',
        headers: {
            'X-XSRF-TOKEN': XSRF_TOKEN,
            // 'Content-Type': 'application/json'
        },
        body: formData
    })
};
