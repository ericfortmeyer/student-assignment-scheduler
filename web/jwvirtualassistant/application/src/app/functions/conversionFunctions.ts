export function base64ToArrayBuffer(base64String: string): ArrayBuffer  {
    const str = window.atob(base64String);
    const buf = new ArrayBuffer(str.length);
    const bufView = new Uint8Array(buf);
    for (let i = 0, strLen = str.length; i < strLen; i++) {
        bufView[i] = str.charCodeAt(i);
    }
    return buf;
}

export function arrayBufferToPlainText(arrayBuffer: ArrayBuffer): string {
    return String.fromCharCode.apply(null, new Uint8Array(arrayBuffer));
}

export function byteStringToBase64(byteString: string): string {
    return window.btoa(byteString);
}
export function obj2ArrayBuffer (obj) {
    return new TextEncoder().encode(JSON.stringify(obj));
}
