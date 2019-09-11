const tokenContainerCrypto = {
    encrypt: function (key, tokenContainer) {
        return crypto.subtle.encrypt(
            {
                name: 'RSA-OAEP'
            },
            key,
            this._encode(tokenContainer)
        )
    },
    _encode: function (tokenContainer) {
        return new TextEncoder(JSON.stringify(tokenContainer))
    }
}

