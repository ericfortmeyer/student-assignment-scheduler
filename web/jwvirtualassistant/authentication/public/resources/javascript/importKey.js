function importKey() {
    const pem = secretKey;
    const pemHeader = '-----BEGIN RSA PUBLIC KEY-----\n';
    const pemFooter = '\n-----END RSA PUBLIC KEY-----';
    const pemContents = pem.substring(pemHeader.length, pem.length - pemFooter.length);
    const binaryDerString = window.atob(pemContents);
    const binaryDer = str2ab(binaryDerString);
    return crypto.subtle.importKey(
        'spki',
        binaryDer,
        {
            name: 'RSA-OAEP',
            hash: 'SHA-512'
        },
        true,
        ['encrypt']
    );
}

function str2ab(str) {
    const buf = new ArrayBuffer(str.length);
    const bufView = new Uint8Array(buf);
    for (let i = 0, strLen = str.length; i < strLen; i++) {
      bufView[i] = str.charCodeAt(i);
    }
    return buf;
}
  