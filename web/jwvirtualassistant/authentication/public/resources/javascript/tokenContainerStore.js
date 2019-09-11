const tokenContainerStore = {
    store: function (name, encryptedTokenContainer) {
        document.cookie = `${name}=${encoder.encode(encryptedTokenContainer)}`;
    }
}

const encoder = {
    encode: (encryptedTokenContainer) => this._arrayBufferToByteString(encryptedTokenContainer).byteStringToBase64(),
    _arrayBufferToByteString: (arrayBuffer) => {
        return {
            _res: String.fromCharCode.apply(null, new Uint8Array(arrayBuffer)),
            byteStringToBase64: () => window.btoa(this._res)
        };
    }
}
