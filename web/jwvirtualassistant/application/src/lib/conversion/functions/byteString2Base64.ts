export function byteString2Base64(byteString: string): string {
    return window.btoa(byteString);
}
