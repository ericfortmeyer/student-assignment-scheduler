import { arrayBuffer2PlainText } from "./arrayBuffer2PlainText";
import { byteString2Base64 } from "./byteString2Base64";
export function arrayBuffer2Base64(arrayBuffer: ArrayBuffer): string {
    return byteString2Base64(arrayBuffer2PlainText(arrayBuffer));
}
