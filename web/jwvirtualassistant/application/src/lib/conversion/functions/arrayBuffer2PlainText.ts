export function arrayBuffer2PlainText(arrayBuffer: ArrayBuffer): string {
    return String.fromCharCode.apply(null, new Uint8Array(arrayBuffer));
}
